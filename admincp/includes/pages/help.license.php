<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

$pageid = 329;
checkPagePermission($pageid);
echo "<div id=\"content\">\n    <div id=\"content_padded\">\n        ";
if ($updatelic) {
    logActivityGlobal("Forcefully License Update", "license", "", "admin");
    $licinfo = licince\getLicenseDetails(false, true);
}
$_product_id = $licinfo["item_id"];
echo "\n        <div  class=\"groupstabes\">\n            <h2>\n                <span class=\"groupstabesheadertext\">License Information</span>\n            </h2>\n            <div class=\"groupstabescontant\">\n\n                <table class=\"form\">\n                    <thead>\n                    <tr>\n                        <td class=\"fieldlabel\"> ";
echo $LNG["license"];
echo " ";
echo $LNG["for"];
echo "                            ( ";
echo $licinfo["prodcut"];
echo " )\n                        </td>\n                        <td class=\"fieldarea\">\n                            <form method=\"post\"><input value=\"";
echo $LNG["fourcefullyupdatelicenseinfo"];
echo "\"\n                                                       name=\"updatelic\" type=\"submit\"/></form>\n                        </td>\n                    </tr>\n                    </thead>\n                    <tbody>\n                    <tr>\n\n                        <td class=\"fieldlabel\">";
echo $LNG["version"];
echo " </td>\n                        <td class=\"fieldarea\">\n                            <style>\n                                .blink_me {\n                                    animation: blinker 1s linear infinite;\n                                }\n\n                                @keyframes blinker {\n                                    50% {\n                                        opacity: 0;\n                                    }\n                                }\n                            </style>\n\n                            <div>\n\n                                <strong>Installed ";
echo $config["version"] . " " . $config["release_candidate"];
echo "</strong>";
$ver_req = json_decode(initCurl("https://api.dhru.com/integration/api/v1/productversions"), true)["data"];
$_current_version = $ver_req[$_product_id]["version"]["release"];
echo "</div>";
if ($_current_version !== $config["version"]) {
    echo "<div><span class='blink_me' > " . $LNG["new"] . " " . $LNG["version"] . " " . $LNG["available"] . " : " . $_current_version . " </span></div> <br/>";
    echo "<a href='https://support.dhru.com/Dhru-Fusion/releasenotes/' target='_blank'> Find out more about new version </a>";
}
echo "\n                        </td>\n                    </tr>\n                    <tr>\n                        <td class=\"fieldlabel\">";
echo $LNG["license"];
echo " ";
echo $LNG["key"];
echo "</td>\n                        <td class=\"fieldarea\"><span\n                                    style=\" font-size: 30px; border-radius : 5px; padding: 5px; background: none repeat scroll 0% 0% rgb(102, 102, 102); color: rgb(255, 255, 255);\">";
echo $licinfo["license_key"];
echo "</span>\n                        </td>\n                    </tr>\n\n                    <tr>\n                        <td class=\"fieldlabel\"> ";
echo $LNG["license"];
echo " ";
echo $LNG["status"];
echo " </td>\n                        ";
if ($licinfo["status"] == "Active") {
    $clr = "badge badge-success";
} else {
    $clr = "textred";
}
echo "                        <td class=\"fieldarea\"><span class=\"";
echo $clr;
echo "\"> ";
echo $licinfo["status"];
echo "</span></td>\n                    </tr>\n\n<!--                    <tr>\n                        <td class=\"fieldlabel\"> </td>\n                        <td class=\"fieldarea\">\n\n                            </td>\n\n                    </tr>\n\n                    ";
if ($licinfo["reseller"] != "on") {
    echo "                        <tr>\n                            <td class=\"fieldlabel\">";
    echo $LNG["company"];
    echo " ";
    echo $LNG["name"];
    echo "</td>\n                            <td class=\"fieldarea\"> ";
    echo $licinfo["companyname"];
    echo "</td>\n                        </tr>\n                        ";
}
echo "\n                    <tr>\n                        <td class=\"fieldlabel\">";
echo $LNG["email"];
echo "</td>\n\n                        <td class=\"fieldarea\">\n                            ";
echo $licinfo["reseller"] != "on" ? $licinfo["email"] : $licinfo["customfields"]["licensetoemail"];
echo "</td>\n                        </td>\n                    </tr>\n                    ";
if ($licinfo["reseller"] != "on") {
    echo "                    <tr>\n                        <td class=\"fieldlabel\">";
    echo $LNG["register"];
    echo " ";
    echo $LNG["on"];
    echo "</td>\n                        <td class=\"fieldarea\"> ";
    echo $licinfo["regdate"];
    echo "</td>\n                    </tr>\n\n                     -->\n                    <tr>\n                        ";
}
echo "                        <td class=\"fieldlabel\">";
echo $LNG["valid"];
echo " ";
echo $LNG["till"];
echo "</td>\n                        <td class=\"fieldarea\"> ";
if ($licinfo["billingcycle"] == "One Time") {
    echo "Life Time";
} else {
    echo $licinfo["next_due_date"];
}
echo "</td>\n                    </tr>\n\n                    <tr>\n                        <td class=\"fieldlabel\">";
echo $LNG["valid"];
echo " ";
echo $LNG["domain"];
echo "</td>\n                        <td class=\"fieldarea\"> ";
echo implode(" | ", $licinfo["valid_domains"]);
echo "</td>\n                    </tr>\n\n                    <tr>\n                        <td class=\"fieldlabel\">";
echo $LNG["valid"];
echo " ";
echo $LNG["ip"];
echo "</td>\n                        <td class=\"fieldarea\"> ";
echo implode(" | ", $licinfo["valid_ips"]);
echo "</td>\n                    </tr>\n                    <!--\n\t<tr>\n        <td class=\"fieldlabel\">";
echo $LNG["free"];
echo " ";
echo $LNG["technical"];
echo " ";
echo $LNG["support"];
echo "</td>\n        <td class=\"fieldarea\"> <strong style=\"color: rgb(168, 63, 45);\">";
$date = strtotime(date("Y-m-d", strtotime($licinfo["regdate"])) . " +3 month");
$current = time();
if ($date <= $current) {
    echo (string) $LNG["expired"];
} else {
    echo "<label style=\"color: rgb(0, 121, 61);\">" . $LNG["active"] . " </label>";
}
echo "</strong></td>\n        </tr>\n-->\n\n                    </tbody>\n                </table>\n            </div>\n        </div>\n\n\n        <div  class=\"groupstabes\">\n            <h2>\n                <img src=\"data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAkAAAAJCAYAAADgkQYQAAAAAXNSR0IArs4c6QAAAAlwSFlzAAALEwAACxMBAJqcGAAAAAd0SU1FB9oIGRQbOY8MjgMAAAA8SURBVBjTY2BAAzdv3vwPBAzImAGbInSFWBU9f/4cRSFWRb9+/UJRiFMRTOGNGzf+k28SUW4iynfo4QQAj22WmutXxVsAAAAASUVORK5CYII=\">\n                <span class=\"groupstabesheadertext\">Addons & Features</span>&nbsp;<font class=\"backline\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</font>\n            </h2>\n            <div class=\"groupstabescontant\">\n                <table class=\"form\">\n                    <tbody>\n                    ";
foreach ($licinfo["addons"] as $value) {
    if ($value["status"] == "Active") {
        $clr = "badge badge-success";
    } else {
        $clr = "textred";
    }
    echo "<tr><td class=\"fieldlabel\">" . $value["name"] . "</td><td class=\"fieldarea\"> <span   class=\"" . $clr . "\">" . $value["status"] . " </span>";
    if ($value["billingcycle"] != "One Time" && $value["status"] == "Active") {
        echo " <span class='badge badge-info'> Expired On : " . date("d M Y", strtotime($value["next_due_date"])) . " </span>";
    }
    if (isset($value["info"])) {
        echo " <span >[" . $value["info"] . "]<span>  ";
    }
    if (isset($value["credits"])) {
        echo "<b> You have  " . $value["credits_left"] . " balance</b>";
    }
    echo "</td></tr>";
}
echo "<!--\n                        <tr>\n                            <td class=\"fieldlabel\">\n                                <div id=\"notification1\" class=\"alert\">                                    <a href=\"javascript:SubmitForm ('#btnaddgroup','settinggeo','#frm','#notification','true','#main_loader');\"> </a>                                      .\n                                </div>\n                            </td>\n                        </tr>\n                        -->\n\n\n                    </tbody>\n                </table>\n            </div>\n        </div>";
$fileverioncheck = "6.1.0";

?>