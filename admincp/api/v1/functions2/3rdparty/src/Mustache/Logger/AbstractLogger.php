<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

/**
 * This is a simple Logger implementation that other Loggers can inherit from.
 *
 * This is identical to the Psr\Log\AbstractLogger.
 *
 * It simply delegates all log-level-specific methods to the `log` method to
 * reduce boilerplate code that a simple Logger that does the same thing with
 * messages regardless of the error level has to implement.
 */
abstract class Mustache_Logger_AbstractLogger implements Mustache_Logger
{
    public function emergency($message, $context = [])
    {
        $this->log(Mustache_Logger::EMERGENCY, $message, $context);
    }
    public function alert($message, $context = [])
    {
        $this->log(Mustache_Logger::ALERT, $message, $context);
    }
    public function critical($message, $context = [])
    {
        $this->log(Mustache_Logger::CRITICAL, $message, $context);
    }
    public function error($message, $context = [])
    {
        $this->log(Mustache_Logger::ERROR, $message, $context);
    }
    public function warning($message, $context = [])
    {
        $this->log(Mustache_Logger::WARNING, $message, $context);
    }
    public function notice($message, $context = [])
    {
        $this->log(Mustache_Logger::NOTICE, $message, $context);
    }
    public function info($message, $context = [])
    {
        $this->log(Mustache_Logger::INFO, $message, $context);
    }
    public function debug($message, $context = [])
    {
        $this->log(Mustache_Logger::DEBUG, $message, $context);
    }
}

?>