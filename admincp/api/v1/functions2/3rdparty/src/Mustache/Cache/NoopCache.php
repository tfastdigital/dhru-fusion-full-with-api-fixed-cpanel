<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

/**
 * Mustache Cache in-memory implementation.
 *
 * The in-memory cache is used for uncached lambda section templates. It's also useful during development, but is not
 * recommended for production use.
 */
class Mustache_Cache_NoopCache extends Mustache_Cache_AbstractCache
{
    public function load($key)
    {
        return false;
    }
    public function cache($key, $value)
    {
        $this->log(Mustache_Logger::WARNING, "Template cache disabled, evaluating \"{className}\" class at runtime", ["className" => $key]);
        eval("?>" . $value);
    }
}

?>