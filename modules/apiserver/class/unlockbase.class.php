<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

define("UNLOCKBASE_API_KEY", $VAL["apikey"]);
define("UNLOCKBASE_API_DEBUG", false);
define("UNLOCKBASE_API_URL", "http://www.unlockbase.com/xml/api/v3");
define("UNLOCKBASE_VARIABLE_ERROR", "_UnlockBaseError");
define("UNLOCKBASE_VARIABLE_ARRAY", "_UnlockBaseArray");
define("UNLOCKBASE_VARIABLE_POINTERS", "_UnlockBasePointers");
if (!extension_loaded("curl")) {
    trigger_error("cURL extension not installed", 256);
}
class UnlockBase
{
    public static function CallAPI($Action, $Parameters = [])
    {
        if (is_string($Action)) {
            if (is_array($Parameters)) {
                $Parameters["Key"] = UNLOCKBASE_API_KEY;
                $Parameters["Action"] = $Action;
                $Ch = curl_init(UNLOCKBASE_API_URL);
                curl_setopt($Ch, CURLOPT_CONNECTTIMEOUT, 10);
                curl_setopt($Ch, CURLOPT_TIMEOUT, 30);
                curl_setopt($Ch, CURLOPT_HEADER, false);
                curl_setopt($Ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($Ch, CURLOPT_ENCODING, "");
                curl_setopt($Ch, CURLOPT_POST, true);
                curl_setopt($Ch, CURLOPT_POSTFIELDS, UnlockBase::BuildQuery($Parameters));
                $Data = curl_exec($Ch);
                if (UNLOCKBASE_API_DEBUG && curl_errno($Ch) != CURLE_OK) {
                    trigger_error(curl_error($Ch), 512);
                }
                curl_close($Ch);
                return $Data;
            }
            trigger_error("Parameters must be an array", 512);
        } else {
            trigger_error("Action must be a string", 512);
        }
        return false;
    }
    public static function ParseXML($XML)
    {
        if (!is_string($XML)) {
            if (UNLOCKBASE_API_DEBUG) {
                trigger_error("Invalid argument supplied for UnlockBase::ParseXML()", 512);
            }
            return false;
        }
        ${UNLOCKBASE_VARIABLE_ERROR} =& ${UNLOCKBASE_VARIABLE_ERROR};
        ${UNLOCKBASE_VARIABLE_ARRAY} =& ${UNLOCKBASE_VARIABLE_ARRAY};
        ${UNLOCKBASE_VARIABLE_POINTERS} =& ${UNLOCKBASE_VARIABLE_POINTERS};
        ${UNLOCKBASE_VARIABLE_ERROR} = false;
        ${UNLOCKBASE_VARIABLE_ARRAY} = [];
        ${UNLOCKBASE_VARIABLE_POINTERS} = [];
        $Parser = xml_parser_create("UTF-8");
        xml_set_element_handler($Parser, ["UnlockBase", "XML_Start"], ["UnlockBase", "XML_End"]);
        xml_set_character_data_handler($Parser, ["UnlockBase", "XML_CData"]);
        xml_parser_set_option($Parser, XML_OPTION_CASE_FOLDING, 0);
        $Success = xml_parse($Parser, $XML, true) && !${UNLOCKBASE_VARIABLE_ERROR};
        if (UNLOCKBASE_API_DEBUG) {
            if (${UNLOCKBASE_VARIABLE_ERROR}) {
                trigger_error("Unrecognized XML format", 512);
            } else {
                if (xml_get_error_code($Parser) != XML_ERROR_NONE) {
                    trigger_error(xml_error_string(xml_get_error_code($Parser)), 512);
                }
            }
        }
        xml_parser_free($Parser);
        $Array =& ${UNLOCKBASE_VARIABLE_ARRAY};
        unset($GLOBALS[UNLOCKBASE_VARIABLE_ERROR]);
        unset($GLOBALS[UNLOCKBASE_VARIABLE_ARRAY]);
        unset($GLOBALS[UNLOCKBASE_VARIABLE_POINTERS]);
        return $Success ? $Array : false;
    }
    public static function CheckEmail($Email)
    {
        return (bool) preg_match("/^[0-9a-z_\\-\\.]+@([0-9a-z][0-9a-z\\-]*[0-9a-z]\\.)+[a-z]{2,}\$/i", $Email);
    }
    public static function CheckIMEI($IMEI, $Checksum = true)
    {
        if (is_string($IMEI) && strlen($IMEI) == 15 && is_numeric($IMEI)) {
            if (!$Checksum) {
                return true;
            }
            $i = 0;
            for ($Sum = 0; $i < 14; $i++) {
                $Tmp = $IMEI[$i] * ($i % 2 + 1);
                $Sum += $Tmp % 10 + intval($Tmp / 10);
            }
            return (10 - $Sum % 10) % 10 == $IMEI[14];
        }
        return false;
    }
    public static function CheckProviderID($ProviderID)
    {
        return is_string($ProviderID) && deregi("^[0-9a-z]{4,5}\\-[0-9a-z]{7}\$", $ProviderID);
    }
    public static function CheckMEP_PRD($Type, $String)
    {
        return true;
    }
    public static function BuildQuery($Parameters)
    {
        if (function_exists("http_build_query")) {
            return http_build_query($Parameters);
        }
        $Data = [];
        foreach ($Parameters as $Name => $Value) {
            array_push($Data, urlencode($Name) . "=" . urlencode($Value));
        }
        return implode("&", $Data);
    }
    public static function XML_Start($Parser, $Name, $Attributes)
    {
        ${UNLOCKBASE_VARIABLE_ERROR} =& ${UNLOCKBASE_VARIABLE_ERROR};
        ${UNLOCKBASE_VARIABLE_ARRAY} =& ${UNLOCKBASE_VARIABLE_ARRAY};
        ${UNLOCKBASE_VARIABLE_POINTERS} =& ${UNLOCKBASE_VARIABLE_POINTERS};
        if (${UNLOCKBASE_VARIABLE_ERROR}) {
            return NULL;
        }
        if (count(${UNLOCKBASE_VARIABLE_POINTERS}) == 0) {
            ${UNLOCKBASE_VARIABLE_POINTERS}[] =& ${UNLOCKBASE_VARIABLE_ARRAY};
        } else {
            $Pointer =& ${UNLOCKBASE_VARIABLE_POINTERS}[count(${UNLOCKBASE_VARIABLE_POINTERS}) - 1];
            if (is_null($Pointer)) {
                $Pointer[] = [];
                ${UNLOCKBASE_VARIABLE_POINTERS}[count(${UNLOCKBASE_VARIABLE_POINTERS}) - 1] =& $Pointer[0];
                $Pointer =& $Pointer[0];
            } else {
                if (is_array($Pointer)) {
                    if (isset($Pointer[$Name])) {
                        if (!is_array($Pointer[$Name])) {
                            ${UNLOCKBASE_VARIABLE_ERROR} = true;
                            return NULL;
                        }
                        $Pointer[$Name][] = [];
                        ${UNLOCKBASE_VARIABLE_POINTERS}[] =& $Pointer[$Name][count($Pointer[$Name]) - 1];
                        return NULL;
                    }
                } else {
                    ${UNLOCKBASE_VARIABLE_ERROR} = true;
                    return NULL;
                }
            }
            $Pointer[$Name] = NULL;
            ${UNLOCKBASE_VARIABLE_POINTERS}[] =& $Pointer[$Name];
        }
    }
    public static function XML_End($Parser, $Name)
    {
        ${UNLOCKBASE_VARIABLE_ERROR} =& ${UNLOCKBASE_VARIABLE_ERROR};
        ${UNLOCKBASE_VARIABLE_POINTERS} =& ${UNLOCKBASE_VARIABLE_POINTERS};
        if (${UNLOCKBASE_VARIABLE_ERROR}) {
            return NULL;
        }
        array_pop(${UNLOCKBASE_VARIABLE_POINTERS});
    }
    public static function XML_CData($Parser, $Data)
    {
        if (rtrim($Data) == "") {
            return NULL;
        }
        ${UNLOCKBASE_VARIABLE_ERROR} =& ${UNLOCKBASE_VARIABLE_ERROR};
        ${UNLOCKBASE_VARIABLE_POINTERS} =& ${UNLOCKBASE_VARIABLE_POINTERS};
        if (${UNLOCKBASE_VARIABLE_ERROR}) {
            return NULL;
        }
        $Pointer =& ${UNLOCKBASE_VARIABLE_POINTERS}[count(${UNLOCKBASE_VARIABLE_POINTERS}) - 1];
        if (is_array($Pointer)) {
            ${UNLOCKBASE_VARIABLE_ERROR} = true;
        } else {
            $Pointer .= $Data;
        }
    }
}

?>