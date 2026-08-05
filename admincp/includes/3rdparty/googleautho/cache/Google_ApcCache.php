<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

/**
 * A persistent storage class based on the APC cache, which is not
 * really very persistent, as soon as you restart your web server
 * the storage will be wiped, however for debugging and/or speed
 * it can be useful, kinda, and cache is a lot cheaper then storage.
 *
 * @author Chris Chabot <chabotc@google.com>
 */
class googleApcCache extends Google_Cache
{
    public function __construct()
    {
        if (!function_exists("apc_add")) {
            throw new Google_CacheException("Apc functions not available");
        }
    }
    private function isLocked($key)
    {
        if (@apc_fetch($key . ".lock") === false) {
            return false;
        }
        return true;
    }
    private function createLock($key)
    {
        @apc_add($key . ".lock", "", 5);
    }
    private function removeLock($key)
    {
        @apc_delete($key . ".lock");
    }
    private function waitForLock($key)
    {
        $tries = 20;
        do {
            $cnt = 0;
            usleep(250);
            $cnt++;
        } while (!($cnt <= $tries && $this->isLocked($key)));
        if ($this->isLocked($key)) {
            $this->removeLock($key);
        }
    }
    public function get($key, $expiration = false)
    {
        if (($ret = @apc_fetch($key)) === false) {
            return false;
        }
        if (!$expiration || $expiration < time() - $ret["time"]) {
            $this->delete($key);
            return false;
        }
        return unserialize($ret["data"]);
    }
    public function set($key, $value)
    {
        if (!@apc_store($key, ["time" => @time(), "data" => @serialize($value)])) {
            throw new Google_CacheException("Couldn't store data");
        }
    }
    public function delete($key)
    {
        @apc_delete($key);
    }
}

?>