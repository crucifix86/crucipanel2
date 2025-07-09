<!-- Footer -->
<footer class="youplay-footer youplay-footer-parallax">

    <div class="image" data-speed="0.4" data-img-position="50% 0%">
        <img src="{{ asset('img/bg/footer.jpg') }}" alt="" class="jarallax-img">
    </div>


    <div class="wrapper">




        <!-- Social Buttons -->
        @php
            $socialLinks = \App\Models\SocialLink::where('active', true)->orderBy('order')->get();
            $footerSettings = \App\Models\FooterSetting::first();
        @endphp
        
        @if($socialLinks->count() > 0)
        <div class="social">
            <div class="container">
                @if($footerSettings && $footerSettings->content)
                    <h3>{!! $footerSettings->content !!}</h3>
                @else
                    <h3>Connect socially with <strong>{{ config('pw-config.server_name') }}</strong></h3>
                @endif

                <div class="social-icons">
                    @foreach($socialLinks as $link)
                    <div class="social-icon">
                        <a href="{{ $link->url }}" target="_blank">
                            <i class="{{ $link->icon }}"></i>
                            <span>{{ $link->platform }}</span>
                        </a>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        @endif
        <!-- /Social Buttons -->



        <!-- Copyright -->
        <div class="copyright">
            <div class="container">
                @if($footerSettings && $footerSettings->copyright)
                    <p>{!! $footerSettings->copyright !!}</p>
                @else
                    <p>{{ date('Y') }} &copy; <strong>{{ config('pw-config.server_name') }}</strong>. All rights reserved</p>
                @endif
                <p>{{ __('Made with') }} &#10084; {{ __('By') }} <a href="https://www.youtube.com/hrace009" target="_blank" class="text-blue-500 hover:underline"
                    >Harris Marfel</a></p>
            </div>
        </div>
        <!-- /Copyright -->

    </div>
</footer>
<!-- /Footer -->
