@extends('core::admin.master')

@section('title', __('New qa'))

@section('content')

    <div class="header">
        @include('core::admin._button-back', ['module' => 'qas'])
        <h1 class="header-title">@lang('New qa')</h1>
    </div>

    {!! BootForm::open()->action(route('admin::index-qas'))->multipart()->role('form') !!}
        @include('qas::admin.item._form')
    {!! BootForm::close() !!}

@endsection
