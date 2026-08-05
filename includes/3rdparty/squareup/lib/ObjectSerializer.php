<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

namespace SquareConnect;

/**
 * ObjectSerializer Class Doc Comment
 *
 * @category Class
 * @package  SquareConnect
 * @author   Square Inc.
 * @license  http://www.apache.org/licenses/LICENSE-2.0 Apache Licene v2
 * @link     https://squareup.com/developers
 */
class ObjectSerializer
{
    public static function sanitizeForSerialization($data)
    {
        if (is_scalar($data) || NULL === $data) {
            $sanitized = $data;
        } else {
            if ($data instanceof \DateTime) {
                $sanitized = $data->format(\DateTime::ISO8601);
            } else {
                if (is_array($data)) {
                    foreach ($data as $property => $value) {
                        $data[$property] = self::sanitizeForSerialization($value);
                    }
                    $sanitized = $data;
                } else {
                    if (is_object($data)) {
                        $values = [];
                        foreach (array_keys($data::$swaggerTypes) as $property) {
                            $getter = $data::$getters[$property];
                            if ($data->{$getter}() !== NULL) {
                                $values[$data::$attributeMap[$property]] = self::sanitizeForSerialization($data->{$getter}());
                            }
                        }
                        $sanitized = (object) $values;
                    } else {
                        $sanitized = (string) $data;
                    }
                }
            }
        }
        return $sanitized;
    }
    public function sanitizeFilename($filename)
    {
        if (preg_match("/.*[\\/\\\\](.*)\$/", $filename, $match)) {
            return $match[1];
        }
        return $filename;
    }
    public function toPathValue($value)
    {
        return rawurlencode($this->toString($value));
    }
    public function toQueryValue($object)
    {
        if (is_array($object)) {
            return implode(",", $object);
        }
        return $this->toString($object);
    }
    public function toHeaderValue($value)
    {
        return $this->toString($value);
    }
    public function toFormValue($value)
    {
        if ($value instanceof \SplFileObject) {
            return $value->getRealPath();
        }
        return $this->toString($value);
    }
    public function toString($value)
    {
        if ($value instanceof \DateTime) {
            return $value->format(\DateTime::ISO8601);
        }
        return $value;
    }
    public function serializeCollection($collection, $collectionFormat, $allowCollectionFormatMulti = false)
    {
        while ($allowCollectionFormatMulti && "multi" === $collectionFormat) {
            switch ($collectionFormat) {
                case "pipes":
                    return implode("|", $collection);
                    break;
                case "tsv":
                    return implode("\t", $collection);
                    break;
                case "ssv":
                    return implode(" ", $collection);
                    break;
                case "csv":
                default:
                    return implode(",", $collection);
            }
        }
        return preg_replace("/%5B[0-9]+%5D=/", "=", http_build_query($collection, "", "&"));
    }
    public static function deserialize($data, $class, $httpHeaders = NULL)
    {
        if (NULL === $data) {
            $deserialized = NULL;
        } else {
            if (substr($class, 0, 4) === "map[") {
                $inner = substr($class, 4, -1);
                $deserialized = [];
                if (strrpos($inner, ",") !== false) {
                    $subClass_array = explode(",", $inner, 2);
                    $subClass = $subClass_array[1];
                    foreach ($data as $key => $value) {
                        $deserialized[$key] = self::deserialize($value, $subClass);
                    }
                }
            } else {
                if (strcasecmp(substr($class, -2), "[]") == 0) {
                    $subClass = substr($class, 0, -2);
                    $values = [];
                    foreach ($data as $key => $value) {
                        $values[] = self::deserialize($value, $subClass);
                    }
                    $deserialized = $values;
                } else {
                    if ($class === "ByteArray") {
                        $deserialized = unpack("C*", (string) $data);
                    } else {
                        if ($class === "\\DateTime") {
                            $deserialized = new \DateTime($data);
                        } else {
                            if (in_array($class, ["DateTime", "bool", "boolean", "byte", "double", "float", "int", "integer", "mixed", "number", "object", "string", "void"])) {
                                settype($data, $class);
                                $deserialized = $data;
                            } else {
                                if ($class === "\\SplFileObject") {
                                    if (array_key_exists("Content-Disposition", $httpHeaders) && preg_match("/inline; filename=['\"]?([^'\"\\s]+)['\"]?\$/i", $httpHeaders["Content-Disposition"], $match)) {
                                        $filename = Configuration::getDefaultConfiguration()->getTempFolderPath() . sanitizeFilename($match[1]);
                                    } else {
                                        $filename = tempnam(Configuration::getDefaultConfiguration()->getTempFolderPath(), "");
                                    }
                                    $deserialized = new \SplFileObject($filename, "w");
                                    $byte_written = $deserialized->fwrite($data);
                                    error_log("[INFO] Written " . $byte_written . " byte to " . $filename . ". Please move the file to a proper folder or delete the temp file after processing.\n", 3, Configuration::getDefaultConfiguration()->getDebugFile());
                                } else {
                                    $instance = new $class();
                                    foreach ($instance::$swaggerTypes as $property => $type) {
                                        $propertySetter = $instance::$setters[$property];
                                        if (isset($propertySetter) && isset($data->{$instance::$attributeMap[$property]})) {
                                            $propertyValue = $data->{$instance::$attributeMap[$property]};
                                            if (isset($propertyValue)) {
                                                $instance->{$propertySetter}(self::deserialize($propertyValue, $type));
                                            }
                                        }
                                    }
                                    $deserialized = $instance;
                                }
                            }
                        }
                    }
                }
            }
        }
        return $deserialized;
    }
}

?>