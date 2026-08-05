<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

if (!$_SESSION["adminid"]) {
    exit;
}
if (!$id) {
    $id = $_SESSION["adminid"];
}
$exp = explode(",", $_SESSION["page_access"]);
$admns = mysqli_fetch_assoc(dquery("select username,credit from tbl_admin where id='" . $admn . "'"));
if (isset($save)) {
    $md5 = md5(md5($current) . "9486");
    if ($DEMOMODE) {
        echo "<div id='notification1' class='errorbox'>This Function not enabled in Demo Mode.</div>";
    } else {
        $sql = dquery("select * from tbl_admin where password='" . $md5 . "' and id='" . $admn . "'");
        if (mysqli_num_rows($sql) || in_array(55, $exp)) {
            if ($new && $confirmation) {
                if ($new == $confirmation) {
                    $data = NULL;
                    $data["password"] = md5(md5($new) . "9486");
                    $db->update("tbl_admin", $data, "id=" . $admn);
                    echo "<div id='notification1' class='successbox'>" . $LNG["datasavesuccessfully"] . "</div>";
                } else {
                    echo "<div id='notification1' class='errorbox'>" . $LNG["password"] . " " . $LNG["notsame"] . "</div>";
                }
            } else {
                echo "<div id='notification1' class='errorbox'>" . $LNG["fieldblank"] . "</div>";
            }
        } else {
            echo "<div id='notification1' class='errorbox'>" . $LNG["wrong"] . " " . $LNG["password"] . "</div>";
        }
    }
}
if ($generate && $password) {
    $md5 = md5(md5($password) . "9486");
    if (mysqli_num_rows(dquery("select * from tbl_admin where password='" . $md5 . "' and id='" . $admn . "'"))) {
        $passc = $password;
    }
}
echo "<div id=\"notification1\" class=\"info mb-3\">\n";
$limit = $admns["credit"] != "" ? $admns["credit"] : "Unlimited";
echo $LNG["add"] . " " . $LNG["fund"] . " " . $LNG["limit"] . " : " . $limit;
echo "</div>\n<form method=\"post\">\n<div  class=\"groupstabes\" >\n          <h2>\n            <span class=\"groupstabesheadertext\">Install App</span>\n          </h2>\n          <div class=\"groupstabescontant\">\n\n<table class=\"form\" id=\"\">\n<tbody>\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["your"];
echo " ";
echo $LNG["password"];
echo " </td>\n    <td class=\"fieldarea\"><input type=\"password\" name=\"password\" />\n        ";
if ($passc) {
    echo "            <img src=\"https://chart.googleapis.com/chart?chs=150x150&cht=qr&chl=";
    echo $_SERVER["SERVER_NAME"];
    echo "___";
    echo $admns["username"];
    echo "___";
    echo $passc;
    echo "___";
    echo $admindirpath;
    echo "___";
    echo $config["config_site_name"];
    echo "&choe=UTF-8\" />\n            ";
}
echo "    </td>\n\n</tr>\n\n<tr>\n    <td class=\"fieldlabel\"></td>\n    <td class=\"fieldarea\"><input value=\"";
echo $LNG["generate"];
echo " QR ";
echo $LNG["code"];
echo "\" id=\"btne\"\n\n    class=\"btn save\" name=\"generate\" type=\"submit\" /></td>\n\n</tr>\n</tbody>\n</table>\n</div></div>\n</form>\n<form method=\"post\">\n<div  class=\"groupstabes\" >\n          <h2>\n            <span class=\"groupstabesheadertext\">";
echo $LNG["password"];
echo " ";
echo $LNG["change"];
echo "</span>\n          </h2>\n          <div class=\"groupstabescontant\">\n\n<table  class=\"form\">\n<tbody>\n<input type=\"hidden\" name=\"admn\" value=\"";
echo $admn;
echo "\" />\n<input type=\"hidden\" name=\"loaddefault\" value=\"editadmin.php\" />\n";
if (!in_array(55, $exp)) {
    echo "<tr>\n    <td class=\"fieldlabel\">";
    echo $LNG["current"];
    echo " ";
    echo $LNG["password"];
    echo "</td>\n    <td class=\"fieldarea\"><input type=\"password\" name=\"current\" /></td>\n</tr>\n";
}
echo "<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["new"];
echo " ";
echo $LNG["password"];
echo "</td>\n    <td class=\"fieldarea\"><input type=\"password\" name=\"new\" /></td>\n</tr>\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["confirmation"];
echo " ";
echo $LNG["password"];
echo "</td>\n    <td class=\"fieldarea\"><input type=\"password\" name=\"confirmation\" /></td>\n</tr>\n<tr>\n    <td class=\"fieldlabel\"></td>\n    <td class=\"fieldarea\"><input value=\"";
echo $LNG["save"];
echo "\" id=\"btneditadmin\" class=\"btn save\" name=\"save\" type=\"submit\" /></td>\n</tr>\n</tbody>\n</table>\n</div></div>\n</form>\n";
$fileverioncheck = "6.1.0";

?>