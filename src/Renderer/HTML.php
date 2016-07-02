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
 * Default HTML Renderer.
 *
 * @author Abdul.Mohsen B. A. A. <admin@arabcoders.org>
 */
class HTML implements Renderer
{
    /**
     * Render text.
     *
     * @param array $array
     * @param array $options
     *
     * @return string
     */
    public function render( array $array, array $options = [ ] ): string
    {
        $list      = '';
        $wrapTag   = ( empty( $options['wrapTag'] ) ) ? 'ul' : $options['wrapTag'];
        $listTag   = ( empty( $options['listTag'] ) ) ? 'li' : $options['listTag'];
        $className = ( empty( $options['className'] ) ) ? 'pagination' : $options['className'];

        foreach ( $array as $page )
        {
            $hrefClass = ( $page['is_current'] || $page['is_control'] || !isset( $options['showControls'] ) ) ? '' : ' class="hidden-xs" ';
            $href      = "<a {$hrefClass} href=\"{$page["url"]}\">{$page["label"]}</a>";
            $tagClass  = ( $page["is_current"] ) ? " class=\"active\" " : "";
            $list .= "<{$listTag}{$tagClass}>{$href}</{$listTag}>" . PHP_EOL;
        }

        return "<{$wrapTag} class=\"{$className}\">{$list}</{$wrapTag}>";
    }
}

