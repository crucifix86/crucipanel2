# Missing CSS Styles from Shop.blade.php

## 1. Shop-Specific Styles

### Shop Grid and Items
```css
/* Shop Grid */
.shop-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
    gap: 30px;
    position: relative;
    z-index: 1;
}

.shop-item {
    background: linear-gradient(135deg, rgba(0, 0, 0, 0.4), rgba(147, 112, 219, 0.1));
    border: 2px solid rgba(147, 112, 219, 0.4);
    border-radius: 20px;
    padding: 25px;
    text-align: center;
    transition: all 0.4s ease;
    position: relative;
    overflow: hidden;
    box-shadow: 0 15px 40px rgba(0, 0, 0, 0.3);
}

.shop-item::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(147, 112, 219, 0.2), transparent);
    transition: left 0.5s ease;
}

.shop-item:hover::before {
    left: 100%;
}

.shop-item:hover {
    transform: translateY(-10px) scale(1.02);
    border-color: #9370db;
    box-shadow: 
        0 25px 60px rgba(0, 0, 0, 0.4),
        0 0 50px rgba(147, 112, 219, 0.3);
}

.item-icon {
    width: 80px;
    height: 80px;
    margin: 0 auto 20px;
    background: rgba(147, 112, 219, 0.2);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 2.5rem;
}

.item-name {
    font-size: 1.3rem;
    color: #dda0dd;
    margin-bottom: 10px;
    font-weight: 600;
}

.item-description {
    font-size: 0.9rem;
    color: #b19cd9;
    margin-bottom: 20px;
    line-height: 1.4;
    min-height: 40px;
}

.item-price {
    font-size: 1.2rem;
    color: #ffd700;
    margin-bottom: 15px;
    font-weight: 600;
    text-shadow: 0 0 10px rgba(255, 215, 0, 0.6);
}

.discount-badge {
    position: absolute;
    top: 10px;
    right: 10px;
    background: linear-gradient(45deg, #ff6b6b, #dc3545);
    color: #fff;
    padding: 5px 15px;
    border-radius: 20px;
    font-size: 0.9rem;
    font-weight: 600;
}
```

### Purchase and Bonus Buttons
```css
.purchase-button {
    background: linear-gradient(45deg, #9370db, #8a2be2);
    color: #fff;
    border: none;
    padding: 10px 20px;
    border-radius: 20px;
    font-size: 1rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    width: 100%;
}

.purchase-button:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 30px rgba(147, 112, 219, 0.6);
}

.bonus-button {
    background: linear-gradient(45deg, #ffd700, #ffed4e);
    color: #333;
    border: none;
    padding: 10px 20px;
    border-radius: 20px;
    font-size: 0.9rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    width: 100%;
}

.bonus-button:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 30px rgba(255, 215, 0, 0.6);
}
```

## 2. User Info Bar Styles
```css
/* User Info Bar */
.user-info-bar {
    background: linear-gradient(135deg, rgba(0, 0, 0, 0.4), rgba(147, 112, 219, 0.1));
    border: 2px solid rgba(147, 112, 219, 0.3);
    border-radius: 20px;
    padding: 20px;
    margin-bottom: 30px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 20px;
    position: relative;
    z-index: 10;
}

.user-balance {
    display: flex;
    gap: 30px;
    flex-wrap: wrap;
}

.balance-item {
    display: flex;
    align-items: center;
    gap: 8px;
}

.balance-icon {
    font-size: 1.3rem;
}

.balance-label {
    color: #b19cd9;
    font-weight: 600;
}

.balance-value {
    color: #ffd700;
    font-size: 1.2rem;
    font-weight: 700;
    text-shadow: 0 0 10px rgba(255, 215, 0, 0.4);
}
```

