<?php

namespace App\DataTables;

use App\DataTables\Core\BaseDatable;
use App\DataTables\Export\DesignExportHandler;
use App\Designs;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;

class DesignDataTable extends BaseDatable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
            ->addIndexColumn()
            ->addColumn('name', fn (Designs $design) => view('admin.designs._tableTitle', compact('design')))
            ->editColumn('staff_id', fn (Designs $design) => (($design->user->first_name ?? '') . ' ' . ($design->user->last_name ?? '')))
            ->editColumn('progress',fn (Designs $design) => Designs::PROGRESS[$design->progress])
            ->editColumn('status',fn (Designs $design) => Designs::STATUS[$design->status])
            ->editColumn('duration',fn (Designs $design) => $design->duration)
            ->editColumn('created_at', fn (Designs $design) => formatDate($design->created_at))
            ->editColumn('updated_at', fn (Designs $design) => formatDate($design->updated_at))
            ->addColumn('action', fn (Designs $design) => view('admin.designs._tableAction', compact('design')))
            ->filterColumn('title', function($query, $keyword) {
                $query->where('title', 'like', "%{$keyword}%");
            })
            ->orderColumn('title', 'title $1')
            ->rawColumns(['action', 'title', 'type', 'status']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Designs $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Designs $model)
    {
        return $model->newQuery()->with('user');
    }

    protected function getColumns(): array
    {
        return [
            Column::checkbox(''),
            Column::make('id')->title(__('STT'))->data('DT_RowIndex')->searchable(false),
            Column::make('name')->title(__('Tên'))->width('18%'),
            Column::make('staff_id')->title(__('Nhân viên'))->width('18%'),
            Column::make('progress')->title(__('Tiến trình'))->width('10%'),
            Column::make('duration')->title(__('Thời gian'))->width('20%'),
            Column::make('status')->title(__('Trạng thái'))->width('10%'),
            Column::make('updated_at')->title(__('Thời gian cập nhật'))->searchable(false),
            Column::make('created_at')->title(__('Thời gian tạo'))->searchable(false),
            Column::computed('action')
                ->title(__('Tác vụ'))
                ->exportable(false)
                ->printable(false)
                ->width(60)
                ->addClass('text-center'),
        ];
    }

    protected function getTableButton(): array
    {
        return [
            Button::make('create')->addClass('btn btn-success d-none')->text('<i class="fal fa-plus-circle mr-2"></i>'.__('Tạo mới')),
            Button::make('bulkDelete')->addClass('btn btn-danger d-none')->text('<i class="fal fa-trash-alt mr-2"></i>'.__('Xóa')),
            Button::make('export')->addClass('btn btn-primary')->text('<i class="fal fa-download mr-2"></i>'.__('Xuất')),
            Button::make('print')->addClass('btn bg-primary')->text('<i class="fal fa-print mr-2"></i>'.__('In')),
        ];
    }

    protected function getBuilderParameters(): array
    {
        return [
            'order' => [6, 'desc'],
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename(): string
    {
        return 'Designs_'.date('YmdHis');
    }

    protected function buildExcelFile()
    {
        $this->request()->merge(['length' => -1]);
        $source = app()->call([$this, 'query']);
        $source = $this->applyScopes($source);

        return new DesignExportHandler($source->get());
    }

    public function printPreview()
    {
        $this->request()->merge(['length' => -1]);
        $source = app()->call([$this, 'query']);
        $source = $this->applyScopes($source);
        $data = $source->get();
        return view('admin.designs.print', compact('data'));
    }
}
