<?php
/**
 * Generic contract for Native Blocks Carousel services.
 *
 * @package NativeBlocksCarousel
 */

declare(strict_types=1);

namespace Weblazer\NativeBlocksCarousel\Contracts;

interface ServiceInterface
{
    /**
     * Enregistre les hooks du service.
     *
     * @return void
     */
    public function register(): void;
}