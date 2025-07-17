-- SQL to manually delete the shade theme
-- Run this in your production database

-- First, check if the theme exists
SELECT * FROM themes WHERE name = 'shade' OR display_name LIKE '%shade%';

-- If it exists and you want to delete it, run:
DELETE FROM themes WHERE name = 'shade' OR display_name LIKE '%shade%';

-- Also check for and delete the CSS file (run in terminal):
-- rm /path/to/your/public/css/themes/theme-shade.css