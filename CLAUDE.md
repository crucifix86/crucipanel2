# Claude Context for CruciPanel2

## SAFETY VERSION: v2.1.453
- **Mobile theme completely removed and original responsive design restored**
- **All non-essential files cleaned up, project directory organized**
- **This is our stable baseline version for new features**

## PRIVATE MESSAGING IMPLEMENTATION PLAN

### Overview
Implement a private messaging system that allows users to send messages to each other within the panel.

### Key Features
1. **User Search**: Search for users by name or email to send messages
2. **Click-to-Message**: Click on player names in members list to send message
3. **Inbox/Outbox**: View received and sent messages
4. **Notifications**: Show unread message count
5. **Message Threading**: Reply to messages with conversation view
6. **Profile Message Wall**: Public message wall on user profiles for comments/greetings
7. **Admin Controls**: Enable/disable messaging system globally
8. **Mass Messaging**: Admin ability to message all users at once

### Database Schema
```sql
-- Private Messages Table
CREATE TABLE messages (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    sender_id INT NOT NULL,
    recipient_id INT NOT NULL,
    subject VARCHAR(255),
    message TEXT NOT NULL,
    is_read BOOLEAN DEFAULT FALSE,
    parent_id BIGINT NULL, -- For threading
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    deleted_by_sender BOOLEAN DEFAULT FALSE,
    deleted_by_recipient BOOLEAN DEFAULT FALSE,
    FOREIGN KEY (sender_id) REFERENCES users(ID),
    FOREIGN KEY (recipient_id) REFERENCES users(ID),
    FOREIGN KEY (parent_id) REFERENCES messages(id),
    INDEX idx_recipient_read (recipient_id, is_read),
    INDEX idx_sender (sender_id)
);

-- Profile Message Wall
CREATE TABLE profile_messages (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    profile_user_id INT NOT NULL, -- User whose profile this is posted on
    sender_id INT NOT NULL,
    message TEXT NOT NULL,
    is_visible BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (profile_user_id) REFERENCES users(ID),
    FOREIGN KEY (sender_id) REFERENCES users(ID),
    INDEX idx_profile_visible (profile_user_id, is_visible)
);

-- System Settings for Messaging
ALTER TABLE settings ADD COLUMN messaging_enabled BOOLEAN DEFAULT TRUE;
ALTER TABLE settings ADD COLUMN profile_wall_enabled BOOLEAN DEFAULT TRUE;
```

### Implementation Steps
1. **Create Migration & Model**
   - Messages table migration
   - Profile messages table migration
   - Message and ProfileMessage models with relationships
   - Add message count to User model
   - Update Settings model for messaging toggles

2. **Backend Controllers**
   - MessagesController for private message CRUD
   - ProfileMessagesController for wall messages
   - Search functionality for users
   - Mark as read/unread
   - Soft delete for sender/recipient
   - Admin mass messaging endpoint

3. **Frontend Components**
   - Message compose modal/page
   - Inbox/Outbox views with pagination
   - Unread badge in navigation
   - User search autocomplete
   - Profile message wall component
   - Admin messaging interface

4. **Integration Points**
   - Add message icon/link to player names in members list
   - Add messaging section to user dashboard
   - Add "Send Message" button to user profiles
   - Show unread count in main navigation
   - Add message wall to profile pages
   - Admin panel messaging settings

5. **Admin Features**
   - Toggle messaging system on/off
   - Toggle profile walls on/off
   - Mass message all users interface
   - View messaging statistics
   - Moderate inappropriate messages

6. **Security Considerations**
   - Rate limiting for message sending
   - Message content validation/sanitization
   - Profile wall moderation (user can hide messages)
   - Admin ability to view/moderate all messages
   - Prevent spam with cooldowns

### UI/UX Design
- Clean, simple interface matching mystical theme
- Modal for quick message composition
- Full page view for message threads
- Toast notifications for new messages
- Mobile-responsive design
- Profile message wall with:
  - Public comments visible to all
  - Delete option for profile owner
  - Report button for inappropriate content
  - Pagination for many messages
- Admin panel integration:
  - Settings page with messaging toggles
  - Mass message interface with preview
  - Message statistics dashboard

## CRITICAL PUBLIC PROFILE ISSUES (v2.1.472)

### THE PROBLEMS:
1. **Wall content is ABOVE the navigation bar and header** - This means content is being rendered outside/before the container
2. **Profile sections are underneath all widgets** - Not using the container's margin-left properly
3. **Page structure is completely broken** - Elements are scattered, not following the layout

