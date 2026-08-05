<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

namespace Stripe;

/**
 * Class Collection
 *
 * @property string $object
 * @property string $url
 * @property bool $has_more
 * @property mixed $data
 *
 * @package Stripe
 */
class Collection extends StripeObject implements \IteratorAggregate
{
    use ApiOperations\Request;
    protected $_requestParams = [];
    const OBJECT_NAME = "list";
    public static function baseUrl()
    {
        return Stripe::$apiBase;
    }
    public function setRequestParams($params)
    {
        $this->_requestParams = $params;
    }
    public function all($params = NULL, $opts = NULL)
    {
        list($url, $params) = $this->extractPathAndUpdateParams($params);
        list($response, $opts) = $this->_request("get", $url, $params, $opts);
        $this->_requestParams = $params;
        return Util\Util::convertToStripeObject($response, $opts);
    }
    public function create($params = NULL, $opts = NULL)
    {
        list($url, $params) = $this->extractPathAndUpdateParams($params);
        list($response, $opts) = $this->_request("post", $url, $params, $opts);
        $this->_requestParams = $params;
        return Util\Util::convertToStripeObject($response, $opts);
    }
    public function retrieve($id, $params = NULL, $opts = NULL)
    {
        list($url, $params) = $this->extractPathAndUpdateParams($params);
        $id = Util\Util::utf8($id);
        $extn = urlencode($id);
        list($response, $opts) = $this->_request("get", $url . "/" . $extn, $params, $opts);
        $this->_requestParams = $params;
        return Util\Util::convertToStripeObject($response, $opts);
    }
    public function getIterator()
    {
        return new \ArrayIterator($this->data);
    }
    public function autoPagingIterator()
    {
        return new Util\AutoPagingIterator($this, $this->_requestParams);
    }
    private function extractPathAndUpdateParams($params)
    {
        $url = parse_url($this->url);
        if (!isset($url["path"])) {
            throw new Error\Api("Could not parse list url into parts: " . $url);
        }
        if (isset($url["query"])) {
            $query = [];
            parse_str($url["query"], $query);
            $params = array_merge($params ?: [], $query);
        }
        return [$url["path"], $params];
    }
}

?>