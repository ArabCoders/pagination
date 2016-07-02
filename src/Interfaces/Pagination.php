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

use \ArrayIterator;

/**
 * Pagination Interface.
 *
 * @author Abdul.Mohsen B. A. A. <admin@arabcoders.org>
 */
Interface Pagination extends \IteratorAggregate
{

    /**
     * Class Constructor.
     * <code>
     * $f = new Pagination( null,[
     *      'translate' => function ( $key, $val ) use ( $lang )
     *      {
     *          return ( array_key_exists( $key, $lang ) ? $lang[$key] : $val;
     *      }
     * ]);
     *</code>
     *
     * @param Renderer $renderer total items in the set
     * @param array    $options  currcent scope
     */
    public function __construct( Renderer $renderer, array $options = [ ] );

    /**
     * Set Page Url
     *
     * @param string $url page Url.
     *
     * @return Pagination
     */
    public function setUrl( string $url ): Pagination;

    /**
     * Get Page Title.
     *
     * @param string $prefix
     *
     * @return string
     */
    public function getTitle( string $prefix = '' ): string;

    /**
     * Set The Paginator Paramters.
     *
     * @param int $items   total items in the set.
     * @param int $page    currcent scope.
     * @param int $perpage total items per page.
     *
     * @return Pagination
     */
    public function setItems( int $items, int $page = 1, int $perpage = 10 ): Pagination;

    /**
     * Set the current page
     *
     * @param int $page
     *
     * @return Pagination
     */
    public function setPage( int $page = 1 ): Pagination;

    /**
     * Return the current page number
     *
     * @return int
     */
    public function getPage(): int;

    /**
     * To get the start count of the items. Starts at 0
     *
     * @return int
     */
    public function getStart(): int;

    /**
     * To get the end count of the items. Ends at -1
     *
     * @return int
     */
    public function getEnd(): int;

    /**
     * Return the total pages
     *
     * @return int
     */
    public function count(): int;

    /**
     * Return the items per page
     *
     * @return int
     */
    public function getPerpage(): int;

    /**
     * Get url.
     *
     * @return string
     */
    public function getUrl(): string;

    /**
     * Show Paging Control
     *
     * @return Pagination
     */
    public function showControl(): Pagination;

    /**
     * Hide Paging Control
     *
     * @return Pagination
     */
    public function hideControl(): Pagination;

    /**
     * Return the current page url or the url for a page number
     *
     * @param int $pageNumber
     *
     * @return string
     */
    public function getPageUrl( int $pageNumber = null ): string;

    /**
     * Return the next page url
     *
     * @return string
     */
    public function getNextPageUrl(): string;

    /**
     * Get the prev page url
     *
     * @return string
     */
    public function getPrevPageUrl(): string;

    /**
     * This method allow the iteration inside of foreach()
     *
     * @return ArrayIterator
     */
    public function getIterator(): ArrayIterator;

    /**
     * toArray() export the pagination into an array.
     *
     * @return array
     */
    public function toArray(): array;

    /**
     * Set Renderer
     *
     * @param Renderer $renderer
     *
     * @return Pagination
     */
    public function setRenderer( Renderer $renderer ): Pagination;

    /**
     * Render the paginator.
     *
     * @param array $options .
     *
     * @return string
     */
    public function render( array $options = [ ] ): string;
}