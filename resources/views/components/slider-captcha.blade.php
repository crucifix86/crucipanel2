@props(['fieldName' => 'captcha_verified'])

<div class="slider-captcha-container" id="slider-captcha-{{ $fieldName }}">
    <div class="slider-captcha-header">
        <span class="slider-captcha-text">{{ __('captcha.slide_to_verify') ?? 'Slide to verify' }}</span>
        <span class="slider-captcha-status"></span>
    </div>
    <div class="slider-captcha-puzzle">
        <div class="puzzle-background"></div>
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
    const sliderHandle = container.querySelector('.slider-handle');
    const trackFill = container.querySelector('.slider-track-fill');
    const statusEl = container.querySelector('.slider-captcha-status');
    const hiddenInput = document.getElementById('{{ $fieldName }}');
    const puzzleContainer = container.querySelector('.slider-captcha-puzzle');
    const sliderTrack = container.querySelector('.slider-captcha-track');
    
    let isDraggingPuzzle = false;
    let isDraggingSlider = false;
    let startX = 0;
    let currentX = 0;
    let verified = false;
    
    const targetPosition = 0.7 + (Math.random() * 0.2); // Random target between 70-90%
    
    // Puzzle piece dragging
    puzzlePiece.addEventListener('mousedown', startDragPuzzle);
    puzzlePiece.addEventListener('touchstart', startDragPuzzle);
    
    // Slider handle dragging
    sliderHandle.addEventListener('mousedown', startDragSlider);
    sliderHandle.addEventListener('touchstart', startDragSlider);
    
    function startDragPuzzle(e) {
        if (verified) return;
        isDraggingPuzzle = true;
        puzzlePiece.classList.add('dragging');
        startX = e.type.includes('mouse') ? e.clientX : e.touches[0].clientX;
        currentX = puzzlePiece.offsetLeft;
        
        document.addEventListener('mousemove', dragPuzzle);
        document.addEventListener('mouseup', endDragPuzzle);
        document.addEventListener('touchmove', dragPuzzle);
        document.addEventListener('touchend', endDragPuzzle);
        
        e.preventDefault();
    }
    
    function dragPuzzle(e) {
        if (!isDraggingPuzzle) return;
        
        const clientX = e.type.includes('mouse') ? e.clientX : e.touches[0].clientX;
        const deltaX = clientX - startX;
        const maxX = puzzleContainer.offsetWidth - puzzlePiece.offsetWidth;
        let newX = currentX + deltaX;
        
        newX = Math.max(0, Math.min(newX, maxX));
        puzzlePiece.style.left = newX + 'px';
        
        checkAlignment();
    }
    
    function endDragPuzzle() {
        isDraggingPuzzle = false;
        puzzlePiece.classList.remove('dragging');
        
        document.removeEventListener('mousemove', dragPuzzle);
        document.removeEventListener('mouseup', endDragPuzzle);
        document.removeEventListener('touchmove', dragPuzzle);
        document.removeEventListener('touchend', endDragPuzzle);
    }
    
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
        const maxX = sliderTrack.offsetWidth - sliderHandle.offsetWidth;
        let newX = currentX + deltaX;
        
        newX = Math.max(0, Math.min(newX, maxX));
        sliderHandle.style.left = newX + 'px';
        
        const progress = newX / maxX;
        trackFill.style.width = (progress * 100) + '%';
        
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
        const puzzleProgress = puzzlePiece.offsetLeft / (puzzleContainer.offsetWidth - puzzlePiece.offsetWidth);
        const sliderProgress = sliderHandle.offsetLeft / (sliderTrack.offsetWidth - sliderHandle.offsetWidth);
        
        if (Math.abs(puzzleProgress - targetPosition) < 0.05 && Math.abs(sliderProgress - targetPosition) < 0.05) {
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
                
                // Snap to exact position
                const puzzleTargetX = targetPosition * (puzzleContainer.offsetWidth - puzzlePiece.offsetWidth);
                const sliderTargetX = targetPosition * (sliderTrack.offsetWidth - sliderHandle.offsetWidth);
                puzzlePiece.style.left = puzzleTargetX + 'px';
                sliderHandle.style.left = sliderTargetX + 'px';
                trackFill.style.width = (targetPosition * 100) + '%';
                
                // Success animation
                container.style.animation = 'captchaSuccess 0.5s ease';
            }
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