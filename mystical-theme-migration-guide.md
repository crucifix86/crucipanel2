# Mystical Theme Migration Guide

This guide explains how to integrate the unified CSS and JavaScript files into your existing blade templates.

## Step 1: Add Unified Files to Your Layout

In your main layout file (likely `resources/views/layouts/app.blade.php` or similar), add these references in the `<head>` section:

```blade
<!-- Unified Mystical Theme CSS -->
<link rel="stylesheet" href="{{ asset('css/mystical-theme.css') }}">

<!-- Font Awesome (if not already included) -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
```

And before the closing `</body>` tag:

```blade
<!-- Unified Mystical Theme JavaScript -->
<script src="{{ asset('js/mystical-theme.js') }}"></script>
```

## Step 2: Clean Up Individual Blade Files

For each blade file (home, shop, donate, vote, rankings, members), follow these steps:

### Remove Inline Styles

Remove the entire `<style>` block from each blade file. This includes:
- Font imports
- Base styles
- Animations
- All component styles

### Remove Inline Scripts

Remove JavaScript code blocks that handle:
- Particle creation
- Widget collapse functionality
- Dropdown handling
- PIN field functionality
- News popup handling
- Visit reward functionality

### Keep Page-Specific Elements

Keep only:
- HTML structure
- Blade directives (@if, @foreach, etc.)
- Data attributes
- Page-specific JavaScript that passes data to the unified functions

## Step 3: Update HTML Structure

### Add Required Classes and IDs

Ensure your HTML elements have the proper classes and IDs that the unified CSS/JS expects:

#### For Collapsible Widgets:
```html
<!-- Login Box -->
<div id="loginBox" class="widget-box collapsed">
    <div class="widget-header" onclick="toggleLoginBox()">
        <h3>{{ __('site.login.title') }}</h3>
        <button class="collapse-toggle">▼</button>
    </div>
    <div class="widget-content">
        <!-- Content here -->
    </div>
</div>

<!-- Visit Reward Box -->
<div id="visitRewardBox" class="widget-box">
    <div class="widget-header" onclick="toggleVisitRewardBox()">
        <h3>{{ __('site.visit_reward.title') }}</h3>
        <button class="collapse-toggle">▼</button>
    </div>
    <div class="widget-content">
        <!-- Content here -->
    </div>
</div>
```

#### For Navigation:
```html
<nav class="nav-bar">
    <div class="nav-links">
        <a href="{{ route('home') }}" class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}">
            {{ __('site.nav.home') }}
        </a>
        <!-- More nav items -->
        <div class="nav-dropdown">
            <span class="nav-link dropdown-toggle">
                {{ __('site.nav.rankings') }} <span class="dropdown-arrow">▼</span>
            </span>
            <div class="dropdown-menu">
                <!-- Dropdown items -->
            </div>
        </div>
    </div>
</nav>
```

#### For Particles:
```html
<div class="mystical-bg"></div>
<div class="floating-particles"></div>
```

## Step 4: Initialize Page-Specific Data

### For Visit Reward Widget

Add this script tag in pages that use the visit reward:

```blade
<script>
    window.visitRewardData = {
        canClaim: {{ auth()->check() && !auth()->user()->hasClaimedVisitRewardToday() ? 'true' : 'false' }},
        secondsUntilNext: {{ auth()->check() ? auth()->user()->secondsUntilNextVisitReward() : 0 }},
        userId: {{ auth()->check() ? auth()->user()->ID : 'null' }}
    };
    
    window.visitRewardTranslations = {
        checkIn: '{{ __("site.visit_reward.check_in") }}',
        claimed: '{{ __("site.visit_reward.claimed") }}',
        claiming: '{{ __("site.visit_reward.claiming") }}',
        error: '{{ __("site.visit_reward.error") }}',
        rewardClaimed: '{{ __("site.visit_reward.reward_claimed") }}',
        currencyName: '{{ config("pw-config.currency_name") }}'
    };
</script>
```

### For News Popups

Ensure news items have proper onclick handlers:

```html
<div class="news-card" onclick="openNewsPopup('{{ $article->slug }}')">
    <!-- News content -->
</div>
```

And add the popup container:

```html
<div id="newsPopup" style="display: none;">
    <div class="popup-content">
        <button class="close-btn" onclick="closeNewsPopup()">×</button>
        <div id="newsContent"></div>
    </div>
</div>
```

## Step 5: Example Migration - home.blade.php

Here's a simplified example of how home.blade.php should look after migration:

