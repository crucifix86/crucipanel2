<!-- Footer -->
<footer class="portal-footer" id="site-footer" style="background-color: var(--footer-bg, #0a0e1a) !important;">
    <!-- Additional isolation wrapper -->
    <div style="position: relative; z-index: 1; contain: layout style paint; isolation: isolate; background: transparent !important;">
    <div class="footer-wrapper">
        @php
            try {
                $socialLinks = \App\Models\SocialLink::where('active', true)->orderBy('order')->get();
                $footerSettings = \App\Models\FooterSetting::first();
            } catch (\Exception $e) {
                $socialLinks = collect();
                $footerSettings = null;
            }
        @endphp
        
        <!-- Social Section -->
        @if($socialLinks->count() > 0)
        <div class="footer-social-section" style="background-color: var(--footer-social-bg, #1a1f2e) !important;">
            <div class="container">
                <div class="social-content">
                    @if($footerSettings && $footerSettings->content)
                        <div class="footer-custom-content">
                            {!! $footerSettings->content !!}
                        </div>
                    @else
                        <h3 class="social-heading">Connect socially with <strong>{{ config('pw-config.server_name') }}</strong></h3>
                    @endif

                    <div class="social-icons-wrapper">
                        @foreach($socialLinks as $link)
                        <a href="{{ $link->url }}" target="_blank" class="social-icon-link" title="{{ $link->platform }}">
                            <div class="social-icon-box">
                                <i class="{{ $link->icon }}"></i>
                            </div>
                            <span class="social-label">{{ $link->platform }}</span>
                        </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        @endif

        <!-- Copyright Section -->
        <div class="footer-copyright-section" style="background-color: var(--footer-copyright-bg, #0a0e1a) !important;">
            <div class="container">
                <div class="copyright-content">
                    <div class="copyright-text">
                        @if($footerSettings && $footerSettings->copyright)
                            <div class="footer-custom-content">
                                {!! $footerSettings->copyright !!}
                            </div>
                        @else
                            <p>{{ date('Y') }} &copy; <strong>{{ config('pw-config.server_name') }}</strong>. All rights reserved</p>
                        @endif
                    </div>
                    <div class="developer-credit">
                        <p>{{ __('Made with') }} <span class="footer-heart">♥</span> {{ __('By') }} 
                            <a href="https://www.youtube.com/hrace009" target="_blank" class="developer-link">Harris Marfel</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
</footer>

