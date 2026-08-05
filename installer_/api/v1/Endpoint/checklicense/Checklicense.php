<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

namespace Dhru\Endpoint\checklicense;

class Checklicense
{
    public $para = NULL;
    public function __construct($Base)
    {
        $this->para = $Base->parameters;
    }
}

?>