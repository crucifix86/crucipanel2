/* =====================================================
   MYSTICAL PURPLE THEME - UNIFIED JAVASCRIPT
   ===================================================== */

// ===========================================
// 1. PARTICLE SYSTEM
// ===========================================
function createParticles() {
    const particlesContainer = document.querySelector('.floating-particles');
    if (!particlesContainer) return;
    
    const numberOfParticles = 60;

    for (let i = 0; i < numberOfParticles; i++) {
        const particle = document.createElement('div');
        particle.className = 'particle';
        particle.style.left = Math.random() * 100 + '%';
        particle.style.top = 100 + '%';
        particle.style.animationDelay = Math.random() * 8 + 's';
        particle.style.animationDuration = (Math.random() * 6 + 6) + 's';
        
        // Random purple colors for particles
        const colors = ['#9370db', '#8a2be2', '#4b0082', '#6a5acd'];
        const color = colors[Math.floor(Math.random() * colors.length)];
        particle.style.background = `linear-gradient(45deg, ${color}, ${color}aa)`;
        particle.style.boxShadow = `0 0 10px ${color}`;
        
        particlesContainer.appendChild(particle);
    }
}

// ===========================================
// 2. WIDGET COLLAPSE FUNCTIONALITY
// ===========================================
function initializeCollapsibleWidgets() {
    // Login Box
    const loginBox = document.getElementById('loginBox');
    if (loginBox) {
        const savedLoginState = localStorage.getItem('loginBoxCollapsed');
        if (savedLoginState === 'false') {
            loginBox.classList.remove('collapsed');
        }
    }
    
    // Visit Reward Box
    const visitRewardBox = document.getElementById('visitRewardBox');
    if (visitRewardBox) {
        const savedRewardState = localStorage.getItem('visitRewardBoxCollapsed');
        if (savedRewardState === 'true') {
            visitRewardBox.classList.add('collapsed');
        }
    }
}

function toggleLoginBox() {
    const loginBox = document.getElementById('loginBox');
    if (!loginBox) return;
    
    loginBox.classList.toggle('collapsed');
    const isCollapsed = loginBox.classList.contains('collapsed');
    localStorage.setItem('loginBoxCollapsed', isCollapsed);
}

function toggleVisitRewardBox() {
    const rewardBox = document.getElementById('visitRewardBox');
    if (!rewardBox) return;
    
    rewardBox.classList.toggle('collapsed');
    const isCollapsed = rewardBox.classList.contains('collapsed');
    localStorage.setItem('visitRewardBoxCollapsed', isCollapsed);
}

// ===========================================
// 3. DROPDOWN MENU HANDLING
// ===========================================
function initializeDropdowns() {
    document.addEventListener('click', function(event) {
        const dropdowns = document.querySelectorAll('.nav-dropdown');
        dropdowns.forEach(dropdown => {
            if (!dropdown.contains(event.target)) {
                dropdown.classList.remove('active');
            }
        });
    });
}

// ===========================================
// 4. PIN FIELD FUNCTIONALITY
// ===========================================
function initializePinField() {
    const usernameInput = document.querySelector('input[name="name"]');
    const pinField = document.getElementById('pin-field');
    
    if (usernameInput && pinField) {
        usernameInput.addEventListener('blur', function() {
            if (this.value.length > 2) {
                pinField.style.display = 'block';
            }
        });
    }
}

// ===========================================
// 5. PAGE ENTRANCE ANIMATION
// ===========================================
function initializePageAnimation() {
    const container = document.querySelector('.container');
    if (container) {
        container.style.animation = 'fadeInUp 1.5s ease-out';
    }
}

