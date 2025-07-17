# Mystical Theme Component Examples

This document shows how to use the Blade components created for the mystical theme.

## Using the Components

### 1. Card Component

Basic card:
```blade
<x-mystical.card>
    <p>This is a basic card with default styling.</p>
</x-mystical.card>
```

Card with title and icon:
```blade
<x-mystical.card title="Server Features" icon="⚔️">
    <ul>
        <li>Custom rates</li>
        <li>Active community</li>
        <li>Regular events</li>
    </ul>
</x-mystical.card>
```

Animated card with custom class:
```blade
<x-mystical.card title="Special Offer" icon="🎁" :animated="true" class="gold-border">
    <p>Get 50% bonus coins this weekend!</p>
</x-mystical.card>
```

### 2. Button Component

Primary button:
```blade
<x-mystical.button>
    Click Me
</x-mystical.button>
```

Gold button with icon:
```blade
<x-mystical.button type="gold" icon="fas fa-coins">
    Buy Now
</x-mystical.button>
```

Animated button with link:
```blade
<x-mystical.button type="animated" href="{{ route('shop') }}" size="lg">
    Visit Shop
</x-mystical.button>
```

Button with onclick:
```blade
<x-mystical.button onclick="claimVisitReward()" icon="fas fa-gift">
    Claim Reward
</x-mystical.button>
```

Disabled button:
```blade
<x-mystical.button :disabled="true">
    Coming Soon
</x-mystical.button>
```

### 3. Section Component

Basic section:
```blade
<x-mystical.section title="Welcome to Haven">
    <p>Experience the ultimate Perfect World server...</p>
</x-mystical.section>
```

Section with subtitle:
```blade
<x-mystical.section 
    title="Latest News" 
    subtitle="Stay updated with server announcements">
    <!-- News content here -->
</x-mystical.section>
```

Section with icon and custom class:
```blade
<x-mystical.section 
    title="Top Rankings" 
    icon="🏆" 
    class="rankings-section">
    <!-- Rankings content here -->
</x-mystical.section>
```

## Complete Page Example

Here's how a page might look using these components:

```blade
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="container-inner">
        <!-- Header -->
        <header class="header header-center">
            <h1 class="logo">{{ config('pw-config.server_name') }}</h1>
            <p class="tagline">Your mystical journey begins here</p>
        </header>
        
        <!-- Welcome Section -->
        <x-mystical.section 
            title="Welcome Adventurer" 
            subtitle="Choose your path and begin your journey"
            icon="✨">
            
            <div class="feature-grid">
                <x-mystical.card title="PvE Content" icon="🗡️">
                    <p>Explore dungeons and defeat bosses</p>
                    <x-mystical.button href="{{ route('guide.pve') }}">
                        Learn More
                    </x-mystical.button>
                </x-mystical.card>
                
                <x-mystical.card title="PvP Battles" icon="⚔️">
                    <p>Test your skills against other players</p>
                    <x-mystical.button href="{{ route('rankings.pvp') }}">
                        View Rankings
                    </x-mystical.button>
                </x-mystical.card>
                
                <x-mystical.card title="Crafting" icon="🔨" :animated="true">
                    <p>Create powerful items and gear</p>
                    <x-mystical.button type="gold" href="{{ route('guide.crafting') }}">
                        Crafting Guide
                    </x-mystical.button>
                </x-mystical.card>
            </div>
        </x-mystical.section>
        
        <!-- Special Offers -->
        <x-mystical.section title="Limited Time Offers" class="offers-section">
            <x-mystical.card title="Weekend Special" icon="🎁" class="gold-border">
                <p>Double experience points all weekend!</p>
                <x-mystical.button type="animated" size="lg" onclick="showNotification('info', 'Event starts Friday!')">
                    Get Details
                </x-mystical.button>
            </x-mystical.card>
        </x-mystical.section>
    </div>
</div>
@endsection
```

## Adding Custom Styles

You can extend the component styles in your unified CSS:

```css
/* Custom card variant */
.card.gold-border {
    border-color: var(--color-gold);
    box-shadow: 0 0 30px rgba(255, 215, 0, 0.3);
}

/* Feature grid layout */
.feature-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 30px;
    margin-top: 40px;
}

/* Custom section styling */
.offers-section {
    background: linear-gradient(135deg, rgba(255, 215, 0, 0.05), rgba(147, 112, 219, 0.1));
}
```

## Benefits of Using Components

1. **Consistency**: All cards, buttons, and sections look the same across the site
2. **Reusability**: Write once, use everywhere
3. **Maintainability**: Update the component file to change all instances
4. **Clean Templates**: Blade files become more readable
5. **Props Validation**: Components can validate and provide defaults

## Creating Your Own Components

To create a new mystical theme component:

1. Create a new file in `resources/views/components/mystical/`
2. Define props using `@props` directive
3. Use theme CSS classes
4. Make it flexible with slots

Example - Alert component:
```blade
{{-- resources/views/components/mystical/alert.blade.php --}}
@props([
    'type' => 'info', // info, success, warning, error
    'dismissible' => true
])

@php
    $typeStyles = [
        'info' => 'alert-info',
        'success' => 'alert-success',
        'warning' => 'alert-warning',
        'error' => 'alert-error'
    ];
@endphp

<div class="alert {{ $typeStyles[$type] }}" id="alert-{{ uniqid() }}">
    {{ $slot }}
    @if($dismissible)
        <button class="alert-close" onclick="this.parentElement.remove()">×</button>
    @endif
</div>
```

Usage:
```blade
<x-mystical.alert type="success">
    Your character has been created successfully!
</x-mystical.alert>
```