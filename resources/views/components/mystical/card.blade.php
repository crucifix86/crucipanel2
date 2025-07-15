@props([
    'title' => null,
    'icon' => null,
    'class' => '',
    'animated' => false
])

<div class="card {{ $animated ? 'card-animated' : '' }} {{ $class }}">
    @if($title || $icon)
        <div class="card-header">
            @if($icon)
                <span class="card-icon">{{ $icon }}</span>
            @endif
            @if($title)
                <h3 class="card-title">{{ $title }}</h3>
            @endif
        </div>
    @endif
    
    <div class="card-content">
        {{ $slot }}
    </div>
</div>