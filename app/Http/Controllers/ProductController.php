<?php

namespace App\Http\Controllers;

use App\Brands;
use App\DataTables\ProductDataTable;
use App\Designs;
use App\Domain\Admin\Models\Admin;
use App\Http\Requests\Admin\ProductRequest;
use App\Produces;
use App\Products;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductController
{
    use AuthorizesRequests;

    public function index(ProductDataTable $dataTable)
    {
        $this->authorize('view', Products::class);

        return $dataTable->render('admin.products.index');
    }

    public function create(): View
    {
        $this->authorize('create', Products::class);
        $brands = Brands::all();
        $design_used = Products::whereNull('parent')->get('design_id')->toArray();
        $designs = Designs::whereNotIn('id', $design_used)->get();

        return view('admin.products.create', compact('designs', 'brands'));
    }

    public function store(ProductRequest $request)
    {
        $this->authorize('create', Products::class);
        $design = Designs::findOrFail($request->design_id);
        $data = $request->all();
        $data['name'] = $design->name;
        $product = Products::create($data);

        Products::create(array_merge($data, ['parent' => $product->id]));

        flash()->success(__('Sản phẩm ":model" đã được tạo thành công !', ['model' => $product->name]));

        return intended($request, route('admin.products.index'));
    }

    public function edit(Products $product): View
    {
        $this->authorize('update', $product);

        $children = Products::where('parent', $product->id)->with(['design', 'brand'])->get();
        foreach ($children as &$child) {
            $produce_ids = json_decode($child->produce_id, 1);
            $child->produce_quantity = json_decode($child->produce_quantity, 1);
            $produce = [];
            foreach ($produce_ids as $produce_id) {
                $produce[] = Produces::findOrFail($produce_id)->name;
            }
            $child->produce_id = $produce;
            $child->size = json_decode($child->size);
        }
        $brands = Brands::all();
        $produces = Produces::all();
        return view('admin.products.edit', compact('product', 'children', 'brands', 'produces'));
    }

    public function update(Products $product, ProductRequest $request)
    {
        $this->authorize('update', $product);

        if ($request->hasFile('image')) {
            $product->addMedia($request->image)->toMediaCollection('image');
        }

        $product->update($request->all());

        flash()->success(__('Sản phẩm ":model" đã được cập nhật !', ['model' => $product->name]));

        return intended($request, route('admin.products.index'));
    }

    public function editOrder(Products $parent, Products $product)
    {
        $this->authorize('update', $parent);

        $produce_ids = json_decode($product->produce_id, 1);
        $product->produce_quantity = json_decode($product->produce_quantity, 1);
        $produce = [];
        foreach ($produce_ids as $produce_id) {
            $produce[] = $produce_id;
        }
        $product->produce_id = $produce;
        $product->size = json_decode($product->size);
        $brands = Brands::all();
        $produces = Produces::all();
        return view('admin.products.editChildPopup', compact('parent', 'brands', 'produces', 'product'))->render();
    }

    public function storeOrder(Products $product, Request $request)
    {
        $produce_id = $request->produce_id;
        $produce_quantity = $request->produce_quantity;

        //size
        $size_type = $request->size_type;
        $size_quantity = $request->size_quantity;
        $size_map = [];
        foreach ($size_type as $key => $size) {
            $size_map[] = "$size:" . $size_quantity[$key];
        }

        $data = [
            'name' => $product->name,
            'parent' => $product->id,
            'quantity' => $request->quantity,
            'cut' => $request->cut,
            'size' => json_encode($size_map),
            'produce_id' => json_encode($produce_id),
            'produce_quantity' => json_encode($produce_quantity),
            'brand_id' => $request->brand_id,
            'note' => $request->note,
        ];

        Products::create($data);

        flash()->success(__('Order sản xuất cho mẫu ":model" đã được tạo thành công !', ['model' => $product->name]));

        return redirect()->route('admin.products.edit', $product->id);
    }

    public function updateOrder(Products $product, Request $request)
    {
        $produce_id = $request->produce_id;
        $produce_quantity = $request->produce_quantity;

        //size
        $size_type = $request->size_type;
        $size_quantity = $request->size_quantity;
        $size_map = [];
        foreach ($size_type as $key => $size) {
            $size_map[] = "$size:" . $size_quantity[$key];
        }

        $data = [
            'quantity' => $request->quantity,
            'cut' => $request->cut,
            'size' => json_encode($size_map),
            'produce_id' => json_encode($produce_id),
            'produce_quantity' => json_encode($produce_quantity),
            'brand_id' => $request->brand_id,
            'note' => $request->note,
            'receive' => $request->receive,
            'not_receive' => $request->not_receive,
        ];

        $product->update($data);

        flash()->success(__('Order sản xuất cho mẫu ":model" đã được tạo thành công !', ['model' => $product->name]));

        return redirect()->route('admin.products.edit', $product->parent);
    }

    public function destroy(Products $product)
    {
        $this->authorize('delete', $product);
        if (\App\Enums\PageState::Active == $product->status && !$product->menu_items(MenuItem::TYPE_POST)->get()->isEmpty()) {
            return response()->json([
                'status' => 'error',
                'message' => __('Sản phẩm đang được sử dụng không thể xoá!'),
            ]);
        }
        logActivity($product, 'delete'); // log activity

        $product->delete();

        return response()->json([
            'status' => true,
            'message' => __('Sản phẩm đã xóa thành công !'),
        ]);
    }

    public function bulkDelete(Request $request)
    {
        $count_deleted = 0;
        $deletedRecord = Products::whereIn('id', $request->input('id'))->get();
        foreach ($deletedRecord as $product) {
            if (\App\Enums\PageState::Active != $product->status && $product->menu_items(MenuItem::TYPE_POST)->get()->isEmpty()) {
                logActivity($product, 'delete'); // log activity
                $product->delete();
                $count_deleted++;
            }
        }
        return response()->json([
            'status' => true,
            'message' => __('Đã xóa ":count" Sản phẩm thành công và ":count_fail" Sản phẩm đang được sử dụng, không thể xoá',
                [
                    'count' => $count_deleted,
                    'count_fail' => count($request->input('id')) - $count_deleted,
                ]),
        ]);
    }

    public function changeStatus(Products $product, Request $request)
    {
        $this->authorize('update', $product);

        $product->update(['status' => $request->status]);

        logActivity($product, 'update'); // log activity

        return response()->json([
            'status' => true,
            'message' => __('Sản phẩm đã được cập nhật trạng thái thành công !'),
        ]);
    }

    public function bulkStatus(Request $request)
    {
        $total = Products::whereIn('id', $request->id)->get();
        foreach ($total as $product) {
            $product->update(['status' => $request->status]);
            logActivity($product, 'update'); // log activity
        }

        return response()->json([
            'status' => true,
            'message' => __(':count Sản phẩm đã được cập nhật trạng thái thành công !', ['count' => $total->count()]),
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
