<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

/**
* caches instances of the wsdl class
* 
* @author   Scott Nichol <snichol@users.sourceforge.net>
* @author	Ingo Fischer <ingo@apollon.de>
* @version  $Id: class.wsdlcache.php,v 1.7 2007/04/17 16:34:03 snichol Exp $
* @access public 
*/
class nusoap_wsdlcache
{
    /**
     *	@var resource
     *	@access private
     */
    public $fplock = NULL;
    /**
     *	@var integer
     *	@access private
     */
    public $cache_lifetime = NULL;
    /**
     *	@var string
     *	@access private
     */
    public $cache_dir = NULL;
    /**
     *	@var string
     *	@access public
     */
    public $debug_str = "";
    public function nusoap_wsdlcache($cache_dir = ".", $cache_lifetime = 0)
    {
        $this->fplock = [];
        $this->cache_dir = $cache_dir != "" ? $cache_dir : ".";
        $this->cache_lifetime = $cache_lifetime;
    }
    public function createFilename($wsdl)
    {
        return $this->cache_dir . "/wsdlcache-" . md5($wsdl);
    }
    public function debug($string)
    {
        $this->debug_str .= get_class($this) . ": " . $string . "\n";
    }
    public function get($wsdl)
    {
        $filename = $this->createFilename($wsdl);
        if ($this->obtainMutex($filename, "r")) {
            if (0 < $this->cache_lifetime && file_exists($filename) && $this->cache_lifetime < time() - filemtime($filename)) {
                unlink($filename);
                $this->debug("Expired " . $wsdl . " (" . $filename . ") from cache");
                $this->releaseMutex($filename);
            } else {
                if (!file_exists($filename)) {
                    $this->debug($wsdl . " (" . $filename . ") not in cache (1)");
                    $this->releaseMutex($filename);
                } else {
                    $fp = fopen($filename, "r");
                    if ($fp) {
                        $s = implode("", file($filename));
                        fclose($fp);
                        $this->debug("Got " . $wsdl . " (" . $filename . ") from cache");
                    } else {
                        $s = NULL;
                        $this->debug($wsdl . " (" . $filename . ") not in cache (2)");
                    }
                    $this->releaseMutex($filename);
                    return !is_null($s) ? unserialize($s) : NULL;
                }
            }
        } else {
            $this->debug("Unable to obtain mutex for " . $filename . " in get");
        }
    }
    public function obtainMutex($filename, $mode)
    {
        if (isset($this->fplock[md5($filename)])) {
            $this->debug("Lock for " . $filename . " already exists");
            return false;
        }
        $this->fplock[md5($filename)] = fopen($filename . ".lock", "w");
        if ($mode == "r") {
            return flock($this->fplock[md5($filename)], LOCK_SH);
        }
        return flock($this->fplock[md5($filename)], LOCK_EX);
    }
    public function put($wsdl_instance)
    {
        $filename = $this->createFilename($wsdl_instance->wsdl);
        $s = serialize($wsdl_instance);
        if ($this->obtainMutex($filename, "w")) {
            $fp = fopen($filename, "w");
            if (!$fp) {
                $this->debug("Cannot write " . $wsdl_instance->wsdl . " (" . $filename . ") in cache");
                $this->releaseMutex($filename);
                return false;
            }
            fputs($fp, $s);
            fclose($fp);
            $this->debug("Put " . $wsdl_instance->wsdl . " (" . $filename . ") in cache");
            $this->releaseMutex($filename);
            return true;
        }
        $this->debug("Unable to obtain mutex for " . $filename . " in put");
        return false;
    }
    public function releaseMutex($filename)
    {
        $ret = flock($this->fplock[md5($filename)], LOCK_UN);
        fclose($this->fplock[md5($filename)]);
        unset($this->fplock[md5($filename)]);
        if (!$ret) {
            $this->debug("Not able to release lock for " . $filename);
        }
        return $ret;
    }
    public function remove($wsdl)
    {
        $filename = $this->createFilename($wsdl);
        if (!file_exists($filename)) {
            $this->debug($wsdl . " (" . $filename . ") not in cache to be removed");
            return false;
        }
        $this->obtainMutex($filename, "w");
        $ret = unlink($filename);
        $this->debug("Removed (" . $ret . ") " . $wsdl . " (" . $filename . ") from cache");
        $this->releaseMutex($filename);
        return $ret;
    }
}
/**
 * For backward compatibility
 */
class wsdlcache extends nusoap_wsdlcache
{
}

?>