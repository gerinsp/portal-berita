<nav class="sidenav shadow-right sidenav-light">
    <div class="sidenav-menu">
        <div class="nav accordion" id="accordionSidenav">
            <!-- Sidenav Menu Heading (Account)-->
            <!-- * * Note: * * Visible only on and above the sm breakpoint-->
            <div class="sidenav-menu-heading d-sm-none">Account</div>
            <!-- Sidenav Link (Alerts)-->
            <!-- * * Note: * * Visible only on and above the sm breakpoint-->
            <a class="nav-link d-sm-none" href="#!">
                <div class="nav-link-icon"><i data-feather="bell"></i></div>
                Alerts
                <span class="badge bg-warning-soft text-warning ms-auto">4 New!</span>
            </a>
            <!-- Sidenav Link (Messages)-->
            <!-- * * Note: * * Visible only on and above the sm breakpoint-->
            <a class="nav-link d-sm-none" href="#!">
                <div class="nav-link-icon"><i data-feather="mail"></i></div>
                Messages
                <span class="badge bg-success-soft text-success ms-auto">2 New!</span>
            </a>
            <!-- Sidenav Menu Heading (Core)-->
            <div class="sidenav-menu-heading">Menu</div>
            <!-- Sidenav Link (Dashboard)-->
            <a class="nav-link {{ (request()->is('admin') || request()->is('admin/dashboard')) ? 'active' : '' }}" href="{{ route('admin-dashboard') }}">
                <div class="nav-link-icon"><i data-feather="activity"></i></div>
                Dashboard
            </a>
            <!-- Sidenav Accordion (Posts)-->
            <a class="nav-link {{ (request()->is('admin/pos*')) ? 'active' : '' }}" href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#pos-menu" aria-expanded="false" aria-controls="pos-menu">
                <div class="nav-link-icon"><i data-feather="file-text"></i></div>
                Post
                <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
            </a>
            <div class="collapse {{ (request()->is('admin/pos*')) ? 'show' : '' }}" id="pos-menu" data-bs-parent="#pos-menu">
                <nav class="sidenav-menu-nested nav" id="pos-menu">
                    <a class="nav-link {{ (request()->is('admin/pos/post') || request()->is('admin/pos/post/*/edit') || request()->is('admin/pos/published') || request()->is('admin/pos/draft') || request()->is('admin/pos/trash')) ? 'active' : '' }}" href="{{ route('post.index') }}" href="animations.html">Semua Post</a>
                    @if (Auth::user()->roles == 'Administrator' || Auth::user()->roles == 'Penulis')
                    <a class="nav-link {{ (request()->is('admin/pos/post/create')) ? 'active' : '' }}" href="{{ route('post.create') }}">Tambah Baru</a>
                    @endif
                    @if (Auth::user()->roles == 'Administrator')
                        <a class="nav-link {{ (request()->is('admin/pos/category*')) ? 'active' : '' }}" href="{{ route('category.index') }}">Kategori</a>
                        <a class="nav-link {{ (request()->is('admin/pos/tag*')) ? 'active' : '' }}" href="{{ route('tag.index') }}">Tag</a>
                    @endif
                </nav>
            </div>
            <!-- Sidenav Link (Foto)-->
            <a class="nav-link {{ (request()->is('admin/photo*')) ? 'active' : '' }}" href="{{ route('photo.index') }}">
                <div class="nav-link-icon"><i data-feather="camera"></i></div>
                Foto
            </a>
            <!-- Sidenav Link (Video)-->
            {{-- <a class="nav-link {{ (request()->is('admin/video*')) ? 'active' : '' }}" href="{{ route('video.index') }}">
                <div class="nav-link-icon"><i data-feather="film"></i></div>
                Video
            </a> --}}
            @if (Auth::user()->roles == 'Administrator')
                <!-- Sidenav Link (Video)-->
                <a class="nav-link {{ (request()->is('admin/breaking-news*')) ? 'active' : '' }}" href="{{ route('breaking-news') }}">
                    <div class="nav-link-icon"><i data-feather="list"></i></div>
                    Breaking News
                </a>
                <!-- Sidenav Link (Video)-->
                <a class="nav-link {{ (request()->is('admin/headline*')) ? 'active' : '' }}" href="{{ route('headline') }}">
                    <div class="nav-link-icon"><i data-feather="list"></i></div>
                    Headline
                </a>
                <a class="nav-link {{ (request()->is('admin/page*')) ? 'active' : '' }}" href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#collapsePages" aria-expanded="false" aria-controls="collapsePages">
                    <div class="nav-link-icon"><i data-feather="file-text"></i></div>
                    Pages
                    <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse {{ (request()->is('admin/page*')) ? 'show' : '' }}" id="collapsePages" data-bs-parent="#accordionSidenav">
                    <nav class="sidenav-menu-nested nav">
                        <a class="nav-link {{ (request()->is('admin/page/redaction')) ? 'active' : '' }}" href="{{ route('redaction.index') }}">Redaksi</a>
                        <a class="nav-link {{ (request()->is('admin/page/guideline')) ? 'active' : '' }}" href="{{ route('guideline.index') }}">Pedoman</a>
                        <a class="nav-link {{ (request()->is('admin/page/disclaimer')) ? 'active' : '' }}" href="{{ route('disclaimer.index') }}">Disclaimer</a>
                        <a class="nav-link {{ (request()->is('admin/page/contact')) ? 'active' : '' }}" href="{{ route('contact.index') }}">Kontak</a>
                    </nav>
                </div>
            @endif
            <!-- Sidenav Accordion (Pengguna)-->
            <a class="nav-link {{ (request()->is('admin/users*')) ? 'active' : '' }}" href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#collapseUtilities" aria-expanded="false" aria-controls="collapseUtilities">
                <div class="nav-link-icon"><i data-feather="user"></i></div>
                Pengguna
                <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
            </a>
            <div class="collapse {{ (request()->is('admin/users*')) ? 'show' : '' }}" id="collapseUtilities" data-bs-parent="#accordionSidenav">
                <nav class="sidenav-menu-nested nav">
                    @if (Auth::user()->roles == 'Administrator')
                        <a class="nav-link {{ (request()->is('admin/users/user')) ? 'active' : '' }}" href="{{ route('user.index') }}">Semua Pengguna</a>
                        <a class="nav-link {{ (request()->is('admin/users/user/create')) ? 'active' : '' }}" href="{{ route('user.create') }}">Tambah Baru</a>
                    @endif
                    <a class="nav-link {{ (request()->is('admin/users/user/profile') || request()->is('admin/users/user/profile/password')) ? 'active' : '' }}" href="{{ route('profile-user') }}">Profil</a>
                </nav>
            </div>
            @if (Auth::user()->roles == 'Administrator')
                <!-- Sidenav Link (Pengaturan)-->
                <a class="nav-link {{ (request()->is('admin/settings*')) ? 'active' : '' }}" href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#collapseSettings" aria-expanded="false" aria-controls="collapseSettings">
                    <div class="nav-link-icon"><i data-feather="settings"></i></div>
                    Pengaturan
                    <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse {{ (request()->is('admin/settings*')) ? 'show' : '' }}" id="collapseSettings" data-bs-parent="#accordionSidenav">
                    <nav class="sidenav-menu-nested nav">
                        <a class="nav-link {{ (request()->is('admin/settings/breaking-news')) ? 'active' : '' }}" href="{{ route('breaking-news.index') }}">Breaking News</a>
                        <a class="nav-link {{ (request()->is('admin/settings/headline')) ? 'active' : '' }}" href="{{ route('headline.index') }}">Headline</a>
                        <a class="nav-link {{ (request()->is('admin/settings/apps')) ? 'active' : '' }}" href="{{ route('apps.index') }}">Aplikasi</a>
                    </nav>
                </div>
            @endif
        </div>
    </div>
    <!-- Sidenav Footer-->
    <div class="sidenav-footer">
        <div class="sidenav-footer-content">
            <div class="sidenav-footer-subtitle">Logged in as:</div>
            <div class="sidenav-footer-title">{{ Auth::user()->name }}</div>
        </div>
    </div>
</nav>