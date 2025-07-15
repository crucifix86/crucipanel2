# Mystical Purple Theme Style Analysis

## Common Color Values

### Primary Purple Shades
- `#9370db` - Medium Purple (primary brand color)
- `#8a2be2` - Blue Violet (secondary brand color)
- `#4b0082` - Indigo (accent color)
- `#6a5acd` - Slate Blue (alternative accent)
- `#b19cd9` - Light Purple (text color)
- `#dda0dd` - Plum (highlight text)
- `#e6d7f0` - Lavender (main text color)

### Background Colors
- `radial-gradient(ellipse at center, #2a1b3d 0%, #1a0f2e 50%, #0a0514 100%)` - Main body gradient
- `rgba(0, 0, 0, 0.8)` - Dark overlay
- `rgba(147, 112, 219, 0.2)` - Purple overlay
- `rgba(26, 15, 46, 0.6)` - Deep purple background

### Special Colors
- `#ffd700` - Gold (currency/rewards)
- `#ffed4e` - Light Gold
- `#10b981` - Green (online status)
- `#ef4444` - Red (offline/error)

## Common CSS Patterns

### 1. Gradients

#### Background Gradients
```css
background: radial-gradient(ellipse at center, #2a1b3d 0%, #1a0f2e 50%, #0a0514 100%);
background: linear-gradient(135deg, rgba(0, 0, 0, 0.8), rgba(147, 112, 219, 0.2));
background: linear-gradient(45deg, #9370db, #8a2be2, #9370db, #4b0082);
background: linear-gradient(135deg, rgba(147, 112, 219, 0.1), rgba(75, 0, 130, 0.1));
```

#### Mystical Background Overlay
```css
.mystical-bg {
    background: 
        radial-gradient(circle at 20% 30%, rgba(138, 43, 226, 0.15) 0%, transparent 50%),
        radial-gradient(circle at 80% 70%, rgba(75, 0, 130, 0.12) 0%, transparent 50%),
        radial-gradient(circle at 50% 50%, rgba(148, 0, 211, 0.08) 0%, transparent 50%);
}
```

### 2. Shadows

#### Box Shadows
```css
box-shadow: 0 20px 60px rgba(0, 0, 0, 0.5);
box-shadow: 0 10px 30px rgba(147, 112, 219, 0.6);
box-shadow: 0 15px 40px rgba(0, 0, 0, 0.3);
box-shadow: 0 0 50px rgba(147, 112, 219, 0.3);
```

#### Text Shadows
```css
text-shadow: 0 0 50px rgba(147, 112, 219, 0.8);
text-shadow: 0 0 30px rgba(147, 112, 219, 0.8);
text-shadow: 0 0 15px rgba(147, 112, 219, 0.6);
text-shadow: 0 0 20px rgba(255, 215, 0, 0.8);
```

### 3. Animations

#### Gradient Shift
```css
@keyframes gradientShift {
    0%, 100% { background-position: 0% 50%; }
    50% { background-position: 100% 50%; }
}
```

#### Floating Particles
```css
@keyframes float {
    0%, 100% { transform: translateY(0px) rotate(0deg); opacity: 0; }
    10% { opacity: 1; }
    90% { opacity: 1; }
    50% { transform: translateY(-100px) rotate(180deg); opacity: 0.7; }
}
```

#### Shimmer Background
```css
@keyframes shimmerBg {
    0%, 100% { transform: translateX(-100%) translateY(-100%) rotate(45deg); }
    50% { transform: translateX(100%) translateY(100%) rotate(45deg); }
}
```

#### Dragon Pulse
```css
@keyframes dragonPulse {
    0%, 100% { opacity: 0.1; transform: scale(1) rotate(-15deg); }
    50% { opacity: 0.2; transform: scale(1.1) rotate(-10deg); }
}
```

#### Rotate Border
```css
@keyframes rotateBorder {
    0% { transform: translate(-50%, -50%) rotate(0deg); }
    100% { transform: translate(-50%, -50%) rotate(360deg); }
}
```

#### Epic Glow
```css
@keyframes epicGlow {
    0% { text-shadow: 0 0 20px rgba(147, 112, 219, 0.6); }
    100% { text-shadow: 0 0 40px rgba(147, 112, 219, 1), 0 0 60px rgba(138, 43, 226, 0.8); }
}
```

#### Pulse
```css
@keyframes pulse {
    0%, 100% { transform: scale(1); opacity: 1; }
    50% { transform: scale(1.2); opacity: 0.8; }
}
```

## Layout Structure Patterns

