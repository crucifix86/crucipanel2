# Guild Icon Project - DO NOT DELETE

## What We Learned

### How Perfect World Faction Icons Work

1. **Icons are CLIENT-SIDE resources** - They are NOT stored on the server or in the database
2. **Sprite Sheet System Required**:
   - `iconlist_guild.png` - A sprite sheet containing all faction icons (16x16 pixels each)
   - `iconlist_guild.txt` - A mapping file that links faction IDs to positions in the sprite
   - Format: `width\nheight\nrows\ncols\nfaction_id.dds\n...`

3. **The Game Server**:
   - Has NO icon storage in GFactionInfo structure
   - Cannot dynamically serve icons to clients
   - Icons must be distributed as part of game client files

### Reference Implementations

1. **Alexdnepro Panel** (PHP):
   - Stores icons in `server_side/klan/` directory
   - Uses `seticon()` function to add icons to sprite sheet
   - Updates version file when icons change
   - Icons must be manually distributed to clients

2. **This JSP Plugin**:
   - Allows individual icon upload (16x16 GIF files)
   - Has "Download" feature that:
     - Generates sprite sheet from all uploaded icons
     - Creates the mapping text file
     - Zips them for manual distribution
   - Admin must patch these files into game client

### Current Limitations

1. **No Auto-Update** - Game client cannot fetch icons dynamically from server
2. **Manual Patching Required** - Every icon change needs client-side patch
3. **Distribution Problem** - All players need updated sprite sheets

### Our Implementation

We currently save individual faction icons in `storage/app/public/faction-icons/` but they only display on the web panel, not in-game. To make them work in-game would require:

1. Generating sprite sheets from uploaded icons
2. Creating a patch distribution system
3. Having all players download and install patches

### Files in This Folder

- `iconlist_guild.png` - Example sprite sheet
- `iconlist_guild.txt` - Example mapping file  
- `index.jsp` - JSP implementation for reference
- `icons/` - Example individual icon files

## Note

This folder is kept for reference and potential future implementation of a sprite sheet generator or auto-patcher system.