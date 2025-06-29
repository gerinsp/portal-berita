@php
    $app = App\Models\App::where('id', '1')->first();
@endphp
<!DOCTYPE html>
<html class="no-js" lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $app->title }} - {{ $app->name }}</title>
    {{-- Meta --}}
    <meta name="description" content="{{ (isset($post->post_teaser))? $post->post_teaser : $app->description  }}">
    {{-- Meta Facebook --}}
    <meta property="og:title" content="{{ (isset($post->post_title))? $post->post_title : $app->title }}" />
    <meta property="og:type" content="{{ (isset($post->category->name))? $post->category->name : 'News' }}" />
    <meta property="og:url" content="{{ (isset($post->slug))? route('post-detail', $item->slug) : $app->link_web }}" />
    <meta property="og:image" content="{{ (isset($post->post_image))? Storage::url($post->post_image) : $app->link_web }}" />
    {{-- Meta Twitter --}}
    <meta name="twitter:title" content="{{ (isset($post->post_title))? $post->post_title : $app->title }}">
    <meta name="twitter:description" content="{{ (isset($post->post_teaser))? $post->post_teaser : $app->description }}">
    <meta name="twitter:image" content="{{ (isset($post->post_image))? Storage::url($post->post_image) : $app->link_web }}">
    <meta name="twitter:card" content="{{ (isset($post->post_image))? Storage::url($post->post_image) : $app->link_web }}">

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/x-icon" href="{{ Storage::url($app->favicon) }}"/>
    <link rel="stylesheet" href="{{ asset('/assets/css/chat.css') }}">

    <!-- CSS  -->
    @stack('prepend-style')
    @include('includes.style')
    @stack('addon-style')
</head>

<body>
    <div class="scroll-progress primary-bg"></div>
    <!-- Preloader Start -->
    <div id="preloader-active">
        <div class="preloader d-flex align-items-center justify-content-center">
            <div class="preloader-inner position-relative">
                <div class="text-center">
                    <div data-loader="spinner"></div>
                    <p>Loading...</p>
                </div>
            </div>
        </div>
    </div>
    <div class="main-wrap">
        {{-- Navigation --}}
        @include('includes.navbar')
        <main class="position-relative">
            @include('includes.search')
            @yield('content')
        </main>
        <div class="chat-widget">
            <!-- Chat Button -->
            <button class="chat-button" id="chatButton">
                <span id="chatIcon">💬</span>
                <div class="notification-badge" id="notificationBadge">1</div>
            </button>

            <!-- Chat Container -->
            <div class="chat-container" id="chatContainer">
                <!-- Chat Header -->
                <div class="chat-header">
                    <div>
                        <h3 style="color: white">News Chatbot</h3>
                        <div class="chat-status" id="chatStatus">Online</div>
                    </div>
                    <button class="close-chat" id="closeChat">×</button>
                </div>

                <!-- Chat Messages -->
                <div class="chat-messages" id="chatMessages">
                    <div class="message bot">
                        <div>Hi! How can I help you today?</div>
                        <div class="message-time">Just now</div>
                    </div>
                </div>

                <!-- Typing Indicator -->
                <div class="typing-indicator" id="typingIndicator">
                    <div class="typing-dots">
                        <div class="typing-dot"></div>
                        <div class="typing-dot"></div>
                        <div class="typing-dot"></div>
                    </div>
                    <span>Chatbot is typing...</span>
                </div>

                <!-- Quick Replies -->
                <div class="quick-replies" id="quickReplies">
                    <button class="quick-reply-btn" data-message="Berita terkini">
                        <span class="icon">👋</span>
                        Berita terkini
                    </button>
                    <button class="quick-reply-btn" data-message="Layanan di tvri">
                        <span class="icon">🙏</span>
                        Layanan di tvri
                    </button>
                    <button class="quick-reply-btn" data-message="Form Pengajuan tvri">
                        <span class="icon">📦</span>
                        Daftar formulir Pengajuan di tvri
                    </button>
                </div>

                <!-- Chat Input -->
                <div class="chat-input">
                    <div class="input-group">
                    <textarea
                        id="messageInput"
                        placeholder="Type your message..."
                        rows="1"
                    ></textarea>
                    </div>
                    <button class="send-button" id="sendButton">
                        <span>➤</span>
                    </button>
                </div>
            </div>
        </div>
        {{-- Footer --}}
        @include('includes.footer')
    </div>
    <!-- Main Wrap End-->
    <div class="dark-mark"></div>
    <!-- Vendor JS-->
    <script src="{{ asset('/assets/js/chat.js') }}"></script>
    @stack('prepend-script')
    @include('includes.script')
    @stack('addon-script')
</body>

</html>
