<?php
/**
 * This file is part of {@see \arabcoders\pagination} package.
 *
 * (c) 2014-2016 Abdul.Mohsen B. A. A.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with the source code, if said file is not present
 * assume it's proprietary license, unless otherwise stated.
 */

namespace arabcoders\pagination\Interfaces;

/**
 * Renderer Interface
 *
 * @author Abdul.Mohsen B. A. A. <admin@arabcoders.org>
 */
interface Renderer
{
    /**
     * Render the Paginator.
     *
     * @param array $array   Pages list.
     * @param array $options Options.
     *
     * @return string
     */
    Public function render( array $array, array $options = [ ] );
}