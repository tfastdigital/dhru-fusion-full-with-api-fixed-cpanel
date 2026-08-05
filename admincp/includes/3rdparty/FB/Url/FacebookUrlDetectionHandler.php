<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

namespace Facebook\Url;

/**
 * Class FacebookUrlDetectionHandler
 *
 * @package Facebook
 */
class FacebookUrlDetectionHandler implements UrlDetectionInterface
{
    public function getCurrentUrl()
    {
        return $this->getHttpScheme() . "://" . $this->getHostName() . $this->getServerVar("REQUEST_URI");
    }
    protected function getHttpScheme()
    {
        return $this->isBehindSsl() ? "https" : "http";
    }
    protected function isBehindSsl()
    {
        $protocol = $this->getHeader("X_FORWARDED_PROTO");
        if ($protocol) {
            return $this->protocolWithActiveSsl($protocol);
        }
        $protocol = $this->getServerVar("HTTPS");
        if ($protocol) {
            return $this->protocolWithActiveSsl($protocol);
        }
        return (string) $this->getServerVar("SERVER_PORT") === "443";
    }
    protected function protocolWithActiveSsl($protocol)
    {
        $protocol = strtolower((string) $protocol);
        return in_array($protocol, ["on", "1", "https", "ssl"], true);
    }
    protected function getHostName()
    {
        if ($host = $this->getHeader("X_FORWARDED_HOST")) {
            $elements = explode(",", $host);
            $host = $elements[count($elements) - 1];
        } else {
            if (!($host = $this->getHeader("HOST")) && !($host = $this->getServerVar("SERVER_NAME"))) {
                $host = $this->getServerVar("SERVER_ADDR");
            }
        }
        $host = strtolower(preg_replace("/:\\d+\$/", "", trim($host)));
        $scheme = $this->getHttpScheme();
        $port = $this->getCurrentPort();
        $appendPort = ":" . $port;
        if ($scheme == "http" && $port == "80" || $scheme == "https" && $port == "443") {
            $appendPort = "";
        }
        return $host . $appendPort;
    }
    protected function getCurrentPort()
    {
        $port = $this->getHeader("X_FORWARDED_PORT");
        if ($port) {
            return (string) $port;
        }
        $protocol = (string) $this->getHeader("X_FORWARDED_PROTO");
        if ($protocol === "https") {
            return "443";
        }
        return (string) $this->getServerVar("SERVER_PORT");
    }
    protected function getServerVar($key)
    {
        return isset($_SERVER[$key]) ? $_SERVER[$key] : "";
    }
    protected function getHeader($key)
    {
        return $this->getServerVar("HTTP_" . $key);
    }
}

?>