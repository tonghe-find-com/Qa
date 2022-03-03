@extends('core::admin.master')

@section('title', __('New qacategory'))

@section('content')

    <div class="header">
        @include('core::admin._button-back', ['module' => 'qacategories'])
        <h1 class="header-title">@lang('New qacategory')</h1>
    </div>

    {!! BootForm::open()->action(route('admin::index-qacategories'))->multipart()->role('form') !!}
        @include('qas::admin.category._form')
    {!! BootForm::close() !!}

@endsection
