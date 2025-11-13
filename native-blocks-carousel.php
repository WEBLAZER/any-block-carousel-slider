<?php
/**
 * Plugin Name: Native Blocks Carousel
 * Plugin URI: https://github.com/WEBLAZER/native-blocks-carousel
 * Description: Transform any WordPress block into a performant carousel with pure CSS. Zero JavaScript, works with Gallery, Grid, Post Template, and Group blocks.
 * Version: 1.0.2
 * Author: weblazer35
 * Author URI: https://weblazer.fr
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: native-blocks-carousel
 * Domain Path: /languages
 * Requires at least: 6.0
 * Tested up to: 6.8
 * Requires PHP: 7.4
 *
 * @package NativeBlocksCarousel
 */

declare(strict_types=1);

use Weblazer\NativeBlocksCarousel\Activator;
use Weblazer\NativeBlocksCarousel\Autoloader;
use Weblazer\NativeBlocksCarousel\Plugin;

if (!defined('ABSPATH')) {
    exit;
}

define('NATIVE_BLOCKS_CAROUSEL_VERSION', '1.0.2');
define('NATIVE_BLOCKS_CAROUSEL_PLUGIN_FILE', __FILE__);
define('NATIVE_BLOCKS_CAROUSEL_PLUGIN_URL', plugin_dir_url(__FILE__));
define('NATIVE_BLOCKS_CAROUSEL_PLUGIN_PATH', plugin_dir_path(__FILE__));
require_once __DIR__ . '/includes/Autoloader.php';

Autoloader::register(__DIR__ . '/includes/');

register_activation_hook(__FILE__, [Activator::class, 'activate']);
register_deactivation_hook(__FILE__, [Activator::class, 'deactivate']);

Plugin::instance()->boot();