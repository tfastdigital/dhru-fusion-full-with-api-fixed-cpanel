<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

/**
 * Abstract Mustache Cache class.
 *
 * Provides logging support to child implementations.
 *
 * @abstract
 */
abstract class Mustache_Cache_AbstractCache implements Mustache_Cache
{
    private $logger = NULL;
    public function getLogger()
    {
        return $this->logger;
    }
    public function setLogger($logger = NULL)
    {
        if ($logger !== NULL && !($logger instanceof Mustache_Logger || is_a($logger, "Psr\\Log\\LoggerInterface"))) {
            throw new Mustache_Exception_InvalidArgumentException("Expected an instance of Mustache_Logger or Psr\\Log\\LoggerInterface.");
        }
        $this->logger = $logger;
    }
    protected function log($level, $message, $context = [])
    {
        if (isset($this->logger)) {
            $this->logger->log($level, $message, $context);
        }
    }
}

?>