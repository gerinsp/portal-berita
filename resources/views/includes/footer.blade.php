<footer>
    <!-- Footer Start-->
    <!-- footer-bottom aera -->
    <div class="footer-bottom-area background11">
        <div class="container">
            <div class="footer-border pt-30 pb-30">
                <div class="row d-flex align-items-center justify-content-between">
                    <div class="col-lg-6">
                        <div class="footer-copy-right">
                            <p class="font-medium">© {{ $app->name }} | {{ $app->title }} </p>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="footer-menu float-lg-right mt-lg-0 mt-3">
                            <ul class="font-medium">
                                <li><a href="{{ route('redaksi') }}">Redaksi</a></li>
                                <li><a href="{{ route('pedoman') }}">Pedoman</a></li>
                                <li><a href="{{ route('disclaimer') }}">Disclaimer</a></li>
                                <li><a href="{{ route('kontak') }}">Kontak</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Footer End-->
</footer>