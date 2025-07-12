@php
    $footerSettings = \App\Models\FooterSetting::first();
    $footerContent = $footerSettings ? $footerSettings->content : '<p class="footer-text">Begin your journey through the realms of endless cultivation</p>';
    $footerCopyright = $footerSettings ? $footerSettings->copyright : '&copy; ' . date('Y') . ' ' . config('pw-config.server_name') . '. All rights reserved.';
    $footerAlignment = $footerSettings ? $footerSettings->alignment : 'center';
@endphp

<!-- Main footer -->
<footer class="footer-main footer-{{ $footerAlignment }}">
    <div class="footer-content">
        {!! $footerContent !!}
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

/* Responsive */
@media (max-width: 640px) {
    .footer-main {
        padding: 20px;
    }
    
    .footer-text {
        font-size: 0.875rem;
    }
}
</style>