<?php
/**
 * Gestion de l'activation et la désactivation du plugin.
 *
 * @package NativeBlocksCarousel
 */

declare(strict_types=1);

namespace Weblazer\NativeBlocksCarousel;

/**
 * Vérifie la compatibilité lors de l'activation du plugin.
 */
class Activator
{
    /**
     * Exécuté lors de l'activation du plugin.
     *
     * @return void
     */
    public static function activate(): void
    {
        if (\version_compare(\get_bloginfo('version'), '6.0', '<')) {
            \wp_die(
                \esc_html__('Ce plugin nécessite WordPress 6.0 ou plus récent.', 'native-blocks-carousel'),
                \esc_html__('Version WordPress insuffisante', 'native-blocks-carousel')
            );
        }

        if (\version_compare(\PHP_VERSION, '7.4', '<')) {
            \wp_die(
                \esc_html__('Ce plugin nécessite PHP 7.4 ou plus récent.', 'native-blocks-carousel'),
                \esc_html__('Version PHP insuffisante', 'native-blocks-carousel')
            );
        }
    }

    /**
     * Exécuté lors de la désactivation du plugin.
     *
     * @return void
     */
    public static function deactivate(): void
    {
        // Nettoyage futur si nécessaire.
    }
}