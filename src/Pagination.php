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

namespace arabcoders\pagination;

use \ArrayIterator;
use arabcoders\pagination\
{
    Interfaces\Renderer as RendererInterface,
    Interfaces\Pagination as PaginationInterface
};

/**
 * Pagination.
 *
 * @author Abdul.Mohsen B. A. A. <admin@arabcoders.org>
 */
class Pagination implements PaginationInterface
{
    /**
     * @var int current page number.
     */
    protected $page = 1;

    /**
     * @var int total items.
     */
    protected $items = 0;

    /**
     * @var int items perpage.
     */
    protected $perpage = 10;

    /**
     * @var int total pages.
     */
    protected $pages = 0;

    /**
     * @var string paging url
     */
    protected $url = '';

    /**
     * @var bool
     */
    protected $showControls = true;

    /**
     * @var RendererInterface
     */
    protected $renderer;

    /**
     * @var array class used phrases.
     */
    protected $lang = [
        'PAGE_FIRST' => '<<',
        'PAGE_PREV'  => '<',

        'PAGE_LAST' => '>>',
        'PAGE_NEXT' => '>',

        'PAGE_IN'  => '%d / %d',
        'TPAGE_IN' => '%d : %d',
    ];

    public function __construct( RendererInterface $renderer, array $options = [ ] )
    {
        $this->setRenderer( $renderer );

        if ( !empty( $options['translate'] ) && is_callable( $options['translate'] ) )
        {
            $translator = &$options['translate'];

            foreach ( $this->lang as $key => $value )
            {
                $this->lang[$key] = $translator( $key, $value );
            }
        }
    }

    public function setUrl( string $url ): PaginationInterface
    {
        $this->url = $url;

        return $this;
    }

    public function getTitle( string $prefix = '' ): string
    {
        return ( $this->pages <= 1 ) ? '' : ( $prefix . sprintf( $this->lang['TPAGE_IN'], $this->page, $this->pages ) );
    }

    public function setItems( int $items, int $page = 1, int $perpage = 10 ): PaginationInterface
    {
        $this->items   = $items;
        $this->perpage = $perpage;
        $this->page    = ( !$page ) ? 1 : $page;
        $this->pages   = @ceil( $this->items / $this->perpage );

        return $this;
    }

    public function setPage( int $page = 1 ): PaginationInterface
    {
        $this->page = $page;

        return $this;
    }

    public function getPage(): int
    {
        return $this->page;
    }

    public function getStart(): int
    {
        return $this->perpage * ( $this->page - 1 );
    }

    public function getEnd(): int
    {
        return ( ( $this->perpage - 1 ) * $this->page ) + ( $this->page - 1 );
    }

    public function count(): int
    {
        return $this->pages;
    }

    public function getPerpage(): int
    {
        return $this->perpage;
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    public function showControl(): PaginationInterface
    {
        $this->showControls = true;

        return $this;
    }

    public function hideControl(): PaginationInterface
    {
        $this->showControls = false;

        return $this;
    }

    public function getPageUrl( int $pageNumber = null ): string
    {
        $pageNumber = ( is_null( $pageNumber ) ) ? $this->page : $pageNumber;

        if ( $pageNumber > 0 && $pageNumber <= $this->pages )
        {
            return sprintf( $this->url, $pageNumber );
        }

        return '';
    }

    public function getNextPageUrl(): string
    {
        return $this->getPageUrl( $this->page + 1 );
    }

    public function getPrevPageUrl(): string
    {
        return $this->getPageUrl( $this->page - 1 );
    }

    public function getIterator(): ArrayIterator
    {
        return new \ArrayIterator( $this->toArray() );
    }

    public function toArray(): array
    {
        if ( !$this->pages )
        {
            return [ ];
        }

        $navigation = [
            'baseUrl' => $this->url,
            'onPage'  => $this->getPage(),
            'perPage' => $this->getPerpage(),
        ];

        if ( $this->page > 1 && $this->showControls )
        {
            $navigation['control']['first'] = $this->buildPaginationModel( 1, $this->lang['PAGE_FIRST'], false, "first" );

            $prev = $this->page - 1;

            if ( $prev > 1 )
            {
                $navigation['control']['prev'] = $this->buildPaginationModel( $prev, $this->lang['PAGE_PREV'], false, "prev" );
            }
        }

        for ( $i = 1; $i <= $this->pages; $i++ )
        {
            $navigation['pages'][] = $this->buildPaginationModel( $i, $i, $i == $this->page );
        }

        $next = $this->page + 1;

        if ( $next < $this->pages && $this->showControls )
        {
            $navigation['control']['next'] = $this->buildPaginationModel( $next, $this->lang['PAGE_NEXT'], false, "next" );
        }

        if ( $this->page < $this->pages && $this->pages )
        {
            $navigation['control']['last'] = $this->buildPaginationModel( $this->pages, $this->lang['PAGE_LAST'], false, "last" );
        }

        $navigation['total'] = $this->pages;

        return $navigation;
    }

    public function setRenderer( RendererInterface $renderer ): PaginationInterface
    {
        $this->renderer = $renderer;

        return $this;
    }

    public function render( array $options = [ ] ): string
    {
        if ( $this->pages <= 1 )
        {
            return '';
        }

        $options['showControls'] = $this->showControls;

        $options['caller'] = &$this;

        $render = $this->renderer->render( $this->toArray(), $options );

        return ( empty( $render ) ) ? '' : $render;
    }

    public function __toString()
    {
        return $this->render();
    }

    /**
     * Build the pagination model
     *
     * @param   int    $pageNumber Page Number
     * @param   string $label      Label
     * @param   bool   $isCurrent  is Current page
     * @param   string $isLabel    is Label
     *
     * @return array
     */
    protected function buildPaginationModel( int $pageNumber, string $label, bool $isCurrent = false, string $isLabel = 'page' ): array
    {
        return [
            'page_number'   => $pageNumber,
            'label'         => $label,
            'is_current'    => $isCurrent,
            'url'           => $this->getPageUrl( $pageNumber ),
            "is_{$isLabel}" => true,
            // first, prev, next, last.
            'is_control'    => ( $isLabel != 'page' ) ? true : false,
        ];
    }
}