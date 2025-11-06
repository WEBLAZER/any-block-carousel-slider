<?php
/**
 * Plugin Name: Native Blocks Carousel
 * Plugin URI: https://github.com/WEBLAZER/native-blocks-carousel
 * Description: Transform any WordPress block into a performant carousel with pure CSS. Zero JavaScript, works with Gallery, Grid, Post Template, and Group blocks.
 * Version: 1.0.1
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

// Empêcher l'accès direct
if (!defined('ABSPATH')) {
    exit;
}

// Constantes du plugin
define('NATIVE_BLOCKS_CAROUSEL_VERSION', '1.0.1');
define('NATIVE_BLOCKS_CAROUSEL_PLUGIN_URL', plugin_dir_url(__FILE__));
define('NATIVE_BLOCKS_CAROUSEL_PLUGIN_PATH', plugin_dir_path(__FILE__));

/**
 * Classe principale du plugin Native Blocks Carousel
 */
class NativeBlocksCarousel
{
    /**
     * Instance unique du plugin
     */
    private static $instance = null;

    /**
     * Constructeur privé pour le pattern Singleton
     */
    private function __construct()
    {
        add_action('init', [$this, 'init']);
    }

    /**
     * Retourne l'instance unique du plugin
     */
    public static function getInstance(): self
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Initialisation du plugin
     */
    public function init(): void
    {
        // Charger les styles CSS (frontend et éditeur)
        add_action('enqueue_block_assets', [$this, 'enqueue_block_assets']);

        // Charger les scripts JavaScript pour l'éditeur uniquement
        add_action('enqueue_block_editor_assets', [$this, 'enqueue_editor_scripts']);

        // Filtrer le rendu des blocs pour injecter les variables CSS
        // Priorité 20 pour s'exécuter après WordPress qui applique les styles (priorité 10)
        add_filter('render_block', [$this, 'inject_carousel_variables'], 20, 2);

        // Les traductions sont automatiquement chargées par WordPress.org
    }

    /**
     * Charger les styles CSS pour le frontend ET l'éditeur
     * Utilise enqueue_block_assets pour éviter le warning
     */
    public function enqueue_block_assets(): void
    {
        wp_enqueue_style(
            'native-blocks-carousel',
            NATIVE_BLOCKS_CAROUSEL_PLUGIN_URL . 'assets/css/carousel.css',
            [],
            NATIVE_BLOCKS_CAROUSEL_VERSION
        );

        // Charger le script frontend (uniquement sur le frontend, pas dans l'éditeur)
        if (!is_admin()) {
            wp_enqueue_script(
                'native-blocks-carousel-frontend',
                NATIVE_BLOCKS_CAROUSEL_PLUGIN_URL . 'assets/js/carousel-frontend.js',
                [],
                NATIVE_BLOCKS_CAROUSEL_VERSION,
                true // Charger dans le footer
            );
        }

        // Injecter les couleurs des boutons du thème
        $this->inject_theme_button_colors();
    }

    /**
     * Injecter les couleurs des boutons du thème dans le CSS
     */
    private function inject_theme_button_colors(): void
    {
        // Récupérer les styles globaux du thème
        $theme_json = WP_Theme_JSON_Resolver::get_merged_data();
        $styles = $theme_json->get_stylesheet();

        // Extraire les couleurs des boutons depuis les styles du thème
        $button_bg = '';
        $button_color = '';

        // Récupérer les données du thème
        $settings = $theme_json->get_data();

        // Méthode 1 : Chercher dans theme.json (priorité)
        if (isset($settings['styles']['elements']['button']['color']['background'])) {
            $button_bg = $settings['styles']['elements']['button']['color']['background'];
        }

        if (isset($settings['styles']['elements']['button']['color']['text'])) {
            $button_color = $settings['styles']['elements']['button']['color']['text'];
        }

        // Méthode 2 : Chercher dans le CSS compilé si theme.json n'a rien
        if (empty($button_bg) && preg_match('/.wp-element-button[^{]*\{[^}]*background-color:\s*([^;]+)/s', $styles, $matches)) {
            $button_bg = trim($matches[1]);
        }

        if (empty($button_color) && preg_match('/.wp-element-button[^{]*\{[^}]*color:\s*([^;]+)/s', $styles, $matches)) {
            $button_color = trim($matches[1]);
        }

        // Méthode 3 : Chercher les variables var(--wp--preset--color--xxx)
        if (!empty($button_bg) && strpos($button_bg, 'var(') !== false) {
            // Extraire le nom de la variable et chercher sa valeur
            if (preg_match('/var\(([^)]+)\)/', $button_bg, $var_match)) {
                $var_name = trim($var_match[1]);
                if (preg_match('/' . preg_quote($var_name, '/') . ':\s*([^;]+)/s', $styles, $color_match)) {
                    $button_bg = trim($color_match[1]);
                }
            }
        }

        if (!empty($button_color) && strpos($button_color, 'var(') !== false) {
            // Extraire le nom de la variable et chercher sa valeur
            if (preg_match('/var\(([^)]+)\)/', $button_color, $var_match)) {
                $var_name = trim($var_match[1]);
                if (preg_match('/' . preg_quote($var_name, '/') . ':\s*([^;]+)/s', $styles, $color_match)) {
                    $button_color = trim($color_match[1]);
                }
            }
        }

        // Générer le CSS inline
        $custom_css = ':root {';

        if (!empty($button_bg)) {
            $custom_css .= '--carousel-button-bg: ' . esc_attr($button_bg) . ';';
        }

        if (!empty($button_color)) {
            $custom_css .= '--carousel-button-color: ' . esc_attr($button_color) . ';';
        }

        $custom_css .= '}';

        // Ajouter le CSS inline si des couleurs ont été trouvées
        if (!empty($button_bg) || !empty($button_color)) {
            wp_add_inline_style('native-blocks-carousel', $custom_css);
        }
    }

