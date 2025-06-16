@extends('layouts.app')

@section('title')
    Portal Berita Seputar
@endsection

@section('content')

<!--Featured post Start-->
<div class="home-featured">
    <div class="post-carausel-3 post-module-1">
        @php
            $headlineNo = 1;
        @endphp
        @foreach ($headlines as $headline)
        <div class="post-thumb position-relative">
            <div class="thumb-overlay img-hover-slide position-relative" style="background-image: url({{ Storage::url($headline->post->post_image) }})">
                <a class="img-link" href="{{ route('post-detail', $headline->post->slug) }}"></a>a\


                <div class="post-content-overlay ml-30 mr-30">
                    <div class="entry-meta meta-0 font-small mb-20">
                        @php
                            $sc = App\Models\Category::where('id', $headline->post->sub_categories)->first();
                        @endphp
                        @if ($headline->post->sub_categories != NULL)
                            <a href="#">
                                <span class="post-cat background{{ $headlineNo++; }} color-white">
                                    {{ $sc->name; }}
                                </span>
                            </a>
                        @else
                            <a href="#">
                                <span class="post-cat background{{ $headlineNo++; }} color-white">
                                    {{ $headline->post->category->name; }}
                                </span>
                            </a>
                        @endif
                    </div>
                    <h3 class="post-title">
                        <a class="color-white" href="{{ route('post-detail', $headline->post->slug) }}">
                            {{ $headline->post->post_title; }}
                        </a>
                    </h3>
                    <div class="entry-meta meta-1 font-small color-grey mt-10 pr-5 pl-5">
                        <span class="post-on">{{ date('d F Y', strtotime($headline->post->published_at));}}</span>
                        <span class="hit-count has-dot">
                            {{ splitName($headline->post->user->name); }}
                        </span>
                        <a class="float-right" href="#"><i class="ti-heart"></i></a>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
