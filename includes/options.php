<?php

/**
 * @internal never define functions inside callbacks.
 * these functions could be run multiple times; this would result in a fatal error.
 */

/**
 * custom option and settings
 */
function kittymachine_settings_init()
{
    // Register a new setting for "kittymachine" page.
    register_setting('kittymachine', 'kittymachine_options');

    // Register a new section in the "kittymachine" page.
    add_settings_section(
        'kittymachine_section_developers',
        __('Configure the kitty block.', 'kittymachine'),
        'kittymachine_section_developers_callback',
        'kittymachine'
    );

    // Register a new field in the "kittymachine_section_developers" section, inside the "kittymachine" page.
    add_settings_field(
        'kittymachine_field_auto_refresh', // As of WP 4.6 this value is used only internally.
        // Use $args' label_for to populate the id inside the callback.
        __('Automatic refresh', 'kittymachine'),
        'kittymachine_field_auto_refresh_cb',
        'kittymachine',
        'kittymachine_section_developers',
        array(
            'label_for'         => 'kittymachine_field_auto_refresh',
            'class'             => 'kittymachine_row',
            'kittymachine_custom_data' => 'custom',
        )
    );

    // Register a new field in the "kittymachine_section_developers" section, inside the "kittymachine" page.
    add_settings_field(
        'kittymachine_field_auto_refresh_frequency', // As of WP 4.6 this value is used only internally.
        // Use $args' label_for to populate the id inside the callback.
        __('Automatic refresh frequency', 'kittymachine'),
        'kittymachine_field_auto_refresh_frequency_cb',
        'kittymachine',
        'kittymachine_section_developers',
        array(
            'label_for'         => 'kittymachine_field_auto_refresh_frequency',
            'class'             => 'kittymachine_row',
            'kittymachine_custom_data' => 'custom',
        )
    );
}

/**
 * Expose options in front-end script
 *
 * @return void
 */
function my_enqueue_scripts()
{
    wp_enqueue_script(
        'view',
        plugins_url('wp-content/plugins/kittymachine/build/view.js', __FILE__)
    );

    $scriptData = get_option('kittymachine_options');

    wp_localize_script('view', 'km_options', $scriptData);
}
add_action('wp_enqueue_scripts', 'my_enqueue_scripts');

/**
 * Developers section callback function.
 *
 * @param array $args  The settings array, defining title, id, callback.
 */
function kittymachine_section_developers_callback($args)
{
?>
    <p id="<?php echo esc_attr($args['id']); ?>"><?php esc_html_e('Lets you toggle automatic update and the frequency of those.', 'kittymachine'); ?></p>
<?php
}

/**
 * Top level menu callback function
 */
function kittymachine_options_page_html()
{
    // check user capabilities
    if (!current_user_can('manage_options')) {
        return;
    }

    // add error/update messages

    // check if the user have submitted the settings
    // WordPress will add the "settings-updated" $_GET parameter to the url
    if (isset($_GET['settings-updated'])) {
        // add settings saved message with the class of "updated"
        add_settings_error('kittymachine_messages', 'kittymachine_message', __('Settings Saved', 'kittymachine'), 'updated');
    }

    // show error/update messages
    // settings_errors('kittymachine_messages');
?>
    <div class="wrap">
        <h1><?php echo esc_html(get_admin_page_title()); ?></h1>
        <form action="options.php" method="post">
            <?php
            // output security fields for the registered setting "kittymachine"
            settings_fields('kittymachine');
            // output setting sections and their fields
            // (sections are registered for "kittymachine", each field is registered to a specific section)
            do_settings_sections('kittymachine');
            // output save settings button
            submit_button('Save Settings');
            ?>
        </form>
    </div>
<?php
}

/**
 * Automatic refresh field callback function.
 *
 * WordPress has magic interaction with the following keys: label_for, class.
 * - the "label_for" key value is used for the "for" attribute of the <label>.
 * - the "class" key value is used for the "class" attribute of the <tr> containing the field.
 * Note: you can add custom key value pairs to be used inside your callbacks.
 *
 * @param array $args
 */
function kittymachine_field_auto_refresh_cb($args)
{
    // Get the value of the setting we've registered with register_setting()
    $options = get_option('kittymachine_options');
    $value = $options[$args['label_for']] ?? true;
?>
    <select id="<?php echo esc_attr($args['label_for']); ?>" data-custom="<?php echo esc_attr($args['kittymachine_custom_data']); ?>" name="kittymachine_options[<?php echo esc_attr($args['label_for']); ?>]">
        <option value="true" <?php echo (selected($value, "true", false)); ?>>
            <?php esc_html_e('Yes', 'kittymachine'); ?>
        </option>
        <option value="false" <?php echo (selected($value, "false", false)); ?>>
            <?php esc_html_e('No', 'kittymachine'); ?>
        </option>
    </select>
<?php
}

/**
 * Automatic refresh frequency field callbakc function.
 *
 * @param array $args
 */
function kittymachine_field_auto_refresh_frequency_cb($args)
{
    // Get the value of the setting we've registered with register_setting()
    $options = get_option('kittymachine_options');
    $value = $options[$args['label_for']] ?? 5;
?>
    <input type="number" id="<?php echo esc_attr($args['label_for']); ?>" data-custom="<?php echo esc_attr($args['kittymachine_custom_data']); ?>" name="kittymachine_options[<?php echo esc_attr($args['label_for']); ?>]" value=<?php echo $value; ?> />
<?php
}
