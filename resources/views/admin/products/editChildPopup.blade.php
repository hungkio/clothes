<div class="modal fade show" id="editChild" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form action="{{ route('admin.products.updateOrder', $product->id) }}" method="POST" data-block=""
                  enctype="multipart/form-data" id="post-form" novalidate="novalidate">
                {{ csrf_field() }}
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title text-center" id="exampleModalLabel">
                        Cập nhật order sản xuất</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="d-flex align-items-start flex-column flex-md-row">

                        <!-- Left content -->
                        <div class="w-100 order-2 order-md-1 left-content">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card">

                                        <div class="card-body">
                                            <fieldset>
                                                <div class="collapse show" id="general">
                                                    <div class="form-group row">
                                                        <label class="col-lg-2 col-form-label text-lg-right"
                                                               for="quantity">
                                                            <span class="text-danger">*</span>
                                                            Số lượng:
                                                        </label>
                                                        <div class="col-lg-9">
                                                            <input autocomplete="new-password" type="text" readonly
                                                                   name="quantity" id="quantity"
                                                                   class="form-control" placeholder="Số lượng"
                                                                   value="{{ $product->quantity }}">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label class="col-lg-2 col-form-label text-lg-right"
                                                               for="cut">
                                                            <span class="text-danger">*</span>
                                                            Số lượng cắt:
                                                        </label>
                                                        <div class="col-lg-9">
                                                            <input autocomplete="new-password" type="text"
                                                                   name="cut" id="cut" class="form-control"
                                                                   placeholder="Số lượng cắt"
                                                                   value="{{ $product->cut }}">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label class="col-lg-2 col-form-label text-lg-right"
                                                               for="cut">
                                                            <span class="text-danger">*</span>
                                                            Thuộc tính sản phẩm:
                                                        </label>
                                                        <div class="col-lg-9 ">
                                                            <div class="group-size-child">
                                                                @foreach($product->size as $size)
                                                                    <div class="form-row form-size-child">
                                                                        <div class="form-group col-md-3">
                                                                            <input type="text" class="form-control" readonly
                                                                                   name="color_type[]"
                                                                                   value="{{ @explode(':', $size)[0] }}"
                                                                                   placeholder="Mã màu">
                                                                        </div>
                                                                        <div class="form-group col-md-3">
                                                                            <input type="text" class="form-control" readonly
                                                                                   name="size_type[]"
                                                                                   value="{{ @explode(':', $size)[1] }}"
                                                                                   placeholder="Size S, M, L, Xl">
                                                                        </div>
                                                                        <div class="form-group col-md-3">
                                                                            <input type="number" class="form-control" readonly
                                                                                   name="size_quantity[]"
                                                                                   value="{{ @explode(':', $size)[2] }}"
                                                                                   placeholder="Số lượng">
                                                                        </div>
                                                                        <div class="form-group col-md-3">
                                                                            <input type="number" class="form-control"
                                                                                   name="size_quantity_received[]"
                                                                                   value="{{ @explode(':', $size)[3] }}"
                                                                                   placeholder="Số lượng đã nhận">
                                                                        </div>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label class="col-lg-2 col-form-label text-lg-right"
                                                               for="cut">
                                                            <span class="text-danger">*</span>
                                                            Nguyên liệu:
                                                        </label>
                                                        <div class="col-lg-9 ">
                                                            <div class="group-produce-child">
                                                                @foreach($product->produce_id as $key => $produce_id)
                                                                    <div class="form-row form-produce-child">
                                                                        <div class="form-group col-md-6">
                                                                            <select name="produce_id[]" disabled
                                                                                    class="form-control "
                                                                                    data-width="100%">
                                                                                @foreach($produces as $produce)
                                                                                    <option value="{{ $produce->id }}"
                                                                                            @if($produce_id == $produce->id) selected @endif>
                                                                                        {{ $produce->name }}
                                                                                    </option>
                                                                                @endforeach
                                                                            </select>
                                                                            <div class="clearfix"></div>
                                                                        </div>
                                                                        <div class="form-group col-md-3">
                                                                            <input type="number" class="form-control" readonly
                                                                                   name="produce_quantity[]" value="{{ $product->produce_quantity[$key] }}"
                                                                                   placeholder="Số lượng">

                                                                        </div>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="select-taxon"
                                                               class="col-lg-2 text-lg-right col-form-label">
                                                            <span class="text-danger">*</span> Xưởng
                                                        </label>
                                                        <div class="col-lg-9">
                                                            <select name="brand_id" class="form-control " disabled
                                                                    data-width="100%">
                                                                @foreach($brands as $brand)
                                                                    <option value="{{ $brand->id }}" @if($brand->id == $product->brand_id) selected @endif>
                                                                        {{ $brand->name }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                            <div class="clearfix"></div>
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <label class="col-lg-2 col-form-label text-lg-right"
                                                               for="note">
                                                            Ghi chú:
                                                        </label>
                                                        <div class="col-lg-9">
                                                            <input autocomplete="new-password" type="text"
                                                                   name="note" id="note" class="form-control"
                                                                   placeholder="Ghi chú" value="{{ $product->note }}">
                                                        </div>

                                                    </div>

                                                </div>

                                            </fieldset>

                                        </div>
                                    </div>

                                </div>
                            </div>

                        </div>
                        <!-- /left content -->
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                    <button type="submit" class="btn btn-primary">Lưu</button>
                </div>
            </form>
        </div>
    </div>
</div>
