<?php

/**
 * Registers the block using the metadata loaded from the `block.json` file.
 * Behind the scenes, it registers also all assets so they can be enqueued
 * through the block editor in the corresponding context.
 *
 * @see https://developer.wordpress.org/reference/functions/register_block_type/
 */
function kittymachine_kittymachine_block_init()
{
    register_block_type(KITTYMACHINE_PATH . '/build');
}
add_action('init', 'kittymachine_kittymachine_block_init');

/**
 * Register our kittymachine_settings_init to the admin_init action hook.
 */
add_action('admin_init', 'kittymachine_settings_init');
