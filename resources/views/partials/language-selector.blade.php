<!-- Language Selector -->
<div class="language-selector">
    <i class="fas fa-globe language-icon"></i>
    <select id="language-select" onchange="changeLanguage(this.value)">
        <option value="en" {{ app()->getLocale() == 'en' ? 'selected' : '' }}>English</option>
        <option value="id" {{ app()->getLocale() == 'id' ? 'selected' : '' }}>Indonesian</option>
    </select>
</div>


<script>
    function changeLanguage(lang) {
        window.location.href = '{{ url("/set-language") }}/' + lang;
    }
</script>