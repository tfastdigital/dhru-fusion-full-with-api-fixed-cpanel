<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

namespace Dhru;

class Base
{
    public $DisplayOut = NULL;
    public $content_format = NULL;
    public $parameters = NULL;
    public $method = NULL;
    public $endpoint = NULL;
    public $querystring = NULL;
    public function __construct()
    {
        try {
            $this->processRequest();
            var_dump($this);
            exit;
        } catch (\ErrorOut $e) {
            $this->DisplayOut->status = "error";
            $this->DisplayOut->message = $e->getMessage();
            $this->DisplayOut->data = $e->getData();
            Out($this->DisplayOut);
        } catch (\SuccessOut $e) {
            $this->DisplayOut->status = "success";
            $this->DisplayOut->message = $e->getMessage();
            $this->DisplayOut->data = $e->getData();
            Out($this->DisplayOut);
        } catch (\PDOException $e) {
            $this->DisplayOut->status = "error";
            $this->DisplayOut->message = $e->getMessage();
            $this->DisplayOut->data = [];
            Out($this->DisplayOut);
        } catch (\Exception $e) {
            $this->DisplayOut->status = "error";
            $this->DisplayOut->message = $e->getMessage();
            Out($this->DisplayOut);
        }
    }
    private function processRequest()
    {
        $this->method = strtolower($_SERVER["REQUEST_METHOD"]);
        $parse_url = parse_url(filter_var($_SERVER["REQUEST_URI"], FILTER_SANITIZE_STRING));
        $path = explode("api/" . $_ENV["ENDPOINT_VERSION"] . "/", $parse_url["path"]);
        $path = explode("/", $path[1]);
        if (contains($_SERVER["SERVER_SOFTWARE"], "nginx")) {
            $endpoint = apache_request_headers()["X-Endpoint"];
            $this->endpoint = strtolower($endpoint);
        } else {
            $this->endpoint = strtolower($path[0]);
        }
        parse_str($parse_url["query"], $this->querystring);
        $this->validateEndPoint();
    }
    private function validateEndPoint()
    {
        if (is_dir(ROOTDIR . "/Endpoint/" . $this->endpoint) && isset($this->endpoint)) {
            if (file_exists(ROOTDIR . "/Endpoint/" . $this->endpoint . "/" . $this->method . ".php")) {
                $_endpountClass = "\\Dhru\\Endpoint\\" . $this->endpoint . "\\" . $this->method;
                $this->processParams();
                $endpoint = new $_endpountClass($this);
            } else {
                throw new \ErrorOut("Method does not exist . " . $this->endpoint);
            }
        } else {
            throw new \ErrorOut("Endpoint does not exist . " . $this->endpoint);
        }
    }
    public function processParams()
    {
        $parameters = [];
        if (isset($_SERVER["QUERY_STRING"])) {
            parse_str($_SERVER["QUERY_STRING"], $parameters);
        }
        $body = file_get_contents("php://input");
        $content_type = false;
        if (isset($_SERVER["CONTENT_TYPE"])) {
            $content_type = $_SERVER["CONTENT_TYPE"];
        }
        if ($body != "") {
            switch ($content_type) {
                case "application/json":
                    $body_params = json_decode($body);
                    if (json_last_error() != JSON_ERROR_NONE) {
                        throw new \ErrorOut("invalid json body passed");
                    }
                    if ($body_params) {
                        foreach ($body_params as $param_name => $param_value) {
                            $parameters[$param_name] = $param_value;
                        }
                    }
                    $this->content_format = "json";
                    break;
                case "application/x-www-form-urlencoded":
                    parse_str($body, $postvars);
                    foreach ($postvars as $field => $value) {
                        $parameters[$field] = $value;
                    }
                    $this->content_format = "html";
                    $this->parameters = $parameters;
                    break;
                default:
                    throw new \ErrorOut("Supported content types are application/json,application/x-www-form-urlencoded");
            }
        }
    }
    public function isJson($string)
    {
        json_decode($string);
        return json_last_error() == JSON_ERROR_NONE;
    }
}

?>