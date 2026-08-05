<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

define("DEFINE_MY_ACCESS", true);
define("DEFINE_DHRU_FILE", true);
define("ADMIN", true);
require_once "../../../comm.php";
require_once "../../../includes/fun.inc.php";
if (!$_SESSION["adminid"]) {
    echo "<div align=\"center\"><h3>Session expired. <a style=\"color: #666;\" href=\"index.php?main2redirect=true\">Please relogin</a></h3></div>";
    $_SESSION["admin_afterlogin_re"] = $_SERVER["REQUEST_URI"];
    exit;
}
if ($network_check) {
    checkDemoMode(false);
    $network = implode(",", $network_check);
    if ($all_network == "ALL") {
        $data["assigned_network"] = "ALL";
    } else {
        $data["assigned_network"] = $network;
    }
    if ($db->update("tbl_services_imei", $data, "id=" . $id)) {
        echo "<div id=notification1 class=successbox> " . $LNG["networkassign"] . " " . $LNG["savesuccessfully"] . " </div>";
    } else {
        echo "<div id=notification1 class=errorbox> " . $LNG["datanotsave"] . " </div>";
    }
}
include_once ROOTDIR . "/includes/imeiservices.fun.php";
$md5id = md5($id);
$imeiserviceDetails = getIMEIServices("", $md5id);
echo "\n<link rel=\"stylesheet\" href=\"../../templates/";
echo $_SESSION["admin_template"];
echo "/x-main2.css\" />\n\n<script src=\"http://code.jquery.com/jquery-latest.min.js\"  type=\"text/javascript\"></script> <script src=\"../../templates/";
echo $_SESSION["admin_template"];
echo "/js/x-main2.fun.js\" language=\"javascript\"></script>\n<form id=\"frmnetwork\" name=\"\" method=\"post\">\n<input type=\"hidden\" value=\"";
echo $id;
echo "\" name=\"id\"/>\n";
echo generate_token("form");
$result = dquery("select ID,Name from tbl_network where api='" . $imeiserviceDetails["listing"] . "'");
$numrows = mysqli_num_rows($result);
echo "<table id=\"main_tbl\" style=\"display: table;\">\n            <thead>\n              <tr>\n                <th> <input value=\"ALL\" class=\"check-all\" name=\"all_network\" onclick=\"SetAllCheckBoxes(this)\" type=\"checkbox\"/>";
echo $LNG["all"];
echo "</th><th>";
echo $LNG["id"];
echo "</th><th>";
echo $LNG["network"];
echo " ";
echo $LNG["name"];
echo "</th>\n              </tr>\n            </thead>\n            <tbody>\n";
if ($numrows) {
    $network = explode(",", $imeiserviceDetails["reqredfield"]["assigned_network"]);
    while ($row = mysqli_fetch_assoc($result)) {
        if (in_array($row["ID"], $network) || $imeiserviceDetails["reqredfield"]["assigned_network"] == "ALL") {
            $checked = "checked";
        } else {
            $checked = "";
        }
        echo "<tr><td><input name=network_check[" . $row["ID"] . "] value=" . $row["ID"] . " type=checkbox " . $checked . " id='i_" . $rowm["ID"] . "'><label for='i_" . $rowm["ID"] . "'></label></td><td>" . $row["ID"] . "</td><td>" . $row["Name"] . "</td></tr>";
    }
}
echo "</tbody></table>\n<p class=\"fixedbtn\"><input value=\"";
echo $LNG["save"];
echo "\" id=\"btnedituser\" class=\"submit\" type=\"submit\" /></p>\n\n</form>";
$fileverioncheck = "6.1.0";

?>