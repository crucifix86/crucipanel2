# Theme Unification Process - Detailed Notes

## Current Status (v2.1.360)
- Working on theme-unification branch
- Theme selector/editor was removed to focus on fixing CSS first
- Last version with theme selector: v2.1.359 (on master branch)
- Will re-add theme selector/editor AFTER all CSS is properly unified

## Process Being Used

### For Each Page (shop, donate, rankings, vote, members):

1. **Read the blade file** to find the CSS block
   - Look for `<style>` or `@section('styles')` 
   - Find where it ends (`</style>` or `@endsection`)

2. **Extract the CSS**
   - Save to temporary file (e.g., shop-inline-css.tmp)
   - Note the line numbers (e.g., shop had 1100+ lines, donate had 961 lines)

3. **Add body class to the page**
   - Add `@section('body-class', 'page-name-page')` after the title section
   - Examples: 'shop-page', 'donate-page', 'rankings-page', 'vote-page'

4. **Append CSS to mystical-purple-unified.css**
   - Add comment header: `/* Page Name Page Specific Styles */`
   - Prefix ALL selectors with `body.page-name`
   - Replace all instances of `body {` with `body.page-name {`
   - Preserve exact formatting and rules
   - End with comment: `/* End of Page Name Page Specific Styles */`

5. **Remove the inline CSS from blade file**
   - Delete entire `<style>` block or `@section('styles')` section
   - Leave the HTML content intact

## Pages Completed

### ✅ shop.blade.php
- Had 1100+ lines of inline CSS (lines 6-1111)
- Body class: 'shop-page'
- CSS moved to unified file with `body.shop-page` prefix
- Temp file: shop-inline-css.tmp

### ✅ donate.blade.php  
- Had 961 lines of inline CSS (lines 6-967)
- Body class: 'donate-page'
- CSS moved to unified file with `body.donate-page` prefix
- Temp file: donate-inline-css.tmp

### ✅ rankings.blade.php
- Had 840 lines of inline CSS (lines 7-847)
- Used `@section('styles')` approach
- Body class: 'rankings-page'
- CSS moved to unified file with `body.rankings-page` prefix
- Temp file: rankings-inline-css.tmp

### ✅ vote.blade.php
- Had 1031 lines of inline CSS (lines 15-1046)
- Used `@section('styles')` approach
- Body class: 'vote-page'
- CSS moved to unified file with `body.vote-page` prefix
- Temp file: vote-inline-css.tmp

### ❌ members.blade.php
- NOT STARTED YET
- Will need same treatment

## Key Files

### Modified Files:
- `/home/doug/crucipanel2/public/css/mystical-purple-unified.css` - Contains all unified styles
- `/home/doug/crucipanel2/resources/views/website/shop.blade.php` - Inline CSS removed
- `/home/doug/crucipanel2/resources/views/website/donate.blade.php` - Inline CSS removed
- `/home/doug/crucipanel2/resources/views/website/rankings.blade.php` - Inline CSS removed
- `/home/doug/crucipanel2/resources/views/website/vote.blade.php` - Inline CSS removed

### Temp Files Created:
- shop-inline-css.tmp
- donate-inline-css.tmp
- rankings-inline-css.tmp
- vote-inline-css.tmp

### Important Notes:
- Each page's CSS is completely isolated with body class prefixing
- This ensures no CSS conflicts between pages
- The theme selector will work properly once re-added because inline CSS no longer overrides theme CSS
- All styles preserved EXACTLY as they were to maintain appearance

## What Happens Next:
1. Test current changes (shop, donate, rankings, vote)
2. If all looks good, proceed with members.blade.php
3. After all pages unified, re-add theme selector from v2.1.359

## Critical Rules:
- NEVER change the CSS rules themselves
- ALWAYS prefix with body.page-class
- PRESERVE exact appearance
- Test each page after changes