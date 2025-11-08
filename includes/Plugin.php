<?php
/**
 * Classe principale du plugin Native Blocks Carousel.
 *
 * @package NativeBlocksCarousel
 */

declare(strict_types=1);

namespace Weblazer\NativeBlocksCarousel;

use Weblazer\NativeBlocksCarousel\Contracts\ServiceInterface;
use Weblazer\NativeBlocksCarousel\Translations;

/**
 * Point d'entrée orchestrant les différents services du plugin.
 */
class Plugin
{
    /**
     * Instance unique de la classe.
     *
     * @var Plugin|null
     */
    private static ?Plugin $instance = null;

    /**
     * Liste des services enregistrés.
     *
     * @var ServiceInterface[]
     */
    private array $services;

    /**
     * Constructeur privé.
     *
     * @param ServiceInterface[] $services Liste des services du plugin.
     */
    public function __construct(array $services)
    {
        $this->services = $services;
    }

    /**
     * Récupère l'instance unique du plugin.
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
     * Initialise le plugin en déclarant les hooks requis.
     *
     * @return void
     */
    public function boot(): void
    {
        \add_action('init', [$this, 'init']);
    }

    /**
     * Hook init : prépare les traductions et les services.
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