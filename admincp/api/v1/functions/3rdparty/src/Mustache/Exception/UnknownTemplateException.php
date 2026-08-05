<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

/**
 * Unknown template exception.
 */
class Mustache_Exception_UnknownTemplateException extends InvalidArgumentException implements Mustache_Exception
{
    protected $templateName = NULL;
    public function __construct($templateName, Exception $previous = NULL)
    {
        $this->templateName = $templateName;
        $message = sprintf("Unknown template: %s", $templateName);
        if (version_compare(PHP_VERSION, "5.3.0", ">=")) {
            parent::__construct($message, 0, $previous);
        } else {
            parent::__construct($message);
        }
    }
    public function getTemplateName()
    {
        return $this->templateName;
    }
}

?>