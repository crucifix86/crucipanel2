<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Theme;

class MobileThemeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Read the mobile theme CSS
        $mobileCss = file_get_contents(public_path('css/themes/theme-mobile-mystical.css'));
        
        // Create or update the mobile theme
        Theme::updateOrCreate(
            ['name' => 'mobile-mystical'],
            [
                'display_name' => 'Mobile Mystical',
                'description' => 'Clean and responsive theme optimized for mobile devices',
                'css_content' => $mobileCss,
                'js_content' => '// Mobile Menu JavaScript
document.addEventListener("DOMContentLoaded", function() {
    // Add mobile menu toggle functionality
    const navbar = document.querySelector(".navbar, nav[role=\"navigation\"]");
    if (navbar && window.innerWidth <= 768) {
        navbar.addEventListener("click", function(e) {
            if (e.target === navbar || e.target.closest(".navbar::after")) {
                const navLinks = document.querySelector(".navbar-nav, nav ul, .nav-links");
                if (navLinks) {
                    navLinks.classList.toggle("mobile-active");
                    document.body.classList.toggle("mobile-menu-open");
                }
            }
        });
        
        // Close menu when clicking outside
        document.addEventListener("click", function(e) {
            if (!e.target.closest(".navbar") && !e.target.closest(".navbar-nav")) {
                const navLinks = document.querySelector(".navbar-nav, nav ul, .nav-links");
                if (navLinks && navLinks.classList.contains("mobile-active")) {
                    navLinks.classList.remove("mobile-active");
                    document.body.classList.remove("mobile-menu-open");
                }
            }
        });
    }
    
    // Add data-label attributes for responsive tables
    if (window.innerWidth <= 480) {
        document.querySelectorAll("table").forEach(function(table) {
            const headers = Array.from(table.querySelectorAll("thead th")).map(th => th.textContent.trim());
            table.querySelectorAll("tbody tr").forEach(function(row) {
                row.querySelectorAll("td").forEach(function(cell, index) {
                    if (headers[index]) {
                        cell.setAttribute("data-label", headers[index]);
                    }
                });
            });
        });
    }
    
    // Prevent iOS form zoom
    const viewport = document.querySelector("meta[name=viewport]");
    if (viewport) {
        viewport.content = "width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no";
    }
});',
                'layout_content' => 'layouts.mobile',
                'is_active' => true,
                'is_visible' => true,
                'is_default' => false,
                'is_auth_theme' => false,
                'is_mobile_theme' => true,
                'is_editable' => true
            ]
        );
    }
}