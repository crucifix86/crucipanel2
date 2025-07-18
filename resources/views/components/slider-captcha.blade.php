@props(['fieldName' => 'captcha_verified'])

<div class="slider-captcha-container" id="slider-captcha-{{ $fieldName }}">
    <div class="slider-captcha-header">
        <span class="slider-captcha-text">{{ __('captcha.slide_to_verify') ?? 'Slide to verify' }}</span>
        <span class="slider-captcha-status"></span>
    </div>
    <div class="slider-captcha-puzzle">
        <div class="puzzle-background"></div>
        <div class="puzzle-target">
            <div class="target-icon">🎯</div>
        </div>
        <div class="puzzle-piece">
            <div class="puzzle-icon">🧩</div>
        </div>
    </div>
    <div class="slider-captcha-track">
        <div class="slider-handle">
            <span class="slider-arrow">➤</span>
        </div>
        <div class="slider-track-fill"></div>
    </div>
    <input type="hidden" name="{{ $fieldName }}" id="{{ $fieldName }}" value="">
</div>

<style>
.slider-captcha-container {
    width: 100%;
    margin: 0 auto;
    background: rgba(0, 0, 0, 0.2);
    border: 1px solid rgba(147, 112, 219, 0.4);
    border-radius: 6px;
    padding: 10px;
    position: relative;
}

.slider-captcha-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 8px;
    color: #dda0dd;
    font-size: 11px;
}

.slider-captcha-status {
    font-size: 14px;
}

.slider-captcha-puzzle {
    width: 100%;
    height: 50px;
    position: relative;
    background: linear-gradient(135deg, rgba(147, 112, 219, 0.1), rgba(138, 43, 226, 0.1));
    border-radius: 4px;
    margin-bottom: 8px;
    overflow: hidden;
}

.puzzle-background {
    position: absolute;
    width: 100%;
    height: 100%;
    background-image: 
        repeating-linear-gradient(45deg, transparent, transparent 10px, rgba(147, 112, 219, 0.1) 10px, rgba(147, 112, 219, 0.1) 20px),
        repeating-linear-gradient(-45deg, transparent, transparent 10px, rgba(138, 43, 226, 0.1) 10px, rgba(138, 43, 226, 0.1) 20px);
}

.puzzle-target {
    position: absolute;
    width: 32px;
    height: 32px;
    top: 50%;
    transform: translateY(-50%);
    background: rgba(147, 112, 219, 0.2);
    border: 2px dashed rgba(147, 112, 219, 0.6);
    border-radius: 4px;
    display: flex;
    align-items: center;
    justify-content: center;
    animation: targetPulse 2s ease-in-out infinite;
}

.puzzle-target.highlight {
    background: rgba(50, 205, 50, 0.2);
    border-color: rgba(50, 205, 50, 0.6);
}

.target-icon {
    font-size: 16px;
    opacity: 0.5;
    filter: drop-shadow(0 1px 2px rgba(0, 0, 0, 0.3));
}

@keyframes targetPulse {
    0%, 100% { opacity: 0.5; transform: translateY(-50%) scale(1); }
    50% { opacity: 0.8; transform: translateY(-50%) scale(1.05); }
}

