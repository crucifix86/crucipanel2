<?php



/*
 * @author Harris Marfel <hrace009@gmail.com>
 * @link https://youtube.com/c/hrace009
 * @copyright Copyright (c) 2022.
 */

return [
    'dashboard' => 'Dashboard',
    'welcome!' => 'Welcome to your ' . config('app.name') . ' admin dashboard!',
    'playerOnline' => 'Players Online',
    'accountRegistered' => 'Registered Account',
    'totalCharacter' => 'Character Created',
    'totalFaction' => 'Faction Created',
    'configSaved' => 'Configuration has been saved!',
    'pagination' => [
        'showing' => 'Showing',
        'to' => 'to',
        'of' => 'of',
        'results' => 'results',
        'for' => 'For'
    ],
    
    // Page Manager Translations
    'page_manager' => 'Page Manager',
    'create_page' => 'Create Page',
    'edit_page' => 'Edit Page',
    'view_pages' => 'View Pages',
    'back_to_list' => 'Back to List',
    'page_title' => 'Page Title',
    'nav_title' => 'Navigation Title',
    'nav_title_help' => 'This is the title that will appear in the navigation menu',
    'slug' => 'URL Slug',
    'slug_help' => 'Leave empty to auto-generate from title. This will be the URL path for the page.',
    'content' => 'Content',
    'content_help' => 'You can use HTML to format your page content',
    'order' => 'Order',
    'order_help' => 'Pages with lower numbers appear first in the navigation',
    'meta_description' => 'Meta Description',
    'meta_keywords' => 'Meta Keywords',
    'active' => 'Active',
    'inactive' => 'Inactive',
    'show_in_nav' => 'Show in Navigation',
    'yes' => 'Yes',
    'no' => 'No',
    'status' => 'Status',
    'actions' => 'Actions',
    'edit' => 'Edit',
    'delete' => 'Delete',
    'confirm_delete' => 'Are you sure you want to delete this page?',
    'no_pages_found' => 'No pages found',
    'page_created' => 'Page created successfully!',
    'page_updated' => 'Page updated successfully!',
    'page_deleted' => 'Page deleted successfully!',
    'page_status_updated' => 'Page status updated successfully!',
    'create' => 'Create',
    'update' => 'Update',
    
    // Messaging Translations
    'messaging' => [
        'title' => 'Messaging',
        'settings' => 'Messaging Settings',
        'settings_updated' => 'Messaging settings have been updated successfully!',
        'enable_messaging' => 'Enable Private Messaging',
        'enable_messaging_desc' => 'Allow users to send private messages to each other',
        'enable_profile_wall' => 'Enable Profile Message Wall',
        'enable_profile_wall_desc' => 'Allow users to post public messages on profiles',
        'message_rate_limit' => 'Messages per Hour',
        'message_rate_limit_desc' => 'Maximum number of private messages a user can send per hour',
        'wall_message_rate_limit' => 'Wall Posts per Hour',
        'wall_message_rate_limit_desc' => 'Maximum number of profile wall posts a user can make per hour',
    ],
];
