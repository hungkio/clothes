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
                                @if($design->id)
                                    | <a href="" class="text-primary font-weight-semibold"
                                         target="_blank">{{ Str::limit($design->name , 20) }}</a>
                                @endif
                            </legend>
                            <div class="collapse show" id="general">
                                <div class="form-group row">
                                    <label class="col-lg-2 col-form-label text-lg-right"><span class="text-danger">*</span> {{ __('Ảnh mẫu thiết kế') }}:</label>
                                    <div class="col-lg-9">
                                        <div id="thumbnail">
                                            <div class="single-image">
                                                <div class="image-holder" onclick="document.getElementById('image').click();">
                                                    <img id="image_url" width="170" height="170" src="{{ $design->getFirstMediaUrl('image') ?? '/backend/global_assets/images/placeholders/placeholder.jpg'}}" />
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
                                    :placeholder="__('Tên thiết kế')"
                                    :label="__('Tên thiết kế')"
                                    :value="$design->name"
                                    required
                                >
                                </x-text-field>

                                <div class="form-group row">
                                    <label for="select-taxon" class="col-lg-2 text-lg-right col-form-label">
                                        <span class="text-danger">*</span> {{ __('Tiến trình') }}
                                    </label>
                                    <div class="col-lg-9">
                                        <select name="progress" class="form-control" data-width="100%">
                                            @foreach(\App\Designs::PROGRESS as $key => $progress)
                                                <option value="{{ $key }}"
                                                        @if($key == @$design->status) selected @endif>
                                                    {{ $progress }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <div class="clearfix"></div>
                                        @error('status')
                                        <span class="form-text text-danger">
                                                {{ $message }}
                                            </span>
                                        @enderror
                                    </div>
                                </div>



                                <div class="form-group row">
                                    <label for="select-taxon" class="col-lg-2 text-lg-right col-form-label">
                                        <span class="text-danger">*</span> {{ __('Nhân viên') }}
                                    </label>
                                    <div class="col-lg-9">
                                        <select name="staff_id" class="form-control" data-width="100%">
                                            @foreach($users as $user)
                                                <option value="{{ $user->id }}"
                                                        @if($design->staff_id == @$user->id) selected @endif>
                                                    {{ $user->first_name . ' ' .$user->last_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <div class="clearfix"></div>
                                        @error('status')
                                        <span class="form-text text-danger">
                                                {{ $message }}
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-lg-2 col-form-label text-lg-right col-form-label">
                                        Thời gian
                                    </label>
                                    <div class="col-lg-9">
                                        <input type="text" name="duration" value="{{ @$design->duration }}">
                                    </div>
                                </div>

                            </div>

                        </fieldset>

                    </x-card>
                    <div class="d-flex justify-content-center align-items-center action-div" id="action-form">
                        <a href="{{ route('admin.designs.index') }}" class="btn btn-light">{{ __('Trở lại') }}</a>
                        <div class="btn-group ml-3">
                            <button class="btn btn-primary btn-block" data-loading><i
                                    class="mi-save mr-2"></i>{{ __('Lưu') }}</button>
                            <button class="btn btn-primary dropdown-toggle" data-toggle="dropdown"></button>
                            <div class="dropdown-menu dropdown-menu-right">
                                <a href="javascript:void(0)" class="dropdown-item submit-type"
                                   data-redirect="{{ route('admin.designs.index') }}">{{ __('Lưu & Thoát') }}</a>
                                <a href="javascript:void(0)" class="dropdown-item submit-type"
                                   data-redirect="{{ route('admin.designs.create') }}">{{ __('Lưu & Thêm mới') }}</a>
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
    <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <script>

        $(function () {
            $('input[name="duration"]').daterangepicker({

                locale: {
                    format: 'DD/MM/YYYY'
                }
            });

        })
    </script>
@endpush()