```blade
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="container-inner">
        <!-- Dragon ornaments -->
        <div class="dragon-ornament dragon-left">🐉</div>
        <div class="dragon-ornament dragon-right">🐉</div>
        
        <!-- Header -->
        <header class="header header-center">
            <a href="{{ route('home') }}">
                <h1 class="logo">{{ config('pw-config.server_name', 'Haven Perfect World') }}</h1>
                <p class="tagline">{{ __('site.home.tagline') }}</p>
                <div class="mystical-border"></div>
            </a>
        </header>
        
        <!-- Navigation -->
        @include('website.partials.navigation')
        
        <!-- Welcome Section -->
        <section class="content-section welcome-section">
            <h2 class="section-title">{{ __('site.home.welcome_title') }}</h2>
            <p class="section-subtitle">{{ __('site.home.welcome_subtitle') }}</p>
            <!-- Content -->
        </section>
        
        <!-- News Grid -->
        <section class="news-section">
            <!-- News items -->
        </section>
        
        <!-- Footer -->
        @include('website.partials.footer')
    </div>
</div>

<!-- News Popup -->
<div id="newsPopup" style="display: none;">
    <!-- Popup content -->
</div>

<!-- Visit Reward Data -->
@auth
<script>
    window.visitRewardData = {
        canClaim: {{ !auth()->user()->hasClaimedVisitRewardToday() ? 'true' : 'false' }},
        secondsUntilNext: {{ auth()->user()->secondsUntilNextVisitReward() }},
        userId: {{ auth()->user()->ID }}
    };
</script>
@endauth
@endsection
```

## Step 6: Testing Checklist

After migration, test each page for:

1. **Visual Appearance**
   - [ ] Background gradients and patterns display correctly
   - [ ] Floating particles animate properly
   - [ ] All purple theme colors are consistent
   - [ ] Fonts load correctly (Cinzel)

2. **Interactive Elements**
   - [ ] Navigation dropdowns work
   - [ ] Widget collapse/expand with localStorage persistence
   - [ ] News popups open and close
   - [ ] Visit reward claiming functionality
   - [ ] Character dropdowns (members page)

3. **Responsive Design**
   - [ ] Mobile layout adjusts properly
   - [ ] Fixed widgets become relative on mobile
   - [ ] Navigation remains usable on small screens

4. **Performance**
   - [ ] Page loads faster without inline styles
   - [ ] Animations run smoothly
   - [ ] No console errors

## Step 7: Optional Optimizations

### Create Blade Components

Consider creating reusable Blade components for common elements:

```blade
<!-- resources/views/components/widget-box.blade.php -->
@props(['id', 'title', 'collapsed' => false])

<div id="{{ $id }}" class="widget-box {{ $collapsed ? 'collapsed' : '' }}">
    <div class="widget-header" onclick="toggle{{ ucfirst($id) }}()">
        <h3>{{ $title }}</h3>
        <button class="collapse-toggle">▼</button>
    </div>
    <div class="widget-content">
        {{ $slot }}
    </div>
</div>
```

Usage:
```blade
<x-widget-box id="loginBox" title="{{ __('site.login.title') }}" :collapsed="true">
    <!-- Login form content -->
</x-widget-box>
```

### Minify Assets

For production, consider minifying the CSS and JS files:

```bash
# Using npm/yarn with a build tool
npm run production

# Or use online minifiers and save as:
# public/css/mystical-theme.min.css
# public/js/mystical-theme.min.js
```

## Troubleshooting

### Common Issues and Solutions

1. **Styles not applying**: Ensure the CSS file is loaded before any page content
2. **JavaScript errors**: Check that the JS file is loaded after the DOM content
3. **Missing animations**: Verify that animation keyframes are included in the CSS
4. **Widget state not saving**: Check browser localStorage permissions
5. **Particles not showing**: Ensure `.floating-particles` container exists in HTML

### Browser Compatibility

The unified theme supports:
- Chrome/Edge (latest)
- Firefox (latest)
- Safari (latest)
- Mobile browsers

For older browsers, consider adding:
- CSS vendor prefixes
- JavaScript polyfills for modern features

## Benefits of Migration

1. **Performance**: Faster page loads with cached CSS/JS files
2. **Maintainability**: Single source of truth for styles and scripts
3. **Consistency**: Guaranteed same look across all pages
4. **Development Speed**: Easier to make theme-wide changes
5. **Code Organization**: Cleaner blade templates focused on structure

## Next Steps

1. Back up your existing blade files
2. Implement changes on a development environment first
3. Test thoroughly before deploying to production
4. Consider version control for the unified files
5. Document any custom modifications for future developers