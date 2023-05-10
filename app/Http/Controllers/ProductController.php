<?php

namespace App\Http\Controllers;

use App\Brands;
use App\DataTables\ProductDataTable;
use App\Designs;
use App\Domain\Admin\Models\Admin;
use App\Http\Requests\Admin\ProductRequest;
use App\Produces;
use App\Products;
use GuzzleHttp\Client;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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

    public function store(Request $request)
    {
        $this->authorize('create', Products::class);
        $design = Designs::findOrFail($request->design_id);
        $data = $request->all();
        $data['name'] = $design->name;
        $product = Products::create($data);

        $design->update([
            'status' => 2
        ]);
        flash()->success(__('Sản phẩm ":model" đã được tạo thành công !', ['model' => $product->name]));

        return redirect()->route('admin.products.index');
    }

    public function edit(Products $product): View
    {
        $this->authorize('update', $product);

        $children = Products::where('parent', $product->id)->with(['design', 'brand'])->get();
        foreach ($children as &$child) {
            $produce_ids = json_decode($child->produce_id, 1) ?? [];
            $child->produce_quantity = json_decode($child->produce_quantity, 1) ?? [];
            $produce = [];
            foreach ($produce_ids as $produce_id) {
                $produce[] = Produces::findOrFail($produce_id)->name;
            }
            $child->produce_id = $produce;
            $child->size = json_decode($child->size);
            $total_item = 0;
            $total_received = 0;
            foreach ($child->size as $size) {
                $size_exploded = explode(':', $size);
                $total_item += $size_exploded[2];
                $total_received += @$size_exploded[3];
            }
            $child->receive = $total_received;
            $child->not_receive = $total_item - $total_received;
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

        $produce_ids = json_decode($product->produce_id, 1) ?? [];
        $product->produce_quantity = json_decode($product->produce_quantity, 1) ?? [];
        $produce = [];
        foreach ($produce_ids as $produce_id) {
            $produce[] = $produce_id;
        }
        $product->produce_id = $produce;
        $product->size = json_decode($product->size) ?? [];
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
        $color_type = $request->color_type;
        $size_map = [];
        foreach ($size_type as $key => $size) {
            $size_map[] = $color_type[$key] . ":$size:" . $size_quantity[$key];
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

        $oldChildren = $product->children()->get();
        $new = Products::create($data);
        $this->putCake($product, $new, true, $oldChildren);

        $this->updateParentInfo($product->id);
        $this->updateProduce([], [], $produce_id, $produce_quantity);
        flash()->success(__('Order sản xuất cho mẫu ":model" đã được tạo thành công !', ['model' => $product->name]));

        return redirect()->route('admin.products.edit', $product->id);
    }

    public function updateOrder(Products $product, Request $request)
    {
        $old_produce_id = $product->produce_id;
        $old_produce_quantity = $product->produce_quantity;

        $produce_id = json_decode($product->produce_id);
        $produce_quantity = $request->produce_quantity;

        //size
        $size_type = $request->size_type;
        $size_quantity = $request->size_quantity;
        $color_type = $request->color_type;
        $size_quantity_received = $request->size_quantity_received;
        $size_map = [];
        foreach ($size_type as $key => $size) {
            $size_map[] =  "$color_type[$key]:$size:$size_quantity[$key]:$size_quantity_received[$key]" ;
        }

        $data = [
            'quantity' => $request->quantity,
            'cut' => $request->cut,
            'size' => json_encode($size_map),
            'produce_id' => json_encode($produce_id),
            'produce_quantity' => json_encode($produce_quantity),
            'brand_id' => $request->brand_id,
            'not_receive' => $request->not_receive,
        ];

        $parent = $product->parent()->first();
        $oldChildren = $parent->children()->get();
        $product->update($data);
        $this->putCake($parent, $product, false, $oldChildren);

        $this->updateParentInfo($product->parent);
        $this->updateProduce(
            $old_produce_id ? json_decode($old_produce_id) : [],
            $old_produce_quantity ? json_decode($old_produce_quantity) : [],
            $produce_id,
            $produce_quantity
        );

        flash()->success(__('Order sản xuất cho mẫu ":model" đã được tạo thành công !', ['model' => $product->name]));

        return redirect()->route('admin.products.edit', $product->parent);
    }

    public function destroy(Products $product)
    {
        $this->authorize('delete', $product);

        $product->delete();

        return response()->json([
            'status' => true,
            'message' => __('Sản phẩm đã xóa thành công !'),
        ]);
    }

    public function updateParentInfo($product_id)
    {
        $product = Products::findOrFail($product_id);
        $children = Products::where('parent', $product_id)->get();
        $total_quantity = 0;
        $total_cut = 0;
        $total_receive = 0;
        $total_not_receive = 0;
        foreach ($children as $child) {
            $total_item = 0;
            $total_received = 0;
            foreach (json_decode($child->size) as $size) {
                $size_exploded = explode(':', $size);
                $total_item += $size_exploded[2];
                $total_received += $size_exploded[3];
            }
            $child->receive = $total_received;
            $child->not_receive = $total_item - $total_received;

            $total_quantity += $child->quantity;
            $total_cut += $child->cut;
            $total_receive += $child->receive;
            $total_not_receive += $child->not_receive;
        }

        $product->update([
            'quantity' => $total_quantity,
            'cut' => $total_cut,
            'receive' => $total_receive,
            'not_receive' => $total_not_receive,
        ]);
    }

    public function updateProduce($old_produce_id, $old_produce_quantity, $produce_id, $produce_quantity)
    {
        $data_new = [];
        foreach ($produce_id as $key => $produce) {
            if (array_key_exists($produce, $data_new)) {
                $data_new[$produce] += $produce_quantity[$key];
            } else {
                $data_new = [$produce => (int)$produce_quantity[$key]] + $data_new;
            }
        }

        $data_old = [];
        foreach ($old_produce_id as $key => $produce) {
            if (array_key_exists($produce, $data_old)) {
                $data_old[$produce] += $old_produce_quantity[$key];
            } else {
                $data_old = [$produce => (int)$old_produce_quantity[$key]] + $data_old;
            }
        }

        $diffs = [];
        foreach ($data_new as $key => $new) {
            if (array_key_exists($key, $data_old)) {
                $diffs = [$key => $new - $data_old[$key]] + $diffs;
            } else {
                $diffs = [$key => $new] + $diffs;
            }
        }

        foreach ($diffs as $diff_id => $diff) {
            $diffObject = Produces::findOrFail($diff_id);
            $diffObject->update([
                'quantity' => $diffObject->quantity - $diff
            ]);
        }
    }

    public function bulkDelete(Request $request)
    {
        $count_deleted = 0;
        $deletedRecord = Products::whereIn('id', $request->input('id'))->get();
        foreach ($deletedRecord as $product) {
            $product->delete();
            $count_deleted++;
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

    public function getFields($products, $parent)
    {
        $sizes = [];
        $colors = [];
        $fields = [];
        foreach ($products as $prd) {
            $prd_size = json_decode($prd->size);
            foreach ($prd_size as $sz) {
                $size_arr = explode(':', $sz); // {color : size : quantity}

                //colors
                if (!in_array($size_arr[0], $colors)) {
                    $colors[] = $size_arr[0];
                }

                // sizes
                if (!in_array($size_arr[1], $sizes)) {
                    $sizes[] = $size_arr[1];
                }

                $fields[] = [
                    (object) [
                        'name' => "Màu",
                        'value' => $size_arr[0],
                    ],
                    (object) [
                        'name' => "Size",
                        'value' => $size_arr[1],
                    ],
                    'quantity' => $size_arr[2],
                    'quantity_received' => @$size_arr[3],
                    'id' => $size_arr[3] ?? ''
                ];
            }
        }

        // mapping size id
        $parent_sizes = json_decode($parent->size) ?? [];
        $parent_sizes_arr = [];
        foreach ($parent_sizes as $parent_size) {
            $p_sz = explode(':', $parent_size);
            $parent_sizes_arr[$p_sz[0].':'.$p_sz[1]] = $p_sz[2];
        }

        foreach ($fields as $key => $field) {
            $field_key = $field[0]->value . ':' . $field[1]->value;
            if (key_exists($field_key, $parent_sizes_arr)) {
                $fields[$key]['id'] = $parent_sizes_arr[$field_key];
            }
        }
        return [$sizes, $colors, $fields];
    }

    public function putCake($data, $newChild, $isNewOrder = false, $oldChildren = [])
    {
        //get size children
        $children = $data->children()->get();
        $getFields = $this->getFields($children, $data);
        $sizes = $getFields[0];
        $colors = $getFields[1];
        $fields = $getFields[2];

        // merge same value
        $newFields = [];
        foreach ($fields as $field) {
            if ($field['id']) {
                $found = false;
                foreach ($newFields as $key => $new) {
                    if ($field['id'] == $new['id']) {
                        $newFields[$key]['quantity'] += $field['quantity'];
                        $found = true;
                    }
                }
                if (!$found) {
                    $newFields[] = $field;
                }
            } else {
                $newFields[] = $field;
            }
        }
        $fields = $newFields;

        // $product_attributes, $fields
        $variations = [];
        foreach ($fields as $field) {
            $field_copy = $field;
            unset($field_copy['quantity']);
            unset($field_copy['id']);
            unset($field_copy['quantity_received']);
            $variation = [
                'fields' => $field_copy,
                'images' => $data->design ? [$data->design->getFirstMediaUrl('image')] : '',
                'last_imported_price' => 0,
                'retail_price' => 0,
                'weight' => 0,
            ];
            if ($field['id']) {
                $variation = array_merge($variation, [
                    'id' => $field['id']
                ]);
            }
            $variations[] = (object)$variation;
        }
        $product_attributes = [
            (object)[
                'name' => 'Màu',
                'values' => (array)$colors
            ],
            (object)[
                'name' => 'Size',
                'values' => (array)$sizes
            ]
        ];

        //end $product_attributes, $fields

        $objectProduct = new \stdClass();
        $objectProduct->name = $data->name;
        $objectProduct->note_product = $data->note;
        $objectProduct->product_attributes = $product_attributes;
        $objectProduct->variations = $variations;
        $objectProduct->weight = 1;

        $object = new \stdClass();
        $object->product = $objectProduct;

        if ($data->id_pos) {
            $response = callApi(pos_put_url($data->id_pos), 'PUT', json_encode($object));
        } else {
            $response = callApi(pos_post_url(), 'POST', json_encode($object));
        }

        if (@$response->success) {
            $size_mix_variations = [];
            $variations_pos = $response->data->variations;
            foreach ($variations_pos as $key => $var) {
                $fields[$key]['id'] = $var->id;
                $size_mix_variations[] = $var->fields[0]->value . ':' . $var->fields[1]->value . ':' . $var->id;
            }
            $data->update([
                'id_pos' => $response->data->id,
                'size' => json_encode($size_mix_variations),
            ]);

            if ($isNewOrder) {
                $this->newPurchase($data, $fields, $newChild, $oldChildren);
            } else {
                $this->updatePurchase($data, $fields, $newChild, $oldChildren);
            }
        }

    }

    public function newPurchase($parent, $data, $newChild, $oldChildren)
    {
        $oldData = $this->getFields($oldChildren, $parent);
        //compare fields
        if (!empty($oldData) && !empty($oldData[2])) {
            foreach ($data as $key => $newField) {
                $change = false;
                foreach ($oldData[2] as $oldField) {
                    if ($oldField[0]->value == $newField[0]->value && $oldField[1]->value == $newField[1]->value) {
                        $change = $newField['quantity'] - $oldField['quantity'];
                        break;
                    }
                }
                if ($change <= 0) {
                    unset($data[$key]);
                }
                if ($change > 0) {
                    $data[$key]['quantity'] = $change;
                }

            }
        }

        $items = [];
        foreach ($data as $key => $field)  {
            $items[] = (object)[
                "imported_price" => 0,
                "index" => $key,
                'quantity' => (int)$field['quantity'],
                'variation_id' => $field['id']
            ];
        }
        $payload = [
            'status'=> -1,
            "items" => $items,
            "note"=> "",
            "not_create_transaction" => false,
            "auto_create_debts" => true,
            "change_received_at" => true,
            "warehouse_id" => '5b9371b6-54c8-4168-a653-d25ebb434d6b',
            "images" => []
        ];
        $object = new \stdClass();
        $object->purchase = (object)$payload;
        $response = callApi(pos_post_purchase_url(), 'POST', json_encode($object));

        if (@$response->success) {
            $newChild->update([
                'purchase_id' => $response->data->id,
            ]);
        }
    }

    public function updatePurchase($parent, $data, $newChild, $oldChildren)
    {
        $oldData = $this->getFields($oldChildren, $parent);
        //compare fields
        if (!empty($oldData)) {
            foreach ($data as $key => $newField) {
                $change = false;
                foreach ($oldData[2] as $oldField) {
                    if ($oldField[0]->value == $newField[0]->value && $oldField[1]->value == $newField[1]->value) {
                        if (!$newField['quantity_received']) {
                            $newField['quantity_received'] = 0;
                        }
                        if (!$oldField['quantity_received']) {
                            $oldField['quantity_received'] = 0;
                        }
                        $change = ($newField['quantity_received'] ?? 0) - ($oldField['quantity_received'] ?? 0);
                        break;
                    }
                }
                if ($change <= 0) {
                    $data[$key]['quantity_changed'] = 0;
                }
                if ($change > 0) {
                    $data[$key]['quantity_changed'] = $change;
                }

            }
        }

        $newPurchaseItems = [];
        $oldPurchaseItems = [];
        $noChange = true;
        foreach ($data as $key => $field)  {
            if ($field['quantity_changed']) {
                $noChange = false;
            }
            $newPurchaseItems[] = (object)[
                "imported_price" => 0,
                "index" => $key,
                'quantity' => (int)$field['quantity_changed'],
                'variation_id' => $field['id']
            ];
            $oldPurchaseItems[] = (object)[
                "imported_price" => 0,
                "index" => $key,
                'quantity' => (int)$field['quantity'] - (int)$field['quantity_received'],
                'variation_id' => $field['id']
            ];
        }

        if ($noChange) {
            return;
        }

        $newPurchase = [
            'discount'=> 0,
            "items" => $newPurchaseItems,
            "note"=> $newChild->note,
            "not_create_transaction" => false,
            "auto_create_debts" => true,
            "warehouse_id" => '5b9371b6-54c8-4168-a653-d25ebb434d6b',
            "images" => [],
            'received_at' => time(),
            'prepaid_debt' => 0,
            'status' => 1,
            "tags" => [1],
            "transport_fee"=> 0,
        ];
        $oldPurchase = [
            "id"=> $newChild->purchase_id,
            'discount'=> 0,
            "items" => $oldPurchaseItems,
            "note"=> $newChild->note,
            "not_create_transaction" => false,
            "auto_create_debts" => true,
            "warehouse_id" => '5b9371b6-54c8-4168-a653-d25ebb434d6b',
            "images" => [],
            'received_at' => time(),
            'prepaid_debt' => 0,
            "tags" => [1],
            "transport_fee"=> 0,
        ];

        $object = new \stdClass();
        $object->newPurchase = (object)$newPurchase;
        $object->oldPurchase = (object)$oldPurchase;

        $response = callApi(pos_post_separate_url(), 'POST', json_encode($object));
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
