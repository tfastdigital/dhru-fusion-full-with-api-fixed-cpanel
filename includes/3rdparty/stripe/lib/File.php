<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

namespace Stripe;

/**
 * Class File
 *
 * @property string $id
 * @property string $object
 * @property int $created
 * @property string $filename
 * @property Collection $links
 * @property string $purpose
 * @property int $size
 * @property string $title
 * @property string $type
 * @property string $url
 *
 * @package Stripe
 */
class File extends ApiResource
{
    use ApiOperations\All;
    use ApiOperations\Create;
    use ApiOperations\Retrieve;
    const OBJECT_NAME = "file";
    const OBJECT_NAME_ALT = "file_upload";
    public static function classUrl()
    {
        return "/v1/files";
    }
    public static function create($params = NULL, $options = NULL)
    {
        $opts = Util\RequestOptions::parse($options);
        if (is_null($opts->apiBase)) {
            $opts->apiBase = Stripe::$apiUploadBase;
        }
        $flatParams = [];
        foreach (Util\Util::flattenParams($params) as $pair) {
            $flatParams[$pair[0]] = $pair[1];
        }
        return static::_create($flatParams, $opts);
    }
}

?>