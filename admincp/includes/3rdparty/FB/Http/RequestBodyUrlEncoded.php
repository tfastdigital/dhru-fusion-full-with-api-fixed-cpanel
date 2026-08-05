<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

namespace Facebook\Http;

/**
 * Class RequestBodyUrlEncoded
 *
 * @package Facebook
 */
class RequestBodyUrlEncoded implements RequestBodyInterface
{
    /**
     * @var array The parameters to send with this request.
     */
    protected $params = [];
    public function __construct($params)
    {
        $this->params = $params;
    }
    public function getBody()
    {
        return http_build_query($this->params, NULL, "&");
    }
}

?>