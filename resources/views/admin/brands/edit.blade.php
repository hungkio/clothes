@extends('admin.layouts.master')

@section('title', __('Chỉnh sửa :model', ['model' => $brand->name]))
@section('page-header')
    <x-page-header>
        {{ Breadcrumbs::render() }}
    </x-page-header>
@stop

@section('page-content')
    @include('admin.brands._form', [
        'url' =>  route('admin.brands.update', $brand),
        'staff' => $brand ?? new \App\Brands,
        'method' => 'PUT'
    ])
@stop
@push('js')
    <script>
        $('.form-check-input-styled').uniform();
    </script>
    <script src="{{ asset('backend/js/editor-admin.js') }}"></script>
    {!! JsValidator::formRequest('App\Http\Requests\Admin\BrandRequest', '#post-form'); !!}
@endpush

