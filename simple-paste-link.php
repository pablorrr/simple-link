<?php
/**
 *
 * Plugin Name: Simple Paste Link
 * Plugin URI: https://websitecreator.cba.pl
 * Description: Shortcode dla kolorowania dowolnego linku
 * Version: 1.0
 * Author: Paweł Kalisz
 * Author URI:https://websitecreator.cba.pl
 * License:MIT
 */

use Main\Paste_Link_Plugin;

if (!defined('ABSPATH')) exit;

require_once(__DIR__ . '/inc/paste-link-plugin.php');

function Run_Paste_Link_Plugin(): Paste_Link_Plugin
{
    return Paste_Link_Plugin::instance();
}

Run_Paste_Link_Plugin();

