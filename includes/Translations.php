<?php
/**
 * Service de chargement des traductions pour Any Block Carousel Slider.
 *
 * @package AnyBlockCarouselSlider
 */

declare(strict_types=1);

namespace Weblazer\AnyBlockCarouselSlider;

use Weblazer\AnyBlockCarouselSlider\Contracts\TranslationServiceInterface;

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
            'any-block-carousel-slider',
            false,
            dirname(plugin_basename(ANY_BLOCK_CAROUSEL_SLIDER_PLUGIN_FILE)) . '/languages'
        );
    }
}