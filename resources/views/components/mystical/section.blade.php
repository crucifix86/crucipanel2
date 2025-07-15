@props([
    'title' => null,
    'subtitle' => null,
    'icon' => null,
    'class' => ''
])

<section class="content-section {{ $class }}">
    @if($title)
        <h2 class="section-title">
            @if($icon)
                <span class="section-icon">{{ $icon }}</span>
            @endif
            {{ $title }}
        </h2>
    @endif
    
    @if($subtitle)
        <p class="section-subtitle">{{ $subtitle }}</p>
    @endif
    
    <div class="section-content">
        {{ $slot }}
    </div>
</section>