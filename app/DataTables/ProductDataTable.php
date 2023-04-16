<?php

namespace App\DataTables;

use App\DataTables\Core\BaseDatable;
use App\DataTables\Export\ProductExportHandler;
use App\Products;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;

class ProductDataTable extends BaseDatable
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
            ->addColumn('name', fn (Products $product) => view('admin.products._tableTitle', compact('product')))
            ->editColumn('quantity', fn (Products $product) => $product->quantity)
            ->editColumn('cut', fn (Products $product) => $product->cut)
            ->editColumn('receive', fn (Products $product) => $product->receive)
            ->editColumn('not_receive', fn (Products $product) => $product->not_receive)
            ->editColumn('created_at', fn (Products $product) => formatDate($product->created_at))
            ->editColumn('updated_at', fn (Products $product) => formatDate($product->updated_at))
            ->addColumn('action', 'admin.products._tableAction')
            ->filterColumn('title', function($query, $keyword) {
                $query->where('title', 'like', "%{$keyword}%");
            })
            ->orderColumn('title', 'title $1')
            ->rawColumns(['action', 'title', 'type', 'status']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param Products $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Products $model)
    {
        return $model->newQuery()->whereNull('parent')->with(['brand', 'design']);
    }

    protected function getColumns(): array
    {
        return [
            Column::checkbox(''),
            Column::make('id')->title(__('STT'))->data('DT_RowIndex')->searchable(false),
            Column::make('name')->title(__('Tên'))->width('18%'),
            Column::make('quantity')->title(__('Số lượng'))->width('10%'),
            Column::make('cut')->title(__('Số lượng cắt'))->width('10%'),
            Column::make('receive')->title(__('Đã nhận'))->width('10%'),
            Column::make('not_receive')->title(__('Chưa nhận'))->width('10%'),
            Column::make('created_at')->title(__('Thời gian tạo'))->searchable(false),
            Column::make('updated_at')->title(__('Thời gian cập nhật'))->searchable(false),
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
            Button::make('reset')->addClass('btn bg-primary')->text('<i class="fal fa-undo mr-2"></i>'.__('Thiết lập lại')),
        ];
    }

    protected function getBuilderParameters(): array
    {
        return [
            'order' => [5, 'desc'],
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename(): string
    {
        return 'Products_'.date('YmdHis');
    }

    protected function buildExcelFile()
    {
        $this->request()->merge(['length' => -1]);
        $source = app()->call([$this, 'query']);
        $source = $this->applyScopes($source);

        return new ProductExportHandler($source->get());
    }

    public function printPreview()
    {
        $this->request()->merge(['length' => -1]);
        $source = app()->call([$this, 'query']);
        $source = $this->applyScopes($source);
        $data = $source->get();
        return view('admin.products.print', compact('data'));
    }
}
