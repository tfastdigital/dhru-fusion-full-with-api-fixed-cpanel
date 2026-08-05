<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

namespace ns;

define("DEFINE_MY_ACCESS", true);
define("DEFINE_DHRU_FILE", true);
define("CLIENT", true);
define("SSLON", true);
require "comm.php";
require "includes/fun.inc.php";
require "includes/client.area.inc.php";
$currentpage = "htc";
$IMEI = preg_replace("/[^0-9]/i", "", $IMEI);
chkMd5sumsubpage();
echo "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Strict//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd\">\n<html xmlns=\"http://www.w3.org/1999/xhtml\">\n<head>\n<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />\n<title>HTC Service adviser</title>\n<style type=\"text/css\">\n\tbody {\n\t\tfont-family: \"Trebuchet MS\", Arial, Helvetica;\n\t\tfont-size: 15px;\n\t\tcolor: #333333;\n\t}\n\tinput {\n\t\tfont-size: 18px;\n\t}\n\t.error, .success {\n        position: relative;\n        margin: 0 0 15px 0;\n        padding: 0;\n        border: 1px solid;\n        background-position: 10px 11px !important;\n        background-repeat: no-repeat !important;\n        font-family:Arial, Helvetica, sans-serif;\n\t\tfont-size:12px;\n        width: 100%;\n\t\tmargin:auto;\n\t\ttext-align:left;\n        padding: 10px;\n\t}\n\t.error {\n        background: #ffcece;\n        border-color: #df8f8f;\n        color: #665252;\n\t}\n\t.success {\n        background: #d5ffce;\n        border-color: #9adf8f;\n        color: #556652;\n\t}\n    \n\t#header {\n\t\tfont-family: \"Trebuchet MS\", Arial, Helvetica;\n\t\tfont-size: 18px;\n\t\tfont-weight: bold;\n\t\tborder-bottom: 2px solid #eee;\n\t}\n\t\n\t#header img {\n\t\tmargin-right: 15px;\t\n\t}\n\t\n\t#header #unlock {\n\t\tcolor: #5588bb;\t\n\t}\n\t\n\t#header #base {\n\t\tcolor: #8b8b8b;\t\n\t}\n\t\n\t#header #tool {\n\t\tcolor: #3399cc;\t\n\t}\n\t\n\t#header #htc {\n\t\tcolor: #666666;\n\t}\n</style>\n</head>\n\n<body>\n\n\t<p id=\"header\"> <span id=\"unlock\">";
echo $config["site_name"];
echo "</span> <span id=\"tool\">HTC Service adviser</span><br />\n\n\t<span id=\"htc\">for HTC mobile phones</span></p>\n\t\n";
if (is_numeric($IMEI)) {
    $response = initCurl("http://www.unlockbase.com/xml/api/htc.php?IMEI=" . $IMEI);
    if ($response) {
        $response = new SimpleXMLElement($response);
        if ($response->Error) {
            echo "<div class='error'>" . $response->Error . "</div> <br />";
        } else {
            if ($response->Tool == "Bad IMEI" || $response->Tool == "No IMEI provided" || $response->Tool == "Bad IMEI") {
                echo "<div class='error'> " . $IMEI . " : " . $response->Tool . " </div> <br />";
            } else {
                if ($response->Tool == "None") {
                    echo "<div class='error'> Sorry no service found! for " . $_POST["IMEI"] . "</div> <br />";
                } else {
                    $_unlcokbaseserviceid = (string) $response->Tool;
                    $result = dquery("SELECT `service_name`,(SELECT `group_name` FROM `tbl_imei_group` WHERE `id`=tbl_services_imei.group_id) as gname FROM `tbl_services_imei` WHERE `API_ID`='" . $_unlcokbaseserviceid . "' ");
                    if (mysqli_num_rows($result)) {
                        echo "<div class='success'> The following tool is available for your IMEI :" . $_POST["IMEI"] . " <ul>";
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<li> " . $row["gname"] . " => " . $row["service_name"] . " </li> ";
                        }
                        echo "</ul></div><br />";
                    } else {
                        echo "<div class='error'> Sorry no service found! for " . $IMEI . "</div> <br />";
                    }
                }
            }
        }
    } else {
        echo "Error in connection to server!<br />";
    }
}
echo "\n<div align=\"left\">\n    <p>Enter an IMEI and find whether an HTC service is available for your phone !</p>\n\t<form action=\"\" method=\"post\"  >\n\t\t<input type=\"text\" name=\"IMEI\" size=\"15\" maxlength=\"15\" value=\"\" />\n        <input type=\"hidden\" name=\"lookup\" />\n\t\t<input type=\"submit\" value=\"Lookup\"  />\n\t</form>\n</div>    \n    \n</body>\n</html>";
class no
{
}

?>