### 1. Fixed Widgets
- **Server Status**: `position: fixed; top: 20px; left: 20px; width: 220px;`
- **Login Box**: `position: fixed; top: 100px; left: 20px; width: 220px;`
- **Visit Reward**: `position: fixed; top: 420px; left: 20px; width: 220px;`

### 2. Container Structure
```css
.container {
    position: relative;
    z-index: 3;
    max-width: 1000px;
    margin-left: 260px;
    margin-right: auto;
    padding: 20px;
    min-height: 100vh;
}
```

### 3. Header Structure
```css
.header {
    margin-bottom: 60px;
    padding: 60px 0;
    position: relative;
}
```

### 4. Navigation Bar
```css
.nav-bar {
    background: linear-gradient(135deg, rgba(0, 0, 0, 0.4), rgba(147, 112, 219, 0.1));
    backdrop-filter: blur(20px);
    border: 2px solid rgba(147, 112, 219, 0.3);
    border-radius: 20px;
    padding: 15px 30px;
    margin-bottom: 40px;
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.5);
}
```

## Widget Styles

### 1. Cards/Sections
```css
background: linear-gradient(135deg, rgba(147, 112, 219, 0.1), rgba(75, 0, 130, 0.1));
backdrop-filter: blur(20px);
border: 2px solid rgba(147, 112, 219, 0.3);
border-radius: 30px;
padding: 50px;
box-shadow: 0 20px 60px rgba(0, 0, 0, 0.5), inset 0 1px 0 rgba(147, 112, 219, 0.2);
```

### 2. Buttons
```css
/* Primary Button */
background: linear-gradient(45deg, #9370db, #8a2be2);
color: #fff;
border: none;
padding: 12px 30px;
border-radius: 30px;
font-size: 1.1rem;
font-weight: 600;
cursor: pointer;
transition: all 0.3s ease;

/* Gold Button */
background: linear-gradient(45deg, #ffd700, #ffed4e);
color: #4a0e4e;

/* Hover Effects */
transform: translateY(-2px);
box-shadow: 0 10px 30px rgba(147, 112, 219, 0.6);
```

### 3. Input Fields
```css
background: rgba(0, 0, 0, 0.4);
border: 1px solid rgba(147, 112, 219, 0.5);
border-radius: 8px;
color: #e6d7f0;
font-size: 0.9rem;
padding: 8px 12px;
transition: all 0.3s ease;
```

## Font Styles

### 1. Primary Font
```css
@import url('https://fonts.googleapis.com/css2?family=Cinzel:wght@400;600;700&display=swap');
font-family: 'Cinzel', serif;
```

### 2. Font Sizes
- Logo: `4.5rem`
- Section Titles: `2.8rem`
- Card Titles: `1.6rem`
- Navigation: `1.1rem`
- Body Text: `1rem`
- Small Text: `0.9rem` / `0.85rem`

### 3. Font Weights
- Normal: `400`
- Semi-Bold: `600`
- Bold: `700`

## Unique Styles Per Page

### Home Page
- Visit Reward Widget (gold theme)
- News Grid (3-column layout)
- Server Features Grid (4-column)

### Shop Page
- Category Sidebar (fixed width: 250px)
- Product Grid with hover effects
- User Balance Bar
- Character Selector Dropdown

### Donate Page
- Donation Methods Grid
- Payment Details Cards
- Benefits Section

### Vote Page
- Arena Top 100 Section (gold theme)
- Cooldown Timers
- Vote Sites Grid

### Rankings Page
- Dual Column Layout
- Ranking Rows with hover effects
- Rank number colors (gold, silver, bronze)

### Members Page
- Member Cards Grid
- Discord Integration Styles
- Character Dropdown Lists

## Common Component Patterns

### 1. Particle System
```javascript
function createParticles() {
    const particlesContainer = document.querySelector('.floating-particles');
    const numberOfParticles = 60;
    // Creates floating purple particles
}
```

### 2. Collapsible Widgets
- Login Box
- Visit Reward Box
- Both use localStorage to save state

### 3. Dropdown Menus
- Navigation dropdown
- Character selector
- Consistent hover and active states

### 4. Responsive Breakpoints
- Desktop: Default styles
- Mobile: `@media (max-width: 768px)`
- Container margin-left: 0 on mobile
- Fixed widgets become relative positioned

## Recommended Unified CSS Structure

```css
/* 1. Base Reset & Typography */
/* 2. Color Variables */
/* 3. Background Patterns */
/* 4. Animations */
/* 5. Layout Structure */
/* 6. Components */
   - Navigation
   - Cards/Sections
   - Buttons
   - Forms
   - Widgets
/* 7. Page-Specific Overrides */
/* 8. Responsive Styles */
```