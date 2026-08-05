<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

namespace Facebook\Http;

/**
 * Class RequestBodyMultipartt
 *
 * Some things copied from Guzzle
 *
 * @package Facebook
 *
 * @see https://github.com/guzzle/guzzle/blob/master/src/Post/MultipartBody.php
 */
class RequestBodyMultipart implements RequestBodyInterface
{
    /**
     * @var string The boundary.
     */
    private $boundary = NULL;
    /**
     * @var array The parameters to send with this request.
     */
    private $params = NULL;
    /**
     * @var array The files to send with this request.
     */
    private $files = [];
    public function __construct($params = [], $files = [], $boundary = NULL)
    {
        $this->params = $params;
        $this->files = $files;
        $this->boundary = $boundary ?: uniqid();
    }
    public function getBody()
    {
        $body = "";
        $params = $this->getNestedParams($this->params);
        foreach ($params as $k => $v) {
            $body .= $this->getParamString($k, $v);
        }
        foreach ($this->files as $k => $v) {
            $body .= $this->getFileString($k, $v);
        }
        $body .= "--" . $this->boundary . "--\r\n";
        return $body;
    }
    public function getBoundary()
    {
        return $this->boundary;
    }
    private function getFileString($name, \Facebook\FileUpload\FacebookFile $file)
    {
        return sprintf("--%s\r\nContent-Disposition: form-data; name=\"%s\"; filename=\"%s\"%s\r\n\r\n%s\r\n", $this->boundary, $name, $file->getFileName(), $this->getFileHeaders($file), $file->getContents());
    }
    private function getParamString($name, $value)
    {
        return sprintf("--%s\r\nContent-Disposition: form-data; name=\"%s\"\r\n\r\n%s\r\n", $this->boundary, $name, $value);
    }
    private function getNestedParams($params)
    {
        $query = http_build_query($params, NULL, "&");
        $params = explode("&", $query);
        $result = [];
        foreach ($params as $param) {
            list($key, $value) = explode("=", $param, 2);
            $result[urldecode($key)] = urldecode($value);
        }
        return $result;
    }
    protected function getFileHeaders(\Facebook\FileUpload\FacebookFile $file)
    {
        return "\r\nContent-Type: " . $file->getMimetype();
    }
}

?>