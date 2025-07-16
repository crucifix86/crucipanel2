# Claude Context for CruciPanel2

## Important Project Information

### SAFETY VERSION: v2.1.258
- **Voting function working perfectly as of this version**
- Always revert to this version if voting breaks after changes
- This is our stable baseline version

### Development Environment
- **Two environments are now available:**
  - **Production**: VPS (Contabo server) - live version
  - **Local Testing**: http://localhost:8000 - for testing migrations, features, and changes before pushing to git
- Database credentials for local: user: admin, pass: vTzllyedTYjL4, database: pw
- Always test locally first, then push to git, then deploy to VPS

### Git Configuration
- GitHub username: **crucifix86**
- Repository: https://github.com/crucifix86/crucipanel2
- Always use crucifix86 for git operations

### Release Process
When making releases, ALWAYS follow these steps in order:

1. **Update VERSION file**: 
   - Path: `/home/doug/crucipanel2/VERSION`
   - Format: `v2.1.X` (increment X for each release)
   - Check current version before updating

2. **Commit changes**:
   ```bash
   git add -A && git commit -m "Descriptive commit message" && git push origin master
   ```

3. **Create and push tag**:
   ```bash
   git tag -a vX.X.X -m "Brief description" && git push origin vX.X.X
   ```

4. **Create GitHub release**:
   ```bash
   gh release create vX.X.X --title "vX.X.X - Title" --notes "Release notes"
   ```

### Email Configuration
- Using PHP mail with Postfix (not sendmail)
- Domain must have SPF record: `v=spf1 ip4:SERVER_IP ~all`
- Email settings are stored in .env and cached with `config:cache`
- FROM address must match the user's domain

### Project Structure
- Admin panel uses: `layouts/admin.blade.php`
- User dashboard uses: `layouts/app.blade.php`
- Public pages use: `layouts/portal.blade.php`
- Password reset uses its own full HTML layout

### Design Guidelines
- Header logo (haven_perfect_world_logo.svg) - larger, main branding
- Badge logo (crucifix_logo.svg) - smaller, only in:
  - Admin dashboard header
  - User dashboard header
  - Navbar (everywhere)
  - NOT in public page headers

### Testing Requirements
- Always test email functionality on VPS
- Check /var/log/mail.log for email issues
- Run `php artisan config:cache` after .env changes
- Password reset must handle users with and without PINs

### Common Issues & Solutions
1. **Email not sending**: Check SPF record, ensure FROM matches domain
2. **Settings appear reset**: Actually reading from cache, use config() not env()
3. **Updates needed**: Create new version, tag, and release on GitHub

### Commands to Remember
- Check mail log: `sudo tail -f /var/log/mail.log`
- Clear Laravel cache: `php artisan config:clear && php artisan config:cache`
- Find server IP: `curl ifconfig.me`
- Verify SPF: `dig +short txt yourdomain.com`

## DO NOT
- Test locally - the panel is on VPS only
- Use env() in controllers when config is cached
- Add badge logo to public page headers
- Hardcode domain-specific values (must work for all users)
- Clear git history or use different git user

## CRITICAL THEME UNIFICATION WORK IN PROGRESS

### Current Status (v2.1.360 - theme-unification branch)
We're fixing the theme selector that only works on home page. The issue: inline CSS left in pages when themes were unified.

### IMPORTANT: Theme Selector/Editor Status
- **Theme selector/editor was removed to focus on fixing CSS first**
- **Last version with theme selector: v2.1.359 (on master branch)**
- Will re-add theme selector/editor AFTER all CSS is properly unified
- DO NOT add theme selector back until all pages are unified

### What's Been Done:
1. Created backups of all pages with inline CSS
2. **COMPLETED: shop.blade.php** - Moved 1100+ lines to unified CSS with body.shop-page ✓ LOOKS GOOD
3. **COMPLETED: donate.blade.php** - Moved 961 lines to unified CSS with body.donate-page ✓ LOOKS GOOD
4. **COMPLETED: rankings.blade.php** - Moved 840 lines to unified CSS with body.rankings-page ✓ LOOKS GOOD
5. **BROKEN: vote.blade.php** - CSS is obliterated, style is all wrong ❌ NEEDS FIX
   - Have backup in vote-inline-css.tmp
   - CSS was extracted from lines 15-1046
6. Created temp files for all completed pages

### What MUST Be Done Next:
1. **FIX vote.blade.php CSS** - The CSS migration failed, style is broken
2. **members.blade.php** - PENDING (last page to fix)

### Critical Notes:
- User explicitly said: "its imperative that when removing the inline code the theme is preserved exactly"
- Previous attempts failed because styles weren't properly moved to CSS file
- MUST test each page after changes to ensure appearance is EXACTLY the same
- Work one page at a time, test, commit, create release
- Each page gets body class: shop-page, donate-page, rankings-page, etc.
- All styles in unified CSS must be scoped with body.page-class

