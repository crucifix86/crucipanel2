{{-- Theme Toggle Button for Home Page --}}
<button id="theme-toggle" class="btn btn-sm theme-toggle-btn" title="Toggle theme">
    <i class="fas fa-moon" id="theme-icon"></i>
</button>

<style>
    .theme-toggle-btn {
        background: rgba(255, 255, 255, 0.1);
        border: 2px solid rgba(255, 255, 255, 0.3);
        color: rgba(255, 255, 255, 0.9);
        padding: 8px 12px;
        border-radius: 8px;
        transition: all 0.3s ease;
        backdrop-filter: blur(10px);
    }
    
    .theme-toggle-btn:hover {
        background: rgba(255, 255, 255, 0.1);
        border-color: var(--accent-primary);
        color: var(--accent-primary);
        transform: translateY(-2px);
    }
    
    .theme-toggle-btn i {
        font-size: 16px;
        transition: transform 0.3s ease;
    }
    
    .theme-toggle-btn:hover i {
        transform: rotate(20deg);
    }
    
    /* Light mode styles */
    body:not(.dark-mode) .theme-toggle-btn {
        border-color: rgba(0, 0, 0, 0.2);
        color: var(--text-primary);
    }
    
    body:not(.dark-mode) .theme-toggle-btn:hover {
        background: var(--hover-bg);
        border-color: var(--accent-primary);
        color: var(--accent-primary);
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const themeToggle = document.getElementById('theme-toggle');
    const themeIcon = document.getElementById('theme-icon');
    const body = document.body;
    
    // Check for saved theme preference or default to dark mode
    const currentTheme = localStorage.getItem('theme') || 'dark';
    
    // Apply the theme
    if (currentTheme === 'light') {
        body.classList.remove('dark-mode');
        themeIcon.classList.remove('fa-moon');
        themeIcon.classList.add('fa-sun');
    } else {
        body.classList.add('dark-mode');
        themeIcon.classList.remove('fa-sun');
        themeIcon.classList.add('fa-moon');
    }
    
    // Theme toggle functionality
    themeToggle.addEventListener('click', function() {
        if (body.classList.contains('dark-mode')) {
            // Switch to light mode
            body.classList.remove('dark-mode');
            themeIcon.classList.remove('fa-moon');
            themeIcon.classList.add('fa-sun');
            localStorage.setItem('theme', 'light');
        } else {
            // Switch to dark mode
            body.classList.add('dark-mode');
            themeIcon.classList.remove('fa-sun');
            themeIcon.classList.add('fa-moon');
            localStorage.setItem('theme', 'dark');
        }
    });
});
</script>