@extends('layouts.app')

@section('title')
    {{ $tag->name }}
@endsection

@section('content')
<!--archive header-->
<div class="archive-header text-center mt-40">
    <div class="container">
        <h2><span class="color3">{{ $tag->name }}</span></h2>
        <div class="breadcrumb">
            <a href="{{ route('home') }}" rel="nofollow">Beranda</a>
            <span></span> {{ $tag->name }}
        </div>
        <div class="bt-1 border-color-1 mt-30 mb-50"></div>
    </div>
</div>
<!--main content-->
<div class="main_content sidebar_right pb-50">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-md-12 col-sm-12">
                <!--loop-list-->
                <div class="loop-grid row">
                    @foreach ($post_tag as $item)                  
                    <article class="col-lg-6 mb-50 animate-conner">
                        <div class="post-thumb d-flex mb-30 border-radius-5 img-hover-scale animate-conner-box">
                            <a href="">
                                <img src="{{ Storage::url($item->post_image) }}" alt="">
                            </a>
                        </div>
                        <div class="post-content">
                            <div class="entry-meta meta-0 font-small mb-15">
                                <a href="{{ route('home-category', $item->category_slug) }}">
                                    <span class="post-cat background1 color-white">
                                       {{ $item->category }} 
                                    </span>
                                </a>
                            </div>
                            <h3 class="post-title">
                                <a href="{{ route('post-detail', $item->slug) }}">{{ $item->post_title; }}</a>
                            </h3>
                            <div class="entry-meta meta-1 font-small color-grey mt-15 mb-15">
                                <span class="post-by">
                                    By <a href="#">{{ $item->author; }}</a>
                                </span>
                                <span class="post-on has-dot">{{ date('d F Y', strtotime($item->published_at));}}</span>
                            </div>
                            <div class="post-excerpt mb-25">
                                <p>
                                    {{ $item->post_teaser; }}
                                </p>
                            </div>
                        </div>
                    </article>
                    @endforeach
                </div>
                <!--pagination-->
                <div class="pagination-area pt-30 text-center bt-1 border-color-1">
                    <div class="container">
                        <div class="row">
                            <div class="col-xl-12">
                                <div class="single-wrap d-flex justify-content-center">
                                     {{-- {!! $post_tag->links() !!} --}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-12 col-sm-12 primary-sidebar sticky-sidebar">
                <div class="widget-area pl-30">
                    <!--Widget latest posts style 1-->
                    <div class="sidebar-widget widget_alitheme_lastpost mb-50">
                        <div class="widget-header position-relative mb-20 pb-10">
                            <h5 class="widget-title mb-10">Latest Posts</h5>
                            <div class="bt-1 border-color-1"></div>
                        </div>
                        <div class="post-block-list post-module-1">
                            <ul class="list-post">
                                @php
                                    $no=1;
                                @endphp
                                @foreach ($latest_post as $latest)                              
                                <li class="mb-30">
                                    <div class="d-flex">
                                        <div class="post-thumb d-flex mr-15 border-radius-5 img-hover-scale">
                                            <a href="{{ route('post-detail', $latest->slug) }}">
                                                <img src="{{ Storage::url($latest->post_image) }}" alt="">
                                            </a>
                                        </div>
                                        <div class="post-content media-body">
                                            <div class="entry-meta meta-0 mb-10">
                                                <a href="{{ route('home-category', $latest->category->slug) }}">
                                                    <span class="post-in background{{ $no++; }} color-white font-small">
                                                        {{ $latest->category->name }}
                                                    </span>
                                                </a>
                                            </div>
                                            <h6 class="post-title mb-10 text-limit-2-row">
                                                {{ $latest->post_title; }}
                                            </h6>
                                            <div class="entry-meta meta-1 font-x-small color-grey">
                                                <span class="post-on">
                                                    {{ date('d F Y', strtotime($latest->published_at));}}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('addon-style')
<script type="text/javascript" src="https://platform-api.sharethis.com/js/sharethis.js#property=61acbda059afaf001ae4aa06&product=inline-share-buttons" async="async"></script>
@endpush