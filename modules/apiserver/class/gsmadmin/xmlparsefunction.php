<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

define("GsmAdmin_API_DEBUG", false);
define("GsmAdmin_VARIABLE_ERROR", "_GsmAdminError");
define("GsmAdmin_VARIABLE_ARRAY", "_GsmAdminArray");
define("GsmAdmin_VARIABLE_POINTERS", "_GsmAdminPointers");
class GsmAdmin
{
    public function ParseXML($XML)
    {
        if (!is_string($XML)) {
            if (GsmAdmin_API_DEBUG) {
                trigger_error("Invalid argument supplied for GsmAdmin::ParseXML()", 512);
            }
            return false;
        }
        ${GsmAdmin_VARIABLE_ERROR} =& ${GsmAdmin_VARIABLE_ERROR};
        ${GsmAdmin_VARIABLE_ARRAY} =& ${GsmAdmin_VARIABLE_ARRAY};
        ${GsmAdmin_VARIABLE_POINTERS} =& ${GsmAdmin_VARIABLE_POINTERS};
        ${GsmAdmin_VARIABLE_ERROR} = false;
        ${GsmAdmin_VARIABLE_ARRAY} = [];
        ${GsmAdmin_VARIABLE_POINTERS} = [];
        $Parser = xml_parser_create("UTF-8");
        xml_set_element_handler($Parser, ["GsmAdmin", "XML_Start"], ["GsmAdmin", "XML_End"]);
        xml_set_character_data_handler($Parser, ["GsmAdmin", "XML_CData"]);
        xml_parser_set_option($Parser, XML_OPTION_CASE_FOLDING, 0);
        $Success = xml_parse($Parser, $XML, true) && !${GsmAdmin_VARIABLE_ERROR};
        if (GsmAdmin_API_DEBUG) {
            if (${GsmAdmin_VARIABLE_ERROR}) {
                trigger_error("Unrecognized XML format", 512);
            } else {
                if (xml_get_error_code($Parser) != XML_ERROR_NONE) {
                    trigger_error(xml_error_string(xml_get_error_code($Parser)), 512);
                }
            }
        }
        xml_parser_free($Parser);
        $Array =& ${GsmAdmin_VARIABLE_ARRAY};
        unset($GLOBALS[GsmAdmin_VARIABLE_ERROR]);
        unset($GLOBALS[GsmAdmin_VARIABLE_ARRAY]);
        unset($GLOBALS[GsmAdmin_VARIABLE_POINTERS]);
        return $Success ? $Array : false;
    }
    public function XML_Start($Parser, $Name, $Attributes)
    {
        ${GsmAdmin_VARIABLE_ERROR} =& ${GsmAdmin_VARIABLE_ERROR};
        ${GsmAdmin_VARIABLE_ARRAY} =& ${GsmAdmin_VARIABLE_ARRAY};
        ${GsmAdmin_VARIABLE_POINTERS} =& ${GsmAdmin_VARIABLE_POINTERS};
        if (${GsmAdmin_VARIABLE_ERROR}) {
            return NULL;
        }
        if (count(${GsmAdmin_VARIABLE_POINTERS}) == 0) {
            ${GsmAdmin_VARIABLE_POINTERS}[] =& ${GsmAdmin_VARIABLE_ARRAY};
        } else {
            $Pointer =& ${GsmAdmin_VARIABLE_POINTERS}[count(${GsmAdmin_VARIABLE_POINTERS}) - 1];
            if (is_null($Pointer)) {
                $Pointer[] = [];
                ${GsmAdmin_VARIABLE_POINTERS}[count(${GsmAdmin_VARIABLE_POINTERS}) - 1] =& $Pointer[0];
                $Pointer =& $Pointer[0];
            } else {
                if (is_array($Pointer)) {
                    if (isset($Pointer[$Name])) {
                        if (!is_array($Pointer[$Name])) {
                            ${GsmAdmin_VARIABLE_ERROR} = true;
                            return NULL;
                        }
                        $Pointer[$Name][] = [];
                        ${GsmAdmin_VARIABLE_POINTERS}[] =& $Pointer[$Name][count($Pointer[$Name]) - 1];
                        return NULL;
                    }
                } else {
                    ${GsmAdmin_VARIABLE_ERROR} = true;
                    return NULL;
                }
            }
            $Pointer[$Name] = NULL;
            ${GsmAdmin_VARIABLE_POINTERS}[] =& $Pointer[$Name];
        }
    }
    public function XML_End($Parser, $Name)
    {
        ${GsmAdmin_VARIABLE_ERROR} =& ${GsmAdmin_VARIABLE_ERROR};
        ${GsmAdmin_VARIABLE_POINTERS} =& ${GsmAdmin_VARIABLE_POINTERS};
        if (${GsmAdmin_VARIABLE_ERROR}) {
            return NULL;
        }
        array_pop(${GsmAdmin_VARIABLE_POINTERS});
    }
    public function XML_CData($Parser, $Data)
    {
        if (rtrim($Data) == "") {
            return NULL;
        }
        ${GsmAdmin_VARIABLE_ERROR} =& ${GsmAdmin_VARIABLE_ERROR};
        ${GsmAdmin_VARIABLE_POINTERS} =& ${GsmAdmin_VARIABLE_POINTERS};
        if (${GsmAdmin_VARIABLE_ERROR}) {
            return NULL;
        }
        $Pointer =& ${GsmAdmin_VARIABLE_POINTERS}[count(${GsmAdmin_VARIABLE_POINTERS}) - 1];
        if (is_array($Pointer)) {
            ${GsmAdmin_VARIABLE_ERROR} = true;
        } else {
            $Pointer .= $Data;
        }
    }
}

?>