<?php

namespace App\Http\Controllers;

use App\Http\Requests\Admin\ProduceRequest;
use App\Produces;
use App\DataTables\ProduceDataTable;
use App\Http\Requests\Admin\PostBulkDeleteRequest;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;

class ProduceController
{
    use AuthorizesRequests;

    public function index(ProduceDataTable $dataTable)
    {
        $this->authorize('view', Produces::class);

        return $dataTable->render('admin.produces.index');
    }

    public function create(): View
    {
        $this->authorize('create', Produces::class);
        return view('admin.produces.create');
    }

    public function store(ProduceRequest $request)
    {
        $this->authorize('create', Produces::class);
        $data = $request->all();
        $produce = Produces::create($data);
        if ($request->hasFile('image')) {
            $produce->addMedia($request->image)->toMediaCollection('image');
        }
        flash()->success(__('Nguyên liệu ":model" đã được tạo thành công !', ['model' => $produce->name]));

        return intended($request, route('admin.produces.index'));
    }

    public function edit(Produces $produce): View
    {
        $this->authorize('update', $produce);

        return view('admin.produces.edit', compact('produce'));
    }

    public function update(Produces $produce, ProduceRequest $request)
    {
        $this->authorize('update', $produce);

        $produce->update($request->all());

        flash()->success(__('Nguyên liệu ":model" đã được cập nhật !', ['model' => $produce->name]));


        return intended($request, route('admin.produces.index'));
    }

    public function destroy(Produces $produce)
    {
        $this->authorize('delete', $produce);

        $produce->delete();

        return response()->json([
            'status' => true,
            'message' => __('Nguyên liệu đã xóa thành công !'),
        ]);
    }

    public function bulkDelete(PostBulkDeleteRequest $request)
    {
        $count_deleted = 0;
        $deletedRecord = Produces::whereIn('id', $request->input('id'))->get();
        foreach ($deletedRecord as $produce) {
            $produce->delete();
            $count_deleted++;
        }
        return response()->json([
            'status' => true,
            'message' => __('Đã xóa ":count" Nguyên liệu thành công ',
                [
                    'count' => $count_deleted,
                ]),
        ]);
    }

    public function changeStatus(Post $produce, Request $request)
    {
        $this->authorize('update', $produce);

        $produce->update(['status' => $request->status]);

        logActivity($produce, 'update'); // log activity

        return response()->json([
            'status' => true,
            'message' => __('Nguyên liệu đã được cập nhật trạng thái thành công !'),
        ]);
    }

    public function bulkStatus(Request $request)
    {
        $total = Produces::whereIn('id', $request->id)->get();
        foreach ($total as $produce)
        {
            $produce->update(['status' => $request->status]);
            logActivity($produce, 'update'); // log activity
        }

        return response()->json([
            'status' => true,
            'message' => __(':count sản phẩm đã được cập nhật trạng thái thành công !', ['count' => $total->count()]),
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
