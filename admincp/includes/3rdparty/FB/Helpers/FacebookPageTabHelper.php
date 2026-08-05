<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

namespace Facebook\Helpers;

/**
 * Class FacebookPageTabHelper
 *
 * @package Facebook
 */
class FacebookPageTabHelper extends FacebookCanvasHelper
{
    /**
     * @var array|null
     */
    protected $pageData = NULL;
    public function __construct(\Facebook\FacebookApp $app, \Facebook\FacebookClient $client, $graphVersion = NULL)
    {
        parent::__construct($app, $client, $graphVersion);
        if (!$this->signedRequest) {
            return NULL;
        }
        $this->pageData = $this->signedRequest->get("page");
    }
    public function getPageData($key, $default = NULL)
    {
        if (isset($this->pageData[$key])) {
            return $this->pageData[$key];
        }
        return $default;
    }
    public function isAdmin()
    {
        return $this->getPageData("admin") === true;
    }
    public function getPageId()
    {
        return $this->getPageData("id");
    }
}

?>