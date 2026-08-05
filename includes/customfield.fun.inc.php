<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

defined("DEFINE_MY_ACCESS") || exit("<h1 style=\"color: #C00; text-align: center;\"><strong>Restricted Access</strong></h1>");
function getCustomFields($type, $relid, $relid2, $admin = "", $order = "", $ordervalues = "", $forshop = false, $currency = "")
{
    $customfields = $where = [];
    $where["type"] = $type;
    if ($relid && is_numeric($relid) && 0 < $relid) {
        $where["relid"] = $relid;
    } else {
        $where["relid"] = 0;
    }
    if (!$admin) {
        $where["adminonly"] = "";
    }
    if ($order) {
        $where["showorder"] = "on";
    }
    $result = select_query("tbl_customfields", "", $where, "sortorder` ASC,`id", "ASC");
    while ($data = mysqli_fetch_assoc($result)) {
        $id = $data["id"];
        $fieldname = $data["fieldname"];
        if (strpos($fieldname, "|")) {
            $fieldname = explode("|", $fieldname);
            $fieldname = trim($fieldname[1]);
        }
        $fieldtype = $data["fieldtype"];
        $description = $data["description"];
        $fieldoptions = $data["fieldoptions"];
        $required = $data["required"];
        $customfieldval = $ordervalues[$id];
        $mapping = NULL;
        if ($data["fieldother"]) {
            $mapping = json_decode($data["fieldother"], true);
            if (!is_array($mapping)) {
                $mapping = NULL;
            }
        }
        $isenc = $data["enc"];
        if ($forshop && ($fieldtype == "dropdown" || $fieldtype == "radio")) {
            $cprice = getConfigurablePrice($id, $currency);
        }
        if ($relid2) {
            $result2 = select_query("tbl_customfieldsvalues", "value", ["fieldid" => $id, "relid" => $relid2]);
            $data = mysqli_fetch_assoc($result2);
            $customfieldval = $forshop ? $data["value"] . " " . formatCurrency(getPriceFromCustomField($id, $data["value"], $currency), $currency) : $data["value"];
        }
        if ($fieldtype == "encrypted") {
            $customfieldval = dec($customfieldval, "9486");
        }
        if ($required == "on") {
            if ($fieldtype != "tickbox" && $fieldtype != "radio") {
                $required = "*";
            } else {
                $required = "";
            }
        }
        if ($fieldtype == "text") {
            $input = "<input class=\"form-control\" type=\"text\" placeholder=\"" . $fieldname . "\" size=\"30\" name=\"customfield[" . $id . "]" . "\"\n            id=\"customfield" . $id . "\" value=\"" . $customfieldval . "\">";
        } else {
            if ($fieldtype == "encrypted") {
                $input = "<input class=\"form-control\" type=\"password\" size=\"30\" name=\"customfield[" . $id . "]" . "\"\n             id=\"customfield" . $id . "\" value=\"" . $customfieldval . "\">";
            } else {
                if ($fieldtype == "datepicker") {
                    $input = "\n<script src=\"http://jquery-ui.googlecode.com/svn/tags/1.8.18/ui/jquery.ui.core.js\"></script>\n<script src=\"http://jquery-ui.googlecode.com/svn/tags/1.8.18/ui/jquery.ui.datepicker.js\"></script>\n<link href=\"http://jquery-ui.googlecode.com/svn/tags/1.8.18/themes/ui-lightness/jquery.ui.datepicker.css\" rel=\"stylesheet\"/>\n<link href=\"http://jquery-ui.googlecode.com/svn/tags/1.8.18/themes/ui-lightness/jquery-ui.css\" rel=\"stylesheet\"/>\n<script type=\"text/javascript\">\n\$(function() {\n    var dates = \$( \"#customfield" . $id . "\").datepicker({\n        changeMonth: true,\n        changeYear: true,\n        yearRange:\"-50:+0\", \n        dateFormat:'yy-mm-dd',\n        onSelect: function( selectedDate ) {\n            var option = this.id == \"from\" ? \"minDate\" : \"maxDate\",\n                instance = \$( this ).data( \"datepicker\" );\n                date = \$.datepicker.parseDate(\n                    instance.settings.dateFormat ||\n                    \$.datepicker._defaults.dateFormat,\n                    selectedDate, instance.settings );\n            dates.not( this ).datepicker( \"option\", option, date );\n        }\n    });\n});\n</script>";
                    $input .= "<input type=\"text\" class=\"form-control\"  name=\"customfield[" . $id . "]" . "\"\n             id=\"customfield" . $id . "\" value=\"" . $customfieldval . "\">";
                } else {
                    if ($fieldtype == "time") {
                        $input = "  <script type=\"text/javascript\" src=\"includes/js/jquery.timeentry.js\"></script>\n        <script type=\"text/javascript\">\n        \$(function(){\n        \t\$('#customfield" . $id . "').timeEntry();\n        });\n        </script>";
                        $input .= "<input type=\"text\" class=\"form-control\"  name=\"customfield[" . $id . "]" . "\"\n             id=\"customfield" . $id . "\" value=\"" . $customfieldval . "\">";
                    } else {
                        if ($fieldtype == "textarea") {
                            $input = "<textarea class=\"form-control\" name=\"customfield[" . $id . "]" . "\" id=\"customfield" . $id . "\" cols=\"60\" rows=\"3\">" . $customfieldval . "</textarea>";
                        } else {
                            if ($fieldtype == "dropdown") {
                                if ($forshop && $cprice) {
                                    $input = "<select class=\"form-control customfield\" onchange=\"getTotalConfigPrice(this);\" name=\"customfield[" . $id . "]" . "\" id=\"customfield" . $id . "\">";
                                } else {
                                    $input = "<select class=\"form-control customfield\" name=\"customfield[" . $id . "]" . "\" id=\"customfield" . $id . "\">";
                                }
                                $fieldoptions = explode(",", $fieldoptions);
                                if ($required != "on") {
                                    $input .= "<option value=''>Select</option>";
                                }
                                foreach ($fieldoptions as $_key => $optionvalue) {
                                    if ($forshop && $cprice) {
                                        $cpriced = preg_replace("/[^0-9.]/i", "", $cprice[$_key]);
                                        $input .= "<option title=\"" . $optionvalue . "\" class=\"" . $cpriced . "\" value=\"" . $optionvalue . "\"";
                                    } else {
                                        $input .= "<option title=\"" . $optionvalue . "\"  value=\"" . $optionvalue . "\"";
                                    }
                                    if ($customfieldval == $optionvalue || $cprice[$_key] == " Free") {
                                        $input .= " selected";
                                    }
                                    if (strpos($optionvalue, "|")) {
                                        $optionvalue = explode("|", $optionvalue);
                                        $optionvalue = trim($optionvalue[1]);
                                    }
                                    if (!is_array($cprice)) {
                                        $cprice[$_key] = "";
                                    }
                                    $input .= ">" . $optionvalue . $cprice[$_key] . "</option>";
                                }
                                $input .= "</select>";
                            } else {
                                if ($fieldtype == "tickbox") {
                                    $input = "<input class=\"form-check-input \" type=\"checkbox\" name=\"customfield[" . $id . "]" . "\" id=\"customfield" . $id . "\"";
                                    if ($customfieldval == "on") {
                                        $input .= " checked";
                                    }
                                    $input .= ">";
                                } else {
                                    if ($fieldtype == "radio") {
                                        $input = "";
                                        $fieldoptions = explode(",", $fieldoptions);
                                        $input .= "<input type=\"hidden\" name=\"customfield[" . $id . "]\" value=\"\" />";
                                        foreach ($fieldoptions as $_key => $optionvalue) {
                                            $input .= "<input class=\"form-radio-input\" name=\"customfield[" . $id . "]\" type=\"radio\" value=\"" . $optionvalue . "\"";
                                            if ($customfieldval == $optionvalue || $cprice[$_key] == " Free") {
                                                $input .= " checked=\"checked\"";
                                            }
                                            if (strpos($optionvalue, "|")) {
                                                $optionvalue = explode("|", $optionvalue);
                                                $optionvalue = trim($optionvalue[1]);
                                            }
                                            if (!is_array($cprice)) {
                                                $cprice[$_key] = "";
                                            }
                                            if ($cprice[$_key]) {
                                                $input .= "/ > " . $optionvalue . "   [" . $cprice[$_key] . "]";
                                            } else {
                                                $input .= "/ > " . $optionvalue;
                                            }
                                            $input .= "<br />";
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
        $customfieldvalraw = $customfieldval;
        if (strpos($customfieldval, "|")) {
            $customfieldval = explode("|", $customfieldval);
            $customfieldval = trim($customfieldval[1]);
        }
        $customfields[] = ["id" => $id, "name" => $fieldname, "description" => $description, "input" => $input, "type" => $fieldtype, "value" => $customfieldval, "option" => $fieldoptions, "rawvalue" => $customfieldvalraw, "mapping" => $mapping, "required" => $required];
    }
    return $customfields;
}
function getPriceFromCustomField($fieldid, $fieldvalue, $currency)
{
    $sql = mysqli_fetch_assoc(dquery("select fieldoptions from tbl_customfields where id='" . $fieldid . "'"));
    $values = explode(",", $sql["fieldoptions"]);
    foreach ($values as $k => $v) {
        if ($v == $fieldvalue) {
            $fieldkey = $k;
        }
    }
    $price = getConfigurablePrice($fieldid, $currency, true);
    return $price[$fieldkey];
}
function getConfigurablePrice($cid, $currency = "", $calculation = false)
{
    if ($currency == "") {
        $currency = $_SESSION["currency"];
    }
    $default = $_SESSION["system_default_currency"];
    $cprice = mysqli_fetch_assoc(dquery("select credit from tbl_customfieldconfig where cid='" . $cid . "' and currency_id='" . $default["id"] . "'"));
    if ($cprice["credit"]) {
        $arr = explode(",", $cprice["credit"]);
        $new = [];
        foreach ($arr as $credit) {
            if ($credit == 0) {
                if ($calculation) {
                    $new[] = 0;
                } else {
                    $new[] = " Free";
                }
            } else {
                if ($default["id"] != $currency["id"]) {
                    $credit = convertCurrency($credit, $default["id"], $currency["id"]);
                }
                if ($calculation) {
                    $new[] = (string) $credit;
                } else {
                    if (0 < $credit) {
                        $sign = "+";
                    } else {
                        $sign = "-";
                        $credit = abs($credit);
                    }
                    $new[] = " " . $sign . " " . $currency["prefix"] . $credit . $currency["suffix"];
                }
            }
        }
        return $new;
    } else {
        return false;
    }
}
function saveCustomFields($relid, $customfields)
{
    $Buff = "";
    if (is_array($customfields)) {
        foreach ($customfields as $id => $value) {
            $relid = preg_replace("/[^0-9]/", "", $relid);
            $result = select_query("tbl_customfieldsvalues", "", ["fieldid" => $id, "relid" => $relid]);
            $num_rows = mysqli_num_rows($result);
            $value = filter_var($value, FILTER_SANITIZE_STRING);
            $cfs = mysqli_fetch_assoc(dquery("select fieldname,fieldtype,enc,(select useasserver from tbl_services_imei\nwhere id=relid) as useasserver from tbl_customfields\n            where id='" . $id . "'"));
            if ($cfs["fieldtype"] == "encrypted") {
                $value = enc($value, "9486");
            }
            if ($num_rows == "0") {
                $Buff .= " " . $value;
                insert_query("tbl_customfieldsvalues", ["fieldid" => $id, "relid" => $relid, "value" => $value, "fieldname" => $cfs["fieldname"], "servicetype" => $cfs["useasserver"] == 2 ? "remote" : ($cfs["useasserver"] == 1 ? "server" : "imei")]);
            } else {
                $Buff .= " " . $value;
                update_query("tbl_customfieldsvalues", ["value" => $value], ["fieldid" => $id, "relid" => $relid]);
            }
        }
    }
    return $Buff;
}
function checkCustomFields($customfields)
{
    global $lng_languag;
    if ($customfields) {
        foreach ($customfields as $id => $value) {
            $result = select_query("tbl_customfields", "", ["id" => $id]);
            $data = mysqli_fetch_assoc($result);
            $fieldname = $data["fieldname"];
            if (strpos($fieldname, "|")) {
                $fieldname = explode("|", $fieldname);
                $fieldname = trim($fieldname[1]);
            }
            $required = $data["required"];
            $regexpr = $data["regexpr"];
            if ($required == "on" && !$value) {
                $errormessage .= "<li>" . $fieldname . " " . $lng_languag["isrequired"];
            }
            if ($regexpr && $value) {
                if (substr($regexpr, 0, 2) == "/^") {
                    if (!preg_match($regexpr, $value)) {
                        $errormessage .= "<li>" . $fieldname . " " . $lng_languag["validationerror"];
                    }
                } else {
                    $errormessage .= "<li>" . $fieldname . " " . $lng_languag["validationerror"];
                }
            }
        }
    }
    return $errormessage;
}
function getCustomfieldServicewise($type, $relid)
{
    global $LNG;
    $result = dquery("select * from tbl_customfields \n    where type='" . $type . "' and relid='" . $relid . "' order by sortorder asc");
    while ($data = mysqli_fetch_assoc($result)) {
        $_isFieldOptionsDisibled = $_isValidation = NULL;
        $arr[$data["id"]]["fieldname"] = "<input type=\"text\"  class=\"form-control\" name=\"customfield[" . $data["id"] . "][fieldname]\" value=\"" . $data["fieldname"] . "\"> *";
        $arr[$data["id"]]["description"] = "<input type=\"text\"   class=\"form-control\"  name=\"customfield[" . $data["id"] . "][description]\" value=\"" . $data["description"] . "\">";
        if ($data["fieldtype"] == "text") {
            $text = "selected";
            $_isFieldOptionsDisibled = "disabled=\"disabled\"";
        } else {
            if ($data["fieldtype"] == "dropdown") {
                $dropdown = "selected";
                $arr[$data["id"]]["configurable"] = $data["fieldoptions"];
                $_isValidation = "disabled=\"disabled\"";
            } else {
                if ($data["fieldtype"] == "radio") {
                    $radio = "selected";
                    $arr[$data["id"]]["configurable"] = $data["fieldoptions"];
                    $_isValidation = "disabled=\"disabled\"";
                } else {
                    if ($data["fieldtype"] == "datepicker") {
                        $picker = "selected";
                        $arr[$data["id"]]["configurable"] = $data["fieldoptions"];
                        $_isValidation = "disabled=\"disabled\"";
                    } else {
                        if ($data["fieldtype"] == "time") {
                            $time = "selected";
                            $arr[$data["id"]]["configurable"] = $data["fieldoptions"];
                            $_isValidation = "disabled=\"disabled\"";
                        } else {
                            if ($data["fieldtype"] == "textarea") {
                                $textarea = "selected";
                                $text = "";
                                $dropdown = "";
                                $radio = "";
                                $_isFieldOptionsDisibled = "disabled=\"disabled\"";
                            } else {
                                if ($data["fieldtype"] == "tickbox") {
                                    $tickbox = "selected";
                                    $_isValidation = "disabled=\"disabled\"";
                                    $_isFieldOptionsDisibled = "disabled=\"disabled\"";
                                } else {
                                    if ($data["fieldtype"] == "encrypted") {
                                        $encry = "selected";
                                        $_isFieldOptionsDisibled = "disabled=\"disabled\"";
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
        $arr[$data["id"]]["fieldtype"] = "<select class=\"form-control customfield\" name=\"customfield[" . $data["id"] . "][fieldtype]\">\n        <option value=\"text\" " . $text . ">" . $LNG["text"] . "</option>\n        <option value=\"dropdown\" " . $dropdown . ">" . $LNG["dropdown"] . "</option>\n        <option value=\"radio\" " . $radio . ">" . "Radio" . "</option>\n        <option value=\"textarea\" " . $textarea . ">" . $LNG["textarea"] . "</option>\n        <option value=\"tickbox\" " . $tickbox . ">" . $LNG["tickbox"] . "</option>\n        <option value=\"datepicker\" " . $picker . ">" . $LNG["datepicker"] . "</option>\n        <option value=\"time\" " . $time . ">" . $LNG["time"] . "</option>\n        <option value=\"encrypted\" " . $encry . ">" . $LNG["encrypted"] . "</option></select>";
        $data["fieldtype"] = "";
        $text = "";
        $encry = "";
        $dropdown = "";
        $textarea = "";
        $tickbox = "";
        $radio = "";
        $arr[$data["id"]]["fieldoptions"] = "<input class=\"form-control fieldoptions\" type=\"text\" name=\"customfield[" . $data["id"] . "][fieldoptions]\" value=\"" . $data["fieldoptions"] . "\" " . $_isFieldOptionsDisibled . ">";
        $arr[$data["id"]]["regexpr"] = "<input class=\"form-control  regexpr\" type=\"text\" name=\"customfield[" . $data["id"] . "][regexpr]\" value=\"" . $data["regexpr"] . "\" " . $_isValidation . ">";
        $arr[$data["id"]]["fieldother"] = $data["fieldother"];
        if ($data["required"] == "on") {
            $selected = "checked";
        } else {
            $selected = "";
        }
        $arr[$data["id"]]["required"] = "<input class=\"form-check-input\" type=\"checkbox\" value=\"on\" id=\"t_" . $data["id"] . "\" name=\"customfield[" . $data["id"] . "][required]\" " . $selected . "><label for=\"t_" . $data["id"] . "\">&nbsp;</label>";
        if ($data["enc"] == "on") {
            $selected = "checked";
        } else {
            $selected = "";
        }
    }
    return $arr;
}
function saveCustomFieldServicewise($id, $customfield)
{
    if (is_array($customfield)) {
        $check = "false";
        foreach ($customfield as $id => $value) {
            foreach ($value as $kc => $kv) {
                if ($kc == "fieldother") {
                    $customfield[$id][$kc] = json_encode($kv);
                } else {
                    $customfield[$id]["fieldother"] = "";
                }
            }
            $result = select_query("tbl_customfields", "", "id='" . $id . "'");
            $num_rows = mysqli_num_rows($result);
            $check = "true";
            if ($num_rows == "0") {
                insert_query("tbl_customfields", $customfield[$id]);
            } else {
                update_query("tbl_customfields", $customfield[$id], "id='" . $id . "'");
            }
        }
    }
    return $check;
}

?>