### WHAT I TRIED AND FAILED:
1. v2.1.464 - Added margins that pushed everything left and broke the theme everywhere
2. v2.1.465-466 - Emergency fixes that made it worse
3. v2.1.467 - Reverted but then broke it again
4. v2.1.468 - Tried to copy container pattern, made elements scatter
5. v2.1.469 - Made it even worse with wrong margins
6. v2.1.470 - Reverted to v2.1.463
7. v2.1.471 - Added content-section wrapper (wrong approach)
8. v2.1.472 - Applied styling but didn't fix structural issues

### THE REAL ISSUE:
- Something is fundamentally wrong with how the public profile content is being rendered
- Content appears OUTSIDE the mystical layout's container structure
- The @yield('content') is not working as expected for this page

### WHAT NEEDS TO BE INVESTIGATED:
1. Why is content appearing above the nav/header?
2. Is there a route/controller issue?
3. Is the blade template structure correct?
4. Is something overriding the layout?

## CURRENT STATUS (v2.1.453)

### ✅ ALL INLINE CSS ISSUES RESOLVED! 
All pages now support theme color changes. The 24+ hours of theme unification work is complete.

### PAGES SUCCESSFULLY UNIFIED:
- home.blade.php ✓ (v2.1.415)
- shop.blade.php ✓ (v2.1.417) 
- donate.blade.php ✓ (v2.1.418)
- vote.blade.php ✓
- members.blade.php ✓
- page.blade.php (custom pages) ✓
- profile/show.blade.php ✓
- pre-login.blade.php ✓
- register.blade.php ✓
- forgot-password.blade.php ✓
- reset-password.blade.php ✓
- rankings.blade.php ✓

### CURRENT WORKING FEATURES:
1. **Theme System** - Fully functional with file-based CSS storage
2. **Theme Editor** - Works correctly, preserves custom CSS
3. **Delete Theme** - Can delete themes from admin panel
4. **Set Site Default Theme** - Admin can set default theme for all new users
5. **Reset All Users to Default** - Force all users to use site default theme
6. **Auth Pages Theming** - Login/register pages support themes

### PENDING TASKS:
1. **Mobile Theme Needs Complete Revert** - Current mobile theme is awful and breaking functionality
   - Custom CSS/JS is interfering with normal panel operation
   - Need to revert to panel's original mobile integration
   - Remove all the mobile "improvements" that made things worse

## HOW THE THEME SYSTEM WORKS

### Key Discovery:
The mystical layout loads CSS from theme files via `route('theme.css')`, NOT from mystical-purple-unified.css directly.

### Theme File Locations:
- `/home/doug/crucipanel2/public/css/themes/theme-default-mystical.css`
- `/home/doug/crucipanel2/public/css/themes/theme-custom-mystical.css`
- Additional theme files as created

### How to Add CSS for New Pages:
1. Add `@section('body-class', 'page-name')` to the blade file
2. Remove ALL inline styles from the page
3. Add CSS to mystical-purple-unified.css with `body.page-name` prefix
4. Copy the CSS to all theme files
5. Use CSS variables for colors that themes can override

## THEME SYSTEM FIXED (v2.1.399)

### ✅ THEME SYSTEM NOW FULLY WORKING
- Theme switching works properly
- Custom CSS is preserved when editing themes
- File-based system with database backup
- Each theme has its own CSS file in `public/css/themes/`

### WHAT WAS FIXED (v2.1.378 - v2.1.399)
1. **Theme CSS Loading Issue**
   - Was: Database loading worked but file loading didn't switch themes
   - Fixed: Hybrid approach - loads from file if exists, falls back to database
   - Theme selection works correctly now

2. **Theme Editor Overwriting Bug**
   - Was: Every time you edited a theme, it copied purple theme over your custom CSS
   - Fixed: Editor now loads existing CSS from file, doesn't overwrite with default
   - Custom CSS is preserved when editing

3. **Theme Management Commands Added**
   - `php artisan themes:check-files` - See which themes have duplicate content
   - `php artisan themes:test-save` - Test if file saving works
   - `php artisan themes:reset-defaults` - Reset default themes to purple
   - `php artisan themes:delete {name}` - Delete themes (no UI option)
   - `php artisan themes:fix-visibility` - Make hidden themes visible
   - `php artisan themes:generate-files` - Generate CSS files for existing themes

### CURRENT DEBUG FEATURES TO REMOVE
- Yellow debug box showing theme info (in mystical layout)
- Theme indicator in bottom-right corner
- Colored border based on theme
- Debug comments in CSS output

### NEXT TASK AFTER COMPACT
- Remove all the on-screen debugging from mystical layout and ThemeAssetController
- Clean final release

## THEME UNIFICATION STATUS (v2.1.378)

