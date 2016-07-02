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

use \Twig_Environment;
use arabcoders\pagination\
{
    Interfaces\Renderer
};

/**
 * Renderer: Twig
 *
 * @author Abdul.Mohsen B. A. A. <admin@arabcoders.org>
 */
class Twig implements Renderer
{
    /**
     * @var Twig_Environment
     */
    private $twig;

    /**
     * @var string
     */
    private $template;

    /**
     * Class Constructor
     *
     * @param Twig_Environment $twig     instance of twig
     * @param string           $template template name
     * @param array            $options  extra options
     */
    public function __construct( Twig_Environment $twig, $template, array $options = [ ] )
    {
        $this->twig = $twig;

        $this->template = $template;
    }

    /**
     * @param array $array
     * @param array $options
     *
     * @return string
     */
    public function render( array $array, array $options = [ ] ): string
    {
        return $this->twig->render( $this->template, [ 'paginator' => $array ] );
    }
}