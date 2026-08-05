<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

/**
 * This class defines attributes, valid values, and usage which is generated from
 * a given json schema. http://tools.ietf.org/html/draft-zyp-json-schema-03#section-5
 *
 * @author Chirag Shah <chirags@google.com>
 *
 */
class Google_Model
{
    public function __construct()
    {
        if (func_num_args() == 1 && is_array(func_get_arg(0))) {
            $array = func_get_arg(0);
            $this->mapTypes($array);
        }
    }
    protected function mapTypes($array)
    {
        foreach ($array as $key => $val) {
            $this->{$key} = $val;
            $keyTypeName = "__" . $key . "Type";
            $keyDataType = "__" . $key . "DataType";
            if ($this->useObjects() && property_exists($this, $keyTypeName)) {
                if ($this->isAssociativeArray($val)) {
                    if (isset($this->{$keyDataType}) && "map" == $this->{$keyDataType}) {
                        foreach ($val as $arrayKey => $arrayItem) {
                            $val[$arrayKey] = $this->createObjectFromName($keyTypeName, $arrayItem);
                        }
                        $this->{$key} = $val;
                    } else {
                        $this->{$key} = $this->createObjectFromName($keyTypeName, $val);
                    }
                } else {
                    if (is_array($val)) {
                        $arrayObject = [];
                        foreach ($val as $arrayIndex => $arrayItem) {
                            $arrayObject[$arrayIndex] = $this->createObjectFromName($keyTypeName, $arrayItem);
                        }
                        $this->{$key} = $arrayObject;
                    }
                }
            }
        }
    }
    protected function isAssociativeArray($array)
    {
        if (!is_array($array)) {
            return false;
        }
        $keys = array_keys($array);
        foreach ($keys as $key) {
            if (is_string($key)) {
                return true;
            }
        }
        return false;
    }
    private function createObjectFromName($name, $item)
    {
        $type = $this->{$name};
        return new $type($item);
    }
    protected function useObjects()
    {
        global $apiConfig;
        return isset($apiConfig["use_objects"]) && $apiConfig["use_objects"];
    }
    public function assertIsArray($obj, $type, $method)
    {
        if ($obj && !is_array($obj)) {
            throw new Google_Exception("Incorrect parameter type passed to " . $method . "(), expected an" . " array containing items of type " . $type . ".");
        }
    }
}

?>