## 3. Character Selector Styles
```css
.character-selector {
    position: relative;
    z-index: 999;
}

.selected-character, .no-character {
    display: flex;
    align-items: center;
    gap: 10px;
}

.char-icon {
    font-size: 1.3rem;
}

.char-label {
    color: #b19cd9;
    font-weight: 600;
}

.char-name {
    color: #dda0dd;
    font-weight: 700;
    font-size: 1.1rem;
}

.change-char, .select-char {
    color: #9370db;
    text-decoration: none;
    padding: 5px 15px;
    border: 1px solid rgba(147, 112, 219, 0.5);
    border-radius: 15px;
    transition: all 0.3s ease;
    font-size: 0.9rem;
}

.change-char:hover, .select-char:hover {
    background: rgba(147, 112, 219, 0.2);
    border-color: #9370db;
    color: #dda0dd;
}

.warning {
    color: #ff6b6b;
    font-weight: 600;
}

.char-dropdown {
    position: absolute;
    top: 100%;
    right: 0;
    margin-top: 10px;
    background: linear-gradient(135deg, rgba(0, 0, 0, 0.95), rgba(147, 112, 219, 0.3));
    backdrop-filter: blur(10px);
    border: 2px solid rgba(147, 112, 219, 0.4);
    border-radius: 15px;
    padding: 20px;
    min-width: 250px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
    z-index: 1000;
}

.char-dropdown h4 {
    color: #9370db;
    margin-bottom: 15px;
    font-size: 1.2rem;
}

.char-option {
    display: block;
    padding: 10px 15px;
    margin-bottom: 8px;
    background: rgba(147, 112, 219, 0.1);
    border: 1px solid rgba(147, 112, 219, 0.3);
    border-radius: 10px;
    text-decoration: none;
    color: #e6d7f0;
    transition: all 0.3s ease;
}

.char-option:hover {
    background: rgba(147, 112, 219, 0.3);
    border-color: #9370db;
    transform: translateX(5px);
}

.char-option .char-name {
    font-weight: 600;
}

.no-chars {
    color: #b19cd9;
    text-align: center;
    padding: 20px;
}

.login-notice {
    text-align: center;
    color: #b19cd9;
    font-size: 1.1rem;
    margin-top: 20px;
}

.login-notice a {
    color: #9370db;
    text-decoration: none;
    font-weight: 600;
    transition: color 0.3s ease;
}

.login-notice a:hover {
    color: #dda0dd;
    text-decoration: underline;
}
```

## 4. Category Sidebar Styles
```css
/* Category Sidebar */
.category-sidebar-link:hover {
    background: rgba(147, 112, 219, 0.3) !important;
    transform: translateX(5px);
    box-shadow: 0 3px 15px rgba(147, 112, 219, 0.4);
}

/* Custom scrollbar for category sidebar */
.category-sidebar-scroll::-webkit-scrollbar {
    width: 6px;
}

.category-sidebar-scroll::-webkit-scrollbar-track {
    background: rgba(147, 112, 219, 0.1);
    border-radius: 3px;
}

.category-sidebar-scroll::-webkit-scrollbar-thumb {
    background: rgba(147, 112, 219, 0.4);
    border-radius: 3px;
}

.category-sidebar-scroll::-webkit-scrollbar-thumb:hover {
    background: rgba(147, 112, 219, 0.6);
}
```

## 5. Shop Tab Styles
```css
/* Tab styles */
.shop-tab {
    display: inline-block;
    padding: 12px 30px;
    background: rgba(147, 112, 219, 0.2);
    color: #fff;
    text-decoration: none;
    border-radius: 30px;
    font-weight: 600;
    transition: all 0.3s ease;
}

.shop-tab:hover {
    background: rgba(147, 112, 219, 0.4);
    transform: translateY(-2px);
    box-shadow: 0 5px 20px rgba(147, 112, 219, 0.4);
}

.shop-tab.active {
    background: linear-gradient(45deg, #9370db, #8a2be2);
    box-shadow: 0 8px 30px rgba(147, 112, 219, 0.6);
}
```

## 6. Voucher History Popup Styles
```css
/* Popup specific styles to prevent theme issues */
#voucherHistoryPopup {
    font-family: 'Cinzel', serif !important;
    color: #e6d7f0 !important;
}

#voucherHistoryPopup * {
    color: inherit;
}
```

## 7. Additional Responsive Styles for Shop
```css
@media (max-width: 768px) {
    .shop-section {
        padding: 30px 20px;
    }
}
```

## Summary
The unified CSS file is missing:
1. Shop grid and item card styles
2. User info bar (balance display)
3. Character selector dropdown
4. Purchase/bonus button styles
5. Category sidebar styles
6. Shop tab navigation
7. Voucher history popup styles
8. Some shop-specific responsive adjustments

These styles should be added to the unified CSS file to ensure the shop page displays correctly.