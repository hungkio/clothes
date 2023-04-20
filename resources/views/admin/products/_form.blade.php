<form action="{{ $url }}" method="POST" data-block enctype="multipart/form-data" id="post-form">
    @csrf
    @method($method ?? 'POST')

    <div class="d-flex align-items-start flex-column flex-md-row">

        <!-- Left content -->
        <div class="w-100 order-2 order-md-1 left-content">
            <div class="row">
                <div class="col-md-12">
                    <x-card>
                        <fieldset>
                            <legend class="font-weight-semibold text-uppercase font-size-sm">
                                {{ __('Chung') }}
                                @if($product->id)
                                    | <a href="" class="text-primary font-weight-semibold"
                                         target="_blank">{{ Str::limit($product->name, 20) }}</a>
                                @endif
                            </legend>
                            <div class="collapse show" id="general">
                                <div class="form-group row">
                                    <label for="select-taxon" class="col-lg-2 text-lg-right col-form-label">
                                        <span class="text-danger">*</span> {{ __('Thiết kế') }}
                                    </label>
                                    <div class="col-lg-9">
                                        <select name="design_id" class="form-control " data-width="100%">
                                            @foreach($designs as $design)
                                                <option value="{{ $design->id }}" >
                                                    {{ $design->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <div class="clearfix"></div>
                                        @error('design_id')
                                        <span class="form-text text-danger">
                                                {{ $message }}
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="select-taxon" class="col-lg-2 text-lg-right col-form-label">
                                        <span class="text-danger">*</span> {{ __('Xưởng') }}
                                    </label>
                                    <div class="col-lg-9">
                                        <select name="brand_id" class="form-control " data-width="100%">
                                            @foreach($brands as $brand)
                                                <option value="{{ $brand->id }}" >
                                                    {{ $brand->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <div class="clearfix"></div>
                                        @error('brand_id')
                                        <span class="form-text text-danger">
                                                {{ $message }}
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <x-text-field
                                    name="note"
                                    :placeholder="__('Ghi chú')"
                                    :label="__('Ghi chú')"
                                    :value="$product->note"
                                >
                                </x-text-field>
                            </div>

                        </fieldset>

                    </x-card>
                    <div class="d-flex justify-content-center align-items-center action-div" id="action-form">
                        <a href="{{ route('admin.products.index') }}" class="btn btn-light">{{ __('Trở lại') }}</a>
                        <div class="btn-group ml-3">
                            <button class="btn btn-primary btn-block" data-loading><i
                                    class="mi-save mr-2"></i>{{ __('Lưu') }}</button>
                            <button class="btn btn-primary dropdown-toggle" data-toggle="dropdown"></button>
                            <div class="dropdown-menu dropdown-menu-right">
                                <a href="javascript:void(0)" class="dropdown-item submit-type"
                                   data-redirect="{{ route('admin.products.index') }}">{{ __('Lưu & Thoát') }}</a>
                                <a href="javascript:void(0)" class="dropdown-item submit-type"
                                   data-redirect="{{ route('admin.products.create') }}">{{ __('Lưu & Thêm mới') }}</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <!-- /left content -->
    </div>
</form>
@push('js')
    <script>
        $(document).on('keyup', '#slug', function () {
        })
    </script>
@endpush()
