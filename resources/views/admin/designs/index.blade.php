@extends('admin.layouts.master')

@section('title', __('Sản phẩm'))
@section('page-header')
    <x-page-header>
        {{ Breadcrumbs::render() }}
    </x-page-header>
@stop

@push('css')
    <style>
        @media (max-width: 767.98px) {
            .btn-danger {
                margin-left: 0!important;
            }
        }
        @media (width: 320px) {
            .btn-danger {
                margin-left: .625rem!important;
            }
        }
    </style>
@endpush

@section('page-content')
    <x-card>
        {{$dataTable->table()}}
    </x-card>

@stop

@push('js')
    {{$dataTable->scripts()}}
    <script>
        $(document).on('change','#select_status', function () {
            var status = $(this).val();
            var url = $(this).attr('data-url');
            confirmAction('Bạn có muốn thay đổi trạng thái ?', function (result) {
                if (result) {
                    $.ajax({
                        url: url,
                        data: {
                            'status': status
                        },
                        type: 'POST',
                        dataType: 'json',
                        success: function(res) {
                            if(res.status == true){
                                showMessage('success', res.message);
                            }else{
                                showMessage('error', res.message);
                            }
                            window.LaravelDataTables['{{ $dataTable->getTableAttribute('id') }}'].ajax.reload();
                        },
                    });
                }else{
                    window.LaravelDataTables['{{ $dataTable->getTableAttribute('id') }}'].ajax.reload();
                }
            });
        });

        $(document).on('click', '.updateStatus', function () {
            var updateUrl = $(this).data('url');

            confirmAction("Bạn có chắc muốn duyệt mẫu thiết kế này?", function (result) {
                if (result) {
                    $.ajax({
                        type: 'PUT',
                        url: updateUrl,
                        data: {
                            _method: "PUT",
                            status: 2
                        },
                        success: function (res) {
                            if (res.status == 'error') {
                                showMessage('error', res.message);
                            } else {
                                showMessage('success', res.message);
                            }
                            Object.keys(window.LaravelDataTables).forEach(function (table) {
                                window.LaravelDataTables[table].ajax.reload()
                            })
                        }
                    })
                }
            })
        })
        @can('products.create')
        $('.buttons-create').removeClass('d-none')
        @endcan
        @can('products.delete')
        $('.btn-danger').removeClass('d-none')
        @endcan
        @can('products.update')
        $('.btn-warning').removeClass('d-none')
        @endcan

        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
        })
    </script>
@endpush
