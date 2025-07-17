#!/bin/bash

# Script to publish Jetstream components to the correct location for Laravel 10/Jetstream 4

echo "Publishing Jetstream components..."

# Create components directory if it doesn't exist
mkdir -p resources/views/components

# Copy all Jetstream components from vendor to components directory
if [ -d "resources/views/vendor/jetstream/components" ]; then
    cp -r resources/views/vendor/jetstream/components/* resources/views/components/
    echo "✓ Jetstream components published successfully!"
else
    echo "✗ Error: Jetstream components not found in vendor directory."
    echo "  Make sure you have run: php artisan jetstream:install livewire"
    exit 1
fi

echo ""
echo "Components are now available as:"
echo "  <x-section-border />"
echo "  <x-input />"
echo "  <x-button />"
echo "  etc."