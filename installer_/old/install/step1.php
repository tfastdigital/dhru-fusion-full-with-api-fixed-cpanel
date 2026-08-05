<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

require_once "settings.inc.php";
if (EI_CONFIG_AVAILABLE) {
    $database_host = $config["server"];
    $database_name = $config["database"];
    $database_username = $config["user"];
    $database_password = "";
    $database_prefix = " \" disabled \"";
    $install_type = isset($_REQUEST["install_type"]) ? $_REQUEST["install_type"] : "";
    $link = @mysqli_connect($config["server"], $config["user"], $config["pass"], $config["database"]);
    exit(mysqli_connect_error());
}
$database_host = isset($_REQUEST["database_host"]) ? $_REQUEST["database_host"] : "";
$database_name = isset($_REQUEST["database_name"]) ? $_REQUEST["database_name"] : "";
$database_username = isset($_REQUEST["database_username"]) ? $_REQUEST["database_username"] : "";
$database_password = isset($_REQUEST["database_password"]) ? $_REQUEST["database_password"] : "";
$_idupgrade = false;
echo "\n\n<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.01 Transitional//EN\">\n\n<html>\n<head>\n    <title>";
echo $_idupgrade ? "Dhru Fusion Upgrade" : "Dhru Fusion New Installation";
echo "</title>\n    <meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />\n    <link rel=\"stylesheet\" type=\"text/css\" href=\"img/styles.css\"></link>\n</head>\n<body>\n<div style=\"width: 960px;margin:auto;\">\n    <br /><br /><br />\n    <h2 align=\"left\"> ";
echo $_idupgrade ? "Upgrade of " : "New Installation of ";
echo " ";
echo EI_APPLICATION_NAME;
echo "!</h2>\n\n    <fieldset>\n        ";
if (!EI_CONFIG_AVAILABLE) {
    echo "            <span style=\"color:#a60000\">*</span> Items marked with an asterisk are required.<br /><br />\n        ";
}
echo "\n        <form method=\"post\" action=\"step2.php\">\n            <table width=\"100%\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\">\n                <tbody>\n                <tr>\n                    <td class=\"gray_table\">\n                        <table width=\"100%\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\">\n                            <tbody>\n                            <tr><td class=\"ltcorner\"></td><td></td><td class=\"rtcorner\"></td></tr>\n                            <tr>\n                                <td></td>\n                                <td align=middle>\n                                    <table width=\"100%\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\">\n                                        <tbody>\n\n                                        ";
if (!EI_CONFIG_AVAILABLE) {
    echo "                                            <tr><td class=text align=left><b>Database Details</b></td></tr>\n                                        ";
} else {
    echo "                                            <tr><td class=text align=left><b>Found your current installation</b></td></tr>\n                                        ";
}
echo "\n                                        </tbody>\n                                    </table>\n                                    <br />\n\n\n                                    <input type=\"hidden\" name=\"submit\" value=\"step2\" />\n                                    <table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"2\" class=\"main_text\">\n\n                                        ";
if (!EI_CONFIG_AVAILABLE) {
    echo "\n                                            <tr>\n                                                <td valign=\"top\" width=\"200px\">&nbsp;Database Host&nbsp;<span style=\"color:#a60000\">*</span></td>\n                                                <td>\n                                                    <input type=\"text\" class=\"form_text\" name=\"database_host\" style=\"width: 300px;\"    value=\"";
    echo $database_host ? $database_host : "localhost";
    echo "\" />\n                                                    <br /><small>Hostame or IP-address of the database server. The database server can be in the form of a hostname, such as db1.myserver.com, or as an IP-address, such as 192.168.0.1</small><br /><br />\n                                                </td>\n                                            </tr>\n                                            <tr>\n\n                                                <td valign=\"top\">&nbsp;Database Name&nbsp;<span style=\"color:#a60000\">*</span></td>\n                                                <td>\n                                                    <input type=\"text\" class=\"form_text\" name=\"database_name\"style=\"width: 300px;\"  value=\"";
    echo $database_name;
    echo "\" />\n                                                    <br /><small>Database Name. The database used to hold the data. An example database name is 'testdb'.</small><br /><br />\n                                                </td>\n                                            </tr>\n                                            <tr>\n                                                <td valign=\"top\">&nbsp;Database Username&nbsp;<span style=\"color:#a60000\">*</span></td>\n                                                <td>\n                                                    <input type=\"text\" class=\"form_text\" name=\"database_username\"style=\"width: 300px;\" value=\"";
    echo $database_username;
    echo "\"/>\n                                                    <br /><small>Database username. The username used to connect to the database server. An example username is 'test_123'.</small><br /><br />\n                                                </td>\n                                            </tr>\n                                            <tr>\n                                                <td valign=\"top\">&nbsp;Database Password&nbsp;<span style=\"color:#a60000\">*</span></td>\n                                                <td>\n                                                    <input type=\"text\" class=\"form_text\" name=\"database_password\"style=\"width: 300px;\"  value=\"";
    echo $database_password;
    echo "\"  autocomplete='off' />\n                                                    <br /><small>Database password. The password is used together with the username, which forms the database user account.</small><br /><br />\n                                                </td>\n                                            </tr>\n                                            <tr>\n\n\n                                                <input type=\"hidden\" name=\"install_type\"  value=\"new\" />\n\n                                            </tr>\n\n\n                                        ";
} else {
    echo "<tr><td colspan=\"2\" >";
    echo "<input type=\"hidden\" name=\"database_host\" value=\"" . $database_host . "\" />";
    echo "<input type=\"hidden\" name=\"database_name\" value=\"" . $database_name . "\" />";
    echo "<input type=\"hidden\" name=\"database_username\" value=\"" . $database_username . "\" />";
    echo "<input type=\"hidden\" name=\"database_password\" value=\"" . $database_password . "\" />";
    echo "<input type=\"hidden\" name=\"install_type\"  value=\"update\" /> ";
    $sql = mysqli_fetch_assoc(dquery("select value from tbl_settings where attribute='config'", $link));
    $config = unserialize($sql["value"]);
    echo "<span style='color:#a60000;font-size: 18px;' >your current version is : " . $config["version"] . " " . $config["release_candidate"] . " <br/>  upgrading to  " . EI_APPLICATION_VERSION . " " . EI_RELEASE_CANDIDATE . "</span>";
    echo "\t<br />\t<br /><br /><br />\t\n                            <input type=\"checkbox\" name=\"knowledge\" id=\"knowledge\" value=\"1\" CHECKED /> <label for=\"knowledge\">Install default knowledge base article</label>\n\t\t\t\t<br /><br /> <br/><br/> *Before starting the upgrade, you should backup your database. <a href=\"http://dhru.com/knowledgebase/999131/How-backup-and-restore-database-using-cPanel-.html\" target=\"_blank\">need help?</a></td><tr>";
}
echo "\n\n\n\n                                        ";
if (!EI_CONFIG_AVAILABLE) {
    echo "                                            <tr>\n                                                <td>&nbsp;Sample Data</td>\n                                                <td>\n                                                    <input type=\"checkbox\" name=\"sample\" id=\"sample\" value=\"1\" /> <label for=\"sample\"> Install Sample Data</label>\n                                                </td>\n                                            </tr>\n\n                                            <tr>\n                                                <td>&nbsp;KnowledgeBase</td>\n                                                <td>\n                                                    <input type=\"checkbox\" name=\"knowledge\" id=\"knowledge\" value=\"1\" CHECKED /> <label for=\"knowledge\">Install default knowledge base article</label>\n                                                </td>\n                                            </tr>\n\n                                            ";
}
echo "\n\n\n\n\n                                        ";
if (!EI_CONFIG_AVAILABLE) {
    echo "                                            ";
    if (EI_USE_USERNAME_AND_PASWORD) {
        echo "                                                <tr><td colspan=\"3\">&nbsp;</td></tr>\n                                                ";
        if (EI_USE_PASSWORD_ENCRYPTION) {
            echo "                                                ";
        }
        echo "                                            ";
    }
    echo "\n                                            <tr>\n                                                <td>&nbsp;Site URL<span style=\"color:#a60000\">*</span></td>\n                                                <td>\n                                                    ";
    $path = str_replace("installer/install/step1.php", "", $_SERVER["REQUEST_URI"]);
    echo "\n                                                    <input type=\"text\" class=\"form_text\" name=\"site_url\" style=\"width: 300px;\" value=\"";
    echo "http://" . $_SERVER["SERVER_NAME"] . "" . $path;
    echo "\" /><br /><small>Site URL. Website address url.</small> \t\t</td>\n                                            </tr>\n\n\n\n                                            ";
}
echo "\n                                    </table>\n\n                                    <br />\n                                </td>\n                                <td></td>\n                            </tr>\n                            <tr><td class=\"lbcorner\"></td><td></td><td class=\"rbcorner\"></td></tr>\n                            </tbody>\n                        </table>\n                    </td>\n                </tr>\n                </tbody>\n            </table>\n\n            ";
if ($_GET["selfupgrade"] == "true") {
    echo "<input type=\"hidden\" name=\"selfupgrade\" value=\"true\" />";
}
echo "\n            <p align=\"right\">\n                <a href='../install.php' title=\"Cancel installation\" class=\"btn remove\" style=\"float: left;\">Cancel</a>\n                <input type=\"image\"  class=\"btn save\" value=\"Continue ";
if (EI_CONFIG_AVAILABLE) {
    echo " to upgrade";
}
echo "\" name=\"btn_submit\" title=\"Continue installation\" />\n\n            </p>\n        </form>\n        ";
include_once "footer.php";
echo "    </fieldset>\n\n</body>\n</html>\n";

?>