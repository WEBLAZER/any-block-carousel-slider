<?php
/**
 * Handles asset loading for Native Blocks Carousel.
 *
 * @package NativeBlocksCarousel
 */

declare(strict_types=1);

namespace Weblazer\NativeBlocksCarousel;

use Weblazer\NativeBlocksCarousel\Contracts\ServiceInterface;

/**
 * Loads the plugin styles and scripts.
 */
class Assets implements ServiceInterface
{
    /**
     * Plugin version.
     *
     * @var string
     */
    private string $version;

    /**
     * Base plugin URL.
     *
     * @var string
     */
    private string $pluginUrl;

    /**
     * Service in charge of theme-inherited styles.
     *
     * @var ThemeStyles
     */
    private ThemeStyles $themeStyles;

    /**
     * Constructor.
     *
     * @param string      $version     Plugin version.
     * @param string      $plugin_url  Base plugin URL.
     * @param ThemeStyles $themeStyles Theme styles service.
     */
    public function __construct(string $version, string $plugin_url, ThemeStyles $themeStyles)
    {
        $this->version = $version;
        $this->pluginUrl = $plugin_url;
        $this->themeStyles = $themeStyles;
    }

    /**
     * Registers hooks used to load assets.
     *
     * @return void
     */
    public function register(): void
    {
        \add_action('enqueue_block_assets', [$this, 'enqueueBlockAssets']);
        \add_action('enqueue_block_editor_assets', [$this, 'enqueueEditorAssets']);
    }

    /**
     * Enqueues shared styles and scripts (frontend + editor).
     *
     * @return void
     */
    public function enqueueBlockAssets(): void
    {
        $this->registerScripts();

        \wp_enqueue_style(
            'native-blocks-carousel',
            $this->pluginUrl . 'assets/css/carousel.css',
            [],
            $this->version
        );

        \wp_enqueue_script('native-blocks-carousel-shared');

        if (!\is_admin()) {
            \wp_enqueue_script('native-blocks-carousel-frontend');
        }

        $this->themeStyles->injectButtonColors();
    }

    /**
     * Enqueues Gutenberg editor specific scripts.
     *
     * @return void
     */
    public function enqueueEditorAssets(): void
    {
        $this->registerScripts();

        \wp_enqueue_style('native-blocks-carousel');

        $editorStylesPath = NATIVE_BLOCKS_CAROUSEL_PLUGIN_PATH . 'assets/css/carousel-editor.css';
        if (\file_exists($editorStylesPath)) {
            $editorStyles = \file_get_contents($editorStylesPath);
            if ($editorStyles) {
                \wp_add_inline_style('native-blocks-carousel', $editorStyles);
            }
        }

        \wp_enqueue_script('native-blocks-carousel-shared');

        \wp_enqueue_script('native-blocks-carousel-editor');
    }

    /**
     * Registers plugin scripts with dependencies.
     *
     * @return void
     */
    private function registerScripts(): void
    {
        if (!\wp_script_is('native-blocks-carousel-shared', 'registered')) {
            \wp_register_script(
                'native-blocks-carousel-shared',
                $this->pluginUrl . 'assets/js/carousel-shared.js',
                [],
                $this->version,
                true
            );
        }

        if (!\wp_script_is('native-blocks-carousel-frontend', 'registered')) {
            \wp_register_script(
                'native-blocks-carousel-frontend',
                $this->pluginUrl . 'assets/js/carousel-frontend-init.js',
                ['native-blocks-carousel-shared'],
                $this->version,
                true
            );
        }

        if (!\wp_script_is('native-blocks-carousel-editor', 'registered')) {
            \wp_register_script(
                'native-blocks-carousel-editor',
                $this->pluginUrl . 'assets/js/carousel-editor.js',
                [
                    'native-blocks-carousel-shared',
                    'wp-blocks',
                    'wp-element',
                    'wp-editor',
                    'wp-components',
                    'wp-data',
                    'wp-compose',
                    'wp-hooks',
                    'wp-i18n',
                ],
                $this->version,
                true
            );
        }
    }
}