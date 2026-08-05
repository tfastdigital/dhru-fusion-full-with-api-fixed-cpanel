<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

namespace Stripe\Sigma;

/**
 * Class Authorization
 *
 * @property string $id
 * @property string $object
 * @property int $created
 * @property int $data_load_time
 * @property string $error
 * @property \Stripe\FileUpload $file
 * @property bool $livemode
 * @property int $result_available_until
 * @property string $sql
 * @property string $status
 * @property string $title
 *
 * @package Stripe\Sigma
 */
class ScheduledQueryRun extends \Stripe\ApiResource
{
    use \Stripe\ApiOperations\All;
    use \Stripe\ApiOperations\Retrieve;
    const OBJECT_NAME = "scheduled_query_run";
    public static function classUrl()
    {
        return "/v1/sigma/scheduled_query_runs";
    }
}

?>