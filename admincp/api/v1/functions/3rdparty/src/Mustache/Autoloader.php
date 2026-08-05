<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

/**
 * Mustache class autoloader.
 */
class Mustache_Autoloader
{
    private $baseDir = NULL;
    /**
     * An array where the key is the baseDir and the key is an instance of this
     * class.
     *
     * @var array
     */
    private static $instances = NULL;
    public function __construct($baseDir = NULL)
    {
        if ($baseDir === NULL) {
            $baseDir = dirname(__FILE__) . "/..";
        }
        $realDir = realpath($baseDir);
        if (is_dir($realDir)) {
            $this->baseDir = $realDir;
        } else {
            $this->baseDir = $baseDir;
        }
    }
    public static function register($baseDir = NULL)
    {
        $key = $baseDir ? $baseDir : 0;
        if (!isset(self::$instances[$key])) {
            self::$instances[$key] = new self($baseDir);
        }
        $loader = self::$instances[$key];
        spl_autoload_register([$loader, "autoload"]);
        return $loader;
    }
    public function autoload($class)
    {
        if ($class[0] === "\\") {
            $class = substr($class, 1);
        }
        if (strpos($class, "Mustache") !== 0) {
            return NULL;
        }
        $file = sprintf("%s/%s.php", $this->baseDir, str_replace("_", "/", $class));
        if (is_file($file)) {
            require $file;
        }
    }
}

?>