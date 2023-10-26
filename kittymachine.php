<?php

/**
 * Plugin Name:       Kitty Machine
 * Description:       The Kitty Machine will grant you much happiness by providing endless furry friends !
 * Requires at least: 6.3.2
 * Requires PHP:      7.0
 * Version:           1.0.0
 * Author:            Aurélien Cros
 * Author URI:        https://aurelien-cros.fr
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       kittymachine
 *
 * @package           create-block
 */

define('KITTYMACHINE_PATH', plugin_dir_path(__FILE__));
$includesFolder = KITTYMACHINE_PATH . '\includes';

require_once($includesFolder . '\init.php');
require_once($includesFolder . '\menu.php');
require_once($includesFolder . '\options.php');
