<?php
/**
 * Gestion des styles hérités du thème pour Native Blocks Carousel.
 *
 * @package NativeBlocksCarousel
 */

declare(strict_types=1);

namespace Weblazer\NativeBlocksCarousel;

/**
 * Récupère et injecte les couleurs des boutons du thème actif.
 */
class ThemeStyles
{
    /**
     * Injecter les couleurs des boutons du thème dans le CSS du plugin.
     *
     * Cette méthode recherche les couleurs configurées pour les boutons
     * dans le fichier theme.json ou dans les feuilles de style compilées
     * par WordPress, puis ajoute ces valeurs sous forme de variables CSS.
     *
     * @return void
     */
    public function injectButtonColors(): void
    {
        $theme_json = \WP_Theme_JSON_Resolver::get_merged_data();
        $styles = $theme_json->get_stylesheet();
        $settings = $theme_json->get_data();

        $button_bg = '';
        $button_color = '';

        if (isset($settings['styles']['elements']['button']['color']['background'])) {
            $button_bg = $settings['styles']['elements']['button']['color']['background'];
        }

        if (isset($settings['styles']['elements']['button']['color']['text'])) {
            $button_color = $settings['styles']['elements']['button']['color']['text'];
        }

        if (empty($button_bg) && \preg_match('/.wp-element-button[^{]*\{[^}]*background-color:\s*([^;]+)/s', $styles, $matches)) {
            $button_bg = \trim($matches[1]);
        }

        if (empty($button_color) && \preg_match('/.wp-element-button[^{]*\{[^}]*color:\s*([^;]+)/s', $styles, $matches)) {
            $button_color = \trim($matches[1]);
        }

        $button_bg = $this->resolveCssVariable($button_bg, $styles);
        $button_color = $this->resolveCssVariable($button_color, $styles);

        $custom_css = ':root {';

        if (!empty($button_bg)) {
            $custom_css .= '--carousel-button-bg: ' . \esc_attr($button_bg) . ';';
        }

        if (!empty($button_color)) {
            $custom_css .= '--carousel-button-color: ' . \esc_attr($button_color) . ';';
        }

        $custom_css .= '}';

        if (!empty($button_bg) || !empty($button_color)) {
            \wp_add_inline_style('native-blocks-carousel', $custom_css);
        }
    }

    /**
     * Résout une variable CSS éventuelle pour en obtenir la valeur réelle.
     *
     * @param string $value  Valeur potentielle d'une variable CSS.
     * @param string $styles Feuille de styles dans laquelle rechercher.
     *
     * @return string
     */
    private function resolveCssVariable(string $value, string $styles): string
    {
        if (empty($value) || false === \strpos($value, 'var(')) {
            return $value;
        }

        if (\preg_match('/var\(([^)]+)\)/', $value, $var_match)) {
            $var_name = \trim($var_match[1]);
            if (\preg_match('/' . \preg_quote($var_name, '/') . ':\s*([^;]+)/s', $styles, $color_match)) {
                return \trim($color_match[1]);
            }
        }

        return $value;
    }
}