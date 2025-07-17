@php
    $footerSettings = \App\Models\FooterSetting::first();
    $footerContent = $footerSettings ? $footerSettings->content : '<p class="footer-text">Begin your journey through the realms of endless cultivation</p>';
    $footerCopyright = $footerSettings ? $footerSettings->copyright : '&copy; ' . date('Y') . ' ' . config('pw-config.server_name') . '. All rights reserved.';
    $footerAlignment = $footerSettings ? $footerSettings->alignment : 'center';
    
    // Get social links
    try {
        $socialLinks = \App\Models\SocialLink::where('active', true)->orderBy('order')->get();
    } catch (\Exception $e) {
        $socialLinks = collect();
    }
@endphp

<!-- Main footer -->
<footer class="footer-main footer-{{ $footerAlignment }}">
    <div class="footer-content">
        {!! $footerContent !!}
        
        @if($socialLinks->count() > 0)
        <div class="social-links">
            @foreach($socialLinks as $link)
            <a href="{{ $link->url }}" target="_blank" class="social-link" title="{{ $link->platform }}">
                <i class="{{ $link->icon }}"></i>
            </a>
            @endforeach
        </div>
        @endif
        
        <p class="footer-text">{!! $footerCopyright !!}</p>
    </div>
</footer>

<style>
.footer-main {
    background: linear-gradient(135deg, rgba(0, 0, 0, 0.3), rgba(147, 112, 219, 0.05));
    border-top: 2px solid rgba(147, 112, 219, 0.3);
    padding: 30px 40px;
    color: #b19cd9;
}

.footer-content {
    max-width: 1200px;
    margin: 0 auto;
}

.footer-text {
    margin: 10px 0;
    color: #b19cd9;
    font-size: 0.95rem;
    line-height: 1.6;
}

.footer-text a {
    color: #9370db;
    text-decoration: none;
    transition: all 0.3s ease;
}

.footer-text a:hover {
    color: #8a2be2;
    text-shadow: 0 0 10px rgba(147, 112, 219, 0.6);
}

/* Alignment classes */
.footer-left {
    text-align: left;
}

.footer-center {
    text-align: center;
}

.footer-right {
    text-align: right;
}

/* Social Links */
.social-links {
    margin: 20px 0;
    display: flex;
    gap: 15px;
    justify-content: center;
    flex-wrap: wrap;
}

.footer-left .social-links {
    justify-content: flex-start;
}

.footer-right .social-links {
    justify-content: flex-end;
}

.social-link {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 40px;
    height: 40px;
    background: rgba(147, 112, 219, 0.2);
    border: 1px solid rgba(147, 112, 219, 0.4);
    border-radius: 50%;
    color: #b19cd9;
    text-decoration: none;
    transition: all 0.3s ease;
}

.social-link:hover {
    background: rgba(147, 112, 219, 0.4);
    border-color: #9370db;
    color: #fff;
    transform: translateY(-3px);
    box-shadow: 0 5px 15px rgba(147, 112, 219, 0.4);
}

.social-link i {
    font-size: 1.2rem;
}

/* Platform specific colors on hover */
.social-link[title="Facebook"]:hover {
    background: #1877f2;
    border-color: #1877f2;
}

.social-link[title="Twitter"]:hover,
.social-link[title="X"]:hover {
    background: #1da1f2;
    border-color: #1da1f2;
}

.social-link[title="Instagram"]:hover {
    background: linear-gradient(45deg, #f58529, #dd2a7b, #8134af, #515bd4);
    border-color: #dd2a7b;
}

.social-link[title="YouTube"]:hover {
    background: #ff0000;
    border-color: #ff0000;
}

.social-link[title="Discord"]:hover {
    background: #5865f2;
    border-color: #5865f2;
}

.social-link[title="TikTok"]:hover {
    background: #000;
    border-color: #000;
}

.social-link[title="LinkedIn"]:hover {
    background: #0077b5;
    border-color: #0077b5;
}

.social-link[title="Twitch"]:hover {
    background: #9146ff;
    border-color: #9146ff;
}

/* Responsive */
@media (max-width: 640px) {
    .footer-main {
        padding: 20px;
    }
    
    .footer-text {
        font-size: 0.875rem;
    }
    
    .social-link {
        width: 35px;
        height: 35px;
    }
    
    .social-link i {
        font-size: 1rem;
    }
}
</style>