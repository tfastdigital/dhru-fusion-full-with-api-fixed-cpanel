<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

namespace Facebook\GraphNodes;

/**
 * Class Collection
 *
 * Modified version of Collection in "illuminate/support" by Taylor Otwell
 *
 * @package Facebook
 */
class Collection implements \ArrayAccess, \Countable, \IteratorAggregate
{
    /**
     * The items contained in the collection.
     *
     * @var array
     */
    protected $items = [];
    public function __construct($items = [])
    {
        $this->items = $items;
    }
    public function getField($name, $default = NULL)
    {
        if (isset($this->items[$name])) {
            return $this->items[$name];
        }
        return $default ?: NULL;
    }
    public function getProperty($name, $default = NULL)
    {
        return $this->getField($name, $default);
    }
    public function getFieldNames()
    {
        return array_keys($this->items);
    }
    public function getPropertyNames()
    {
        return $this->getFieldNames();
    }
    public function all()
    {
        return $this->items;
    }
    public function asArray()
    {
        return array_map(function ($value) {
            return $value instanceof Collection ? $value->asArray() : $value;
        }, $this->items);
    }
    public function map(\Closure $callback)
    {
        return new static(array_map($callback, $this->items, array_keys($this->items)));
    }
    public function asJson($options = 0)
    {
        return json_encode($this->asArray(), $options);
    }
    public function count()
    {
        return count($this->items);
    }
    public function getIterator()
    {
        return new \ArrayIterator($this->items);
    }
    public function offsetExists($key)
    {
        return array_key_exists($key, $this->items);
    }
    public function offsetGet($key)
    {
        return $this->items[$key];
    }
    public function offsetSet($key, $value)
    {
        if (is_null($key)) {
            $this->items[] = $value;
        } else {
            $this->items[$key] = $value;
        }
    }
    public function offsetUnset($key)
    {
        unset($this->items[$key]);
    }
    public function __toString()
    {
        return $this->asJson();
    }
}

?>