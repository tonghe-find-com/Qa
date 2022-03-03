@extends('pages::public.master')

@section('title',$page->meta_title==""?$page->title:$page->meta_title)
@section('keywords',$page->meta_keywords)
@section('description',$page->meta_description)

@push('css')
    <!-- $$$ Single CSS $$$ -->
    <link rel="stylesheet" href="{{ asset('project/css/wrapper.min.css') }}">
@endpush

@push('js')
    <!-- $$$ Single JS $$$ -->
    <!-- The text of pre & next in .flex-nav have been modified in jquery.flexslider-min.js  -->
    <script defer src="{{ asset('project/js/jquery.flexslider-min.js') }}"></script>
    <script defer src="{{ asset('project/js/mall.js') }}"></script>
@endpush

{{-- 頁面Banner  --}}
@push('banner')
    @include('template.pagebanner',['target'=>'qa'])
@endpush

@section('content')
    <section>
        <div class="wrapper-faq">
            <div class="container">
                <h1 class="heading heading-pages u-text-center">{{$page->title}}
                </h1>
                <div class="flexCC mt-4">
                    <nav id="FAQ" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ TypiCMS::homeUrl() }}">首頁</a>
                            </li>
                            <li class="breadcrumb-item"><a href="{{ route(app()->getLocale()."::index-qa") }}">{{$page->title}}</a></li>
                            @isset($model)
                            <li class="breadcrumb-item active" aria-current="page">{{$model->title}}</li>
                            @endisset
                        </ol>
                    </nav>
                </div>
                @foreach ($list as $item)
                    <div class="faqbox">
                        <div class="flexSB">
                            <div class="flexLC">
                                <div class="faqbox__num">{{ $loop->index+1 }}</div>
                                <div class="faqbox__que">{{ $item->title }}</div>
                            </div>
                            <div class="faqbox__arrowbtn bg-color--secondarylight">
                                <i class="fas fa-sort-down"></i>
                            </div>
                        </div>
                        <div class="faqbox__ans">{!! $item->body !!}</div>

                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endsection



