<?php
/**
 * @author Anton Pribora <anton.pribora@gmail.com>
 * @copyright Copyright (c) 2018 Anton Pribora
 * @license https://anton-pribora.ru/license/MIT/
 */

namespace Data;

use ApCode\Web\Pagination;

class CoolPagination implements \JsonSerializable
{
    private $pagination;
    private $pages;

    public function __construct(Pagination $pagination)
    {
        $this->pagination = $pagination;
        $this->recalc();
    }

    private function addPage($text, $number = FALSE, $active = FALSE) {
        $this->pages[] = [
            'text'     => $text,
            'number'   => $number,
            'url'      => $number === false ? false : $this->pagination->pageUrl($number),
            'disabled' => $number === false,
            'active'   => $active,
        ];
    }

    public function pages()
    {
        return $this->pages;
    }

    public function recalc()
    {
        $this->pages = [];

        $pagination = $this->pagination;

        if ($pagination->totalPages() <= 0) {
            return true;
        }

        // First button
        if ($pagination->page() > 0) {
            $this->addPage('«', $pagination->page() - 1);
        } else {
            $this->addPage('«');
        }

        $leftOffsetStart  = 1;
        $leftOffsetEnd    = $pagination->page() - 5;
        $rightOffsetStart = $pagination->page() + 5;
        $rightOffsetEnd   = $pagination->totalPages() - 1;

        if ( $leftOffsetEnd - $leftOffsetStart <= 2 ) {
            $leftOffsetEnd = $leftOffsetStart;
        }

        if ( $rightOffsetEnd - $rightOffsetStart <= 2 ) {
            $rightOffsetEnd = $rightOffsetStart;
        }

        $showedLeftDots  = false;
        $showedRightDots = false;

        for($page = 0; $page < $pagination->totalPages(); ++$page) {
            if ( $page >= $leftOffsetStart && $page < $leftOffsetEnd ) {
                if ( !$showedLeftDots ) {
                    $showedLeftDots = true;
                    $this->addPage('...');
                }

                continue;
            }

            if ( $page > $rightOffsetStart && $page < $rightOffsetEnd ) {
                if ( !$showedRightDots ) {
                    $showedRightDots = true;
                    $this->addPage('...');
                }

                continue;
            }

            $this->addPage($page + 1, $page, $page == $pagination->page());
        }

        // Last button
        if ( $pagination->page() == $pagination->totalPages() - 1 ) {
            $this->addPage('»');
        }
        else {
            $this->addPage('»', $pagination->page() + 1);
        }

        return $this;
    }

    /**
     * {@inheritDoc}
     * @see JsonSerializable::jsonSerialize()
     */
    public function jsonSerialize(): array
    {
        $result = $this->pagination->jsonSerialize();
        $result['pages'] = $this->pages;

        return $result;
    }
}
