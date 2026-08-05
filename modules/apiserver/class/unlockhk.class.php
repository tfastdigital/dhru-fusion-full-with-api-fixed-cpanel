<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

require_once "nusoap/nusoap.php";
define("UNLOCKHK_API_DEBUG", false);
define("UNLOCKHK_API_URL", "http://www.unlock.hk/API/Service.asmx?WSDL");
define("UNLOCKHK_VARIABLE_ERROR", "_UnlockHKError");
define("UNLOCKHK_VARIABLE_ARRAY", "_UnlockHKArray");
define("UNLOCKHK_VARIABLE_POINTERS", "_UnlockHKPointers");
if (!extension_loaded("curl")) {
    trigger_error("cURL extension not installed", 256);
}
class UnlockHK
{
    public function CallAPI($Action, $Parameters = [])
    {
        if (is_string($Action)) {
            if (is_array($Parameters)) {
                $Parameters["UserName"] = UNLOCKHK_USER_NAME;
                $Parameters["Sign"] = md5(UNLOCKHK_USER_NAME . UNLOCKHK_API_KEY);
                $client = new nusoap_client(UNLOCKHK_API_URL, true);
                $client->soap_defencoding = "utf-8";
                $client->decode_utf8 = false;
                $client->xml_encoding = "utf-8";
                $Data = $client->call($Action, $Parameters);
                if (is_array($Data)) {
                    $Data = join($Data);
                }
                return $Data;
            }
            trigger_error("Parameters must be an array", 512);
        } else {
            trigger_error("Action must be a string", 512);
        }
        return false;
    }
    public function ParseXML($XML)
    {
        if (!is_string($XML)) {
            if (UNLOCKHK_API_DEBUG) {
                trigger_error("Invalid argument supplied for UnlockHK::ParseXML()", 512);
            }
            return false;
        }
        ${UNLOCKHK_VARIABLE_ERROR} =& ${UNLOCKHK_VARIABLE_ERROR};
        ${UNLOCKHK_VARIABLE_ARRAY} =& ${UNLOCKHK_VARIABLE_ARRAY};
        ${UNLOCKHK_VARIABLE_POINTERS} =& ${UNLOCKHK_VARIABLE_POINTERS};
        ${UNLOCKHK_VARIABLE_ERROR} = false;
        ${UNLOCKHK_VARIABLE_ARRAY} = [];
        ${UNLOCKHK_VARIABLE_POINTERS} = [];
        $Parser = xml_parser_create("UTF-8");
        xml_set_element_handler($Parser, ["UnlockHK", "XML_Start"], ["UnlockHK", "XML_End"]);
        xml_set_character_data_handler($Parser, ["UnlockHK", "XML_CData"]);
        xml_parser_set_option($Parser, XML_OPTION_CASE_FOLDING, 0);
        $Success = xml_parse($Parser, $XML, true) && !${UNLOCKHK_VARIABLE_ERROR};
        if (UNLOCKHK_API_DEBUG) {
            if (${UNLOCKHK_VARIABLE_ERROR}) {
                trigger_error("Unrecognized XML format", 512);
            } else {
                if (xml_get_error_code($Parser) != XML_ERROR_NONE) {
                    trigger_error(xml_error_string(xml_get_error_code($Parser)), 512);
                }
            }
        }
        xml_parser_free($Parser);
        $Array =& ${UNLOCKHK_VARIABLE_ARRAY};
        unset($GLOBALS[UNLOCKHK_VARIABLE_ERROR]);
        unset($GLOBALS[UNLOCKHK_VARIABLE_ARRAY]);
        unset($GLOBALS[UNLOCKHK_VARIABLE_POINTERS]);
        return $Success ? $Array : false;
    }
    public function XML_Start($Parser, $Name, $Attributes)
    {
        ${UNLOCKHK_VARIABLE_ERROR} =& ${UNLOCKHK_VARIABLE_ERROR};
        ${UNLOCKHK_VARIABLE_ARRAY} =& ${UNLOCKHK_VARIABLE_ARRAY};
        ${UNLOCKHK_VARIABLE_POINTERS} =& ${UNLOCKHK_VARIABLE_POINTERS};
        if (${UNLOCKHK_VARIABLE_ERROR}) {
            return NULL;
        }
        if (count(${UNLOCKHK_VARIABLE_POINTERS}) == 0) {
            ${UNLOCKHK_VARIABLE_POINTERS}[] =& ${UNLOCKHK_VARIABLE_ARRAY};
        } else {
            $Pointer =& ${UNLOCKHK_VARIABLE_POINTERS}[count(${UNLOCKHK_VARIABLE_POINTERS}) - 1];
            if (is_null($Pointer)) {
                $Pointer[] = [];
                ${UNLOCKHK_VARIABLE_POINTERS}[count(${UNLOCKHK_VARIABLE_POINTERS}) - 1] =& $Pointer[0];
                $Pointer =& $Pointer[0];
            } else {
                if (is_array($Pointer)) {
                    if (isset($Pointer[$Name])) {
                        if (!is_array($Pointer[$Name])) {
                            ${UNLOCKHK_VARIABLE_ERROR} = true;
                            return NULL;
                        }
                        $Pointer[$Name][] = [];
                        ${UNLOCKHK_VARIABLE_POINTERS}[] =& $Pointer[$Name][count($Pointer[$Name]) - 1];
                        return NULL;
                    }
                } else {
                    ${UNLOCKHK_VARIABLE_ERROR} = true;
                    return NULL;
                }
            }
            $Pointer[$Name] = NULL;
            ${UNLOCKHK_VARIABLE_POINTERS}[] =& $Pointer[$Name];
        }
    }
    public function XML_End($Parser, $Name)
    {
        ${UNLOCKHK_VARIABLE_ERROR} =& ${UNLOCKHK_VARIABLE_ERROR};
        ${UNLOCKHK_VARIABLE_POINTERS} =& ${UNLOCKHK_VARIABLE_POINTERS};
        if (${UNLOCKHK_VARIABLE_ERROR}) {
            return NULL;
        }
        array_pop(${UNLOCKHK_VARIABLE_POINTERS});
    }
    public function XML_CData($Parser, $Data)
    {
        if (rtrim($Data) == "") {
            return NULL;
        }
        ${UNLOCKHK_VARIABLE_ERROR} =& ${UNLOCKHK_VARIABLE_ERROR};
        ${UNLOCKHK_VARIABLE_POINTERS} =& ${UNLOCKHK_VARIABLE_POINTERS};
        if (${UNLOCKHK_VARIABLE_ERROR}) {
            return NULL;
        }
        $Pointer =& ${UNLOCKHK_VARIABLE_POINTERS}[count(${UNLOCKHK_VARIABLE_POINTERS}) - 1];
        if (is_array($Pointer)) {
            ${UNLOCKHK_VARIABLE_ERROR} = true;
        } else {
            $Pointer .= $Data;
        }
    }
}

?>