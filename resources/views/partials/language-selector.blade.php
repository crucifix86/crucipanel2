<!-- Language Selector -->
<div class="language-selector">
    <i class="fas fa-globe language-icon"></i>
    <label for="language-select">{{ __('Language') }}:</label>
    <select id="language-select" onchange="changeLanguage(this.value)">
        <option value="en" {{ app()->getLocale() == 'en' ? 'selected' : '' }}>English</option>
        <option value="id" {{ app()->getLocale() == 'id' ? 'selected' : '' }}>Indonesian</option>
    </select>
</div>

<style>
    /* Language Selector */
    .language-selector {
        position: fixed;
        top: 20px;
        right: 20px;
        z-index: 100;
        background: linear-gradient(135deg, rgba(0, 0, 0, 0.8), rgba(147, 112, 219, 0.2));
        backdrop-filter: blur(15px);
        border: 1px solid rgba(147, 112, 219, 0.4);
        border-radius: 10px;
        padding: 8px 15px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .language-selector label {
        color: #b19cd9;
        font-size: 0.9rem;
        font-weight: 600;
        margin: 0;
    }

    .language-selector select {
        background: rgba(0, 0, 0, 0.4);
        border: 1px solid rgba(147, 112, 219, 0.5);
        border-radius: 8px;
        color: #e6d7f0;
        padding: 5px 10px;
        font-size: 0.9rem;
        cursor: pointer;
        transition: all 0.3s ease;
        font-family: 'Cinzel', serif;
        min-width: 120px;
    }

    .language-selector select:hover {
        border-color: #9370db;
        box-shadow: 0 0 10px rgba(147, 112, 219, 0.4);
    }

    .language-selector select:focus {
        outline: none;
        border-color: #9370db;
        box-shadow: 0 0 15px rgba(147, 112, 219, 0.6);
    }

    .language-selector select option {
        background: #1a0f2e;
        color: #e6d7f0;
    }

    .language-icon {
        color: #9370db;
        font-size: 1.2rem;
    }

    @media (max-width: 768px) {
        .language-selector {
            position: fixed;
            top: 10px;
            right: 10px;
            padding: 5px 10px;
            font-size: 0.85rem;
        }
        
        .language-selector label {
            display: none;
        }
        
        .language-selector select {
            font-size: 0.85rem;
            min-width: 80px;
            padding: 4px 8px;
        }
    }
</style>

<script>
    function changeLanguage(lang) {
        window.location.href = window.location.pathname + '?language=' + lang;
    }
</script>