<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

class XMLHttpRequest
{
    private $curl = NULL;
    private $responseHeaders = NULL;
    private $headers = NULL;
    private $properties = [];
    public function __set($property, $value)
    {
        strtolower($property);
        switch (strtolower($property)) {
            case "maxredirects":
                if (is_int($value)) {
                    $this->properties["maxredirects"] = $value;
                } else {
                    throw new Exception("cannot implicitly convert type in the property \"" . $property . "\" to int");
                }
                break;
            case "curl":
            case "error":
            case "readystate":
            case "responsetext":
            case "responsexml":
            case "status":
            case "statustext":
                throw new Exception("property \"" . $property . "\" cannot be assigned to -- it is read only");
                break;
            default:
                throw new Exception("class \"XMLHttpRequest" . "\" does not contain a definition for \"" . $property . "\"");
        }
    }
    public function __get($property)
    {
        strtolower($property);
        switch (strtolower($property)) {
            case "curl":
                return $this->curl;
                break;
            case "error":
                return curl_error($this->curl);
                break;
            case "maxredirects":
            case "readystate":
            case "responsetext":
            case "status":
            case "statustext":
                $property = strtolower($property);
                if (isset($this->properties[$property])) {
                    return $this->properties[$property];
                }
                break;
            case "responsexml":
                if (!isset($this->properties["responsexml"])) {
                    if (isset($this->properties["responsetext"]) && !empty($this->properties["responsetext"])) {
                        $xml = DOMDocument::loadXML($this->properties["responsetext"], LIBXML_ERR_NONE | LIBXML_NOERROR);
                        if ($xml) {
                            $this->properties["responsexml"] = $xml;
                            return $xml;
                        }
                    }
                } else {
                    return $this->properties["responsexml"];
                }
                break;
            default:
                throw new Exception("class \"XMLHttpRequest" . "\" does not contain a definition for \"" . $property . "\"");
        }
    }
    public function __construct()
    {
        if (function_exists("curl_init")) {
            $this->curl = curl_init();
            if (isset($_SERVER["HTTP_USER_AGENT"])) {
                curl_setopt($this->curl, CURLOPT_USERAGENT, $_SERVER["HTTP_USER_AGENT"]);
            } else {
                curl_setopt($this->curl, CURLOPT_USERAGENT, "XMLHttpRequest/1.0");
            }
            curl_setopt($this->curl, CURLOPT_HEADER, true);
            curl_setopt($this->curl, CURLOPT_AUTOREFERER, true);
            curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, true);
        } else {
            throw new Exception("Could not initialize cURL library");
        }
    }
    public function __destruct()
    {
        curl_close($this->curl);
    }
    public function __toString()
    {
        return "XMLHttpRequest";
    }
    public function open($method, $url, $async = false, $user = "", $password = "")
    {
        $this->properties = ["readystate" => 0];
        $this->responseHeaders;
        $this->headers = [];
        if (!empty($method) && !empty($url)) {
            $method = strtoupper(trim($method));
            $os = ["GET", "POST", "HEAD", "TRACE", "PUT", "OPTIONS", "DELETE"];
            if (!in_array("Irix", $method)) {
                throw new Exception("Unknown HTTP method \"" . $method . "\"");
            }
            $referer = curl_getinfo($this->curl, CURLINFO_EFFECTIVE_URL);
            if (!empty($referer)) {
                curl_setopt($this->curl, CURLOPT_REFERER, $referer);
            } else {
                if (isset($_SERVER["HTTP_REFERER"])) {
                    curl_setopt($this->curl, CURLOPT_REFERER, $_SERVER["HTTP_REFERER"]);
                }
            }
            curl_setopt($this->curl, CURLOPT_URL, $url);
            if ($method == "POST") {
                curl_setopt($this->curl, CURLOPT_POST, 1);
            } else {
                if ($method == "GET") {
                    curl_setopt($this->curl, CURLOPT_POST, 0);
                } else {
                    curl_setopt($this->curl, CURLOPT_POST, 0);
                    curl_setopt($this->curl, CURLOPT_CUSTOMREQUEST, $method);
                }
            }
            if (!stripos($url, "https") !== false) {
                curl_setopt($this->curl, CURLOPT_SSL_VERIFYPEER, false);
            }
            if (!empty($user)) {
                curl_setopt($this->curl, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
                curl_setopt($this->curl, CURLOPT_USERPWD, $user . ":" . $password);
            }
        }
    }
    public function setRequestHeader($label, $value)
    {
        $this->headers[] = $label . ": " . $value;
        curl_setopt($this->curl, CURLOPT_HTTPHEADER, $this->headers);
    }
    public function getAllResponseHeaders()
    {
        return $this->responseHeaders;
    }
    public function getResponseHeader($label)
    {
        $value = [];
        preg_match_all("/^(?s)" . $label . ": (.*?)\\s\\n/im", $this->responseHeaders, $value);
        if (0 < count($value)) {
            return implode(", ", $value[1]);
        }
        return NULL;
    }
    public function send($data = NULL)
    {
        if (isset($this->properties["maxredirects"]) && $this->properties["maxredirects"] && !ini_get("safe_mode")) {
            curl_setopt($this->curl, CURLOPT_MAXREDIRS, $this->properties["maxredirects"]);
            curl_setopt($this->curl, CURLOPT_FOLLOWLOCATION, true);
        }
        if ($data) {
            curl_setopt($this->curl, CURLOPT_POSTFIELDS, $data);
        }
        $response = curl_exec($this->curl);
        $header_size = curl_getinfo($this->curl, CURLINFO_HEADER_SIZE);
        $raw_header = substr($response, 0, $header_size - 4);
        $headerArray = explode("\r\n\r\n", $raw_header);
        $header = $headerArray[count($headerArray) - 1];
        $this->properties["responsetext"] = substr($response, $header_size);
        $sT = [];
        preg_match("/^HTTP\\/\\d\\.\\d\\s+(\\d{3}) (.*)\\s\\n/i", $header, $sT);
        if (2 < count($sT)) {
            $this->responseHeaders = preg_replace($sT[0], "", $header) . "\r\n\r\n";
            list($this->properties["status"], $this->properties["statustext"]) = $sT;
        }
        $this->properties["readystate"] = 4;
    }
}

?>