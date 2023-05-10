@extends('admin.layouts.master')

@section('title', __('Chỉnh sửa :model', ['model' => $produce->name]))
@section('page-header')
    <x-page-header>
        {{ Breadcrumbs::render() }}
    </x-page-header>
@stop

@section('page-content')
    @include('admin.produces._form', [
        'url' =>  route('admin.produces.update', $produce),
        'produce' => $produce ?? new \App\Produces,
        'method' => 'PUT'
    ])
    <button class="dt-button buttons-create btn btn-success" type="button" data-toggle="modal" data-target="#exampleModal">
        <span><i class="fal fa-plus-circle mr-2"></i>Nhập kho</span>
    </button>
    <table class="table dataTable no-footer" id="ProductDataTable" role="grid" aria-describedby="ProductDataTable_info">
        <thead>
        <tr role="row">
            <th title="STT" class="sorting" tabindex="0" aria-controls="ProductDataTable" rowspan="1" colspan="1"
                aria-label="STT: activate to sort column ascending">Lượt nhập kho
            </th>
            <th title="Số lượng" class="sorting" tabindex="0" aria-controls="ProductDataTable" rowspan="1"
                colspan="1" aria-label="Số lượng: activate to sort column ascending">Số lượng
            </th>
            <th title="Thời gian cập nhật" class="sorting" tabindex="0" aria-controls="ProductDataTable" rowspan="1"
                colspan="1" aria-label="Thời gian cập nhật: activate to sort column ascending">Thời gian
            </th>
        </tr>
        </thead>
        <tbody>
        @foreach($produce->logs as $key => $child)
            <tr role="row" class="odd">
                <td>{{ $key+1 }}</td>
                <td>{{ $child->increase }}</td>
                <td>{{ formatDate($child->created_at) }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <div class="modal fade show" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <form action="{{ route('admin.produces.increase', $produce->id) }}" method="POST" data-block=""
                      enctype="multipart/form-data" id="post-form" novalidate="novalidate">
                    {{ csrf_field() }}
                    <div class="modal-header">
                        <h5 class="modal-title text-center" id="exampleModalLabel">
                            Nhập thêm nguyên liệu</h5>
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
                                                                <input autocomplete="new-password" type="text"
                                                                       name="increase" id="increase"
                                                                       class="form-control" placeholder="Số lượng"
                                                                       value="">
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

@stop
@push('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.7.2/dropzone.css"
          integrity="sha512-CmjeEOiBCtxpzzfuT2remy8NP++fmHRxR3LnsdQhVXzA3QqRMaJ3heF9zOB+c1lCWSwZkzSOWfTn1CdqgkW3EQ=="
          crossorigin="anonymous"/>
    <style>
        .dropzone .dz-preview .dz-image {
            width: 140px;
            height: 86px;
        }

        .dropzone .dz-preview .dz-error-mark, .dropzone .dz-preview .dz-success-mark, .dropzone-previews .dz-preview .dz-error-mark, .dropzone-previews .dz-preview .dz-success-mark {
            right: 50px;
            border: none;
        }

        .dropzone .dz-preview .dz-success-mark, .dropzone .dz-preview .dz-error-mark {
            top: 10%;
            left: 50%;
            margin-left: -35px;
            margin-top: -3px;
        }
    </style>
@endpush
@push('js')
    <script>
        $('.form-check-input-styled').uniform();
    </script>
    <script src="{{ asset('backend/js/editor-admin.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.7.2/min/dropzone.min.js"
            integrity="sha512-9WciDs0XP20sojTJ9E7mChDXy6pcO0qHpwbEJID1YVavz2H6QBz5eLoDD8lseZOb2yGT8xDNIV7HIe1ZbuiDWg=="
            crossorigin="anonymous"></script>
    <script>
        $('.select2').select2({
            placeholder: "{{ __('-- Vui lòng chọn --') }}",
        });

        let maxFileUpload = 9;
        Dropzone.autoDiscover = true;
        Dropzone.options.postImages = {
            url: '{{ route('admin.public.upload-tinymce') }}',
            maxFilesize: 2,
            maxFiles: maxFileUpload,
            addRemoveLinks: true,
            acceptedFiles: "image/*",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            },
            success: function (file, response) {
                $('#post-form').append('<input type="hidden" name="new_images[]" value="' + response.file + '">')
                file.previewElement.classList.add("dz-success")
            },
            removedfile: function (file) {
                file.previewElement.remove()
                if (file.hasOwnProperty('id')) {
                    $('#post-form').find('input[name="images[]"][value="' + file.id + '"]').remove()
                } else {
                    $('#post-form').find('input[name="new_images[]"][value="' + file.name + '"]').remove()
                }
            },
            init: function () {
                var myDropzone = this;
                this.on("addedfile", function (file) {
                    file.previewElement.addEventListener("click", function () {
                        myDropzone.removeFile(file);
                    });
                });
                    @if($produce->getMedia()->isNotEmpty())
                    @foreach($produce->getMedia() as $key => $image)
                let mockFile_{{$key}} = {
                        name: '{{ $image->file_name }}',
                        size: '{{ $image->size }}',
                        id: '{{ $image->id }}'
                    };
                myDropzone.emit("addedfile", mockFile_{{$key}});
                myDropzone.emit("thumbnail", mockFile_{{$key}}, '{{ $image->getFullUrl() }}');
                myDropzone.emit("complete", mockFile_{{$key}});
                $('#post-form').append('<input type="hidden" name="images[]" value="{{ $image->id }}">');
                    @endforeach
                    @endif
                let fileCountOnServer = '{{ $produce->getMedia()->count() }}';
                myDropzone.options.maxFiles = myDropzone.options.maxFiles - fileCountOnServer;

                myDropzone.on("maxfilesexceeded", function (file) {
                    this.removeFile(file);
                    console.log('{{ __("Đã đạt đến tệp tối đa") }}');
                });
            }
        }
    </script>
    {!! JsValidator::formRequest('App\Http\Requests\Admin\ProduceRequest', '#post-form'); !!}
@endpush