    /**
     * Charger les scripts JavaScript pour l'éditeur Gutenberg
     * Ajoute le bouton "Carousel" dans les paramètres des blocs
     */
    public function enqueue_editor_scripts(): void
    {
        wp_enqueue_script(
            'native-blocks-carousel-editor',
            NATIVE_BLOCKS_CAROUSEL_PLUGIN_URL . 'assets/js/carousel-button.js',
            [
                'wp-blocks',
                'wp-element',
                'wp-editor',
                'wp-components',
                'wp-data',
                'wp-compose',
                'wp-hooks',
                'wp-i18n'
            ],
            NATIVE_BLOCKS_CAROUSEL_VERSION,
            true
        );
    }

    /**
     * Injecter les variables CSS pour les carousels
     * (minimumColumnWidth, blockGap, etc.)
     *
     * @param string $block_content Le contenu HTML du bloc
     * @param array $block Les données du bloc
     * @return string Le contenu modifié
     */
    public function inject_carousel_variables(string $block_content, array $block): string
    {
        // Vérifier si le bloc a la classe 'nbc-carousel' (dans className OU dans le HTML)
        $class_name = $block['attrs']['className'] ?? '';
        $has_carousel_class = strpos($class_name, 'nbc-carousel') !== false || strpos($block_content, 'nbc-carousel') !== false;
        
        if (!$has_carousel_class) {
            return $block_content;
        }

        $custom_styles = [];

        // 1. Injecter --carousel-min-width pour les Grids avec minimumColumnWidth (mode Auto)
        if (
            ($block['blockName'] === 'core/group' || $block['blockName'] === 'core/post-template') &&
            strpos($class_name, 'nbc-carousel-min-width') !== false
        ) {
            // Essayer plusieurs chemins possibles pour trouver minimumColumnWidth
            $min_width = $block['attrs']['layout']['minimumColumnWidth'] 
                ?? $block['attrs']['minimumColumnWidth']
                ?? null;
            
            // Vérifier aussi si on est en mode Auto (gridItemPosition === 'auto')
            // Note: minimumColumnWidth devrait déjà être dans les attributs si défini
            
            // Si pas trouvé dans les attributs, essayer d'extraire depuis le grid-template-columns dans le HTML
            // WordPress génère : grid-template-columns: repeat(auto-fill, minmax(min(XXXpx, 100%), 1fr))
            if (!$min_width && preg_match('/minmax\(min\(([^,]+),/', $block_content, $matches)) {
                $min_width = trim($matches[1]);
            }
            
            // Aussi essayer depuis les styles inline si présents
            if (!$min_width && preg_match('/grid-template-columns:\s*[^;]*minmax\(min\(([^,]+),/', $block_content, $matches)) {
                $min_width = trim($matches[1]);
            }
            
            if ($min_width) {
                $custom_styles['--carousel-min-width'] = $min_width;
            }
        }

        // 2. Injecter --wp--style--block-gap pour tous les carousels
        $block_gap = $block['attrs']['style']['spacing']['blockGap'] ?? null;

        // Exception pour Gallery : utiliser le gap horizontal (left) pour le carousel
        if ($block['blockName'] === 'core/gallery' && is_array($block_gap)) {
            $block_gap = $block_gap['left'] ?? $block_gap['top'] ?? null;
        }

        // Si c'est un preset WordPress (ex: "var:preset|spacing|50"), le convertir
        if ($block_gap && is_string($block_gap) && strpos($block_gap, 'var:preset|spacing|') === 0) {
            $preset_slug = str_replace('var:preset|spacing|', '', $block_gap);
            $block_gap = "var(--wp--preset--spacing--{$preset_slug})";
        }

        // Injecter le gap (même si c'est "0" pour None)
        if ($block_gap !== null && $block_gap !== '') {
            // Convertir "0" en "0px" pour les calculs CSS
            $custom_styles['--wp--style--block-gap'] = ($block_gap === '0' || $block_gap === 0) ? '0px' : $block_gap;
        }

        // 3. Injecter les variables de padding pour scroll-padding et positionnement des boutons
        $spacing = $block['attrs']['style']['spacing'] ?? [];
        $padding = $spacing['padding'] ?? null;
        
        // Extraire padding-left, padding-right, padding-top et padding-bottom
        $padding_left = null;
        $padding_right = null;
        $padding_top = null;
        $padding_bottom = null;
        
        if (is_array($padding)) {
            $padding_left = $padding['left'] ?? null;
            $padding_right = $padding['right'] ?? null;
            $padding_top = $padding['top'] ?? null;
            $padding_bottom = $padding['bottom'] ?? null;
        } elseif (is_string($padding) && $padding !== '') {
            // Si c'est une valeur unique (appliquée à tous les côtés)
            $padding_left = $padding;
            $padding_right = $padding;
            $padding_top = $padding;
            $padding_bottom = $padding;
        }
        
        // Fallback : si le padding n'est pas dans les attributs, essayer de l'extraire depuis le style inline
        // WordPress peut appliquer le padding directement dans le style inline (ex: "padding: 2rem;")
        if ($padding_left === null && $padding_right === null && $padding_top === null && $padding_bottom === null) {
            // Chercher spécifiquement dans l'élément avec la classe nbc-carousel
            if (preg_match('/(<(?:div|ul|figure)[^>]*class="[^"]*\bnbc-carousel\b[^"]*"[^>]*?)(?:\s+style="([^"]*)")?/i', $block_content, $carousel_matches)) {
                $style_attr = $carousel_matches[2] ?? '';
                
                if (!empty($style_attr)) {
                    // Extraire padding-left
                    if (preg_match('/padding-left:\s*([^;]+)/i', $style_attr, $matches)) {
                        $padding_left = trim($matches[1]);
                    }
                    
                    // Extraire padding-right
                    if (preg_match('/padding-right:\s*([^;]+)/i', $style_attr, $matches)) {
                        $padding_right = trim($matches[1]);
                    }
                    
                    // Extraire padding-top
                    if (preg_match('/padding-top:\s*([^;]+)/i', $style_attr, $matches)) {
                        $padding_top = trim($matches[1]);
                    }
                    
                    // Extraire padding-bottom
                    if (preg_match('/padding-bottom:\s*([^;]+)/i', $style_attr, $matches)) {
                        $padding_bottom = trim($matches[1]);
                    }
                    
                    // Si c'est un padding unique (ex: "padding: 2rem;")
                    if ($padding_left === null && $padding_right === null && $padding_top === null && $padding_bottom === null) {
                        if (preg_match('/padding:\s*([^;]+)/i', $style_attr, $matches)) {
                            $padding_value = trim($matches[1]);
                            // Vérifier si c'est une valeur unique (pas de format "top right bottom left")
                            if (!preg_match('/\s/', $padding_value)) {
                                $padding_left = $padding_value;
                                $padding_right = $padding_value;
                                $padding_top = $padding_value;
                                $padding_bottom = $padding_value;
                            }
                        }
                    }
                }
            }
        }
        
        // Gérer les presets WordPress pour le padding
        $convert_preset = function($value) {
            if (is_string($value) && strpos($value, 'var:preset|spacing|') === 0) {
                $preset_slug = str_replace('var:preset|spacing|', '', $value);
                return "var(--wp--preset--spacing--{$preset_slug})";
            }
            return $value;
        };
        
        if ($padding_left !== null) {
            $padding_left = $convert_preset($padding_left);
            // Toujours définir avec unité (0px au lieu de 0)
            $custom_styles['--carousel-scroll-padding-left'] = ($padding_left === '0' || $padding_left === 0) ? '0px' : $padding_left;
            $custom_styles['--carousel-padding-left'] = ($padding_left === '0' || $padding_left === 0) ? '0px' : $padding_left;
        } else {
            // Valeurs par défaut
            $custom_styles['--carousel-scroll-padding-left'] = '0px';
            $custom_styles['--carousel-padding-left'] = '0px';
        }
        
        if ($padding_right !== null) {
            $padding_right = $convert_preset($padding_right);
            // Toujours définir avec unité (0px au lieu de 0)
            $custom_styles['--carousel-scroll-padding-right'] = ($padding_right === '0' || $padding_right === 0) ? '0px' : $padding_right;
            $custom_styles['--carousel-padding-right'] = ($padding_right === '0' || $padding_right === 0) ? '0px' : $padding_right;
        } else {
            // Valeurs par défaut
            $custom_styles['--carousel-scroll-padding-right'] = '0px';
            $custom_styles['--carousel-padding-right'] = '0px';
        }
        
        // Injecter padding-top et padding-bottom
        if ($padding_top !== null) {
            $padding_top = $convert_preset($padding_top);
            // Toujours définir avec unité (0px au lieu de 0)
            $custom_styles['--carousel-padding-top'] = ($padding_top === '0' || $padding_top === 0) ? '0px' : $padding_top;
        } else {
            // Valeur par défaut (1rem correspond au padding par défaut du carousel)
            $custom_styles['--carousel-padding-top'] = '1rem';
        }
        
        if ($padding_bottom !== null) {
            $padding_bottom = $convert_preset($padding_bottom);
            // Toujours définir avec unité (0px au lieu de 0)
            $custom_styles['--carousel-padding-bottom'] = ($padding_bottom === '0' || $padding_bottom === 0) ? '0px' : $padding_bottom;
        } else {
            // Valeur par défaut (1rem correspond au padding par défaut du carousel)
            $custom_styles['--carousel-padding-bottom'] = '1rem';
        }

        // Si aucune variable à injecter, retourner tel quel
        if (empty($custom_styles)) {
            return $block_content;
        }

        // Construire la chaîne de styles CSS
        $styles_string = '';
        foreach ($custom_styles as $property => $value) {
            // S'assurer que les valeurs 0 ont toujours une unité pour les variables de padding
            if (($property === '--carousel-padding-left' || $property === '--carousel-padding-right' || 
                 $property === '--carousel-scroll-padding-left' || $property === '--carousel-scroll-padding-right') &&
                ($value === '0' || $value === 0)) {
                $value = '0px';
            }
            $styles_string .= esc_attr($property) . ':' . esc_attr($value) . ';';
        }

        // Injecter les styles dans le HTML
        // Chercher la balise avec la classe nbc-carousel
        $pattern = '/(<(?:div|ul|figure)\s+[^>]*class="[^"]*\bnbc-carousel\b[^"]*"[^>]*?)(?:\s+style="([^"]*)")?(\s*>)/i';

        $replacement = function($matches) use ($styles_string) {
            $tag_start = $matches[1];
            $existing_style = $matches[2] ?? '';
            $tag_end = $matches[3];

            // Combiner les styles existants avec les nouveaux
            $new_style = $existing_style;
            if (!empty($new_style) && !str_ends_with($new_style, ';')) {
                $new_style .= ';';
            }
            $new_style .= $styles_string;

            return $tag_start . ' style="' . $new_style . '"' . $tag_end;
        };

        $modified_content = preg_replace_callback($pattern, $replacement, $block_content, 1);

        return $modified_content ?: $block_content;
    }



}

/**
 * Fonction d'activation du plugin
 */
function native_blocks_carousel_activate(): void
{
    // Vérifier la version de WordPress
    if (version_compare(get_bloginfo('version'), '6.0', '<')) {
        wp_die(
            esc_html__('Ce plugin nécessite WordPress 6.0 ou plus récent.', 'native-blocks-carousel'),
            esc_html__('Version WordPress insuffisante', 'native-blocks-carousel')
        );
    }

    // Vérifier la version de PHP
    if (version_compare(PHP_VERSION, '7.4', '<')) {
        wp_die(
            esc_html__('Ce plugin nécessite PHP 7.4 ou plus récent.', 'native-blocks-carousel'),
            esc_html__('Version PHP insuffisante', 'native-blocks-carousel')
        );
    }
}

/**
 * Fonction de désactivation du plugin
 */
function native_blocks_carousel_deactivate(): void
{
    // Nettoyage si nécessaire
}

// Hooks d'activation et de désactivation
register_activation_hook(__FILE__, 'native_blocks_carousel_activate');
register_deactivation_hook(__FILE__, 'native_blocks_carousel_deactivate');

// Initialiser le plugin
NativeBlocksCarousel::getInstance();