// ===========================================
// 6. NOTIFICATION SYSTEM
// ===========================================
function showNotification(type, message, duration = 5000) {
    // Remove any existing notifications
    const existingNotif = document.querySelector('.mystical-notification');
    if (existingNotif) {
        existingNotif.remove();
    }
    
    // Create notification element
    const notification = document.createElement('div');
    notification.className = 'mystical-notification';
    
    let bgColor, borderColor, textColor, icon;
    switch(type) {
        case 'success':
            bgColor = 'rgba(16, 185, 129, 0.2)';
            borderColor = '#10b981';
            textColor = '#10b981';
            icon = '✓';
            break;
        case 'info':
            bgColor = 'rgba(59, 130, 246, 0.2)';
            borderColor = '#3b82f6';
            textColor = '#3b82f6';
            icon = 'ℹ️';
            break;
        case 'warning':
            bgColor = 'rgba(245, 158, 11, 0.2)';
            borderColor = '#f59e0b';
            textColor = '#f59e0b';
            icon = '⚠️';
            break;
        default:
            bgColor = 'rgba(239, 68, 68, 0.2)';
            borderColor = '#ef4444';
            textColor = '#ef4444';
            icon = '✗';
    }
    
    notification.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        background: ${bgColor};
        border: 2px solid ${borderColor};
        padding: 20px 30px;
        border-radius: 15px;
        z-index: 10000;
        max-width: 400px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
        animation: slideIn 0.3s ease-out;
    `;
    
    notification.innerHTML = `
        <div style="display: flex; align-items: center; gap: 15px;">
            <span style="font-size: 1.5rem;">${icon}</span>
            <span style="color: ${textColor}; font-size: 1.1rem; font-weight: 600;">${message}</span>
        </div>
    `;
    
    document.body.appendChild(notification);
    
    // Auto-remove after duration
    setTimeout(() => {
        notification.style.animation = 'slideOut 0.3s ease-out';
        setTimeout(() => notification.remove(), 300);
    }, duration);
}

// ===========================================
// 7. CHARACTER DROPDOWN TOGGLE
// ===========================================
function toggleCharacters(id) {
    const element = document.getElementById(id);
    if (element) {
        element.style.display = element.style.display === 'none' ? 'block' : 'none';
    }
}

// ===========================================
// 8. NEWS POPUP HANDLING
// ===========================================
function openNewsPopup(slug) {
    const popup = document.getElementById('newsPopup');
    const content = document.getElementById('newsContent');
    
    if (!popup || !content) return;
    
    // Show loading state
    content.innerHTML = '<div style="text-align: center; padding: 40px;"><div style="font-size: 3rem; animation: spin 1s linear infinite;">⏳</div><p style="margin-top: 20px; color: #b19cd9;">Loading article...</p></div>';
    
    // Show popup
    popup.style.display = 'block';
    document.body.style.overflow = 'hidden';
    
    // Fetch article content
    fetch('/api/news/' + slug)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                content.innerHTML = `
                    <span class="news-icon" style="font-size: 3rem; display: block; text-align: center; margin-bottom: 20px;">
                        ${data.article.category === 'update' ? '✨' : 
                          data.article.category === 'event' ? '🎆' : 
                          data.article.category === 'maintenance' ? '🔧' : '📜'}
                    </span>
                    <h1 style="font-size: 2.5rem; color: #9370db; text-align: center; margin-bottom: 20px; text-shadow: 0 0 20px rgba(147, 112, 219, 0.8);">${data.article.title}</h1>
                    <div style="text-align: center; margin-bottom: 30px;">
                        <span style="color: #b19cd9; margin-right: 20px;">📅 ${data.article.date}</span>
                        <span style="background: rgba(147, 112, 219, 0.2); padding: 5px 15px; border-radius: 20px; color: #dda0dd;">${data.article.category}</span>
                    </div>
                    <div style="line-height: 1.8; font-size: 1.1rem;">${data.article.content}</div>
                    ${data.article.author ? '<p style="text-align: right; margin-top: 30px; color: #b19cd9; font-style: italic;">— ' + data.article.author + '</p>' : ''}
                `;
            } else {
                content.innerHTML = '<div style="text-align: center; padding: 40px;"><p style="color: #ef4444;">Failed to load article</p></div>';
            }
        })
        .catch(error => {
            content.innerHTML = '<div style="text-align: center; padding: 40px;"><p style="color: #ef4444;">Error loading article</p></div>';
        });
}

function closeNewsPopup() {
    const popup = document.getElementById('newsPopup');
    if (popup) {
        popup.style.display = 'none';
        document.body.style.overflow = 'auto';
    }
}

// ===========================================
// 9. VISIT REWARD FUNCTIONALITY
// ===========================================
let rewardCountdownInterval = null;

function checkVisitRewardStatus() {
    if (!window.visitRewardData) return;
    
    const claimBtn = document.getElementById('claimRewardBtn');
    const timerDiv = document.getElementById('rewardTimer');
    const countdownSpan = document.getElementById('rewardCountdown');
    
    if (!claimBtn || !timerDiv) return;
    
    if (window.visitRewardData.canClaim) {
        claimBtn.textContent = window.visitRewardTranslations.checkIn;
        claimBtn.disabled = false;
        timerDiv.style.display = 'none';
        
        // Clear any existing countdown
        if (rewardCountdownInterval) {
            clearInterval(rewardCountdownInterval);
            rewardCountdownInterval = null;
        }
    } else {
        claimBtn.textContent = window.visitRewardTranslations.claimed;
        claimBtn.disabled = true;
        timerDiv.style.display = 'block';
        
        // Start countdown
        startRewardCountdown(window.visitRewardData.secondsUntilNext);
    }
}

function startRewardCountdown(seconds) {
    const countdownSpan = document.getElementById('rewardCountdown');
    if (!countdownSpan) return;
    
    let remainingSeconds = seconds;
    
    // Clear any existing countdown
    if (rewardCountdownInterval) {
        clearInterval(rewardCountdownInterval);
    }
    
    function updateCountdown() {
        if (remainingSeconds <= 0) {
            clearInterval(rewardCountdownInterval);
            checkVisitRewardStatus(); // Recheck status when timer expires
            return;
        }
        
        const hours = Math.floor(remainingSeconds / 3600);
        const minutes = Math.floor((remainingSeconds % 3600) / 60);
        const seconds = remainingSeconds % 60;
        
        countdownSpan.textContent = 
            String(hours).padStart(2, '0') + ':' +
            String(minutes).padStart(2, '0') + ':' +
            String(seconds).padStart(2, '0');
        
        remainingSeconds--;
    }
    
    updateCountdown(); // Initial update
    rewardCountdownInterval = setInterval(updateCountdown, 1000);
}

function claimVisitReward() {
    const claimBtn = document.getElementById('claimRewardBtn');
    if (!claimBtn) return;
    
    claimBtn.disabled = true;
    claimBtn.textContent = window.visitRewardTranslations.claiming;
    
    fetch('/api/visit-reward/claim', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({ user_id: window.visitRewardData.userId }),
        credentials: 'same-origin'
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Show success notification
            showRewardNotification(data.reward_amount, data.reward_type);
            
            // Reload page after 2 seconds to update the widget state
            setTimeout(() => {
                window.location.reload();
            }, 2000);
        } else {
            claimBtn.textContent = data.error || 'Error';
            setTimeout(() => {
                window.location.reload();
            }, 2000);
        }
    })
    .catch(error => {
        console.error('Error claiming reward:', error);
        claimBtn.textContent = window.visitRewardTranslations.error;
        setTimeout(() => {
            checkVisitRewardStatus();
        }, 2000);
    });
}

function showRewardNotification(amount, type) {
    // Create notification element
    const notification = document.createElement('div');
    notification.style.cssText = `
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        background: linear-gradient(135deg, rgba(0, 0, 0, 0.9), rgba(255, 215, 0, 0.3));
        border: 2px solid #ffd700;
        padding: 30px 50px;
        border-radius: 20px;
        z-index: 10000;
        text-align: center;
        box-shadow: 0 20px 60px rgba(255, 215, 0, 0.6);
        animation: rewardPop 0.5s ease-out;
    `;
    
    let rewardText = amount + ' ';
    if (type === 'virtual') {
        rewardText += window.visitRewardTranslations.currencyName || 'Coins';
    } else if (type === 'cubi') {
        rewardText += 'Gold';
    } else {
        rewardText += 'Bonus Points';
    }
    
    notification.innerHTML = `
        <div style="font-size: 3rem; margin-bottom: 10px;">🎁</div>
        <div style="color: #ffd700; font-size: 1.5rem; font-weight: 700; margin-bottom: 10px;">${window.visitRewardTranslations.rewardClaimed || 'Reward Claimed!'}</div>
        <div style="color: #ffed4e; font-size: 1.2rem;">+${rewardText}</div>
    `;
    
    document.body.appendChild(notification);
    
    // Remove after animation
    setTimeout(() => {
        notification.style.animation = 'rewardFade 0.5s ease-out';
        setTimeout(() => notification.remove(), 500);
    }, 2000);
}

// ===========================================
// 10. INITIALIZATION
// ===========================================
document.addEventListener('DOMContentLoaded', function() {
    // Initialize all components
    createParticles();
    initializeCollapsibleWidgets();
    initializeDropdowns();
    initializePinField();
    initializePageAnimation();
    
    // Check visit reward status if present
    if (window.visitRewardData) {
        checkVisitRewardStatus();
    }
    
    // Close news popup when clicking outside
    document.addEventListener('click', function(event) {
        const popup = document.getElementById('newsPopup');
        if (event.target === popup) {
            closeNewsPopup();
        }
    });
});

// Add animation styles if not already present
if (!document.querySelector('#mystical-animations')) {
    const animationStyle = document.createElement('style');
    animationStyle.id = 'mystical-animations';
    animationStyle.textContent = `
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        @keyframes slideIn {
            from { transform: translateX(100%); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }
        @keyframes slideOut {
            from { transform: translateX(0); opacity: 1; }
            to { transform: translateX(100%); opacity: 0; }
        }
        @keyframes rewardPop {
            0% { transform: translate(-50%, -50%) scale(0); opacity: 0; }
            50% { transform: translate(-50%, -50%) scale(1.1); }
            100% { transform: translate(-50%, -50%) scale(1); opacity: 1; }
        }
        @keyframes rewardFade {
            0% { transform: translate(-50%, -50%) scale(1); opacity: 1; }
            100% { transform: translate(-50%, -50%) scale(0.8); opacity: 0; }
        }
    `;
    document.head.appendChild(animationStyle);
}