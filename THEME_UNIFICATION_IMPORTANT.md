# CRITICAL: Theme Unification Requirements

## Body Class Requirement for Theme Loading

**IMPORTANT**: The mystical layout loads CSS from `mystical-purple-unified.css` which contains ALL page-specific styles scoped by body classes.

### How It Works

1. Each page MUST set a body class using `@section('body-class', 'page-name')` 
2. The mystical layout applies this class to the `<body>` tag
3. All CSS in mystical-purple-unified.css is scoped with `body.page-name` selectors

### Example

```blade
@extends('layouts.mystical')

@section('body-class', 'vote-page')  <!-- THIS IS CRITICAL! -->

@section('content')
<!-- Page content -->
@endsection
```

### Current Body Classes

- `shop-page` - Shop page styles
- `donate-page` - Donate page styles  
- `rankings-page` - Rankings page styles
- `vote-page` - Vote page styles
- `members-page` - Members page styles

### What Happens Without Body Class?

If you forget to set the body class:
- The page will load with NO styling
- It will look completely broken
- The CSS exists but won't apply because selectors won't match

### CSS Structure

All styles in mystical-purple-unified.css follow this pattern:

```css
body.vote-page .some-element {
    /* styles */
}

body.shop-page .some-element {
    /* different styles */
}
```

This allows us to have different styles for the same class names on different pages without conflicts.

## Theme Loading Issue Fixed

Previously, the mystical layout was loading CSS from `route('theme.css')` which pulled from the database theme system. This has been fixed to load `mystical-purple-unified.css` directly:

```blade
<link rel="stylesheet" href="{{ asset('css/mystical-purple-unified.css') }}">
```

## Summary

1. ALWAYS add `@section('body-class', 'your-page')` to pages using mystical layout
2. ALL CSS is in `mystical-purple-unified.css` scoped by body classes
3. Without the body class, pages will have NO styling
4. The mystical layout now loads the unified CSS file directly, not from database