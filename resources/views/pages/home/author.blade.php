@extends('layouts.app')

@section('title')
    Author
@endsection

@section('content')
@php
    $app = App\Models\App::where('id', '1')->first();
@endphp
 <!--main content-->
<div class="main_content sidebar_right pb-50 mt-40">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <!--author box-->
                <div class="author-bio mb-50">
                    <div class="author-image mb-30">
                        <a href="{{ route('author', $user->id) }}">
                            @if ($user->profile != NULL)
                                <img src="{{ Storage::url($user->profile) }}" alt="" class="avatar">
                            @else
                                <img src="https://ui-avatars.com/api/?name={{ $user->name; }}" alt="" class="avatar">
                            @endif
                        </a>
                    </div>
                    <div class="author-info">
                        <h3>
                            <span class="vcard author">
                                <span class="fn">
                                    <a href="{{ route('author', $user->id) }}" rel="author">{{ $user->name; }}</a>
                                </span>
                            </span>
                        </h3>
                        <h5>Tentang Penulis</h5>
                        <div class="author-description">
                            Penulis di {{ $app->name }} Sejak {{ date('d F Y', strtotime($user->created_at)); }}
                        </div>
                        <a href="{{ route('author', $user->id) }}" class="author-bio-link mb-15">View all posts</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-8 col-md-12 col-sm-12">
                <div class="related-posts">
                    <div class="loop-list">
                        @php
                            $back=1;
                            $no=1;
                        @endphp
                        @foreach ($post as $item)
                        <article class="row mb-30">
                            <div class="col-md-4">
                                <div class="post-thumb position-relative thumb-overlay">
                                    <div class="img-hover-slide border-radius-5 position-relative" style="background-image: url({{ Storage::url($item->post_image) }})">
                                        <a class="img-link" href="{{ route('post-detail', $item->slug) }}"></a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-8 align-center-vertical">
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
                                        <span class="time-reading"><i class="ti-user"></i>
                                            {{ $item->user->name; }}
                                        </span>
                                        <span class="post-on">
                                            <i class="ti-marker-alt"></i>
                                            {{ date('d F Y', strtotime($item->published_at));}}
                                        </span>
                                    </div>
                                    <p class="font-medium">
                                        {{ $item->post_teaser; }}
                                    </p>
                                </div>
                            </div>
                        </article>
                        @endforeach
                    </div>
                </div>
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
            <!--End sidebar-->
        </div>
    </div>
</div>
@endsection