<!--Featured post End-->
<!--  Recent Articles start -->
<div class="recent-area pt-50 pb-50 background12">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 col-md-12">
                <div class="widget-header position-relative mb-30">
                    <h5 class="widget-title mb-30 text-uppercase color1 font-weight-ultra">Update</h5>
                    <div class="letter-background">Update</div>
                </div>
            </div>
            <div class="col-lg-8 col-md-12">
                <div class="news-flash-cover text-right mb-10">
                    <h6 class=""><i class="ti-bolt mr-5"></i>Breaking News</h6>
                    <div id="news-flash" class="d-inline-table">
                        <ul class="right-0">
                            @foreach ($breaking_news as $item)
                                <li>
                                    <a class="font-medium" href="{{ route('post-detail', $item->post->slug) }}">
                                        {{ $item->post->post_title }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-8 col-md-12">
                <div class="loop-list">
                    @php
                        $no = 1;
                    @endphp
                    @foreach ($post as $item)
                    <article class="row mb-50">
                        <div class="col-md-6">
                            <div class="post-thumb position-relative thumb-overlay mr-20">
                                <div class="img-hover-slide border-radius-5 position-relative" style="background-image: url({{ Storage::url($item->post_image) }})">
                                    <a class="img-link" href="{{ route('post-detail', $item->slug) }}"></a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 align-center-vertical">
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
                                <h4 class="post-title">
                                    <a href="{{ route('post-detail', $item->slug) }}">{{ $item->post_title; }}</a>
                                </h4>
                                <div class="entry-meta meta-1 font-small color-grey mt-15 mb-15">
                                    <span class="time-reading">
                                        <i class="ti-user"></i>{{ splitName($item->user->name) }}
                                    </span>
                                    <span class="post-on"><i class="ti-marker-alt"></i>
                                        {{ date('d F Y', strtotime($item->published_at));}}
                                    </span>
                                </div>
                                <p class="font-medium">
                                    {{ $item->post_teaser; }}
                                </p>
                                <a class="readmore-btn font-small text-uppercase font-weight-ultra" href="{{ route('post-detail', $item->slug) }}">
                                    Baca Selengkapnya<i class="ti-arrow-right ml-5"></i>
                                </a>
                            </div>
                        </div>
                    </article>
                    @endforeach
                </div>
                <!--Start pagination -->
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
                                                $start = $post->currentPage() - 1;
                                                $end = $post->currentPage() + 1;
                                                if($start < 1) {
                                                    $start = 1;
                                                    $end += 1;
                                                }
                                                if($end >= $post->lastPage() ) $end = $post->lastPage();
                                            ?>

                                            @if($start > 1)
                                                <li class="page-item">
                                                    <a class="page-link" href="{{ $post->url(1) }}">{{1}}</a>
                                                </li>
                                                @if($post->currentPage() != 4)
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
                <!-- End pagination  -->
            </div>
            <div class="col-lg-4 col-md-12">
                <div class="widget-area">
                    <!--taber-->
                    <div class="sidebar-widget widget-taber mb-30">
                        <div class="widget-taber-content background-white pt-30 pb-30 pl-30 pr-30 border-radius-5">
                            <nav class="tab-nav float-none mb-20">
                                <div class="nav nav-tabs" role="tablist">
                                    <a class="nav-item nav-link active" id="nav-popular-tab" data-toggle="tab" href="#nav-popular" role="tab" aria-controls="nav-popular" aria-selected="true">Teknologi</a>
                                </div>
                            </nav>
                            <div class="tab-content">
                                <!--Tab Tutorial-->
                                <div class="tab-pane fade show active" id="nav-popular" role="tabpanel" aria-labelledby="nav-popular-tab">
                                    <div class="row">
                                        @foreach ($tutorials as $item)
                                        <div class="col-md-6 col-sm-6 sm-grid-content mb-30">
                                            <div class="post-thumb d-flex border-radius-5 img-hover-scale mb-15">
                                                <a href="{{ route('post-detail', $item->slug) }}">
                                                    <img src="{{ Storage::url($item->post_image) }}" alt="">
                                                </a>
                                            </div>
                                            <div class="post-content media-body">
                                                <h6 class="post-title mb-10 text-limit-2-row">
                                                    {{ $item->post_title; }}
                                                </h6>
                                                <div class="entry-meta meta-1 font-x-small color-grey">
                                                    <span class="post-on"><i class="ti-marker-alt"></i>
                                                        {{ date('d F Y', strtotime($item->published_at));}}
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Ads -->
                    <div class="sidebar-widget widget-ads mb-30 text-center">
                        <a href="#">
                            <img class="d-inline-block" src="http://via.placeholder.com/432x200" alt="">
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--Recent Articles End -->
<!-- Recent Posts Start -->
<div class="pt-50 pb-50 background-white">
    <div class="container mb-50">
        <div class="sidebar-widget loop-grid">
            <div class="row">
                <div class="col-lg-4 col-md-12">
                    <div class="widget-header position-relative mb-30">
                        <h5 class="widget-title mb-30 text-uppercase color4 font-weight-ultra">Olahraga</h5>
                        <div class="letter-background">Olahraga</div>
                    </div>
                </div>
                <div class="col-lg-8 col-md-12">
                    <div class="news-flash-cover text-right">

                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="pt-30 bt-1 border-color-1"></div>
                </div>
                @foreach ($gadget as $item)
                <div class="col-lg-4 col-md-6 col-sm-12 mb-30">
                    <div class="post-thumb position-relative thumb-overlay hover-box-shadow-2 mb-30">
                        <div class="img-hover-slide border-radius-5 position-relative" style="background-image: url({{ Storage::url($item->post_image) }})">
                            <a class="img-link" href="{{ route('post-detail', $item->slug) }}"></a>
                            <span class="top-right-icon background8"><i class="mdi mdi-camera-alt"></i></span>
                        </div>
                    </div>
                    <div class="post-content">
                        <div class="entry-meta meta-0 font-small mb-15">
                            <a href="{{ route('home-category', $item->category->slug) }}">
                                <span class="post-cat background1 color-white">
                                    {{ $item->category->name; }}
                                </span>
                            </a>
                        </div>
                        <h4 class="post-title">
                            <a href="{{ route('post-detail', $item->slug) }}">{{ $item->post_title; }}</a>
                        </h4>
                        <div class="entry-meta meta-1 font-small color-grey mt-15 mb-15">
                            <span class="time-reading">
                                <i class="ti-user"></i>{{ splitName($item->user->name) }}
                            </span>
                            <span class="post-on"><i class="ti-marker-alt"></i>
                                {{ date('d F Y', strtotime($item->published_at));}}
                            </span>
                        </div>
                    </div>
                </div>
                @endforeach
                <div class="col-12">
                    <div class="mt-30 bt-1 border-color-1"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="sidebar-widget">
            <div class="widget-header position-relative mb-30">
                <h5 class="widget-title mb-30 text-uppercase color1 font-weight-ultra">Jawa Tengah</h5>
                <div class="letter-background">J</div>
            </div>
            <div class="post-carausel-2 post-module-1 row">
                @foreach ($games as $item)
                <div class="col">
                    <div class="post-thumb position-relative">
                        <div class="thumb-overlay img-hover-slide border-radius-5 position-relative" style="background-image: url({{ Storage::url($item->post_image) }})">
                            <a class="img-link" href="{{ route('post-detail', $item->slug) }}"></a>
                            <span class="top-right-icon background2"><i class="mdi mdi-gamepad"></i></span>
                            <div class="post-content-overlay">
                                <div class="entry-meta meta-0 font-small mb-10">
                                    <a href="{{ route('post-detail', $item->slug) }}">
                                        <span class="post-cat background2 color-white">
                                            {{ $item->category->name; }}
                                        </span>
                                    </a>
                                </div>
                                <h6 class="post-title">
                                    <a class="color-white" href="{{ route('post-detail', $item->slug) }}">{{ $item->post_title; }}</a>
                                </h6>
                                <div class="entry-meta meta-1 font-small color-grey mt-10 pr-5 pl-5">
                                    <span class="time-reading">
                                        <i class="ti-user"></i>{{ splitName($item->user->name) }}
                                    </span>
                                    <span class="post-on"><i class="ti-marker-alt"></i>
                                        {{ date('d F Y', strtotime($item->published_at));}}
                                    </span>
                                    <a class="float-right" href="#"><i class="ti-heart"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
<!-- Recent Posts End -->
@endsection

