@extends('layouts.app')

@section('title')
    {{ $keyword }}
@endsection

@section('content')
<!--archive header-->
<div class="archive-header text-center mb-50 mt-20">
    <div class="container">
        <p class="">Hasil Pencarian</p>
        <h1><span class="color2">{{ $keyword }}</span></h1>
        <p class="font-small color-grey">Kami menemukan {{ $count }} artikel untuk Anda.</p>
    </div>
</div>
<!--main content-->
<div class="main_content sidebar_right pb-50">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-md-12 col-sm-12">
                <!--loop-list-->
                <div class="loop-grid row">
                    @php
                        $no = 1;
                    @endphp
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
                                        <span class="post-cat background{{ $no++; }} color-white">
                                            {{ $sc->name; }}
                                        </span>
                                    </a>
                                @else
                                    <a href="{{ route('home-category', $item->category->slug) }}">
                                        <span class="post-cat background{{ $no++; }} color-white">
                                            {{ $item->category->name; }}
                                        </span>
                                    </a>
                                @endif
                            </div>
                            <h3 class="post-title">
                                <a href="{{ route('post-detail', $item->slug) }}">{{ $item->post_title; }}</a>
                            </h3>
                            <div class="entry-meta meta-1 font-small color-grey mt-15 mb-15">
                                <span class="post-by">By <a href="{{ route('author', $item->user->id) }}">{{ splitName($item->user->name); }}</a></span>
                                <span class="post-on has-dot">{{ date('d F Y', strtotime($item->created_at));}}</span>
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
                                                @php
                                                    $sc = App\Models\Category::where('id', $latest->sub_categories)->first();
                                                @endphp
                                                @if ($latest->sub_categories != NULL)
                                                    <a href="{{ route('home-category', $sc->slug) }}">
                                                        <span class="post-cat background{{ $no++; }} color-white">
                                                            {{ $sc->name; }}
                                                        </span>
                                                    </a>
                                                @else
                                                    <a href="{{ route('home-category', $latest->category->slug) }}">
                                                        <span class="post-cat background{{ $no++; }} color-white">
                                                            {{ $latest->category->name; }}
                                                        </span>
                                                    </a>
                                                @endif
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