.puzzle-piece {
    position: absolute;
    width: 30px;
    height: 30px;
    left: 0;
    top: 50%;
    transform: translateY(-50%);
    background: linear-gradient(135deg, #9370db, #8a2be2);
    border-radius: 4px;
    cursor: grab;
    transition: left 0.1s ease-out;
    box-shadow: 0 2px 8px rgba(147, 112, 219, 0.5);
    display: flex;
    align-items: center;
    justify-content: center;
}

.puzzle-piece.dragging {
    cursor: grabbing;
    transform: translateY(-50%) scale(1.05);
    box-shadow: 0 3px 12px rgba(147, 112, 219, 0.8);
}

.puzzle-piece.verified {
    background: linear-gradient(135deg, #32cd32, #00ff7f);
    box-shadow: 0 2px 8px rgba(50, 205, 50, 0.5);
}

.puzzle-icon {
    font-size: 16px;
    filter: drop-shadow(0 1px 2px rgba(0, 0, 0, 0.3));
}

.slider-captcha-track {
    width: 100%;
    height: 26px;
    background: rgba(0, 0, 0, 0.5);
    border-radius: 13px;
    position: relative;
    overflow: hidden;
}

.slider-handle {
    position: absolute;
    width: 26px;
    height: 26px;
    left: 0;
    top: 0;
    background: linear-gradient(135deg, #9370db, #8a2be2);
    border-radius: 50%;
    cursor: grab;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: left 0.1s ease-out;
    box-shadow: 0 2px 6px rgba(147, 112, 219, 0.5);
}

.slider-handle.dragging {
    cursor: grabbing;
    transform: scale(1.1);
}

.slider-handle.verified {
    background: linear-gradient(135deg, #32cd32, #00ff7f);
    box-shadow: 0 2px 10px rgba(50, 205, 50, 0.5);
}

.slider-arrow {
    color: white;
    font-size: 12px;
    transform: translateX(-1px);
}

.slider-track-fill {
    position: absolute;
    left: 0;
    top: 0;
    height: 100%;
    width: 0;
    background: linear-gradient(90deg, rgba(147, 112, 219, 0.3), rgba(138, 43, 226, 0.3));
    border-radius: 20px;
    transition: width 0.1s ease-out;
}

.slider-track-fill.verified {
    background: linear-gradient(90deg, rgba(50, 205, 50, 0.3), rgba(0, 255, 127, 0.3));
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const container = document.getElementById('slider-captcha-{{ $fieldName }}');
    const puzzlePiece = container.querySelector('.puzzle-piece');
    const puzzleTarget = container.querySelector('.puzzle-target');
    const sliderHandle = container.querySelector('.slider-handle');
    const trackFill = container.querySelector('.slider-track-fill');
    const statusEl = container.querySelector('.slider-captcha-status');
    const hiddenInput = document.getElementById('{{ $fieldName }}');
    const puzzleContainer = container.querySelector('.slider-captcha-puzzle');
    const sliderTrack = container.querySelector('.slider-captcha-track');
    
    let isDraggingSlider = false;
    let startX = 0;
    let currentX = 0;
    let verified = false;
    
    const targetPosition = 0.6 + (Math.random() * 0.3); // Random target between 60-90%
    
    // Position the target
    const maxTargetX = puzzleContainer.offsetWidth - puzzleTarget.offsetWidth;
    puzzleTarget.style.left = (targetPosition * maxTargetX) + 'px';
    
    // Only slider handle is draggable - it controls the puzzle piece
    sliderHandle.addEventListener('mousedown', startDragSlider);
    sliderHandle.addEventListener('touchstart', startDragSlider);
    
    function startDragSlider(e) {
        if (verified) return;
        isDraggingSlider = true;
        sliderHandle.classList.add('dragging');
        startX = e.type.includes('mouse') ? e.clientX : e.touches[0].clientX;
        currentX = sliderHandle.offsetLeft;
        
        document.addEventListener('mousemove', dragSlider);
        document.addEventListener('mouseup', endDragSlider);
        document.addEventListener('touchmove', dragSlider);
        document.addEventListener('touchend', endDragSlider);
        
        e.preventDefault();
    }
    
    function dragSlider(e) {
        if (!isDraggingSlider) return;
        
        const clientX = e.type.includes('mouse') ? e.clientX : e.touches[0].clientX;
        const deltaX = clientX - startX;
        const maxSliderX = sliderTrack.offsetWidth - sliderHandle.offsetWidth;
        let newSliderX = currentX + deltaX;
        
        newSliderX = Math.max(0, Math.min(newSliderX, maxSliderX));
        sliderHandle.style.left = newSliderX + 'px';
        
        const progress = newSliderX / maxSliderX;
        trackFill.style.width = (progress * 100) + '%';
        
        // Move puzzle piece proportionally
        const maxPuzzleX = puzzleContainer.offsetWidth - puzzlePiece.offsetWidth;
        const newPuzzleX = progress * maxPuzzleX;
        puzzlePiece.style.left = newPuzzleX + 'px';
        
        checkAlignment();
    }
    
    function endDragSlider() {
        isDraggingSlider = false;
        sliderHandle.classList.remove('dragging');
        
        document.removeEventListener('mousemove', dragSlider);
        document.removeEventListener('mouseup', endDragSlider);
        document.removeEventListener('touchmove', dragSlider);
        document.removeEventListener('touchend', endDragSlider);
    }
    
    function checkAlignment() {
        const puzzleRect = puzzlePiece.getBoundingClientRect();
        const targetRect = puzzleTarget.getBoundingClientRect();
        
        // Check if puzzle piece overlaps with target (within 5px tolerance)
        const isAligned = Math.abs(puzzleRect.left - targetRect.left) < 5;
        
        if (isAligned) {
            puzzleTarget.classList.add('highlight');
            
            if (!verified) {
                verified = true;
                puzzlePiece.classList.add('verified');
                sliderHandle.classList.add('verified');
                trackFill.classList.add('verified');
                statusEl.textContent = '✓';
                statusEl.style.color = '#32cd32';
                
                // Generate verification token
                const token = btoa(Date.now() + ':' + targetPosition);
                hiddenInput.value = token;
                
                // Snap puzzle piece to exact target position
                const targetLeft = puzzleTarget.offsetLeft;
                puzzlePiece.style.left = targetLeft + 'px';
                
                // Success animation
                container.style.animation = 'captchaSuccess 0.5s ease';
                
                // Disable further dragging
                sliderHandle.style.pointerEvents = 'none';
            }
        } else {
            puzzleTarget.classList.remove('highlight');
        }
    }
});
</script>

<style>
@keyframes captchaSuccess {
    0%, 100% { transform: scale(1); }
    50% { transform: scale(1.02); }
}
</style>