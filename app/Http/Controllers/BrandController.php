<?php

namespace App\Http\Controllers;

use App\DataTables\BrandDataTable;
use App\Http\Requests\Admin\PostBulkDeleteRequest;
use App\Http\Requests\Admin\BrandRequest;
use App\Brands;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;

class BrandController
{
    use AuthorizesRequests;

    public function index(BrandDataTable $dataTable)
    {
        $this->authorize('view', Brands::class);

        return $dataTable->render('admin.brands.index');
    }

    public function create(): View
    {
        $this->authorize('create', Brands::class);
        return view('admin.brands.create');
    }

    public function store(BrandRequest $request)
    {
        $this->authorize('create', Brands::class);
        $data = $request->all();
        $brand = Brands::create($data);

        flash()->success(__('Xưởng ":model" đã được tạo thành công !', ['model' => $brand->title]));

        return intended($request, route('admin.brands.index'));
    }

    public function edit(Brands $brand): View
    {
        $this->authorize('update', $brand);

        return view('admin.brands.edit', compact('brand'));
    }

    public function update(Brands $brand, BrandRequest $request)
    {
        $this->authorize('update', $brand);

        $brand->update($request->all());

        flash()->success(__('Xưởng ":model" đã được cập nhật !', ['model' => $brand->name]));


        return intended($request, route('admin.brands.index'));
    }

    public function destroy(Brands $brand)
    {
        $this->authorize('delete', $brand);

        $brand->delete();

        return response()->json([
            'status' => true,
            'message' => __('Xưởng đã xóa thành công !'),
        ]);
    }

    public function bulkDelete(PostBulkDeleteRequest $request)
    {
        $count_deleted = 0;
        $deletedRecord = Brands::whereIn('id', $request->input('id'))->get();
        foreach ($deletedRecord as $brand) {
            $brand->delete();
            $count_deleted++;
        }
        return response()->json([
            'status' => true,
            'message' => __('Đã xóa ":count" xưởng thành công ',
                [
                    'count' => $count_deleted,
                ]),
        ]);
    }

    public function changeStatus(Post $brand, Request $request)
    {
        $this->authorize('update', $brand);

        $brand->update(['status' => $request->status]);

        logActivity($brand, 'update'); // log activity

        return response()->json([
            'status' => true,
            'message' => __('Xưởng đã được cập nhật trạng thái thành công !'),
        ]);
    }

    public function bulkStatus(Request $request)
    {
        $total = Brands::whereIn('id', $request->id)->get();
        foreach ($total as $brand)
        {
            $brand->update(['status' => $request->status]);
            logActivity($brand, 'update'); // log activity
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
