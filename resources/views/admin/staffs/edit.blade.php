@extends('admin.layouts.master')

@section('title', __('Chỉnh sửa :model', ['model' => $staff->name]))
@section('page-header')
    <x-page-header>
        {{ Breadcrumbs::render() }}
    </x-page-header>
@stop

@section('page-content')
    @include('admin.staffs._form', [
        'url' =>  route('admin.staffs.update', $staff),
        'staff' => $staff ?? new \App\Staffs,
        'method' => 'PUT'
    ])
@stop
@push('js')
    <script>
        $('.form-check-input-styled').uniform();
    </script>
    <script src="{{ asset('backend/js/editor-admin.js') }}"></script>
    {!! JsValidator::formRequest('App\Http\Requests\Admin\StaffRequest', '#post-form'); !!}
@endpush

