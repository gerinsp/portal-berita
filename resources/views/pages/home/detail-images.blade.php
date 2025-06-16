@extends('layouts.app')

@section('title')
    {{ $post->post_title; }}
@endsection

@section('content')
@php
    $app = App\Models\App::where('id', '1')->first();
@endphp
<!--main content-->
<div class="main_content sidebar_right pb-50 pt-50">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-md-12 col-sm-12">
                <div class="entry-header entry-header-1 mb-30">
                    <div class="entry-meta meta-0 font-small mb-15">
                        <a href="{{ route('home-category', $post->category->slug) }}">
                            <span class="post-cat background2 color-white">{{ $post->category->name; }}</span>
                        </a>
                    </div>
                    <h1 class="post-title">
                        <a href="{{ route('post-detail', $post->slug) }}">{{ $post->post_title; }}</a>
                    </h1>
                    <div class="entry-meta meta-1 font-small color-grey mt-15 mb-15">
                        <span class="post-by">By 
                            <a href="{{ route('author', $post->user->id) }}">{{ $post->user->name; }}</a>
                        </span>
                        <span class="post-on has-dot">{{ date('d F Y', strtotime($post->created_at));}}</span>
                    </div>
                    <div class="bt-1 border-color-1 mt-30 mb-30"></div>
                    <div class="single-social-share clearfix ">
                        <div class="entry-meta meta-1 font-small color-grey float-left mt-10"></div>
                         <div class="sharethis-inline-share-buttons"></div>
                    </div>
                </div>
                <!--end entry header-->
                <figure class="single-thumnail">
                    <div class="featured-slider-1 border-radius-5">
                        <div class="featured-slider-1-items">
                            @foreach ($post->galleries as $gallery)
                            <div class="slider-single">
                                <img style="width:900px;" src="{{ Storage::url($gallery->photos ?? '') }}" alt="">
                            </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="arrow-cover"></div>
                    <div class="credit mt-15 font-small color-grey">
                        <i class="ti-credit-card mr-5"></i><span>{{ $post->post_caption; }}</span>
                    </div>
                </figure>
                <div class="entry-main-content">
                    {!! $post->post_content; !!}
                    <table class="table">
                        <tbody>
                            <tr>
                                <th scope="col">Byline/Fotografer</th>
                                <td>{{ $post->post_photographer; }}</td>
                            </tr>
                            <tr>
                                <th scope="col">Source</th>
                                <td>{{ $post->post_source; }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="entry-bottom mt-50 mb-30">
                    <div class="tags">
                        @foreach ($post->tag as $item)
                            <a href="{{ route('home-tag', $item->slug) }}" rel="tag">{{ $item->name; }}</a>
                        @endforeach
                    </div>
                </div>
                <div class="bt-1 border-color-1 mt-30 mb-30"></div>
                <!--author box-->
                <div class="author-bio">
                    <div class="author-image mb-30">
                        @if ($post->user->profile != NULL)
                            <a href="#">
                                <img src="{{ Storage::url($post->user->profile) }}" alt="" class="avatar">
                            </a>
                        @else
                            <a href="#">
                                <img src="https://ui-avatars.com/api/?name={{ $post->user->name; }}" alt="" class="avatar">
                            </a>
                        @endif
                    </div>
                    <div class="author-info">
                        <h3>
                            <span class="vcard author">
                                <span class="fn">
                                    <a href="{{ route('author', $post->user->id) }}" title="Posts by Robert" rel="author">
                                        {{ $post->user->name; }}
                                    </a>
                                </span>
                            </span>
                        </h3>
                        <h5>Tentang Penulis</h5>
                        <div class="author-description">Penulis di {{ $app->name }} Sejak {{ date('d F Y', strtotime($post->user->created_at)); }}</div>
                        <a href="{{ route('author', $post->user->id) }}" class="author-bio-link">Lihat Semua Post</a>
                    </div>
                </div>
                <!--related posts-->
                <div class="related-posts">
                    <h3 class="mb-30">Berita Terkait</h3>
                    <div class="loop-list">
                        @php
                            $related=1;
                        @endphp
                        @foreach ($related_post as $item)                          
                        <article class="row mb-30">
                            <div class="col-md-4">
                                <div class="post-thumb position-relative thumb-overlay">
                                    <div class="img-hover-slide border-radius-5 position-relative" style="background-image: url({{ Storage::url($item->post_image) }}">
                                        <a class="img-link" href="{{ route('post-detail', $item->slug) }}"></a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-8 align-center-vertical">
                                <div class="post-content">
                                    <div class="entry-meta meta-0 font-small mb-15">
                                        <a href="{{ route('home-category', $item->category->slug) }}">
                                            <span class="post-cat background{{ $related++; }} color-white">
                                                {{ $item->category->name }}
                                            </span>
                                        </a>
                                    </div>
                                    <h4 class="post-title">
                                        <a href="{{ route('post-detail', $item->slug) }}">
                                            {{ $item->post_title }}
                                        </a>
                                    </h4>
                                    <div class="entry-meta meta-1 font-small color-grey mt-15 mb-15">
                                        <span class="post-on"><i class="ti-marker-alt"></i> 
                                            {{ date('d F Y', strtotime($item->created_at));}}
                                        </span>
                                        <span class="time-reading"><i class="ti-user"></i>
                                            {{ splitName($item->user->name) }}
                                        </span>
                                    </div>
                                    <p class="font-medium">
                                        {{ $item->post_teaser }}
                                    </p>
                                </div>
                            </div>
                        </article>
                        @endforeach
                    </div>
                </div>
            </div>
            <!--col-lg-8-->
            <!--Right sidebar-->
            <div class="col-lg-4 col-md-12 col-sm-12 primary-sidebar sticky-sidebar">
                <div class="widget-area pl-30">
                    <!--Widget latest posts style 1-->
                    <div class="sidebar-widget widget_alitheme_lastpost mb-50">
                        <div class="widget-header position-relative mb-20 pb-10">
                            <h5 class="widget-title mb-10">Berita Terbaru</h5>
                            <div class="bt-1 border-color-1"></div>
                        </div>
                        <div class="row">
                            @foreach ($latest_post as $item)                          
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
                                        <span class="post-on">
                                            {{ date('d F Y', strtotime($item->created_at));}}
                                        </span>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <!--End sidebar-->
        </div>
    </div>
</div>
@endsection
@push('addon-style')
<script type="text/javascript" src="https://platform-api.sharethis.com/js/sharethis.js#property=61acbda059afaf001ae4aa06&product=inline-share-buttons" async="async"></script>
@endpush