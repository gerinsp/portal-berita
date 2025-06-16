@extends('layouts.app')

@section('title')
    {{ $category->name }}
@endsection

@section('content')
<!--archive header-->
<div class="archive-header text-center mt-40">
    <div class="container">
        <h2><span class="color3">{{ $category->name }}</span></h2>
        <div class="breadcrumb">
            <a href="{{ route('home') }}" rel="nofollow">Beranda</a>
            <span></span> {{ $category->name }}
        </div>
        <div class="bt-1 border-color-1 mt-30 mb-50"></div>
    </div>
</div>
<!--Featured post Start-->
<div class="home-featured mb-50">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="featured-slider-1 border-radius-10">
                    <div class="featured-slider-1-items">
                        @foreach ($headline as $item)                                                   
                        <div class="slider-single">
                            <div class="row no-gutters">
                                <div class="col-lg-6 col-md-12 order-lg-1 order-2 align-center-vertical">
                                    <div class="slider-caption">
                                        <div class="entry-meta meta-0 mb-25">
                                            <a href="{{ route('home-category', $item->post->category->slug) }}">
                                                <span class="post-in background1 color-white font-small">
                                                    {{ $item->post->category->name; }}
                                                </span>
                                            </a>
                                        </div>
                                        <h2 class="post-title">
                                            <a href="{{ route('post-detail', $item->post->slug) }}">{{ $item->post->post_title; }}</a>
                                        </h2>
                                        <div class="entry-meta meta-1 font-small color-grey mt-20 mb-20">
                                            <span class="post-on"><i class="ti-marker-alt"></i>
                                                {{ date('d F Y', strtotime($item->post->published_at));}}
                                            </span>
                                        </div>
                                        <p class="excerpt font-medium mt-25 mb-25">
                                            {{ $item->post->post_teaser; }}
                                        </p>
                                        <div class="entry-meta meta-2">
                                            <a class="float-left mr-10 author-img" href="{{ route('author', $item->post->user->id) }}">
                                                @if ($item->post->user->profile != NULL)
                                                    <img src="{{ Storage::url($item->post->user->profile) }}" alt="">
                                                @else
                                                    <img src="https://ui-avatars.com/api/?name={{ $item->post->user->name; }}" alt="">
                                                @endif
                                            </a>
                                            <a href="{{ route('author', $item->post->user->id) }}">
                                                <span class="author-name">{{ $item->post->user->name; }}</span>
                                            </a>
                                            <br>
                                            <span class="author-add color-grey">Texno.id</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="slider-img col-lg-6 order-lg-2 order-1 col-md-12">
                                    <div class="img-hover-scale">
                                        <span class="top-right-icon background8"><i class="mdi mdi-favorite"></i></span>
                                        <a href="{{ route('post-detail', $item->post->slug) }}">
                                            <img src="{{ Storage::url($item->post->post_image) }}" alt="post-slider">
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <div class="row">
                        <div class="col-lg-6 col-md-12">
                            <div class="arrow-cover"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--Featured post End-->
<!--main content-->
<div class="main_content sidebar_right pb-50">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-md-12 col-sm-12">
                <!--loop-list-->
                <div class="loop-grid row">
                    @foreach ($post as $item)                  
                    <article class="col-lg-6 mb-50 animate-conner">
                        <div class="post-thumb d-flex mb-30 border-radius-5 img-hover-scale animate-conner-box">
                            <a href="{{ route('post-detail', $item->slug) }}">
                                <img src="{{ Storage::url($item->post_image) }}" alt="">
                            </a>
                        </div>
                        <div class="post-content">
                            <div class="entry-meta meta-0 font-small mb-15">
                                @php
                                    $sc = App\Models\Category::where('id', $item->sub_categories)->first();
                                @endphp
                                @if ($item->sub_categories != NULL)
                                    <a href="{{ route('home-category', $sc->slug) }}">
                                        <span class="post-cat background1 color-white">
                                            {{ $sc->name; }}
                                        </span>
                                    </a>
                                @else
                                    <a href="{{ route('home-category', $item->category->slug) }}">
                                        <span class="post-cat background1 color-white">
                                            {{ $item->category->name; }}
                                        </span>
                                    </a>
                                @endif
                            </div>
                            <h3 class="post-title">
                                <a href="{{ route('post-detail', $item->slug) }}">{{ $item->post_title; }}</a>
                            </h3>
                            <div class="entry-meta meta-1 font-small color-grey mt-15 mb-15">
                                <span class="post-by">
                                    By <a href="{{ route('author', $item->user->id) }}">{{ splitName($item->user->name); }}</a>
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
                                    @if ($post->hasPages())
                                        <ul class="pagination" role="navigation">
                                            {{-- Previous Page Link --}}
                                            @if ($post->onFirstPage())
                                                <li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.previous')">
                                                    <span class="page-link" aria-hidden="true">&lsaquo;</span>
                                                </li>
                                            @else
                                                <li class="page-item">
                                                    <a class="page-link" href="{{ $post->previousPageUrl() }}" rel="prev" aria-label="@lang('pagination.previous')">&lsaquo;</a>
                                                </li>
                                            @endif

                                            <?php
                                                $start = $post->currentPage() - 1; // show 3 pagination links before current
                                                $end = $post->currentPage() + 1; // show 3 pagination links after current
                                                if($start < 1) {
                                                    $start = 1; // reset start to 1
                                                    $end += 1;
                                                } 
                                                if($end >= $post->lastPage() ) $end = $post->lastPage(); // reset end to last page
                                            ?>

                                            @if($start > 1)
                                                <li class="page-item">
                                                    <a class="page-link" href="{{ $post->url(1) }}">{{1}}</a>
                                                </li>
                                                @if($post->currentPage() != 4)
                                                    {{-- "Three Dots" Separator --}}
                                                    <li class="page-item disabled" aria-disabled="true"><span class="page-link">...</span></li>
                                                @endif
                                            @endif
                                                @for ($i = $start; $i <= $end; $i++)
                                                    <li class="page-item {{ ($post->currentPage() == $i) ? ' active' : '' }}">
                                                        <a class="page-link" href="{{ $post->url($i) }}">{{$i}}</a>
                                                    </li>
                                                @endfor
                                            @if($end < $post->lastPage())
                                                @if($post->currentPage() + 3 != $post->lastPage())
                                                    {{-- "Three Dots" Separator --}}
                                                    <li class="page-item disabled" aria-disabled="true"><span class="page-link">...</span></li>
                                                @endif
                                                <li class="page-item">
                                                    <a class="page-link" href="{{ $post->url($post->lastPage()) }}">{{$post->lastPage()}}</a>
                                                </li>
                                            @endif

                                            {{-- Next Page Link --}}
                                            @if ($post->hasMorePages())
                                                <li class="page-item">
                                                    <a class="page-link" href="{{ $post->nextPageUrl() }}" rel="next" aria-label="@lang('pagination.next')">&rsaquo;</a>
                                                </li>
                                            @else
                                                <li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.next')">
                                                    <span class="page-link" aria-hidden="true">&rsaquo;</span>
                                                </li>
                                            @endif
                                        </ul>
                                    @endif
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
                            <h5 class="widget-title mb-10">Berita Terbaru</h5>
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