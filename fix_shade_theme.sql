-- Check the shade theme's status
SELECT id, name, display_name, is_default, is_auth_theme, is_active, is_visible 
FROM themes 
WHERE name = 'shade' OR display_name LIKE '%shade%';

-- To make it deletable, you need to set all these flags to 0
-- But first make sure you have another theme set as default/auth/active!

-- Make shade deletable (run this after ensuring other themes are set properly):
UPDATE themes 
SET is_default = 0, is_auth_theme = 0, is_active = 0 
WHERE name = 'shade' OR display_name LIKE '%shade%';

-- After running the UPDATE, the delete button should appear in the UI
-- Or you can delete it directly:
-- DELETE FROM themes WHERE name = 'shade' OR display_name LIKE '%shade%';