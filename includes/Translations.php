<?php
/**
 * Service de chargement des traductions pour Native Blocks Carousel.
 *
 * @package NativeBlocksCarousel
 */

declare(strict_types=1);

namespace Weblazer\NativeBlocksCarousel;

use Weblazer\NativeBlocksCarousel\Contracts\TranslationServiceInterface;

class Translations implements TranslationServiceInterface
{
    /**
     * {@inheritdoc}
     */
    public function register(): void
    {
        add_action('plugins_loaded', [$this, 'loadTranslations']);
    }

    /**
     * {@inheritdoc}
     */
    public function loadTranslations(): void
    {
        load_plugin_textdomain(
            'native-blocks-carousel',
            false,
            dirname(plugin_basename(NATIVE_BLOCKS_CAROUSEL_PLUGIN_FILE)) . '/languages'
        );
    }
}