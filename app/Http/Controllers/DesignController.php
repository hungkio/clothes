<?php

namespace App\Http\Controllers;

use App\DataTables\DesignDataTable;
use App\Designs;
use App\Domain\Admin\Models\Admin;
use App\Http\Requests\Admin\DesignRequest;
use App\Products;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;

class DesignController
{
    use AuthorizesRequests;

    public function index(DesignDataTable $dataTable)
    {
        $this->authorize('view', Designs::class);

        return $dataTable->render('admin.designs.index');
    }

    public function create(): View
    {
        $this->authorize('create', Designs::class);
        $progresses = Designs::PROGRESS;
        $users = Admin::get();

        return view('admin.designs.create', compact('progresses', 'users'));
    }

    public function store(DesignRequest $request)
    {
        $this->authorize('create', Designs::class);
        $data = $request->all();
        $data['status'] = 1;
        $design = Designs::create($data);

        if ($request->hasFile('image')) {
            $design->addMedia($request->image)->toMediaCollection('image');
        }

        flash()->success(__('Mẫu thiết kế ":model" đã được tạo thành công !', ['model' => $design->name]));

        return intended($request, route('admin.designs.index'));
    }

    public function edit(Designs $design): View
    {
        $this->authorize('update', $design);
        $progresses = Designs::PROGRESS;
        $users = Admin::get();

        return view('admin.designs.edit', compact('design', 'progresses', 'users'));
    }

    public function updateStatus(Designs $design, Request $request)
    {
        $design->update($request->all());
        Products::create([
            'name' => $design->name,
            'design_id' => $design->id,
        ]);
        return response()->json([
            'status' => true,
            'message' => __('Mẫu thiết kế ":model" đã được duyệt!', ['model' => $design->name]),
        ]);
    }

    public function update(Designs $design, DesignRequest $request)
    {
        $this->authorize('update', $design);

        if ($request->hasFile('image')) {
            $design->addMedia($request->image)->toMediaCollection('image');
        }

        $design->update($request->all());

        flash()->success(__('Mẫu thiết kế ":model" đã được cập nhật !', ['model' => $design->name]));

        return intended($request, route('admin.designs.index'));
    }

    public function destroy(Designs $design)
    {
        $this->authorize('delete', $design);

        $design->delete();

        return response()->json([
            'status' => true,
            'message' => __('Mẫu thiết kế đã xóa thành công !'),
        ]);
    }

    public function bulkDelete(Request $request)
    {
        $count_deleted = 0;
        $deletedRecord = Designs::whereIn('id', $request->input('id'))->get();
        foreach ($deletedRecord as $design) {
            $design->delete();
            $count_deleted++;
        }
        return response()->json([
            'status' => true,
            'message' => __('Đã xóa ":count" Mẫu thiết kế thành công và ":count_fail" Mẫu thiết kế đang được sử dụng, không thể xoá',
                [
                    'count' => $count_deleted,
                    'count_fail' => count($request->input('id')) - $count_deleted,
                ]),
        ]);
    }

    public function changeStatus(Designs $design, Request $request)
    {
        $this->authorize('update', $design);

        $design->update(['status' => $request->status]);

        logActivity($design, 'update'); // log activity

        return response()->json([
            'status' => true,
            'message' => __('Mẫu thiết kế đã được cập nhật trạng thái thành công !'),
        ]);
    }

    public function bulkStatus(Request $request)
    {
        $total = Designs::whereIn('id', $request->id)->get();
        foreach ($total as $design) {
            $design->update(['status' => $request->status]);
            logActivity($design, 'update'); // log activity
        }

        return response()->json([
            'status' => true,
            'message' => __(':count Mẫu thiết kế đã được cập nhật trạng thái thành công !', ['count' => $total->count()]),
        ]);
    }

    public function upLoadFileImage(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'file' => ['mimes:jpeg,jpg,png', 'required', 'max:2048'],
            ],
            [
                'file.mimes' => __('Tệp tải lên không hợp lệ'),
                'file.max' => __('Tệp quá lớn'),
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()->first('file'),
            ], \Illuminate\Http\Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $file = $request->file('file')->storePublicly('tmp/uploads');

        return response()->json([
            'file' => $file,
            'status' => true,
        ]);
    }
}