### Files Created:
- shop-inline-css.tmp - Contains extracted CSS from shop page
- donate-inline-css.tmp - Contains extracted CSS from donate page
- Backups: *.blade.php.backup for all affected pages
- mystical-purple-unified.css - Contains all unified styles

## Traditional Website Theme Implementation (v2.1.66+)
### Important Context
- **We bypassed the normal Laravel theming system entirely**
- Created custom HTML pages with inline styles to look like a traditional website
- Pre-login page remains unchanged (mystical purple theme)
- All pages use traditional HTML/CSS approach, NOT Laravel components

### Pages Transformed
1. **home.blade.php** - Traditional HTML with fixed login box
2. **rankings.blade.php** - Traditional rankings display (including PvP)
3. **shop.blade.php** - Traditional shop page using Shop model
4. **donate.blade.php** - Traditional donate page using donation config
5. **vote.blade.php** - Traditional vote page using VoteSite model

### Key Implementation Details
- All pages maintain mystical purple theme (floating particles, dragon ornaments)
- Navigation uses public routes for unauthenticated access
- Backend functionality preserved using existing models/functions
- EnsurePreLogin middleware updated to allow public routes
- Login redirect changed from /dashboard to / (home page)

### When Making Updates
- Continue using traditional HTML/CSS approach for consistency
- Avoid Laravel component syntax in these pages
- Always use existing model methods (e.g., Player::subtype(), Faction::subtype())
- Maintain the mystical purple theme across all pages

## Important Fix Needed - Admin Panel Success Messages (v2.1.128)
### Problem Identified
- Session flash messages aren't working properly after saving settings
- This is likely due to config cache clearing affecting sessions
- Affects ALL admin panel save operations (not just system settings)

### Solution That Works
- Use URL query parameter (?saved=1) instead of session flash
- Display inline success message (green box with readable colors)
- Add simple JavaScript to refresh page after 2 seconds
- This pattern needs to be applied to ALL admin controllers

### Controllers That Need This Fix
- DonateController (payment settings)
- NewsController (news settings)
- ChatController (chat settings)
- RankingController (ranking settings)
- ServiceController (service settings)
- ShopController (shop settings)
- VoteController (vote settings)
- Any other admin controllers with save operations

### Implementation Pattern
```php
// In controller:
return redirect()->back()->withInput()->with('saved', '1')
    ->setTargetUrl(url()->previous() . '?saved=1');

// In view:
@if(request()->get('saved') == 1)
    <div class="bg-green-50 dark:bg-green-900/30 border-2 border-green-500 dark:border-green-400 text-green-900 dark:text-green-100 px-4 py-3 rounded-lg relative mb-4 font-semibold" role="alert">
        <span class="block sm:inline">✓ {{ __('admin.configSaved') }}</span>
    </div>
    <script>
        setTimeout(function() {
            window.location.href = window.location.pathname;
        }, 2000);
    </script>
@endif
```

## Current Status (v2.1.75)
### Traditional Theme Pages Completed
1. **Shop** - Has categories, character selection, balance display, purchase buttons
2. **Vote** - Has cooldown logic, displays vote sites from database
3. **Donate** - Shows all payment methods with rates/details
4. **Rankings** - Shows top players, PvP rankings, and factions

### Important Notes on Donation Settings
- **Donation settings are NOT in the admin panel** - they are in config files
- PayPal settings: `config/pw-config.php` under `payment.paypal.*`
  - Key mismatch: Config uses `currency_per` but code looks for `currency_per`
  - Bank uses different keys than expected (e.g., `payment_price` not `pay`)
- Bank transfer: `config/pw-config.php` under `payment.bank_transfer.*`
  - Config has: `bankAccountNo1`, `bankName1`, etc. (not `bank_1_number`)
  - Has `payment_price` not `pay`, `multiply` not `rate`
- Paymentwall: `config/pw-config.php` under `payment.paymentwall.*`
- iPaymu: NOT in separate file, it's under `payment.ipaymu.*` in pw-config.php

### Current Issues  
- Donation settings are NOT configurable in the admin panel
  - Currently only in config files (pw-config.php)
  - No UI to enable/disable payment methods
  - Config keys don't match expected keys in some places:
    - Bank transfer uses 'multiply' not 'rate'
    - Uses 'CurrencySign' not 'currency' 
    - Uses 'bankAccountNo1' not 'bank_1_number'
- Vote and donate pages show blank if:
  - No vote sites in database (add via admin panel)
  - All donation methods disabled in config files
- Shop works but requires:
  - Shop items in database (add via admin panel)
  - Character selection to purchase

### Needed Improvements
- Add donation settings to admin panel (like header/footer settings)
- Create DonationSetting model and migration
- Add admin interface to configure PayPal, Bank, Paymentwall, iPaymu