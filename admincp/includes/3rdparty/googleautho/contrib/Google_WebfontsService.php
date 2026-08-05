<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

/**
 * The "webfonts" collection of methods.
 * Typical usage is:
 *  <code>
 *   $webfontsService = new Google_WebfontsService(...);
 *   $webfonts = $webfontsService->webfonts;
 *  </code>
 */
class Google_WebfontsServiceResource extends Google_ServiceResource
{
    public function listWebfonts($optParams = [])
    {
        $params = [];
        $params = array_merge($params, $optParams);
        $data = $this->__call("list", [$params]);
        if ($this->useObjects()) {
            return new Google_WebfontList($data);
        }
        return $data;
    }
}
/**
 * Service definition for Google_Webfonts (v1).
 *
 * <p>
 * The Google Web Fonts Developer API.
 * </p>
 *
 * <p>
 * For more information about this service, see the
 * <a href="http://code.google.com/apis/webfonts/docs/developer_api.html" target="_blank">API Documentation</a>
 * </p>
 *
 * @author Google, Inc.
 */
class Google_WebfontsService extends Google_Service
{
    public $webfonts = NULL;
    public function __construct(Google_Client $client)
    {
        $this->servicePath = "webfonts/v1/";
        $this->version = "v1";
        $this->serviceName = "webfonts";
        $client->addService($this->serviceName, $this->version);
        $this->webfonts = new Google_WebfontsServiceResource($this, $this->serviceName, "webfonts", json_decode("{\"methods\": {\"list\": {\"httpMethod\": \"GET\", \"response\": {\"\$ref\": \"WebfontList\"}, \"id\": \"webfonts.webfonts.list\", \"parameters\": {\"sort\": {\"enum\": [\"alpha\", \"date\", \"popularity\", \"style\", \"trending\"], \"type\": \"string\", \"location\": \"query\"}}, \"path\": \"webfonts\"}}}", true));
    }
}
class Google_Webfont extends Google_Model
{
    public $kind = NULL;
    public $variants = NULL;
    public $subsets = NULL;
    public $family = NULL;
    public function setKind($kind)
    {
        $this->kind = $kind;
    }
    public function getKind()
    {
        return $this->kind;
    }
    public function setVariants($variants)
    {
        $this->variants = $variants;
    }
    public function getVariants()
    {
        return $this->variants;
    }
    public function setSubsets($subsets)
    {
        $this->subsets = $subsets;
    }
    public function getSubsets()
    {
        return $this->subsets;
    }
    public function setFamily($family)
    {
        $this->family = $family;
    }
    public function getFamily()
    {
        return $this->family;
    }
}
class Google_WebfontList extends Google_Model
{
    protected $__itemsType = "Google_Webfont";
    protected $__itemsDataType = "array";
    public $items = NULL;
    public $kind = NULL;
    public function setItems($items)
    {
        $this->assertIsArray($items, "Google_Webfont", "Google_WebfontList::setItems");
        $this->items = $items;
    }
    public function getItems()
    {
        return $this->items;
    }
    public function setKind($kind)
    {
        $this->kind = $kind;
    }
    public function getKind()
    {
        return $this->kind;
    }
}

?>