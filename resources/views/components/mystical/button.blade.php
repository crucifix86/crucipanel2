@props([
    'type' => 'primary', // primary, gold, animated
    'size' => 'md', // sm, md, lg
    'icon' => null,
    'href' => null,
    'onclick' => null,
    'disabled' => false
])

@php
    $sizeClasses = [
        'sm' => 'btn-sm',
        'md' => '',
        'lg' => 'btn-lg'
    ];
    
    $typeClasses = [
        'primary' => 'btn-primary',
        'gold' => 'btn-gold',
        'animated' => 'btn-animated'
    ];
    
    $classes = 'btn ' . $typeClasses[$type] . ' ' . $sizeClasses[$size];
@endphp

@if($href)
    <a href="{{ $href }}" 
       class="{{ $classes }}" 
       @if($onclick) onclick="{{ $onclick }}" @endif
       @if($disabled) style="pointer-events: none; opacity: 0.6;" @endif>
        @if($icon)
            <i class="{{ $icon }}"></i>
        @endif
        {{ $slot }}
    </a>
@else
    <button type="button" 
            class="{{ $classes }}" 
            @if($onclick) onclick="{{ $onclick }}" @endif
            @if($disabled) disabled @endif>
        @if($icon)
            <i class="{{ $icon }}"></i>
        @endif
        {{ $slot }}
    </button>
@endif