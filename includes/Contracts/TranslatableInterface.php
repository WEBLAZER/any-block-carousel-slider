<?php
/**
 * Contrat pour les services responsables du chargement des traductions.
 *
 * @package NativeBlocksCarousel
 */

declare(strict_types=1);

namespace Weblazer\NativeBlocksCarousel\Contracts;

interface TranslationServiceInterface extends ServiceInterface
{
    /**
     * Charge les fichiers de traduction du plugin.
     *
     * @return void
     */
    public function loadTranslations(): void;
}