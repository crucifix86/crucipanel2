<script>
// Visit Reward Functions
let rewardCountdownInterval = null;

function toggleVisitRewardBox() {
    const rewardBox = document.getElementById('visitRewardBox');
    rewardBox.classList.toggle('collapsed');
    
    // Save state to localStorage
    const isCollapsed = rewardBox.classList.contains('collapsed');
    localStorage.setItem('visitRewardBoxCollapsed', isCollapsed);
}

// Restore visit reward box state on page load
document.addEventListener('DOMContentLoaded', function() {
    const rewardBox = document.getElementById('visitRewardBox');
    if (rewardBox) {
        const savedState = localStorage.getItem('visitRewardBoxCollapsed');
        if (savedState === 'true') {
            rewardBox.classList.add('collapsed');
        }
        
        // Check reward status
        checkVisitRewardStatus();
    }
});

function checkVisitRewardStatus() {
    fetch('/api/visit-reward/status', {
        method: 'GET',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Accept': 'application/json',
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        },
        credentials: 'include'
    })
    .then(response => {
        console.log('Status response:', response.status);
        if (!response.ok) {
            throw new Error('Not authorized');
        }
        return response.json();
    })
    .then(data => {
        const claimBtn = document.getElementById('claimRewardBtn');
        const timerDiv = document.getElementById('rewardTimer');
        const countdownSpan = document.getElementById('rewardCountdown');
        
        if (!data.enabled) {
            claimBtn.textContent = 'Rewards Disabled';
            claimBtn.disabled = true;
            return;
        }
        
        if (data.can_claim) {
            claimBtn.textContent = 'Claim Reward';
            claimBtn.disabled = false;
            timerDiv.style.display = 'none';
            
            // Clear any existing countdown
            if (rewardCountdownInterval) {
                clearInterval(rewardCountdownInterval);
                rewardCountdownInterval = null;
            }
        } else {
            claimBtn.textContent = 'Already Claimed';
            claimBtn.disabled = true;
            timerDiv.style.display = 'block';
            
            // Start countdown
            startRewardCountdown(data.seconds_until_next);
        }
    })
    .catch(error => {
        console.error('Error checking reward status:', error);
        const claimBtn = document.getElementById('claimRewardBtn');
        claimBtn.textContent = 'Error';
        claimBtn.disabled = true;
    });
}

function startRewardCountdown(seconds) {
    const countdownSpan = document.getElementById('rewardCountdown');
    
    // Clear any existing interval
    if (rewardCountdownInterval) {
        clearInterval(rewardCountdownInterval);
    }
    
    let remainingSeconds = seconds;
    
    function updateCountdown() {
        if (remainingSeconds <= 0) {
            clearInterval(rewardCountdownInterval);
            rewardCountdownInterval = null;
            checkVisitRewardStatus();
            return;
        }
        
        const hours = Math.floor(remainingSeconds / 3600);
        const minutes = Math.floor((remainingSeconds % 3600) / 60);
        const secs = remainingSeconds % 60;
        
        countdownSpan.textContent = 
            String(hours).padStart(2, '0') + ':' +
            String(minutes).padStart(2, '0') + ':' +
            String(secs).padStart(2, '0');
        
        remainingSeconds--;
    }
    
    updateCountdown();
    rewardCountdownInterval = setInterval(updateCountdown, 1000);
}

function claimVisitReward() {
    const claimBtn = document.getElementById('claimRewardBtn');
    claimBtn.disabled = true;
    claimBtn.textContent = 'Claiming...';
    
    fetch('/api/visit-reward/claim', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        },
        credentials: 'include',
        body: JSON.stringify({})
    })
    .then(response => {
        console.log('Claim response:', response.status);
        return response.json();
    })
    .then(data => {
        if (data.success) {
            // Show success notification
            showRewardNotification(data.reward_amount, data.reward_type);
            
            // Update button state
            claimBtn.textContent = 'Claimed!';
            
            // Start countdown for next reward
            setTimeout(() => {
                checkVisitRewardStatus();
            }, 2000);
        } else {
            claimBtn.textContent = data.error || 'Error';
            claimBtn.disabled = false;
        }
    })
    .catch(error => {
        console.error('Error claiming reward:', error);
        claimBtn.textContent = 'Error';
        claimBtn.disabled = false;
    });
}

function showRewardNotification(amount, type) {
    // Create notification element
    const notification = document.createElement('div');
    notification.className = 'reward-notification';
    
    let rewardText = amount + ' ';
    if (type === 'virtual') {
        rewardText += '{{ config("pw-config.currency_name", "Coins") }}';
    } else if (type === 'cubi') {
        rewardText += 'Gold';
    } else {
        rewardText += 'Bonus Points';
    }
    
    notification.innerHTML = `
        <div class="reward-notification-content">
            <span class="reward-notification-icon">✨</span>
            <span class="reward-notification-text">You received ${rewardText}!</span>
        </div>
    `;
    
    // Add to page
    document.body.appendChild(notification);
    
    // Animate in
    setTimeout(() => {
        notification.classList.add('show');
    }, 100);
    
    // Remove after 3 seconds
    setTimeout(() => {
        notification.classList.remove('show');
        setTimeout(() => {
            notification.remove();
        }, 300);
    }, 3000);
}
</script>

<style>
.reward-notification {
    position: fixed;
    top: 20px;
    right: 20px;
    background: linear-gradient(135deg, rgba(255, 215, 0, 0.9), rgba(255, 140, 0, 0.9));
    color: #fff;
    padding: 15px 25px;
    border-radius: 10px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
    transform: translateX(400px);
    transition: transform 0.3s ease;
    z-index: 10000;
}

.reward-notification.show {
    transform: translateX(0);
}

.reward-notification-content {
    display: flex;
    align-items: center;
    gap: 10px;
}

.reward-notification-icon {
    font-size: 1.5rem;
}

.reward-notification-text {
    font-weight: 600;
    text-shadow: 0 1px 2px rgba(0, 0, 0, 0.2);
}
</style>