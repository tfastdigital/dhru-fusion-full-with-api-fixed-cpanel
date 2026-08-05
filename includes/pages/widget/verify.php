<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

define("DEFINE_MY_ACCESS", true);
define("DEFINE_DHRU_FILE", true);
define("CLIENT", true);
define("SSLON", true);
require "./comm.php";
require ROOTDIR . "/includes/fun.inc.php";
require ROOTDIR . "/includes/client.area.inc.php";
$id = preg_replace("/[^0-9\\-a-zA-Z]/i", "", $id);
if ($actions) {
    $action = $actions;
}
if ($action == "newserver") {
    $action = "newserver";
} else {
    $action = "imei";
}
echo "<form method='post' enctype=\"multipart/form-data\"  action='";
echo _url("orders/action/" . $action . "/status/available");
echo "'>\n<input type='hidden' name='verification' value='";
echo $id;
echo "' />\n\n  <div id=\"formstyle_1\" style=\"background:white;padding:10px\">\n       <fieldset>         \n              <div class=\"control-group\"><label class=\"control-label\">Details</label>\n              <div class=\"controls\"><textarea cols=\"40\" class=\"form-control\" rows=\"4\" name=\"details\" ></textarea></div>\n              </div>\n               <div class=\"control-group\"><label class=\"control-label\">Attachment</label>\n              <div class=\"controls\"><input type=\"file\"  name=\"attachment\" /></div>\n              </div>\n               <div class=\"control-group\"><label class=\"control-label\">&nbsp;</label>\n              <div class=\"controls\"><input type='submit'  class=\"btn btn-primary\" name='cancel' value='Verify' /></div>\n              </div>\n        </fieldset>      \n </div>              \n              \n\n</form>";

?>