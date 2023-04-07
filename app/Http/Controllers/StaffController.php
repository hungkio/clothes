<?php

namespace App\Http\Controllers;

use App\DataTables\StaffDataTable;
use App\Http\Requests\Admin\PostBulkDeleteRequest;
use App\Http\Requests\Admin\PostStoreRequest;
use App\Http\Requests\Admin\PostUpdateRequest;
use App\Http\Requests\Admin\StaffRequest;
use App\Staffs;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;

class StaffController
{
    use AuthorizesRequests;

    public function index(StaffDataTable $dataTable)
    {
        $this->authorize('view', Staffs::class);

        return $dataTable->render('admin.staffs.index');
    }

    public function create(): View
    {
        $this->authorize('create', Staffs::class);
        $roles = Staffs::ROLE;
        return view('admin.staffs.create', compact('roles'));
    }

    public function store(StaffRequest $request)
    {
        $this->authorize('create', Staffs::class);
        $data = $request->all();
        $staff = Staffs::create($data);

        flash()->success(__('Nhân viên ":model" đã được tạo thành công !', ['model' => $staff->title]));

        return intended($request, route('admin.staffs.index'));
    }

    public function edit(Staffs $staff): View
    {
        $this->authorize('update', $staff);
        $roles = Staffs::ROLE;

        return view('admin.staffs.edit', compact('roles', 'staff'));
    }

    public function update(Staffs $staff, StaffRequest $request)
    {
        $this->authorize('update', $staff);

        if ($request->hasFile('image')) {
            $staff->addMedia($request->image)->toMediaCollection('image');
        }

        $staff->update($request->except(['category', 'image', 'proengsoft_jsvalidation', 'redirect_url']));

        $staff->taxons()->sync($request->input('category'));

        flash()->success(__('Nhân viên ":model" đã được cập nhật !', ['model' => $staff->title]));

        logActivity($staff, 'update'); // log activity

        return intended($request, route('admin.staffs.index'));
    }

    public function destroy(Staffs $staff)
    {
        $this->authorize('delete', $staff);
        if (\App\Enums\PageState::Active == $staff->status && !$staff->menu_items(MenuItem::TYPE_POST)->get()->isEmpty()) {
            return response()->json([
                'status' => 'error',
                'message' => __('Nhân viên đang được sử dụng không thể xoá!'),
            ]);
        }
        logActivity($staff, 'delete'); // log activity

        $staff->delete();

        return response()->json([
            'status' => true,
            'message' => __('Nhân viên đã xóa thành công !'),
        ]);
    }

    public function bulkDelete(PostBulkDeleteRequest $request)
    {
        $count_deleted = 0;
        $deletedRecord = Staffs::whereIn('id', $request->input('id'))->get();
        foreach ($deletedRecord as $staff) {
            if (\App\Enums\PageState::Active != $staff->status && $staff->menu_items(MenuItem::TYPE_POST)->get()->isEmpty()) {
                logActivity($staff, 'delete'); // log activity
                $staff->delete();
                $count_deleted++;
            }
        }
        return response()->json([
            'status' => true,
            'message' => __('Đã xóa ":count" bài viết thành công và ":count_fail" bài viết đang được sử dụng, không thể xoá',
                [
                    'count' => $count_deleted,
                    'count_fail' => count($request->input('id')) - $count_deleted,
                ]),
        ]);
    }

    public function changeStatus(Post $staff, Request $request)
    {
        $this->authorize('update', $staff);

        $staff->update(['status' => $request->status]);

        logActivity($staff, 'update'); // log activity

        return response()->json([
            'status' => true,
            'message' => __('Nhân viên đã được cập nhật trạng thái thành công !'),
        ]);
    }

    public function bulkStatus(Request $request)
    {
        $total = Staffs::whereIn('id', $request->id)->get();
        foreach ($total as $staff)
        {
            $staff->update(['status' => $request->status]);
            logActivity($staff, 'update'); // log activity
        }

        return response()->json([
            'status' => true,
            'message' => __(':count bài viết đã được cập nhật trạng thái thành công !', ['count' => $total->count()]),
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
