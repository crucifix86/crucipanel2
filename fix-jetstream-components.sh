#!/bin/bash

# Script to update all jet- prefixed components to the new Jetstream 4 format

echo "Updating Jetstream component references from x-jet-* to x-*..."

# Find all blade files and replace x-jet- with x-
find resources/views -name "*.blade.php" -type f -exec sed -i 's/<x-jet-/<x-/g' {} \;
find resources/views -name "*.blade.php" -type f -exec sed -i 's/<\/x-jet-/<\/x-/g' {} \;

echo "Update complete!"
echo ""
echo "Component references have been updated to match Jetstream 4 conventions."