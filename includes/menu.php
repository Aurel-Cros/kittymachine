<?php

/**
 * Register our kittymachine_options_page to the admin_menu action hook.
 */
add_action('admin_menu', 'kittymachine_options_page');

/**
 * Add the top level menu page.
 */
function kittymachine_options_page()
{
    add_submenu_page(
        'options-general.php',
        'Kitty Machine',
        'Kitty Machine',
        'manage_options',
        'kittymachine',
        'kittymachine_options_page_html'
    );
    // add_menu_page(
    // 	'Kitty Machine',
    // 	'Kitty Machine',
    // 	'manage_options',
    // 	'kittymachine',
    // 	'kittymachine_options_page_html',
    // 	'pets',
    // 	'plugins.php'
    // );
}


/**
 * Add the settings link in the extensions page
 */
add_filter('plugin_action_links_kittymachine/kittymachine.php', 'km_settings_link');
function km_settings_link($links)
{
    $url = esc_url(add_query_arg('page', 'kittymachine', get_admin_url() . 'options-general.php'));
    $link = "<a href='$url'>" . __('Settings') . "</a>";
    array_push($links, $link);
    return $links;
}
