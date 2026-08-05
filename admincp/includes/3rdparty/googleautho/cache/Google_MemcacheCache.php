<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

/**
 * A persistent storage class based on the memcache, which is not
 * really very persistent, as soon as you restart your memcache daemon
 * the storage will be wiped, however for debugging and/or speed
 * it can be useful, kinda, and cache is a lot cheaper then storage.
 *
 * @author Chris Chabot <chabotc@google.com>
 */
class Google_MemcacheCache extends Google_Cache
{
    private $connection = false;
    public function __construct()
    {
        global $apiConfig;
        if (!function_exists("memcache_connect")) {
            throw new Google_CacheException("Memcache functions not available");
        }
        $this->host = $apiConfig["ioMemCacheCache_host"];
        $this->port = $apiConfig["ioMemCacheCache_port"];
        if (empty($this->host) || empty($this->port)) {
            throw new Google_CacheException("You need to supply a valid memcache host and port");
        }
    }
    private function isLocked($key)
    {
        $this->check();
        if (@memcache_get($this->connection, $key . ".lock") === false) {
            return false;
        }
        return true;
    }
    private function createLock($key)
    {
        $this->check();
        @memcache_add($this->connection, $key . ".lock", "", 0, 5);
    }
    private function removeLock($key)
    {
        $this->check();
        @memcache_delete($this->connection, $key . ".lock");
    }
    private function waitForLock($key)
    {
        $this->check();
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
    private function connect()
    {
        if (!($this->connection = @memcache_pconnect($this->host, $this->port))) {
            throw new Google_CacheException("Couldn't connect to memcache server");
        }
    }
    private function check()
    {
        if (!$this->connection) {
            $this->connect();
        }
    }
    public function get($key, $expiration = false)
    {
        $this->check();
        if (($ret = @memcache_get($this->connection, $key)) === false) {
            return false;
        }
        if (!$expiration || $expiration < time() - $ret["time"]) {
            $this->delete($key);
            return false;
        }
        return $ret["data"];
    }
    public function set($key, $value)
    {
        $this->check();
        if (!@memcache_set($this->connection, $key, ["time" => @time(), "data" => $value], false)) {
            throw new Google_CacheException("Couldn't store data in cache");
        }
    }
    public function delete($key)
    {
        $this->check();
        @memcache_delete($this->connection, $key);
    }
}

?>