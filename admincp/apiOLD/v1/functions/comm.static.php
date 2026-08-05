<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

function itemTypesKeys()
{
    return array_keys(itemTypes());
}
function itemTypes()
{
    $ItemType["product"]["description"] = "Products Sold as a Physical Goods";
    $ItemType["product"]["config"] = itemConfigFields("product");
    $ItemType["licencing"]["description"] = "Software / Service / SaaS Licencing";
    $ItemType["licencing"]["config"] = itemConfigFields("license");
    $ItemType["credit"]["description"] = "Credits, Vouchers, Packages";
    $ItemType["credit"]["config"] = itemConfigFields("credit");
    $ItemType["imei"]["description"] = "Digital services which is using IMEI Field";
    $ItemType["imei"]["config"] = itemConfigFields("imei");
    $ItemType["server"]["description"] = "Digital services for special products";
    $ItemType["server"]["config"] = itemConfigFields("server");
    $ItemType["file"]["description"] = "Digital services with file field";
    $ItemType["file"]["config"] = itemConfigFields("file");
    return $ItemType;
}
function decrypt($data, $key = "ASDF123123ASDF12312ASDFASDF123")
{
    $data = base64_decode($data);
    $l = strlen($key);
    if ($l < 16) {
        $key = str_repeat($key, ceil(16 / $l));
    }
    if (function_exists("mcrypt_encrypt")) {
        $val = mcrypt_decrypt(MCRYPT_BLOWFISH, $key, $data, MCRYPT_MODE_ECB);
    } else {
        $val = openssl_decrypt($data, "BF-ECB", $key, OPENSSL_RAW_DATA | OPENSSL_NO_PADDING);
    }
    return $val;
}
function getCustomFields($type, $relid, $relid2, $admin = "", $order = "", $ordervalues = "", $forshop = false, $currency = "")
{
    global $conn;
    $customfields = [];
    $where = "";
    $where .= " where type='" . $type . "'";
    if ($relid && is_numeric($relid) && 0 < $relid) {
        $where .= " and relid='0'";
    } else {
        $where .= " and relid='0'";
    }
    if (!$admin) {
        $where .= " and adminonly=''";
    }
    if ($order) {
        $where .= " and showorder='on'";
    }
    $result = $conn->query("select * from tbl_customfields " . $where . "\r\n    order by sortorder asc");
    while ($data = $result->fetch(PDO::FETCH_ASSOC)) {
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
            $required = "*";
        }
        if ($fieldtype == "text") {
            $input = "<input class=\"form-control\" type=\"text\" placeholder=\"" . $fieldname . "\" size=\"30\" name=\"customfield[" . $id . "]" . "\"\r\n            id=\"customfield" . $id . "\" value=\"" . $customfieldval . "\">";
        } else {
            if ($fieldtype == "encrypted") {
                $input = "<input class=\"form-control\" type=\"password\" size=\"30\" name=\"customfield[" . $id . "]" . "\"\r\n             id=\"customfield" . $id . "\" value=\"" . $customfieldval . "\">";
            } else {
                if ($fieldtype == "datepicker") {
                    $input = "\r\n<script src=\"http://jquery-ui.googlecode.com/svn/tags/1.8.18/ui/jquery.ui.core.js\"></script>\r\n<script src=\"http://jquery-ui.googlecode.com/svn/tags/1.8.18/ui/jquery.ui.datepicker.js\"></script>\r\n<link href=\"http://jquery-ui.googlecode.com/svn/tags/1.8.18/themes/ui-lightness/jquery.ui.datepicker.css\" rel=\"stylesheet\"/>\r\n<link href=\"http://jquery-ui.googlecode.com/svn/tags/1.8.18/themes/ui-lightness/jquery-ui.css\" rel=\"stylesheet\"/>\r\n<script type=\"text/javascript\">\r\n\$(function() {\r\n\t\tvar dates = \$( \"#customfield" . $id . "\").datepicker({\r\n\t\t\tchangeMonth: true,\r\n            changeYear: true,\r\n            yearRange:\"-50:+0\", \r\n            dateFormat:'yy-mm-dd',\r\n            onSelect: function( selectedDate ) {\r\n\t\t\t\tvar option = this.id == \"from\" ? \"minDate\" : \"maxDate\",\r\n\t\t\t\t\tinstance = \$( this ).data( \"datepicker\" );\r\n\t\t\t\t\tdate = \$.datepicker.parseDate(\r\n\t\t\t\t\t\tinstance.settings.dateFormat ||\r\n\t\t\t\t\t\t\$.datepicker._defaults.dateFormat,\r\n\t\t\t\t\t\tselectedDate, instance.settings );\r\n\t\t\t\tdates.not( this ).datepicker( \"option\", option, date );\r\n\t\t\t}\r\n\t\t});\r\n\t});\r\n</script>";
                    $input .= "<input type=\"text\" class=\"form-control\"  name=\"customfield[" . $id . "]" . "\"\r\n             id=\"customfield" . $id . "\" value=\"" . $customfieldval . "\">";
                } else {
                    if ($fieldtype == "time") {
                        $input = "  <script type=\"text/javascript\" src=\"includes/js/jquery.timeentry.js\"></script>\r\n        <script type=\"text/javascript\">\r\n        \$(function(){\r\n        \t\$('#customfield" . $id . "').timeEntry();\r\n        });\r\n        </script>";
                        $input .= "<input type=\"text\" class=\"form-control\"  name=\"customfield[" . $id . "]" . "\"\r\n             id=\"customfield" . $id . "\" value=\"" . $customfieldval . "\">";
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
                                    $input = "<input class=\"form-check-input\" type=\"checkbox\" name=\"customfield[" . $id . "]" . "\" id=\"customfield" . $id . "\"";
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
        $customfields[] = ["id" => $id, "name" => $fieldname, "description" => $description, "input" => $input, "type" => $fieldtype, "value" => $customfieldval, "rawvalue" => $customfieldvalraw, "required" => $required];
    }
    return $customfields;
}
function createConfigFields($name, $description, $input, $type, $value, $required, $options = "", $showonorder = false)
{
    $arr["name"] = $name;
    $arr["description"] = $description;
    $arr["input"] = $input;
    $arr["type"] = $type;
    $arr["value"] = $value;
    $arr["required"] = $required;
    $arr["options"] = $options;
    $arr["showonorder"] = $showonorder;
    return $arr;
}
function itemConfigFields($itemtype)
{
    $COnfig["imei"][] = createconfigfields("Allow Bulk", "Multiple IMEI separated by new line", "bulk", "checkbox", "1", "1", "", true);
    $COnfig["imei"][] = createconfigfields("Qnt Range", "Qnt Range", "qntrange", "dropdown", "", "", ["5" => 5, "10" => 10, "15" => 15, "20" => 20, "25" => 25], true);
    $COnfig["imei"][] = createconfigfields("Address", "Address ", "address", "textarea", "", "", "", true);
    $COnfig["imei"][] = createconfigfields("Password", "Password ", "password", "password", "", "", "", true);
    $COnfig["license"][] = createconfigfields("Prefix", "License Prefix", "licenseprefix", "text", "", "");
    $COnfig["license"][] = createconfigfields("License Key Format", "License Key Format", "licensekeyforamt", "radio", "", "", ["auto" => "Auto", "manual" => "Manual"], "");
    $COnfig["license"][] = createconfigfields("IP/HW ID Bind", "Bind IP Range or Hardware unique id", "bindiphw", "checkbox", "1", "", "");
    $COnfig["license"][] = createconfigfields("Installed Directory Bind", "Bind with installed directory", "installeddir", "checkbox", "1", "", "");
    return $COnfig[$itemtype];
}
function is_base64($s)
{
    return (bool) preg_match("/^[a-zA-Z0-9\\/\\r\\n+]*={0,2}\$/", $s);
}
function convertProcesstoQuery($Process)
{
    $Process = trim($Process);
    if ($Process == "is") {
        return "='{VALUE}'";
    }
    if ($Process == "is not") {
        return "!='{VALUE}'";
    }
    if ($Process == "start with") {
        return " LIKE '{VALUE}%'";
    }
    if ($Process == "ends with") {
        return " LIKE '%{VALUE}'";
    }
    if ($Process == "contains") {
        return " LIKE '%{VALUE}%'";
    }
    if ($Process == "does not contains") {
        return " NOT LIKE '%{VALUE}%'";
    }
    if ($Process == "greater than") {
        return " >{VALUE}";
    }
    if ($Process == "less than") {
        return " <{VALUE}";
    }
    if ($Process == "is true") {
        return " =true";
    }
    if ($Process == "is false") {
        return " =false";
    }
    if ($Process == "more than") {
        return " >{VALUE}";
    }
}
function CreateWhere($search)
{
    $where = "";
    $filters = $search["filters"];
    $MainLogical = $search["mainLogical"];
    if (0 < count($filters)) {
        $where .= " WHERE (";
    }
    foreach ($filters as $stype) {
        $where .= " (";
        $logics = $stype["logical"];
        foreach ($stype["filterColumns"] as $columns) {
            $where .= " " . $columns["columnName"] . str_replace("{VALUE}", $columns["value"], convertprocesstoquery($columns["process"]));
            $where .= " " . $logics;
        }
        $where = rtrim($where, $logics);
        $where .= ") " . $MainLogical;
    }
    $where = rtrim($where, $MainLogical);
    if (0 < count($filters)) {
        $where .= ")";
    }
    $where = trim($where);
    return $where;
}
function safe_json_encodenew($ARRAY)
{
    return json_encode(utf8izenew($ARRAY), JSON_UNESCAPED_UNICODE);
}
function utf8izenew($d)
{
    if (is_array($d)) {
        foreach ($d as $k => $v) {
            $d[$k] = utf8izenew($v);
        }
    } else {
        if (is_object($d)) {
            foreach ($d as $k => $v) {
                $d->{$k} = utf8izenew($v);
            }
        } else {
            return utf8_encode($d);
        }
    }
    return $d;
}
function getRoundoff()
{
    $_RETURN["auto"] = "Auto";
    $_RETURN["up"] = "Rounds Up";
    $_RETURN["down"] = "Rounds Down";
    $_RETURN["none"] = "None";
    return $_RETURN;
}
function isJson($string)
{
    json_decode($string);
    return json_last_error() == JSON_ERROR_NONE;
}
function getDateformats()
{
    $_RETURN[] = "dd/mm/yyyy";
    $_RETURN[] = "dd/mm/yy";
    return $_RETURN;
}
function getFormatofField()
{
    return ["integer", "string", "flout", "json"];
}
function getFieldType()
{
    return ["text", "checkbox", "checkboxgroup", "dropdown"];
}
function getState($countryCode)
{
    if (file_exists(ROOTDIR . "/functions/static/states/" . $countryCode . ".json")) {
        return json_decode(file_get_contents(ROOTDIR . "/functions/static/states/" . $countryCode . ".json"), true);
    }
    return NULL;
}
function getCountry()
{
    if (file_exists(ROOTDIR . "/functions/static/country.json")) {
        return json_decode(file_get_contents(ROOTDIR . "/functions/static/country.json"), true);
    }
    return NULL;
}
function randkey($length, $integer = false)
{
    if ($integer) {
        $characters = "1234567890";
    } else {
        $characters = "123456789ABCDEFGHIJKLMNPQRSTUVWXYZ";
    }
    $string = "";
    for ($p = 0; $p < $length; $p++) {
        $string .= $characters[mt_rand(0, strlen($characters))];
    }
    return $string;
}
function formatCurrency($amount, $currency = "")
{
    $amount = money_format("%!i", $amount);
    $currencies = getCurrency(true);
    if (!$currencies[$currency][0]) {
        $currencies[$currency][0] = $currency;
    }
    if ($currencies[$currency][4] === 1) {
        $amount .= $currencies[$currency][0];
    } else {
        $amount = $currencies[$currency][0] . $amount;
    }
    return $amount;
}
function getCurrency($raw = false, $code = "")
{
    $currencies = ["ARS" => [NULL, 2, ",", ".", 0, "Argentine Peso"], "AMD" => [NULL, 2, ".", ",", 0, "Armenian Dram"], "AWG" => [NULL, 2, ".", ",", 0, "Aruban Guilder"], "AUD" => ["AU\$", 2, ".", "", 0, "Australian Dollar"], "BSD" => [NULL, 2, ".", ",", 0, "Bahamian Dollar"], "BHD" => [NULL, 3, ".", ",", 0, "Bahraini Dinar"], "BDT" => [NULL, 2, ".", ",", 0, "Bangladesh, Taka"], "BZD" => [NULL, 2, ".", ",", 0, "Belize Dollar"], "BMD" => [NULL, 2, ".", ",", 0, "Bermudian Dollar"], "BOB" => [NULL, 2, ".", ",", 0, "Bolivia, Boliviano"], "BAM" => [NULL, 2, ".", ",", 0, "Bosnia and Herzegovina, Convertible Marks"], "BWP" => [NULL, 2, ".", ",", 0, "Botswana, Pula"], "BRL" => ["R\$", 2, ",", ".", 0, "Brazilian Real"], "BND" => [NULL, 2, ".", ",", 0, "Brunei Dollar"], "CAD" => ["CA\$", 2, ".", ",", 0, "Canadian Dollar"], "KYD" => [NULL, 2, ".", ",", 0, "Cayman Islands Dollar"], "CLP" => [NULL, 0, "", ".", 0, "Chilean Peso"], "CNY" => ["CN&yen;", 2, ".", ",", 0, "China Yuan Renminbi"], "COP" => [NULL, 2, ",", ".", 0, "Colombian Peso"], "CRC" => [NULL, 2, ",", ".", 0, "Costa Rican Colon"], "HRK" => [NULL, 2, ",", ".", 0, "Croatian Kuna"], "CUC" => [NULL, 2, ".", ",", 0, "Cuban Convertible Peso"], "CUP" => [NULL, 2, ".", ",", 0, "Cuban Peso"], "CYP" => [NULL, 2, ".", ",", 0, "Cyprus Pound"], "CZK" => ["K&#269;", 0, "", "", 1, "Czech Koruna"], "DKK" => [NULL, 2, ",", ".", 0, "Danish Krone"], "DOP" => [NULL, 2, ".", ",", 0, "Dominican Peso"], "XCD" => ["EC\$", 2, ".", ",", 0, "East Caribbean Dollar"], "EGP" => [NULL, 2, ".", ",", 0, "Egyptian Pound"], "SVC" => [NULL, 2, ".", ",", 0, "El Salvador Colon"], "EUR" => ["&euro;", 2, ",", ".", 0, "Euro"], "ESP" => ["&euro;", 2, ",", ".", 1, "Euro in spanish format"], "GHC" => [NULL, 2, ".", ",", 0, "Ghana, Cedi"], "GIP" => [NULL, 2, ".", ",", 0, "Gibraltar Pound"], "GTQ" => [NULL, 2, ".", ",", 0, "Guatemala, Quetzal"], "HNL" => [NULL, 2, ".", ",", 0, "Honduras, Lempira"], "HKD" => ["HK\$", 2, ".", ",", 0, "Hong Kong Dollar"], "HUF" => ["HK\$", 0, "", ".", 0, "Hungary, Forint"], "ISK" => ["kr", 0, "", ".", 1, "Iceland Krona"], "INR" => ["&#2352;", 2, ".", ",", 0, "Indian Rupee"], "IDR" => [NULL, 2, ",", ".", 0, "Indonesia, Rupiah"], "IRR" => [NULL, 2, ".", ",", 0, "Iranian Rial"], "JMD" => [NULL, 2, ".", ",", 0, "Jamaican Dollar"], "JPY" => ["&yen;", 0, "", ",", 0, "Japan, Yen"], "JOD" => [NULL, 3, ".", ",", 0, "Jordanian Dinar"], "KES" => [NULL, 2, ".", ",", 0, "Kenyan Shilling"], "KWD" => [NULL, 3, ".", ",", 0, "Kuwaiti Dinar"], "LVL" => [NULL, 2, ".", ",", 0, "Latvian Lats"], "LBP" => [NULL, 0, "", "", 0, "Lebanese Pound"], "LTL" => ["Lt", 2, ",", "", 1, "Lithuanian Litas"], "MKD" => [NULL, 2, ".", ",", 0, "Macedonia, Denar"], "MYR" => [NULL, 2, ".", ",", 0, "Malaysian Ringgit"], "MTL" => [NULL, 2, ".", ",", 0, "Maltese Lira"], "MUR" => [NULL, 0, "", ",", 0, "Mauritius Rupee"], "MXN" => ["MX\$", 2, ".", ",", 0, "Mexican Peso"], "MZM" => [NULL, 2, ",", ".", 0, "Mozambique Metical"], "NPR" => [NULL, 2, ".", ",", 0, "Nepalese Rupee"], "ANG" => [NULL, 2, ".", ",", 0, "Netherlands Antillian Guilder"], "ILS" => ["&#8362;", 2, ".", ",", 0, "New Israeli Shekel ?"], "TRY" => [NULL, 2, ".", ",", 0, "New Turkish Lira"], "NZD" => ["NZ\$", 2, ".", ",", 0, "New Zealand Dollar"], "NOK" => ["kr", 2, ",", ".", 1, "Norwegian Krone"], "PKR" => [NULL, 2, ".", ",", 0, "Pakistan Rupee"], "PEN" => [NULL, 2, ".", ",", 0, "Peru, Nuevo Sol"], "UYU" => [NULL, 2, ",", ".", 0, "Peso Uruguayo"], "PHP" => [NULL, 2, ".", ",", 0, "Philippine Peso"], "PLN" => [" zl", 2, ".", "", 1, "Poland, Zloty"], "GBP" => ["&pound;", 2, ".", ",", 0, "Pound Sterling"], "OMR" => [NULL, 3, ".", ",", 0, "Rial Omani"], "RON" => [NULL, 2, ",", ".", 0, "Romania, New Leu"], "ROL" => [NULL, 2, ",", ".", 0, "Romania, Old Leu"], "RUB" => [NULL, 2, ",", ".", 0, "Russian Ruble"], "SAR" => [NULL, 2, ".", ",", 0, "Saudi Riyal"], "SGD" => [NULL, 2, ".", ",", 0, "Singapore Dollar"], "SKK" => [NULL, 2, ",", "", 0, "Slovak Koruna"], "SIT" => [NULL, 2, ",", ".", 0, "Slovenia, Tolar"], "ZAR" => ["R", 2, ".", "", 0, "South Africa, Rand"], "KRW" => ["&#8361;", 0, "", ",", 0, "South Korea, Won ?"], "SZL" => [NULL, 2, ".", ", ", 0, "Swaziland, Lilangeni"], "SEK" => ["kr", 2, ",", ".", 1, "Swedish Krona"], "CHF" => ["SFr ", 2, ".", "'", 0, "Swiss Franc "], "TZS" => [NULL, 2, ".", ",", 0, "Tanzanian Shilling"], "THB" => ["&#3647;", 2, ".", ",", 1, "Thailand, Baht ?"], "TOP" => [NULL, 2, ".", ",", 0, "Tonga, Paanga"], "AED" => [NULL, 2, ".", ",", 0, "UAE Dirham"], "UAH" => [NULL, 2, ",", "", 0, "Ukraine, Hryvnia"], "USD" => ["\$", 2, ".", ",", 0, "US Dollar"], "VUV" => [NULL, 0, "", ",", 0, "Vanuatu, Vatu"], "VEF" => [NULL, 2, ",", ".", 0, "Venezuela Bolivares Fuertes"], "VEB" => [NULL, 2, ",", ".", 0, "Venezuela, Bolivar"], "VND" => ["&#x20ab;", 0, "", ".", 0, "Viet Nam, Dong ?"], "ZWD" => [NULL, 2, ".", " ", 0, "Zimbabwe Dollar"]];
    if ($code) {
        return $currencies[$code];
    }
    if ($raw) {
        return $currencies;
    }
    foreach ($currencies as $code => $curval) {
        $returncurrency[$code] = $code . " - " . $curval[5];
    }
    return $returncurrency;
}
function getLocalefromCountryCode($country)
{
    $locale = json_decode("{\"AF\":\"prs_AF\",\"AL\":\"sq_AL\",\"DZ\":\"ar_DZ\",\"AR\":\"es_AR\",\"AM\":\"hy_AM\",\"AU\":\"en_AU\",\"AT\":\"de_AT\",\"AZ\":\"az_AZ\",\"BH\":\"ar_BH\",\"BD\":\"bn_BD\",\"BY\":\"be_BY\",\"BE\":\"fr_BE\",\"BZ\":\"en_BZ\",\"BO\":\"es_BO\",\"BA\":\"bs_BA\",\"BR\":\"pt_BR\",\"BN\":\"ms_BN\",\"BG\":\"bg_BG\",\"KH\":\"km_KH\",\"CA\":\"en_CA\",\"CL\":\"arn_CL\",\"CN\":\"bo_CN\",\"CO\":\"es_CO\",\"CR\":\"es_CR\",\"HR\":\"hr_HR\",\"CZ\":\"cs_CZ\",\"DK\":\"da_DK\",\"DO\":\"es_DO\",\"EC\":\"es_EC\",\"EG\":\"ar_EG\",\"SV\":\"es_SV\",\"EE\":\"et_EE\",\"ET\":\"am_ET\",\"FO\":\"fo_FO\",\"FI\":\"fi_FI\",\"FR\":\"br_FR\",\"GE\":\"ka_GE\",\"DE\":\"de_DE\",\"GR\":\"el_GR\",\"GL\":\"kl_GL\",\"GT\":\"es_GT\",\"HN\":\"es_HN\",\"HK\":\"zh_HK\",\"HU\":\"hu_HU\",\"IS\":\"is_IS\",\"IN\":\"as_IN\",\"ID\":\"id_ID\",\"IR\":\"fa_IR\",\"IQ\":\"ar_IQ\",\"IE\":\"en_IE\",\"IL\":\"he_IL\",\"IT\":\"it_IT\",\"JM\":\"en_JM\",\"JP\":\"ja_JP\",\"JO\":\"ar_JO\",\"KZ\":\"kk_KZ\",\"KE\":\"sw_KE\",\"KW\":\"ar_KW\",\"KG\":\"ky_KG\",\"LA\":\"lo_LA\",\"LV\":\"lv_LV\",\"LB\":\"ar_LB\",\"LY\":\"ar_LY\",\"LI\":\"de_LI\",\"LT\":\"lt_LT\",\"LU\":\"de_LU\",\"MO\":\"zh_MO\",\"MK\":\"mk_MK\",\"MY\":\"en_MY\",\"MV\":\"dv_MV\",\"MT\":\"mt_MT\",\"MX\":\"es_MX\",\"MC\":\"fr_MC\",\"MN\":\"mn_MN\",\"ME\":\"sr_ME\",\"MA\":\"ar_MA\",\"NP\":\"ne_NP\",\"NL\":\"fy_NL\",\"NZ\":\"en_NZ\",\"NI\":\"es_NI\",\"NG\":\"ha_NG\",\"NO\":\"nb_NO\",\"OM\":\"ar_OM\",\"PK\":\"ur_PK\",\"PA\":\"es_PA\",\"PY\":\"es_PY\",\"PE\":\"es_PE\",\"PH\":\"en_PH\",\"PL\":\"pl_PL\",\"PT\":\"pt_PT\",\"PR\":\"es_PR\",\"QA\":\"ar_QA\",\"RO\":\"ro_RO\",\"RU\":\"ba_RU\",\"RW\":\"rw_RW\",\"SA\":\"ar_SA\",\"SN\":\"wo_SN\",\"RS\":\"sr_RS\",\"CS\":\"sr_CS\",\"SG\":\"en_SG\",\"SK\":\"sk_SK\",\"SI\":\"sl_SI\",\"ZA\":\"af_ZA\",\"KR\":\"ko_KR\",\"ES\":\"ca_ES\",\"LK\":\"si_LK\",\"SE\":\"se_SE\",\"CH\":\"de_CH\",\"SY\":\"ar_SY\",\"TW\":\"zh_TW\",\"TJ\":\"tg_TJ\",\"TH\":\"th_TH\",\"TT\":\"en_TT\",\"TN\":\"ar_TN\",\"TR\":\"tr_TR\",\"TM\":\"tk_TM\",\"UA\":\"uk_UA\",\"AE\":\"ar_AE\",\"GB\":\"cy_GB\",\"US\":\"en_US\",\"UY\":\"es_UY\",\"UZ\":\"uz_UZ\"\r\n    ,\"VE\":\"es_VE\",\"VN\":\"vi_VN\",\"YE\":\"ar_YE\",\"ZW\":\"en_ZW\"}", true);
    return $locale[$country];
}
function getCurrencyByCountry($countrycode)
{
    $curbycon = json_decode("{\"BD\": \"BDT\", \"BE\": \"EUR\", \"BF\": \"XOF\", \"BG\": \"BGN\",\r\n     \"BA\": \"BAM\", \"BB\": \"BBD\", \"WF\": \"XPF\", \"BL\": \"EUR\", \"BM\": \"BMD\", \"BN\": \"BND\", \"BO\": \"BOB\", \"BH\": \"BHD\", \"BI\": \"BIF\", \"BJ\": \"XOF\", \"BT\": \"BTN\", \"JM\": \"JMD\", \"BV\": \"NOK\", \"BW\": \"BWP\", \"WS\": \"WST\", \"BQ\": \"USD\", \"BR\": \"BRL\", \"BS\": \"BSD\", \"JE\": \"GBP\", \"BY\": \"BYR\", \"BZ\": \"BZD\", \"RU\": \"RUB\", \"RW\": \"RWF\", \"RS\": \"RSD\", \"TL\": \"USD\", \"RE\": \"EUR\", \"TM\": \"TMT\", \"TJ\": \"TJS\", \"RO\": \"RON\", \"TK\": \"NZD\", \"GW\": \"XOF\", \"GU\": \"USD\", \"GT\": \"GTQ\", \"GS\": \"GBP\", \"GR\": \"EUR\", \"GQ\": \"XAF\", \"GP\": \"EUR\", \"JP\": \"JPY\", \"GY\": \"GYD\", \"GG\": \"GBP\", \"GF\": \"EUR\", \"GE\": \"GEL\", \"GD\": \"XCD\", \"GB\": \"GBP\", \"GA\": \"XAF\", \"SV\": \"USD\", \"GN\": \"GNF\", \"GM\": \"GMD\", \"GL\": \"DKK\", \"GI\": \"GIP\", \"GH\": \"GHS\", \"OM\": \"OMR\", \"TN\": \"TND\", \"JO\": \"JOD\", \"HR\": \"HRK\", \"HT\": \"HTG\", \"HU\": \"HUF\", \"HK\": \"HKD\", \"HN\": \"HNL\", \"HM\": \"AUD\", \"VE\": \"VEF\", \"PR\": \"USD\", \"PS\": \"ILS\", \"PW\": \"USD\", \"PT\": \"EUR\", \"SJ\": \"NOK\", \"PY\": \"PYG\", \"IQ\": \"IQD\", \"PA\": \"PAB\", \"PF\": \"XPF\", \"PG\": \"PGK\", \"PE\": \"PEN\", \"PK\": \"PKR\", \"PH\": \"PHP\", \"PN\": \"NZD\", \"PL\": \"PLN\", \"PM\": \"EUR\", \"ZM\": \"ZMK\", \"EH\": \"MAD\", \"EE\": \"EUR\", \"EG\": \"EGP\", \"ZA\": \"ZAR\", \"EC\": \"USD\", \"IT\": \"EUR\", \"VN\": \"VND\", \"SB\": \"SBD\", \"ET\": \"ETB\", \"SO\": \"SOS\", \"ZW\": \"ZWL\", \"SA\": \"SAR\", \"ES\": \"EUR\", \"ER\": \"ERN\", \"ME\": \"EUR\", \"MD\": \"MDL\", \"MG\": \"MGA\", \"MF\": \"EUR\", \"MA\": \"MAD\", \"MC\": \"EUR\", \"UZ\": \"UZS\", \"MM\": \"MMK\", \"ML\": \"XOF\", \"MO\": \"MOP\", \"MN\": \"MNT\", \"MH\": \"USD\", \"MK\": \"MKD\", \"MU\": \"MUR\", \"MT\": \"EUR\", \"MW\": \"MWK\", \"MV\": \"MVR\", \"MQ\": \"EUR\", \"MP\": \"USD\", \"MS\": \"XCD\", \"MR\": \"MRO\", \"IM\": \"GBP\", \"UG\": \"UGX\", \"TZ\": \"TZS\", \"MY\": \"MYR\", \"MX\": \"MXN\", \"IL\": \"ILS\", \"FR\": \"EUR\", \"IO\": \"USD\", \"SH\": \"SHP\", \"FI\": \"EUR\", \"FJ\": \"FJD\", \"FK\": \"FKP\", \"FM\": \"USD\", \"FO\": \"DKK\", \"NI\": \"NIO\", \"NL\": \"EUR\", \"NO\": \"NOK\", \"NA\": \"NAD\", \"VU\": \"VUV\", \"NC\": \"XPF\", \"NE\": \"XOF\", \"NF\": \"AUD\", \"NG\": \"NGN\", \"NZ\": \"NZD\", \"NP\": \"NPR\", \"NR\": \"AUD\", \"NU\": \"NZD\", \"CK\": \"NZD\", \"XK\": \"EUR\", \"CI\": \"XOF\", \"CH\": \"CHF\", \"CO\": \"COP\", \"CN\": \"CNY\", \"CM\": \"XAF\", \"CL\": \"CLP\", \"CC\": \"AUD\", \"CA\": \"CAD\", \"CG\": \"XAF\", \"CF\": \"XAF\", \"CD\": \"CDF\", \"CZ\": \"CZK\", \"CY\": \"EUR\", \"CX\": \"AUD\", \"CR\": \"CRC\", \"CW\": \"ANG\", \"CV\": \"CVE\", \"CU\": \"CUP\", \"SZ\": \"SZL\", \"SY\": \"SYP\", \"SX\": \"ANG\", \"KG\": \"KGS\", \"KE\": \"KES\", \"SS\": \"SSP\", \"SR\": \"SRD\", \"KI\": \"AUD\", \"KH\": \"KHR\", \"KN\": \"XCD\", \"KM\": \"KMF\", \"ST\": \"STD\", \"SK\": \"EUR\", \"KR\": \"KRW\", \"SI\": \"EUR\", \"KP\": \"KPW\", \"KW\": \"KWD\", \"SN\": \"XOF\", \"SM\": \"EUR\", \"SL\": \"SLL\", \"SC\": \"SCR\", \"KZ\": \"KZT\", \"KY\": \"KYD\", \"SG\": \"SGD\", \"SE\": \"SEK\", \"SD\": \"SDG\", \"DO\": \"DOP\", \"DM\": \"XCD\", \"DJ\": \"DJF\", \"DK\": \"DKK\", \"VG\": \"USD\", \"DE\": \"EUR\", \"YE\": \"YER\", \"DZ\": \"DZD\", \"US\": \"USD\", \"UY\": \"UYU\", \"YT\": \"EUR\", \"UM\": \"USD\", \"LB\": \"LBP\", \"LC\": \"XCD\", \"LA\": \"LAK\", \"TV\": \"AUD\", \"TW\": \"TWD\", \"TT\": \"TTD\", \"TR\": \"TRY\", \"LK\": \"LKR\", \"LI\": \"CHF\", \"LV\": \"EUR\", \"TO\": \"TOP\", \"LT\": \"LTL\", \"LU\": \"EUR\", \"LR\": \"LRD\", \"LS\": \"LSL\", \"TH\": \"THB\", \"TF\": \"EUR\", \"TG\": \"XOF\", \"TD\": \"XAF\", \"TC\": \"USD\", \"LY\": \"LYD\", \"VA\": \"EUR\", \"VC\": \"XCD\", \"AE\": \"AED\", \"AD\": \"EUR\", \"AG\": \"XCD\", \"AF\": \"AFN\", \"AI\": \"XCD\", \"VI\": \"USD\", \"IS\": \"ISK\", \"IR\": \"IRR\", \"AM\": \"AMD\", \"AL\": \"ALL\", \"AO\": \"AOA\", \"AQ\": \"\", \"AS\": \"USD\", \"AR\": \"ARS\", \"AU\": \"AUD\", \"AT\": \"EUR\", \"AW\": \"AWG\", \"IN\": \"INR\", \"AX\": \"EUR\", \"AZ\": \"AZN\",\r\n     \"IE\": \"EUR\", \"ID\": \"IDR\", \"UA\": \"UAH\", \"QA\": \"QAR\", \"MZ\": \"MZN\"}", true);
    return $curbycon[$countrycode];
}
function countryList()
{
    $countries = ["AF" => "Afghanistan", "AX" => "Aland Islands", "AL" => "Albania", "DZ" => "Algeria", "AS" => "American Samoa", "AD" => "Andorra", "AO" => "Angola", "AI" => "Anguilla", "AQ" => "Antarctica", "AG" => "Antigua And Barbuda", "AR" => "Argentina", "AM" => "Armenia", "AW" => "Aruba", "AU" => "Australia", "AT" => "Austria", "AZ" => "Azerbaijan", "BS" => "Bahamas", "BH" => "Bahrain", "BD" => "Bangladesh", "BB" => "Barbados", "BY" => "Belarus", "BE" => "Belgium", "BZ" => "Belize", "BJ" => "Benin", "BM" => "Bermuda", "BT" => "Bhutan", "BO" => "Bolivia", "BA" => "Bosnia And Herzegovina", "BW" => "Botswana", "BV" => "Bouvet Island", "BR" => "Brazil", "IO" => "British Indian Ocean Territory", "BN" => "Brunei Darussalam", "BG" => "Bulgaria", "BF" => "Burkina Faso", "BI" => "Burundi", "KH" => "Cambodia", "CM" => "Cameroon", "CA" => "Canada", "CV" => "Cape Verde", "KY" => "Cayman Islands", "CF" => "Central African Republic", "TD" => "Chad", "CL" => "Chile", "CN" => "China", "CX" => "Christmas Island", "CC" => "Cocos (Keeling) Islands", "CO" => "Colombia", "KM" => "Comoros", "CG" => "Congo", "CD" => "Congo, Democratic Republic", "CK" => "Cook Islands", "CR" => "Costa Rica", "CI" => "Cote D'Ivoire", "HR" => "Croatia", "CU" => "Cuba", "CY" => "Cyprus", "CZ" => "Czech Republic", "DK" => "Denmark", "DJ" => "Djibouti", "DM" => "Dominica", "DO" => "Dominican Republic", "EC" => "Ecuador", "EG" => "Egypt", "SV" => "El Salvador", "GQ" => "Equatorial Guinea", "ER" => "Eritrea", "EE" => "Estonia", "ET" => "Ethiopia", "FK" => "Falkland Islands (Malvinas)", "FO" => "Faroe Islands", "FJ" => "Fiji", "FI" => "Finland", "FR" => "France", "GF" => "French Guiana", "PF" => "French Polynesia", "TF" => "French Southern Territories", "GA" => "Gabon", "GM" => "Gambia", "GE" => "Georgia", "DE" => "Germany", "GH" => "Ghana", "GI" => "Gibraltar", "GR" => "Greece", "GL" => "Greenland", "GD" => "Grenada", "GP" => "Guadeloupe", "GU" => "Guam", "GT" => "Guatemala", "GG" => "Guernsey", "GN" => "Guinea", "GW" => "Guinea-Bissau", "GY" => "Guyana", "HT" => "Haiti", "HM" => "Heard Island & Mcdonald Islands", "VA" => "Holy See (Vatican City State)", "HN" => "Honduras", "HK" => "Hong Kong", "HU" => "Hungary", "IS" => "Iceland", "IN" => "India", "ID" => "Indonesia", "IR" => "Iran, Islamic Republic Of", "IQ" => "Iraq", "IE" => "Ireland", "IM" => "Isle Of Man", "IL" => "Israel", "IT" => "Italy", "JM" => "Jamaica", "JP" => "Japan", "JE" => "Jersey", "JO" => "Jordan", "KZ" => "Kazakhstan", "KE" => "Kenya", "KI" => "Kiribati", "KR" => "Korea", "KW" => "Kuwait", "KG" => "Kyrgyzstan", "LA" => "Lao People's Democratic Republic", "LV" => "Latvia", "LB" => "Lebanon", "LS" => "Lesotho", "LR" => "Liberia", "LY" => "Libyan Arab Jamahiriya", "LI" => "Liechtenstein", "LT" => "Lithuania", "LU" => "Luxembourg", "MO" => "Macao", "MK" => "Macedonia", "MG" => "Madagascar", "MW" => "Malawi", "MY" => "Malaysia", "MV" => "Maldives", "ML" => "Mali", "MT" => "Malta", "MH" => "Marshall Islands", "MQ" => "Martinique", "MR" => "Mauritania", "MU" => "Mauritius", "YT" => "Mayotte", "MX" => "Mexico", "FM" => "Micronesia, Federated States Of", "MD" => "Moldova", "MC" => "Monaco", "MN" => "Mongolia", "ME" => "Montenegro", "MS" => "Montserrat", "MA" => "Morocco", "MZ" => "Mozambique", "MM" => "Myanmar", "NA" => "Namibia", "NR" => "Nauru", "NP" => "Nepal", "NL" => "Netherlands", "AN" => "Netherlands Antilles", "NC" => "New Caledonia", "NZ" => "New Zealand", "NI" => "Nicaragua", "NE" => "Niger", "NG" => "Nigeria", "NU" => "Niue", "NF" => "Norfolk Island", "MP" => "Northern Mariana Islands", "NO" => "Norway", "OM" => "Oman", "PK" => "Pakistan", "PW" => "Palau", "PS" => "Palestinian Territory, Occupied", "PA" => "Panama", "PG" => "Papua New Guinea", "PY" => "Paraguay", "PE" => "Peru", "PH" => "Philippines", "PN" => "Pitcairn", "PL" => "Poland", "PT" => "Portugal", "PR" => "Puerto Rico", "QA" => "Qatar", "RE" => "Reunion", "RO" => "Romania", "RU" => "Russian Federation", "RW" => "Rwanda", "BL" => "Saint Barthelemy", "SH" => "Saint Helena", "KN" => "Saint Kitts And Nevis", "LC" => "Saint Lucia", "MF" => "Saint Martin", "PM" => "Saint Pierre And Miquelon", "VC" => "Saint Vincent And Grenadines", "WS" => "Samoa", "SM" => "San Marino", "ST" => "Sao Tome And Principe", "SA" => "Saudi Arabia", "SN" => "Senegal", "RS" => "Serbia", "SC" => "Seychelles", "SL" => "Sierra Leone", "SG" => "Singapore", "SK" => "Slovakia", "SI" => "Slovenia", "SB" => "Solomon Islands", "SO" => "Somalia", "ZA" => "South Africa", "GS" => "South Georgia And Sandwich Isl.", "ES" => "Spain", "LK" => "Sri Lanka", "SD" => "Sudan", "SR" => "Suriname", "SJ" => "Svalbard And Jan Mayen", "SZ" => "Swaziland", "SE" => "Sweden", "CH" => "Switzerland", "SY" => "Syrian Arab Republic", "TW" => "Taiwan", "TJ" => "Tajikistan", "TZ" => "Tanzania", "TH" => "Thailand", "TL" => "Timor-Leste", "TG" => "Togo", "TK" => "Tokelau", "TO" => "Tonga", "TT" => "Trinidad And Tobago", "TN" => "Tunisia", "TR" => "Turkey", "TM" => "Turkmenistan", "TC" => "Turks And Caicos Islands", "TV" => "Tuvalu", "UG" => "Uganda", "UA" => "Ukraine", "AE" => "United Arab Emirates", "GB" => "United Kingdom", "US" => "United States", "UM" => "United States Outlying Islands", "UY" => "Uruguay", "UZ" => "Uzbekistan", "VU" => "Vanuatu", "VE" => "Venezuela", "VN" => "Viet Nam", "VG" => "Virgin Islands, British", "VI" => "Virgin Islands, U.S.", "WF" => "Wallis And Futuna", "EH" => "Western Sahara", "YE" => "Yemen", "ZM" => "Zambia", "ZW" => "Zimbabwe", "XK" => "Kosovo"];
    asort($countries);
    return $countries;
}

?>