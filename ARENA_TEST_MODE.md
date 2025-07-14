# Arena Top 100 Test Mode Documentation

## Overview
This document explains the Arena Top 100 test mode features added to help diagnose and test the voting mechanism when Arena's 12-hour cooldown limits testing.

## Test Mode Features

### 1. Force Successful Votes
When enabled, all Arena callbacks will return `voted=1` (successful vote), regardless of Arena's actual response.

### 2. Clear Vote Timer
When enabled, bypasses the cooldown timer check, allowing unlimited voting for testing purposes.

### 3. Clear Arena Logs Button
Available to admins when test mode is active, this button clears all Arena vote logs for the current user.

## How to Enable Test Mode

### Method 1: Admin Panel
1. Go to Admin Panel → Vote → Arena Top 100
2. Scroll to the "Testing Mode" section (red box)
3. Toggle the options you need:
   - **Force Successful Votes**: Always return successful vote in callbacks
   - **Clear Vote Timer**: Bypass cooldown timer checks
4. Click Save

### Method 2: Environment Variables
Add these to your `.env` file:
```
ARENA_TEST_MODE=true
ARENA_TEST_CLEAR_TIMER=true
```

Then clear and rebuild the config cache:
```bash
php artisan config:clear
php artisan config:cache
```

## How Test Mode Works

### When "Force Successful Votes" is enabled:
1. User clicks vote button
2. Instead of redirecting to Arena, it redirects to your own callback URL
3. The callback always returns `voted=1` (successful)
4. User receives rewards immediately

### When "Clear Vote Timer" is enabled:
1. Cooldown checks are bypassed
2. Vote button is always available
3. Users can vote unlimited times

## Testing Workflow

1. Enable test mode in admin panel
2. Go to Dashboard → Vote
3. You'll see a red warning box indicating test mode is active
4. Click "Vote for Arena Top 100"
5. You'll be redirected back immediately with rewards given
6. If you're an admin, use "Clear My Arena Logs" button to reset for more testing

## Important Warnings

⚠️ **NEVER USE IN PRODUCTION!**
- This mode allows unlimited voting
- Users will receive rewards without actually voting
- All safety checks are bypassed
- Always disable before going live

## Checking Logs

Monitor the Laravel log for test mode activity:
```bash
tail -f storage/logs/laravel.log | grep Arena
```

You'll see entries like:
- `Arena: TEST MODE ACTIVE - Always returning successful vote`
- `Arena: Test mode - forcing valid = 1`
- `Arena: Test mode - simulating immediate callback`
- `Arena: Test mode - bypassing cooldown check`
- `Arena: Cleared all logs for testing`

## Disabling Test Mode

1. Go to Admin Panel → Vote → Arena Top 100
2. Turn off both test mode switches
3. Click Save
4. The red warning boxes will disappear from the vote page

Remember to test with test mode OFF before production to ensure real Arena callbacks work correctly!