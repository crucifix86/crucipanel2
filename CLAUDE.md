# Claude Context for CruciPanel2

## Important Project Information

### Development Environment
- **This project is NOT installed locally** - it runs on a VPS
- All testing must be done on the VPS, not locally
- The VPS is a Contabo server

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