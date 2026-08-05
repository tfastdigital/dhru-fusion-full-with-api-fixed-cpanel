<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

/**
 * Describes a Mustache logger instance.
 *
 * This is identical to the Psr\Log\LoggerInterface.
 *
 * The message MUST be a string or object implementing __toString().
 *
 * The message MAY contain placeholders in the form: {foo} where foo
 * will be replaced by the context data in key "foo".
 *
 * The context array can contain arbitrary data, the only assumption that
 * can be made by implementors is that if an Exception instance is given
 * to produce a stack trace, it MUST be in a key named "exception".
 *
 * See https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-3-logger-interface.md
 * for the full interface specification.
 */
interface Mustache_Logger
{
    const EMERGENCY = "emergency";
    const ALERT = "alert";
    const CRITICAL = "critical";
    const ERROR = "error";
    const WARNING = "warning";
    const NOTICE = "notice";
    const INFO = "info";
    const DEBUG = "debug";
    public function emergency($message, $context);
    public function alert($message, $context);
    public function critical($message, $context);
    public function error($message, $context);
    public function warning($message, $context);
    public function notice($message, $context);
    public function info($message, $context);
    public function debug($message, $context);
    public function log($level, $message, $context);
}

?>