@extends('admin.layouts.master')

@section('title', __('Chỉnh sửa :model', ['model' => $product->name]))
@section('page-header')
    <x-page-header>
        {{ Breadcrumbs::render() }}
    </x-page-header>
@stop

@section('page-content')
    <div id="modal_edit_child"></div>
    <button class="dt-button buttons-create btn btn-success" data-toggle="modal" tabindex="0"
            aria-controls="ProductDataTable"
            data-target="#exampleModal" type="button"><span><i class="fal fa-plus-circle mr-2"></i>Tạo order mới</span>
    </button>

    <!-- Modal create order -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <form action="{{ route('admin.products.storeOrder', $product->id) }}" method="POST" data-block=""
                      enctype="multipart/form-data" id="post-form" novalidate="novalidate">
                    {{ csrf_field() }}
                    <div class="modal-header">
                        <h5 class="modal-title text-center" id="exampleModalLabel">Tạo lượt order sản xuất mới</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="_token" value="5tX1hrAFRExsLMBpMzWmPtCyBCpN80CrNaeIGMUj"> <input
                            type="hidden" name="_method" value="POST">
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
                                                                <input autocomplete="new-password" type="text"
                                                                       name="quantity" id="quantity"
                                                                       class="form-control" placeholder="Số lượng"
                                                                       value="">
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
                                                                       placeholder="Số lượng cắt" value="">
                                                            </div>

                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-lg-2 col-form-label text-lg-right"
                                                                   for="cut">
                                                                <span class="text-danger">*</span>
                                                                Thuộc tính sản phẩm:
                                                            </label>
                                                            <div class="col-lg-9 ">
                                                                <div class="group-size">
                                                                    <div class="form-row form-size">
                                                                        <div class="form-group col-md-3">
                                                                            <input type="text" class="form-control"
                                                                                   name="color_type[]"
                                                                                   value=""
                                                                                   placeholder="Mã màu">
                                                                        </div>
                                                                        <div class="form-group col-md-3">
                                                                            <input type="text" class="form-control"
                                                                                   name="size_type[]"
                                                                                   placeholder="Size S, M, L, Xl">
                                                                        </div>
                                                                        <div class="form-group col-md-3">
                                                                            <input type="number" class="form-control"
                                                                                   name="size_quantity[]"
                                                                                   placeholder="Số lượng">

                                                                        </div>
                                                                        <button type="button"
                                                                                style="height: 2.5em; width: 2.5em;padding: initial;"
                                                                                class="btn btn-danger btn-remove">xóa
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                                <a href="#" id="addSize">Thêm loại size</a>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-lg-2 col-form-label text-lg-right"
                                                                   for="cut">
                                                                <span class="text-danger">*</span>
                                                                Nguyên liệu:
                                                            </label>
                                                            <div class="col-lg-9 ">
                                                                <div class="group-produce">
                                                                    <div class="form-row form-produce">
                                                                        <div class="form-group col-md-6">
                                                                            <select name="produce_id[]"
                                                                                    class="form-control "
                                                                                    data-width="100%">
                                                                                @foreach($produces as $produce)
                                                                                    <option value="{{ $produce->id }}">
                                                                                        {{ $produce->name }}
                                                                                    </option>
                                                                                @endforeach
                                                                            </select>
                                                                            <div class="clearfix"></div>
                                                                        </div>
                                                                        <div class="form-group col-md-3">
                                                                            <input type="number" class="form-control"
                                                                                   name="produce_quantity[]"
                                                                                   placeholder="Số lượng">

                                                                        </div>
                                                                        <button type="button"
                                                                                style="height: 2.5em; width: 2.5em;padding: initial;"
                                                                                class="btn btn-danger btn-remove-produce">xóa
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                                <a href="#" id="addProduce">Thêm loại nguyên liệu</a>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label for="select-taxon"
                                                                   class="col-lg-2 text-lg-right col-form-label">
                                                                <span class="text-danger">*</span> Xưởng
                                                            </label>
                                                            <div class="col-lg-9">
                                                                <select name="brand_id" class="form-control "
                                                                        data-width="100%">
                                                                    @foreach($brands as $brand)
                                                                        <option value="{{ $brand->id }}">
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
                                                                       placeholder="Ghi chú" value="">
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
                        <button type="submit" class="btn btn-primary">Tạo mới</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <table class="table dataTable no-footer" id="ProductDataTable" role="grid" aria-describedby="ProductDataTable_info">
        <thead>
        <tr role="row">
            <th title="STT" class="sorting" tabindex="0" aria-controls="ProductDataTable" rowspan="1" colspan="1"
                aria-label="STT: activate to sort column ascending">Lượt order
            </th>
            <th title="Số lượng" width="10%" class="sorting" tabindex="0" aria-controls="ProductDataTable" rowspan="1"
                colspan="1" style="width: 10%;" aria-label="Số lượng: activate to sort column ascending">Số lượng
            </th>
            <th title="Số lượng cắt" width="10%" class="sorting" tabindex="0" aria-controls="ProductDataTable"
                rowspan="1" colspan="1" style="width: 10%;"
                aria-label="Số lượng cắt: activate to sort column ascending">Số lượng cắt
            </th>
            <th title="Đã nhận" width="10%" class="sorting_desc" tabindex="0" aria-controls="ProductDataTable"
                rowspan="1" colspan="1" style="width: 10%;" aria-sort="descending"
                aria-label="Đã nhận: activate to sort column ascending">Đã nhận
            </th>
            <th title="Chưa nhận" width="10%" class="sorting" tabindex="0" aria-controls="ProductDataTable" rowspan="1"
                colspan="1" style="width: 10%;" aria-label="Chưa nhận: activate to sort column ascending">Chưa nhận
            </th>
            <th title="Ghi chú" width="15%" class="sorting" tabindex="0" aria-controls="ProductDataTable" rowspan="1"
                colspan="1" style="width: 15%;" aria-label="Ghi chú: activate to sort column ascending">Thuộc tính
            </th>
            <th title="Ghi chú" width="15%" class="sorting" tabindex="0" aria-controls="ProductDataTable" rowspan="1"
                colspan="1" style="width: 15%;" aria-label="Ghi chú: activate to sort column ascending">Nguyên liệu
            </th>
            <th title="Ghi chú" width="10%" class="sorting" tabindex="0" aria-controls="ProductDataTable" rowspan="1"
                colspan="1" style="width: 10%;" aria-label="Ghi chú: activate to sort column ascending">Ghi chú
            </th>
            <th title="Ghi chú" width="10%" class="sorting" tabindex="0" aria-controls="ProductDataTable" rowspan="1"
                colspan="1" style="width: 10%;" aria-label="Ghi chú: activate to sort column ascending">Xưởng
            </th>
            <th title="Thời gian cập nhật" class="sorting" tabindex="0" aria-controls="ProductDataTable" rowspan="1"
                colspan="1" aria-label="Thời gian cập nhật: activate to sort column ascending">Thời gian cập nhật
            </th>
            <th title="Tác vụ" width="60" class="text-center sorting_disabled" rowspan="1" colspan="1"
                style="width: 60px;" aria-label="Tác vụ">Tác vụ
            </th>
        </tr>
        </thead>
        <tbody>
        @foreach($children as $key => $child)
            <tr role="row" class="odd">
                <td>{{ $key+1 }}</td>
                <td>{{ $child->quantity }}</td>
                <td>{{ $child->cut }}</td>
                <td>{{ $child->receive }}</td>
                <td>{{ $child->not_receive }}</td>
                <td>
                    @if($child->size)
                        @foreach($child->size as $size)
                            {{ $size }}
                            <br>
                        @endforeach
                    @endif
                </td>
                <td>
                    @if($child->produce_id)
                        @foreach($child->produce_id as $key => $produce)
                            {{$produce . ' : ' . $child->produce_quantity[$key]}}
                            <br>
                        @endforeach
                    @endif
                </td>
                <td>{{ $child->note }}</td>
                <td>{{ $child->brand->name ?? '' }}</td>
                <td>{{ formatDate($child->updated_at) }}</td>
                <td class=" text-center">
                    <div class="list-icons">
                        <a href="javascript:void(0)"
                           data-url="{{ route('admin.products.editOrder', [$product->id, $child->id]) }}"
                           class="item-action btn-primary edit-child"
                           title="Chỉnh sửa"><i class="fal fa-pencil-alt"></i></a>
                    </div>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@stop
