<?php
/**
 * Autoloader basique pour les classes du plugin Native Blocks Carousel.
 *
 * @package NativeBlocksCarousel
 */

declare(strict_types=1);

namespace Weblazer\NativeBlocksCarousel;

/**
 * Autoloader PSR-4 minimaliste pour le namespace du plugin.
 */
class Autoloader
{
    /**
     * Répertoire de base où se trouvent les classes.
     *
     * @var string
     */
    private string $baseDir;

    /**
     * Constructeur privé.
     *
     * @param string $baseDir Répertoire de base.
     */
    private function __construct(string $baseDir)
    {
        $this->baseDir = rtrim($baseDir, '/\\') . '/';
    }

    /**
     * Enregistre l'autoloader et retourne l'instance créée.
     *
     * @param string $baseDir Répertoire de base pour les classes.
     *
     * @return self
     */
    public static function register(string $baseDir): self
    {
        $autoloader = new self($baseDir);
        spl_autoload_register([$autoloader, 'autoload'], true, true);

        return $autoloader;
    }

    /**
     * Charge le fichier correspondant à la classe demandée si elle appartient au namespace du plugin.
     *
     * @param string $class Nom complet de la classe.
     *
     * @return void
     */
    private function autoload(string $class): void
    {
        if (strpos($class, __NAMESPACE__ . '\\') !== 0) {
            return;
        }

        $relativeClass = substr($class, strlen(__NAMESPACE__) + 1);
        $relativePath = str_replace('\\', '/', $relativeClass) . '.php';
        $file = $this->baseDir . $relativePath;

        if (is_readable($file)) {
            require_once $file;
        }
    }
}