<script>
// Scope any style tags in footer to prevent page-wide effects
document.addEventListener('DOMContentLoaded', function() {
    const footerStyles = document.querySelectorAll('#site-footer style');
    footerStyles.forEach(function(styleTag) {
        // Get the CSS text
        let css = styleTag.innerHTML;
        
        // Remove any body/html selectors
        css = css.replace(/\b(body|html)\b[^{]*/g, '#site-footer ');
        
        // Only scope selectors that might affect the page structure
        css = css.replace(/([^{}]+){/g, function(match, selector) {
            // Skip keyframes and media queries
            if (selector.includes('@')) return match;
            
            // Only scope if selector targets structural elements
            if (selector.match(/^\s*(\*|body|html|\.portal-footer|\.footer-social-section|\.footer-copyright-section)/)) {
                const selectors = selector.split(',');
                const scopedSelectors = selectors.map(s => {
                    s = s.trim();
                    if (s && !s.startsWith('#site-footer') && !s.startsWith('.footer-custom-content')) {
                        return '.footer-custom-content ' + s;
                    }
                    return s;
                });
                return scopedSelectors.join(', ') + ' {';
            }
            
            // Leave other selectors untouched
            return match;
        });
        
        // Update the style tag
        styleTag.innerHTML = css;
    });
});
</script>

<style>
.portal-footer {
    background: var(--footer-bg, #0a0e1a);
    margin-top: 4rem;
    position: relative;
    overflow: hidden;
}

.portal-footer::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 2px;
    background: linear-gradient(90deg, 
        transparent, 
        var(--footer-accent, #8b5cf6), 
        var(--footer-accent-secondary, #ec4899),
        var(--footer-accent, #8b5cf6),
        transparent
    );
    animation: footer-glow 3s ease-in-out infinite;
}

@keyframes footer-glow {
    0%, 100% { opacity: 0.6; }
    50% { opacity: 1; }
}


.footer-social-section {
    background: var(--footer-social-bg, #1a1f2e);
    padding: 3rem 0;
    border-bottom: 1px solid var(--footer-border, #3a3f4e);
}

.social-content {
    text-align: {{ $footerSettings->alignment ?? 'center' }};
}

.social-heading {
    color: var(--footer-heading, #e2e8f0);
    font-size: 1.5rem;
    margin-bottom: 2rem;
    font-weight: 300;
}

.social-heading strong {
    color: var(--footer-accent, #8b5cf6);
    font-weight: 600;
}

/* Footer custom content isolation */
.footer-custom-content {
    /* Create a new stacking context */
    position: relative;
    z-index: 1;
    /* Prevent any background styles from leaking out */
    overflow: hidden;
    /* Isolate the content */
    isolation: isolate;
}

/* Scope any styles within custom content to footer only */
.footer-custom-content style {
    /* We'll process style tags to scope them */
}

/* Target any elements that try to style body/html */
.footer-custom-content body,
.footer-custom-content html {
    display: none !important;
}

/* Ensure footer content can't change page background */
.portal-footer {
    /* Create containment boundary */
    contain: layout style paint;
    /* Ensure footer has its own stacking context */
    position: relative;
    z-index: 10;
}

/* Force correct backgrounds on main elements */
html, body {
    /* Use !important to override any injected styles */
    background: var(--body-bg, #1a1f2e) !important;
}

/* Force footer sections to maintain theme backgrounds */
.portal-footer,
.footer-social-section,
.footer-copyright-section {
    background-color: var(--footer-bg, #0a0e1a) !important;
}

.footer-social-section {
    background-color: var(--footer-social-bg, #1a1f2e) !important;
}

.footer-copyright-section {
    background-color: var(--footer-copyright-bg, #0a0e1a) !important;
}

/* Allow custom content to have its own styles while protecting footer structure */
.footer-custom-content {
    /* Allow all content styles except those that would escape */
    all: revert;
}

.social-icons-wrapper {
    display: flex;
    justify-content: {{ $footerSettings->alignment ?? 'center' }};
    flex-wrap: wrap;
    gap: 3rem;
}

.social-icon-link {
    display: flex;
    flex-direction: column;
    align-items: center;
    text-decoration: none;
    transition: all 0.3s ease;
}

.social-icon-box {
    width: 120px;
    height: 120px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: transparent;
    border: none;
    border-radius: 20px;
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
}

.social-icon-box::before {
    content: '';
    position: absolute;
    top: 50%;
    left: 50%;
    width: 0;
    height: 0;
    background: transparent;
    transition: all 0.3s ease;
    transform: translate(-50%, -50%);
    border-radius: 50%;
}

.social-icon-box i {
    font-size: 4rem;
    color: var(--social-icon-color, #94a3b8);
    z-index: 1;
    transition: all 0.3s ease;
}

.social-icon-link:hover .social-icon-box i {
    color: #ffffff;
    transform: scale(1.1);
}

.social-icon-link:hover .social-icon-box {
    transform: translateY(-5px) scale(1.1);
}

/* Fix active/focus states */
.social-icon-link:active .social-icon-box,
.social-icon-link:focus .social-icon-box {
    outline: none;
    transform: translateY(0);
}

.social-icon-link:active .social-icon-box::before {
    opacity: 0.8;
}

/* Prevent default link highlighting */
.social-icon-link {
    -webkit-tap-highlight-color: transparent;
    -webkit-touch-callout: none;
    -webkit-user-select: none;
    user-select: none;
}

.social-label {
    margin-top: 1rem;
    font-size: 1.125rem;
    font-weight: 500;
    color: var(--footer-text, #94a3b8);
    transition: all 0.3s ease;
}

.social-icon-link:hover .social-label {
    color: var(--footer-accent, #8b5cf6);
}

.footer-copyright-section {
    background: var(--footer-copyright-bg, #0a0e1a);
    padding: 2rem 0;
}

.copyright-content {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 1rem;
}

.copyright-text p,
.developer-credit p {
    margin: 0;
    color: var(--footer-text, #94a3b8);
    font-size: 0.875rem;
}

.copyright-text strong {
    color: var(--footer-accent, #8b5cf6);
}

.developer-link {
    color: var(--footer-link, #a78bfa);
    text-decoration: none;
    transition: all 0.3s ease;
}

.developer-link:hover {
    color: var(--footer-link-hover, #c4b5fd);
    text-shadow: 0 0 8px var(--footer-link-glow, rgba(167, 139, 250, 0.5));
}

.footer-heart {
    color: var(--footer-heart, #ec4899);
    animation: heartbeat 1.5s ease-in-out infinite;
}

@keyframes heartbeat {
    0% { transform: scale(1); }
    14% { transform: scale(1.3); }
    28% { transform: scale(1); }
    42% { transform: scale(1.3); }
    70% { transform: scale(1); }
}

/* Theme-specific styles */
.theme-default .portal-footer {
    --footer-bg: #0a0e1a;
    --footer-social-bg: #1a1f2e;
    --footer-copyright-bg: #0a0e1a;
    --footer-border: #3a3f4e;
    --footer-heading: #e2e8f0;
    --footer-text: #94a3b8;
    --footer-accent: #8b5cf6;
    --footer-accent-secondary: #ec4899;
    --footer-link: #a78bfa;
    --footer-link-hover: #c4b5fd;
    --footer-link-glow: rgba(139, 92, 246, 0.5);
    --footer-heart: #ec4899;
    --social-icon-bg: #2a2f3e;
    --social-icon-border: #3a3f4e;
    --social-icon-color: #94a3b8;
    --social-icon-hover-bg: #8b5cf6;
    --social-icon-hover-border: #8b5cf6;
    --social-icon-glow: rgba(139, 92, 246, 0.5);
}

.theme-gamer-dark .portal-footer {
    --footer-bg: #0a0a0a;
    --footer-social-bg: #1a1a1a;
    --footer-copyright-bg: #0a0a0a;
    --footer-border: #333333;
    --footer-heading: #ffffff;
    --footer-text: #ffffff;
    --footer-accent: #00ff88;
    --footer-accent-secondary: #ff0080;
    --footer-link: #00ffff;
    --footer-link-hover: #00ff88;
    --footer-link-glow: rgba(0, 255, 136, 0.5);
    --footer-heart: #ff0080;
    --social-icon-bg: #2a2a2a;
    --social-icon-border: #00ff88;
    --social-icon-color: #00ffff;
    --social-icon-hover-bg: #00ff88;
    --social-icon-hover-border: #00ff88;
    --social-icon-glow: rgba(0, 255, 136, 0.5);
}

.theme-cyberpunk .portal-footer {
    --footer-bg: #000000;
    --footer-social-bg: #1a0f1a;
    --footer-copyright-bg: #000000;
    --footer-border: #333333;
    --footer-heading: #ffffff;
    --footer-text: #ffffff;
    --footer-accent: #fcee09;
    --footer-accent-secondary: #ff0080;
    --footer-link: #fcee09;
    --footer-link-hover: #ff0080;
    --footer-link-glow: rgba(252, 238, 9, 0.5);
    --footer-heart: #ff0080;
    --social-icon-bg: #1a0f1a;
    --social-icon-border: #fcee09;
    --social-icon-color: #fcee09;
    --social-icon-hover-bg: #fcee09;
    --social-icon-hover-border: #fcee09;
    --social-icon-glow: rgba(252, 238, 9, 0.5);
}

/* Platform-specific colors */
.social-icon-link[title="Facebook"]:hover .social-icon-box i { color: #1877f2; }
.social-icon-link[title="Twitter"]:hover .social-icon-box i { color: #1da1f2; }
.social-icon-link[title="Instagram"]:hover .social-icon-box i { color: #e4405f; }
.social-icon-link[title="YouTube"]:hover .social-icon-box i { color: #ff0000; }
.social-icon-link[title="Discord"]:hover .social-icon-box i { color: #5865f2; }
.social-icon-link[title="Twitch"]:hover .social-icon-box i { color: #9146ff; }
.social-icon-link[title="TikTok"]:hover .social-icon-box i { color: #000000; }
.social-icon-link[title="LinkedIn"]:hover .social-icon-box i { color: #0077b5; }
.social-icon-link[title="GitHub"]:hover .social-icon-box i { color: #333333; }
.social-icon-link[title="Reddit"]:hover .social-icon-box i { color: #ff4500; }

/* Responsive */
@media (max-width: 768px) {
    .social-icons-wrapper {
        gap: 1.5rem;
    }
    
    .social-icon-box {
        width: 100px;
        height: 100px;
    }
    
    .social-icon-box i {
        font-size: 3rem;
    }
    
    .social-label {
        font-size: 1rem;
    }
    
    .copyright-content {
        flex-direction: column;
        text-align: center;
    }
}
</style>