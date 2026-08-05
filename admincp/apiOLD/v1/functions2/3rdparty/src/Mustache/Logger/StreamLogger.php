<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

/**
 * A Mustache Stream Logger.
 *
 * The Stream Logger wraps a file resource instance (such as a stream) or a
 * stream URL. All log messages over the threshold level will be appended to
 * this stream.
 *
 * Hint: Try `php://stderr` for your stream URL.
 */
class Mustache_Logger_StreamLogger extends Mustache_Logger_AbstractLogger
{
    protected $level = NULL;
    protected $stream = NULL;
    protected $url = NULL;
    protected static $levels = NULL;
    public function __construct($stream, $level = Mustache_Logger::ERROR)
    {
        $this->setLevel($level);
        if (is_resource($stream)) {
            $this->stream = $stream;
        } else {
            $this->url = $stream;
        }
    }
    public function __destruct()
    {
        if (is_resource($this->stream)) {
            fclose($this->stream);
        }
    }
    public function setLevel($level)
    {
        if (!array_key_exists($level, self::$levels)) {
            throw new Mustache_Exception_InvalidArgumentException(sprintf("Unexpected logging level: %s", $level));
        }
        $this->level = $level;
    }
    public function getLevel()
    {
        return $this->level;
    }
    public function log($level, $message, $context = [])
    {
        if (!array_key_exists($level, self::$levels)) {
            throw new Mustache_Exception_InvalidArgumentException(sprintf("Unexpected logging level: %s", $level));
        }
        if (self::$levels[$this->level] <= self::$levels[$level]) {
            $this->writeLog($level, $message, $context);
        }
    }
    protected function writeLog($level, $message, $context = [])
    {
        if (!is_resource($this->stream)) {
            if (!isset($this->url)) {
                throw new Mustache_Exception_LogicException("Missing stream url, the stream can not be opened. This may be caused by a premature call to close().");
            }
            $this->stream = fopen($this->url, "a");
            if (!is_resource($this->stream)) {
                throw new Mustache_Exception_RuntimeException(sprintf("The stream or file \"%s\" could not be opened.", $this->url));
            }
        }
        fwrite($this->stream, self::formatLine($level, $message, $context));
    }
    protected static function getLevelName($level)
    {
        return strtoupper($level);
    }
    protected static function formatLine($level, $message, $context = [])
    {
        return sprintf("%s: %s\n", self::getLevelName($level), self::interpolateMessage($message, $context));
    }
    protected static function interpolateMessage($message, $context = [])
    {
        if (strpos($message, "{") === false) {
            return $message;
        }
        $replace = [];
        foreach ($context as $key => $val) {
            $replace["{" . $key . "}"] = $val;
        }
        return strtr($message, $replace);
    }
}

?>