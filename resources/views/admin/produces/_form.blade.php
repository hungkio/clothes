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
                                @if($produce->id)
                                    | <a href="" class="text-primary font-weight-semibold"
                                         target="_blank">{{ Str::limit($produce->title, 20) }}</a>
                                @endif
                            </legend>
                            <div class="collapse show" id="general">
                                <div class="form-group row">
                                    <label class="col-lg-2 col-form-label text-lg-right"><span class="text-danger">*</span> {{ __('Ảnh') }}:</label>
                                    <div class="col-lg-9">
                                        <div id="thumbnail">
                                            <div class="single-image">
                                                <div class="image-holder" onclick="document.getElementById('image').click();">
                                                    <img id="image_url" width="170" height="170" src="{{ $produce->getFirstMediaUrl('image') ?? '/backend/global_assets/images/placeholders/placeholder.jpg'}}" />
                                                </div>
                                            </div>
                                        </div>
                                        <input type="file" name="image" id="image"
                                               class="form-control inputfile hide"
                                               onchange="document.getElementById('image_url').src = window.URL.createObjectURL(this.files[0])">
                                        @error('image')
                                        <span class="form-text text-danger">
                                                    {{ $message }}
                                                </span>
                                        @enderror
                                    </div>
                                </div>

                                <x-text-field
                                    name="name"
                                    :placeholder="__('Nguyên liệu')"
                                    :label="__('Nguyên liệu')"
                                    :value="$produce->name"
                                    required
                                >
                                </x-text-field>

                                <x-text-field
                                    name="quantity"
                                    :placeholder="__('Số lượng')"
                                    :label="__('Số lượng')"
                                    :value="$produce->quantity"
                                    required
                                >
                                </x-text-field>
                            </div>
                        </fieldset>

                    </x-card>
                    <div class="d-flex justify-content-center align-items-center action-div" id="action-form">
                        <a href="{{ route('admin.produces.index') }}" class="btn btn-light">{{ __('Trở lại') }}</a>
                        <div class="btn-group ml-3">
                            <button class="btn btn-primary btn-block" data-loading><i
                                    class="mi-save mr-2"></i>{{ __('Lưu') }}</button>
                            <button class="btn btn-primary dropdown-toggle" data-toggle="dropdown"></button>
                            <div class="dropdown-menu dropdown-menu-right">
                                <a href="javascript:void(0)" class="dropdown-item submit-type"
                                   data-redirect="{{ route('admin.produces.index') }}">{{ __('Lưu & Thoát') }}</a>
                                <a href="javascript:void(0)" class="dropdown-item submit-type"
                                   data-redirect="{{ route('admin.produces.create') }}">{{ __('Lưu & Thêm mới') }}</a>
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
