<!--Offcanvas sidebar-->
<aside id="sidebar-wrapper" class="custom-scrollbar offcanvas-sidebar position-right"></aside>
<!-- Main Wrap Start -->
<header class="main-header header-style-1 header-style-3">
    <div class="top-bar background4 d-none d-md-block color-white">
        <div class="container">
            <div class="topbar-inner pt-10 pb-10">
                <div class="row">
                    <div class="col-6">
                        <div class="ml-5 d-inline-block">
                            <ul>
                                @php
                                    $today = Carbon\Carbon::parse(date('Y-m-d'))->translatedFormat('l, d F Y');
                                @endphp
                                <li>
                                    <span class="font-small">
                                        <i class="ti-calendar mr-5"></i>{{ $today }}
                                    </span>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-6 text-right">
                        <ul class="header-social-network d-inline-block list-inline color-white">
                            <li class="list-inline-item">
                                <a class="social-icon facebook-icon text-xs-center color-white" target="_blank" href="#">
                                    <i class="ti-facebook"></i>
                                </a>
                            </li>
                            <li class="list-inline-item">
                                <a class="social-icon twitter-icon text-xs-center color-white" target="_blank" href="#">
                                    <i class="ti-twitter-alt"></i>
                                </a>
                            </li>
                            <li class="list-inline-item">
                                <a class="social-icon instagram-icon text-xs-center color-white" target="_blank" href="#">
                                    <i class="ti-instagram"></i>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--End top bar-->
    <!--End top bar-->
    <div class="header-logo background-white pt-20 pb-20 d-none d-lg-block">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-12 align-center-vertical">
                    <a href="{{ route('home') }}">
                        <img class="logo-img d-inline" src="{{ Storage::url($app->logo) }}" alt="" style="height: 60px;">
                    </a>
                </div>
                <div class="col-lg-8 col-md-12 align-center-vertical d-none d-lg-inline text-right">
                    <a href="#">
                         <img class="ads-img d-inline" src="http://via.placeholder.com/380x56" alt="">
                    </a>
                </div>
            </div>
        </div>
    </div>
    <!--End logo-->
    <div class="header-bottom header-sticky background-white text-center">
        <div class="mobile_menu d-lg-none d-block"></div>
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="logo-tablet d-md-inline d-lg-none d-none">
                        <a href="{{ route('home') }}">
                            <img class="logo-img d-inline" src="{{ Storage::url($app->logo) }}" alt="" style="height: 30px;">
                        </a>
                    </div>
                    <div class="logo-mobile d-inline d-md-none">
                        <a href="{{ route('home') }}">
                            <img class="logo-img d-inline" src="{{ Storage::url($app->logo) }}" alt="" style="height: 25px;">
                        </a>
                    </div>
                    <!-- Main-menu -->
                    <div class="main-nav text-left d-none d-lg-block">
                        <nav>
                            <ul id="navigation" class="main-menu">
                                <li><a href="{{ route('home') }}">BERANDA</a></li>
                                @php
                                    $categories = App\Models\Category::where('parent_id', null)->get();
                                @endphp
                                @foreach ($categories as $menu)
                                    @php
                                        $check_sc = App\Models\Category::where('parent_id', $menu->id)->count();
                                        $sub_categories = App\Models\Category::where('parent_id', $menu->id)->get();
                                    @endphp
                                    <li class="{{ ($check_sc > 0)? 'menu-item-has-children':'' }}">
                                        <a href="{{ route('home-category', $menu->slug) }}">
                                            {{ $menu->name }}
                                        </a>
                                        @if ($check_sc > 0)
                                            <ul class="sub-menu">
                                                @foreach ($sub_categories as $submenu)
                                                    <li><a href="{{ route('home-category', $submenu->slug) }}">{{ $submenu->name }}</a></li>
                                                @endforeach
                                                @if ($menu->name == 'Multimedia')
                                                    <li><a href="{{ route('images') }}">Images</a></li>
                                                @endif
                                            </ul>
                                        @endif
                                    </li>
                                @endforeach
                                <li><a href="{{ route('images') }}">IMAGES</a></li>
                            </ul>
                        </nav>
                    </div>
                    <!-- Search -->
                    <div class="search-button">
                        <button class="search-icon"><i class="ti-search"></i></button>
                        <span class="search-close float-right font-small"><i class="ti-close mr-5"></i>CLOSE</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>