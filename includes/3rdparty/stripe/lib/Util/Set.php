<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

namespace Stripe\Util;

class Set implements \IteratorAggregate
{
    private $_elts = NULL;
    public function __construct($members = [])
    {
        $this->_elts = [];
        foreach ($members as $item) {
            $this->_elts[$item] = true;
        }
    }
    public function includes($elt)
    {
        return isset($this->_elts[$elt]);
    }
    public function add($elt)
    {
        $this->_elts[$elt] = true;
    }
    public function discard($elt)
    {
        unset($this->_elts[$elt]);
    }
    public function toArray()
    {
        return array_keys($this->_elts);
    }
    public function getIterator()
    {
        return new \ArrayIterator($this->toArray());
    }
}

?>