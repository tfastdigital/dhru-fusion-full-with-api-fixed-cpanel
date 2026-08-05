<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

namespace Stripe\Util;

class AutoPagingIterator implements \Iterator
{
    private $lastId = NULL;
    private $page = NULL;
    private $pageOffset = 0;
    private $params = [];
    public function __construct($collection, $params)
    {
        $this->page = $collection;
        $this->params = $params;
    }
    public function rewind()
    {
    }
    public function current()
    {
        $item = current($this->page->data);
        $this->lastId = $item !== false ? $item["id"] : NULL;
        return $item;
    }
    public function key()
    {
        return key($this->page->data) + $this->pageOffset;
    }
    public function next()
    {
        $item = next($this->page->data);
        if ($item === false) {
            $this->pageOffset += count($this->page->data);
            if ($this->page["has_more"]) {
                $this->params = array_merge($this->params ?: [], ["starting_after" => $this->lastId]);
                $this->page = $this->page->all($this->params);
            } else {
                return false;
            }
        }
    }
    public function valid()
    {
        $key = key($this->page->data);
        $valid = $key !== NULL && $key !== false;
        return $valid;
    }
}

?>