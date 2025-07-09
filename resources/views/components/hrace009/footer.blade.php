<!-- Main footer -->
<footer class="footer-main">
    <div class="footer-content">
        <div class="footer-left">
            <p class="footer-copyright">
                Copyright © <span id="get-current-year"></span> 
                <a href="{{ route('HOME') }}" target="_blank" class="footer-link">
                    {{ config('pw-config.server_name') }}
                </a>
            </p>
        </div>
        <div class="footer-right">
            <p class="footer-credits">
                {{ __('Made with') }} <span class="footer-heart">♥</span> {{ __('By') }}
                <a href="https://www.youtube.com/hrace009" target="_blank" class="footer-link">
                    <span id="copyright-by"></span>
                </a>
            </p>
        </div>
    </div>
</footer>

<style>
.footer-main {
    position: sticky;
    bottom: 0;
    z-index: 10;
    background: var(--footer-bg, #1a1f2e);
    border-top: 2px solid var(--footer-border, #3a3f4e);
    box-shadow: 0 -2px 10px rgba(0, 0, 0, 0.3);
}

.footer-content {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 1rem 2rem;
    max-width: 100%;
}

.footer-copyright,
.footer-credits {
    margin: 0;
    color: var(--footer-text, #94a3b8);
    font-size: 0.875rem;
}

.footer-link {
    color: var(--footer-link, #a78bfa);
    text-decoration: none;
    transition: all 0.3s ease;
}

.footer-link:hover {
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
.theme-default .footer-main {
    --footer-bg: #1a1f2e;
    --footer-border: #8b5cf6;
    --footer-text: #94a3b8;
    --footer-link: #a78bfa;
    --footer-link-hover: #c4b5fd;
    --footer-link-glow: rgba(139, 92, 246, 0.5);
    --footer-heart: #ec4899;
}

.theme-gamer-dark .footer-main {
    --footer-bg: #1a1a1a;
    --footer-border: #00ff88;
    --footer-text: #ffffff;
    --footer-link: #00ffff;
    --footer-link-hover: #00ff88;
    --footer-link-glow: rgba(0, 255, 136, 0.5);
    --footer-heart: #ff0080;
}

.theme-cyberpunk .footer-main {
    --footer-bg: #1a0f1a;
    --footer-border: #fcee09;
    --footer-text: #ffffff;
    --footer-link: #fcee09;
    --footer-link-hover: #ff0080;
    --footer-link-glow: rgba(252, 238, 9, 0.5);
    --footer-heart: #ff0080;
}

/* Responsive */
@media (max-width: 640px) {
    .footer-content {
        flex-direction: column;
        gap: 0.5rem;
        padding: 1rem;
        text-align: center;
    }
}
</style>