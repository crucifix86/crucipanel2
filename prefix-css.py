#!/usr/bin/env python3
import re

# Read the CSS
with open('vote-css-clean.tmp', 'r') as f:
    css = f.read()

# Remove the @import line - it should stay at the top level
css = re.sub(r'@import[^;]+;', '', css)

# Split into lines
lines = css.split('\n')
processed_lines = []

in_keyframes = False
in_media = False
media_indent = ""

for line in lines:
    stripped = line.strip()
    
    # Skip empty lines
    if not stripped:
        continue
        
    # Handle @keyframes - these need special treatment
    if '@keyframes' in line:
        in_keyframes = True
        processed_lines.append(line)
        continue
    
    # Handle closing brace for keyframes
    if in_keyframes and line.strip() == '}':
        in_keyframes = False
        processed_lines.append(line)
        continue
        
    # Inside keyframes, don't prefix
    if in_keyframes:
        processed_lines.append(line)
        continue
    
    # Handle @media queries
    if '@media' in line:
        in_media = True
        media_indent = "    "
        processed_lines.append(line)
        continue
        
    # End of media query
    if in_media and line.strip() == '}':
        in_media = False
        media_indent = ""
        processed_lines.append(line)
        continue
    
    # Inside media query
    if in_media:
        # Add extra indentation and prefix
        if re.match(r'^[^{}]+{', stripped):
            # This is a selector
            if stripped.startswith('.') or stripped.startswith('#') or re.match(r'^[a-z]', stripped):
                processed_lines.append(media_indent + 'body.vote-page ' + stripped)
            else:
                processed_lines.append(media_indent + stripped)
        else:
            processed_lines.append(line)
        continue
    
    # Regular CSS rules
    if stripped.startswith('*'):
        processed_lines.append('body.vote-page ' + stripped)
    elif stripped.startswith('body {'):
        processed_lines.append('body.vote-page {')
    elif stripped.startswith('.') or stripped.startswith('#'):
        processed_lines.append('body.vote-page ' + stripped)
    elif re.match(r'^[a-z][a-zA-Z0-9-]*\s*{', stripped):
        # Element selectors
        processed_lines.append('body.vote-page ' + stripped)
    elif re.match(r'^[a-z][a-zA-Z0-9-]*\s*[:.>~+]', stripped):
        # Complex selectors
        processed_lines.append('body.vote-page ' + stripped)
    else:
        processed_lines.append(line)

# Write the result
with open('vote-css-prefixed.tmp', 'w') as f:
    f.write('\n'.join(processed_lines))

print("CSS prefixed successfully!")