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

namespace arabcoders\pagination\Renderer;

use arabcoders\pagination\
{
    Interfaces\Renderer
};

/**
 * Renderer: Json.
 *
 * @author Abdul.Mohsen B. A. A. <admin@arabcoders.org>
 */
class Json implements Renderer
{
    /**
     * @param array $array
     * @param array $options
     *
     * @return string
     */
    public function render( array $array, array $options = [ ] ): string
    {
        return json_encode( $array );
    }
}