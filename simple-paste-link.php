<?php
/*
     * Plugin Name: Simple Paste Link
     * Plugin URI: https://websitecreator.cba.pl
     * Description: Shortcode dla kolorowania dowolnego linku
     * Version: 1.0
     * Author: Paweł Kalisz
     * Author URI:https://websitecreator.cba.pl
     * License:MIT
     */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}
if (!function_exists('__return_false')) {
    require_once(ABSPATH . '/wp-includes/functions.php');
}


function add_link_shortcode($add_link_shortcode)
{

    $options = get_option('plug_settings');
    $url = $options['input_text_field_0'];
    $color = $options['plug_select_field_0'];


    switch ($color) {
        case '1':
            $add_link_shortcode = '<div><div class="animate"><p><a style="color:red" target="_blanket" href="' . esc_url($url) . '">' . esc_url($url) . '</a></p><br></div></div>';
            break;
        case '2':
            $add_link_shortcode = '<div><div class="animate"><p><a style="color:blue" target="_blanket" href="' . esc_url($url) . '">' . esc_url($url) . '</a></p><br></div></div>';
            break;
        case '3':
            $add_link_shortcode = '<div><div class="animate"><p><a style="color:green" target="_blanket" href="' . esc_url($url) . '">' . esc_url($url) . '</a></p><br></div></div>';
            break;
        case '4':
            $add_link_shortcode = '<div><div class="animate"><p><a style="color:black" target="_blanket" href="' . esc_url($url) . '">' . esc_url($url) . '</a></p><br></div></div>';
            break;
    }


    return $add_link_shortcode;
}

add_shortcode('paste', 'add_link_shortcode');

/**
 *
 * sposob dodawania shortcoda na gutenberg: najpierw dodaj widget  shortcode gutenbera  potem wklj [paste] i zachowaj
 */

add_action('admin_menu', 'plug_add_admin_menu');
add_action('admin_init', 'plug_setting_init');


function plug_add_admin_menu()
{

    add_menu_page('Paste Link',
        'Paste Link',
        'manage_options',
        'paste-link',
        'plug_options_page');

}


function plug_setting_init()
{

    register_setting('pluginPage', 'plug_settings');

    add_settings_section(
        'plug_pluginPage_section',
        __('Your section description', 'polish'),
        '__return_false',
        'pluginPage'
    );

    add_settings_field(
        'plug_select_field_0',
        __('Settings field description', 'polish'),
        'plug_select_field_0_render',
        'pluginPage',
        'plug_pluginPage_section'
    );
    add_settings_field(
        'input_text_field_0',
        'Wklej tutaj swój link url',
        'callback_text_field_0_render',
        'pluginPage',
        'plug_pluginPage_section'
    );
}


function plug_select_field_0_render()
{
    $options = get_option('plug_settings');
    ?>
    <select name='plug_settings[plug_select_field_0]'>
        <option value='1' <?php selected($options['plug_select_field_0'], 1); ?>>red color</option>
        <option value='2' <?php selected($options['plug_select_field_0'], 2); ?>>blue color</option>
        <option value='3' <?php selected($options['plug_select_field_0'], 3); ?>>green color</option>
        <option value='4' <?php selected($options['plug_select_field_0'], 4); ?>>black color</option>
    </select>

    <?php

}


function callback_text_field_0_render()
{
    $options = get_option('plug_settings');
    ?>
    <textarea name='plug_settings[input_text_field_0]'
              value='<?php echo $options['input_text_field_0']; ?>'><?php echo esc_url($options['input_text_field_0']); ?></textarea>
    <?php

}

function plug_options_page()
{
    ?>
    <form action='options.php' method='post'>

        <h2>my_plugin_name</h2>

        <?php
        settings_fields('pluginPage');
        do_settings_sections('pluginPage');
        submit_button();
        ?>

    </form>
    <?php
}

?>