@push('css')

@endpush
@push('js')
    <script>
        $('.form-check-input-styled').uniform();
    </script>
    <script src="{{ asset('backend/js/editor-admin.js') }}"></script>
    <script type='text/javascript'>
        $('#addSize').click(function () {
            let count_form_size = $('.group-size').find('.form-size').length
            if (count_form_size < 4) {
                $('.group-size').append($('.group-size').find('.form-size').last().clone())
                $('.btn-remove').click(function () {
                    let count_form_size = $('.group-size').find('.form-size').length
                    if (count_form_size > 1) {
                        $(this).closest('.form-size').remove()
                    }
                })
            }
        })

        $('#addProduce').click(function () {
            let count_form_size = $('.group-produce').find('.form-produce').length
            if (count_form_size < 4) {
                $('.group-produce').append($('.group-produce').find('.form-produce').last().clone())
                $('.btn-remove-produce').click(function () {
                    let count_form_size = $('.group-produce').find('.form-produce').length
                    if (count_form_size > 1) {
                        $(this).closest('.form-produce').remove()
                    }
                })
            }
        })

        $('.btn-remove-produce').click(function () {
            let count_form_size = $('.group-produce').find('.form-produce').length
            if (count_form_size > 1) {
                $(this).closest('.form-produce').remove()
            }
        })

        $('.btn-remove').click(function () {
            let count_form_size = $('.group-size').find('.form-size').length
            if (count_form_size > 1) {
                $(this).closest('.form-size').remove()
            }
        })

        $(document).on('click', '.js-delete1', function () {
            var deleteUrl = $(this).data('url');

            confirmAction(Lang.confirm_delete, function (result) {
                if (result) {
                    $.ajax({
                        type: 'POST',
                        url: deleteUrl,
                        data: {
                            _method: "DELETE"
                        },
                        success: function (res) {
                            if (res.status == 'error') {
                                showMessage('error', res.message);
                            } else {
                                showMessage('success', res.message);
                            }
                            location.reload();
                        }
                    })
                }
            })
        })

        $('.edit-child').click(function () {
            var editUrl = $(this).data('url');

            $.ajax({
                type: 'GET',
                url: editUrl,
                success: function (res) {
                    if (res.status == 'error') {
                        showMessage('error', res.message);
                    } else {
                        $('#modal_edit_child').html(res)
                        $('#editChild').modal('show');
                        $('#addSizeChild').click(function () {
                            let count_form_size = $('.group-size-child').find('.form-size-child').length
                            if (count_form_size < 4) {
                                $('.group-size-child').append($('.group-size-child').find('.form-size-child').last().clone())
                                $('.btn-remove-child').click(function () {
                                    let count_form_size = $('.group-size-child').find('.form-size-child').length
                                    if (count_form_size > 1) {
                                        $(this).closest('.form-size-child').remove()
                                    }
                                })
                            }
                        })
                        $('#addProduce-child').click(function () {
                            let count_form_size = $('.group-produce-child').find('.form-produce-child').length
                            if (count_form_size < 4) {
                                $('.group-produce-child').append($('.group-produce-child').find('.form-produce-child').last().clone())
                                $('.btn-remove-produce-child').click(function () {
                                    let count_form_size = $('.group-produce-child').find('.form-produce-child').length
                                    if (count_form_size > 1) {
                                        $(this).closest('.form-produce-child').remove()
                                    }
                                })
                            }
                        })
                        $('.btn-remove-produce-child').click(function () {
                            let count_form_size = $('.group-produce-child').find('.form-produce-child').length
                            if (count_form_size > 1) {
                                $(this).closest('.form-produce-child').remove()
                            }
                        })
                        $('.btn-remove-child').click(function () {
                            let count_form_size = $('.group-size-child').find('.form-size-child').length
                            if (count_form_size > 1) {
                                $(this).closest('.form-size-child').remove()
                            }
                        })
                    }
                }
            })
        })
    </script>
    {!! JsValidator::formRequest('App\Http\Requests\Admin\ProductRequest', '#post-form'); !!}
@endpush