### ✅ COMPLETED PAGES (11 pages unified)
1. **shop.blade.php** - Unified with body.shop-page
2. **donate.blade.php** - Unified with body.donate-page  
3. **rankings.blade.php** - Unified with body.rankings-page
4. **vote.blade.php** - Unified with body.vote-page
5. **members.blade.php** - Unified with body.members-page
6. **page.blade.php** (custom pages) - Unified with body.custom-page
7. **profile/show.blade.php** - Unified with body.profile-page
8. **pre-login.blade.php** - Unified with body.pre-login-page
9. **register.blade.php** - Unified with body.register-page
10. **forgot-password.blade.php** - Unified with body.forgot-password-page
11. **reset-password.blade.php** - Unified with body.reset-password-page

### 🔄 IN PROGRESS
- None currently

### ❌ NOT YET UNIFIED
- Other profile views (update forms, etc.)
- Any other pages using inline CSS

### LATEST WORK COMPLETED (v2.1.376 - v2.1.378)
1. **Profile Page Unification (v2.1.376)**
   - Redesigned profile/show.blade.php with body.profile-page
   - Added 400+ lines of profile CSS with animated avatars and glassmorphism
   - Fixed issue where text was invisible due to transparent gradient on gold background

2. **Auth Pages Unification (v2.1.377)**
   - Created new layouts/auth.blade.php for cleaner auth pages
   - Unified pre-login.blade.php with body.pre-login-page
   - Unified register.blade.php with body.register-page  
   - Unified forgot-password.blade.php with body.forgot-password-page
   - Unified reset-password.blade.php with body.reset-password-page
   - Added 600+ lines of auth CSS with dragon/phoenix ornaments

3. **Translation Fixes (v2.1.378)**
   - Fixed all incorrect translation keys in password recovery pages
   - Now using existing keys from auth.php language file

### CRITICAL NOTES
- **NEVER USE INLINE CSS!** ALL CSS must go in mystical-purple-unified.css
- **BODY CLASS IS REQUIRED!** Each page MUST have `@section('body-class', 'page-name')`
- All CSS is in `mystical-purple-unified.css` scoped by body classes
- Without body-class, pages will have NO styling
- The mystical layout loads CSS from the unified file, NOT from database
- Auth pages use the new `layouts/auth.blade.php` layout (simpler, no navigation)
- **DO NOT ADD <style> TAGS TO BLADE FILES** - This breaks the theme system!

### APPROACH THAT WORKS
1. Examine current page structure
2. Create clean HTML with semantic classes
3. Add body-class section
4. Move ALL CSS to unified file with body.page-name prefix
5. Test thoroughly before release

### SUMMARY OF THEME UNIFICATION PROJECT
- **Started**: v2.1.366 (fixing theme selector that only worked on home page)
- **Current**: v2.1.378 (11 pages unified, 4300+ lines of CSS)
- **Approach**: Moving all inline CSS to mystical-purple-unified.css with body-class scoping
- **Key Achievement**: Consistent mystical purple theme across all unified pages
- **Still To Do**: Find and unify any remaining pages with inline CSS

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

## CRITICAL THEME UNIFICATION WORK - ALMOST COMPLETE! (v2.1.366)

### Current Status (v2.1.366 - theme-unification branch)
We're fixing the theme selector that only works on home page. The issue: inline CSS left in pages when themes were unified.

### IMPORTANT: Theme Selector/Editor Status
- **Theme selector/editor was removed to focus on fixing CSS first**
- **Last version with theme selector: v2.1.359 (on master branch)**
- Will re-add theme selector/editor AFTER all CSS is properly unified
- DO NOT add theme selector back until all pages are unified

### What's Been Done:
1. **COMPLETED: shop.blade.php** - Moved 1100+ lines to unified CSS with body.shop-page ✓ LOOKS GOOD
2. **COMPLETED: donate.blade.php** - Moved 961 lines to unified CSS with body.donate-page ✓ LOOKS GOOD
3. **COMPLETED: rankings.blade.php** - Moved 840 lines to unified CSS with body.rankings-page ✓ LOOKS GOOD
4. **COMPLETED: vote.blade.php** - Redesigned with clean CSS and gold button styling ✓ LOOKS GOOD
   - Minor issue: Coin amount not showing in Arena Top 100 box
5. **FIXED: mystical.blade.php layout** - Now properly applies body-class to body tag

### What MUST Be Done Next:
1. **FIX coin amount display in Arena box on vote page**
2. **members.blade.php** - PENDING (last page to fix)

### Critical Notes:
- Fixed mystical layout to include body-class in body tag (was preventing CSS from loading!)
- All pages now use unified CSS with body.page-class scoping
- Vote page was redesigned with enhanced gold button styling after original CSS couldn't be restored

### Files Created:
- CURRENT_STATUS_THEME_UNIFICATION.md - Detailed current status
- mystical-purple-unified.css - Contains all unified styles (now 2200+ lines)

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

## Admin Panel Success Messages Pattern
For admin panel save operations that need success feedback, use the URL query parameter pattern (?saved=1) with auto-refresh:

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