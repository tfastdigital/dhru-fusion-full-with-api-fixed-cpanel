<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

if (!defined("REL_PATH")) {
    define("REL_PATH", "");
}
define("API_SITE_TITLE", "Mepserver API example");
define("API_SITE_CSS", "");
define("API_SITE_JS", REL_PATH . "mepserver_api_javascript.js");
define("API_SITE_FORM_ELEMENTS_WRAPPER", "<div><label>%s</label><br />%s</div>");
define("API_SITE_TEMPLATE", mepserver_read_template());
define("API_DISPLAY_ALCATEL", true);
define("API_DISPLAY_PANTECH", true);
define("API_DISPLAY_ZTE", true);
define("API_DISPLAY_BB", true);
define("API_USE_DATABASE", false);
define("API_MYSQL_HOST", "");
define("API_MYSQL_USER", "");
define("API_MYSQL_PASS", "");
define("API_MYSQL_DB", "");
define("API_MYSQL_TABLE", "");
function mepserver_read_template()
{
    $filename = REL_PATH . "mepserver_api_template.html";
    $handle = fopen($filename, "r");
    $template_content = fread($handle, filesize($filename));
    fclose($handle);
    return $template_content;
}
function mepserver_add_form_start($action, $name, $method, $javascript = "")
{
    return "<form action=\"" . $action . "\" name=\"" . $name . "\" method=\"" . $method . "\"" . (!empty($javascript) ? "onsubmit=\"" . $javascript . "\"" : "") . "autocomplete=\"off\">" . "\n";
}
function mepserver_add_form_end()
{
    return "\t\t</form>\n";
}
function mepserver_add_textarea_field($label, $field_name, $extra_html = "")
{
    return sprintf(API_SITE_FORM_ELEMENTS_WRAPPER, $label, "<textarea name=\"" . $field_name . "\"" . (!empty($extra_html) ? " " . $extra_html : "") . "></textarea>");
}
function mepserver_add_text_field($label, $field_name, $extra_html = "")
{
    return sprintf(API_SITE_FORM_ELEMENTS_WRAPPER, $label, "<input type=\"text\" name=\"" . $field_name . "\"" . (!empty($extra_html) ? " " . $extra_html : "") . " value=\"" . mepserver_populate_field($field_name) . "\"/>");
}
function mepserver_add_select_field($label, $field_name, $values_array, $extra_html = "")
{
    $select = "<select name=\"" . $field_name . "\"" . (!empty($extra_html) ? " " . $extra_html : "") . ">" . "\n" . "\t\t\t\t\t<option value=\"0\">" . mepserver_populate_field($field_name) . "</option>" . "\n";
    if (is_array($values_array) && 0 < count($values_array)) {
        foreach ($values_array as $key => $value) {
            $select .= "\t\t\t\t\t<option value=\"" . $key . "\">" . $value . "</option>" . "\n";
        }
    }
    $select .= "\t\t\t\t</select>";
    return sprintf(API_SITE_FORM_ELEMENTS_WRAPPER, $label, $select);
}
function mepserver_add_button_field($type, $field_name, $extra_html = "")
{
    return sprintf(API_SITE_FORM_ELEMENTS_WRAPPER, "&nbsp;", "<input type=\"submit\" name=\"simple\" value=\"" . mepserver_populate_field($field_name) . "\" /><input type=\"hidden\" name=\"type\" value=\"" . $type . "\" />");
}
function mepserver_populate_field($field_name)
{
    global $default_values;
    if (is_array($default_values) && isset($default_values[$field_name])) {
        return stripslashes($default_values[$field_name]);
    }
    return "";
}
function mepserver_create_template($content)
{
    $css_file = API_SITE_CSS;
    if (!empty($css_file)) {
        $css_file = "<link rel=\"stylesheet\" href=\"" . $css_file . "\" type=\"text/css\" media=\"screen\" />";
    }
    $js_file = API_SITE_JS;
    if (!empty($js_file)) {
        $js_file = "<script type=\"text/javascript\" src=\"" . $js_file . "\"></script>";
    }
    echo sprintf(API_SITE_TEMPLATE, API_SITE_TITLE, $css_file, $js_file, $content);
}
function mepserver_read_brands()
{
    $extra = implode("|", [(int) API_DISPLAY_ALCATEL, (int) API_DISPLAY_PANTECH, (int) API_DISPLAY_ZTE, (int) API_DISPLAY_BB]);
    $content = file_get_contents("http://mepserver.com/api_helpers/brands_list.php?extra=" . $extra);
    return unserialize($content);
}
function mepserver_read_countries()
{
    $content = file_get_contents("http://mepserver.com/api_helpers/countries_list.php");
    return unserialize($content);
}
function mepserver_read_meps()
{
    $content = file_get_contents("http://mepserver.com/api_helpers/meps_list.php");
    return unserialize($content);
}
function my_crypt($id, $ip, $contor)
{
    $LoginPasswordXORPass = "asirfhboDCNBdbvKJSVBADFvnfejkFBVBVJadfncdlkncdfN";
    $EncryptXORPass1 = "DCF569C01FFF5D032C72063FEA91D24559E3CCB53BCD293E4DC322C2437F08552D32310C5A70132F4281BF9A8C09AE54C463DCBD86AA";
    $EncryptXORPass2 = "3CA83D3BB954B5D31E265BA3F8761A81F1C74C360EEC8F5247B5A7B6C1EE1908254C353853A3A0A591FDDF360E0DCE162E56AA48A989";
    $p1 = base64_encode($id);
    $p2 = base64_encode($ip);
    $p3 = base64_encode($contor);
    $TempResult = $p1 . "[ || ]" . $p2 . "[ || ]" . $p3;
    $len1 = strlen($EncryptXORPass1) - 1;
    $len2 = strlen($EncryptXORPass2) - 1;
    for ($i = 0; $i <= strlen($TempResult) - 1; $i++) {
        $TempResult[$i] = $TempResult[$i] ^ $EncryptXORPass1[$i % $len1] ^ $EncryptXORPass2[$i % $len2 + 1];
    }
    $TempResult = gzdeflate($TempResult);
    for ($i = 0; $i <= strlen($TempResult) - 1; $i++) {
        $TempResult[$i] = $TempResult[$i] ^ $EncryptXORPass2[$i % $len2] ^ $EncryptXORPass1[$i % $len1 + 1];
    }
    $TempResult = base64_encode($TempResult);
    return strrev($TempResult);
}
function echo_pre($array)
{
    echo "<pre>";
    print_r($array);
    echo "</pre>";
}
function mepserver_mysql_conn($host, $db_user, $db_pass, $db)
{
    $con = mysqli_connect($host, $db_user, $db_pass, $db);
    if (!$con) {
        exit("Mysql connection failed: " . mysqli_error());
    }
    return $con;
}

?>