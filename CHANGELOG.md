# Changelog

All notable changes to Haven Perfect World Panel will be documented in this file.

## [v2.1.70] - 2025-01-11

### Added
- Shop category navigation system with mask filtering
- 21 shop categories including weapons, armor, fashion, charms, etc.
- Active category highlighting
- Category icons for visual identification

### Changed
- Shop now properly uses the panel's mask system for item categorization
- Shop controller now accepts mask parameter for filtering
- Removed debug comments from shop and vote pages

### Fixed
- Shop now displays items properly with category filtering

## [v2.1.69] - 2025-01-11

### Fixed
- Added empty state messages for shop and vote pages when no items/sites exist
- Added debug output to show item/site counts
- Fixed potential display issues when database has no data

### Added
- "No Items Available" message for empty shop
- "No Vote Sites Available" message for empty vote page

## [v2.1.68] - 2025-01-11

### Added
- Actual shop functionality with purchase buttons on shop page
- Support for both currency and bonus point purchases
- Actual donate functionality with links to all enabled payment methods
- Actual vote functionality with proper vote submission forms
- Character selection check for shop purchases

### Changed
- Shop items now show purchase buttons when logged in
- Donate methods now show action buttons when logged in
- Vote sites now have working vote buttons when logged in
- All pages show "Login Required" status when not authenticated

## [v2.1.67] - 2025-01-11

### Fixed
- Shop page now properly shows logged-in status instead of prompting to login
- Donate page now properly shows logged-in status instead of prompting to login  
- Vote page now properly shows logged-in status instead of prompting to login
- Added personalized welcome messages for authenticated users on these pages

## [v2.1.66] - 2025-01-11

### Added
- Traditional HTML website theme implementation
- Custom shop page with mystical purple theme
- Custom donate page with payment method display
- Custom vote page with voting sites display
- Public routes for shop, donate, and vote sections

### Changed
- Transformed panel to look like a traditional website
- Bypassed normal Laravel theming system for custom HTML/CSS approach
- Updated home.blade.php to use traditional HTML structure
- Modified navigation to use public routes for unauthenticated access

### Notes
- Pre-login page remains unchanged as requested
- All pages maintain mystical purple theme with floating particles
- Backend functionality preserved using existing models and functions