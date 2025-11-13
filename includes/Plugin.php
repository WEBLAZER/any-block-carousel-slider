<?php
/**
 * Main class for the Native Blocks Carousel plugin.
 *
 * @package NativeBlocksCarousel
 */

declare(strict_types=1);

namespace Weblazer\NativeBlocksCarousel;

use Weblazer\NativeBlocksCarousel\Contracts\ServiceInterface;
use Weblazer\NativeBlocksCarousel\Translations;

/**
 * Entry point coordinating the different plugin services.
 */
class Plugin
{
    /**
     * Singleton instance.
     *
     * @var Plugin|null
     */
    private static ?Plugin $instance = null;

    /**
     * Registered services.
     *
     * @var ServiceInterface[]
     */
    private array $services;

    /**
     * Public constructor.
     *
     * @param ServiceInterface[] $services Plugin services.
     */
    public function __construct(array $services)
    {
        $this->services = $services;
    }

    /**
     * Retrieves the singleton instance of the plugin.
     *
     * @return Plugin
     */
    public static function instance(): Plugin
    {
        if (null === self::$instance) {
            $theme_styles = new ThemeStyles();
            $services = [
                new Translations(),
                new Assets(
                    NATIVE_BLOCKS_CAROUSEL_VERSION,
                    NATIVE_BLOCKS_CAROUSEL_PLUGIN_URL,
                    $theme_styles
                ),
                new Renderer(),
            ];

            self::$instance = new self($services);
        }

        return self::$instance;
    }

    /**
     * Boots the plugin by registering required hooks.
     *
     * @return void
     */
    public function boot(): void
    {
        \add_action('init', [$this, 'init']);
    }

    /**
     * Init hook: prepares translations and services.
     *
     * @return void
     */
    public function init(): void
    {
        foreach ($this->services as $service) {
            $service->register();
        }
    }
}