<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

if (!isset($_SESSION[adminid])) {
    exit;
}
echo "    <div id=\"tabcontent\">\n        ";
if ($defaultloadpage != "cronsetting.php") {
    echo "            <ul id=\"tabmenu\">\n                <li class=\"tabmenu-header\"><span>Submenu</span></li>\n                <li><a ";
    if ($defaultloadpage != "apisetting.php") {
        echo "class=tabmenu_active";
    }
    echo " onclick=\"getContect('#tab','main2.php?page=apisetting','','','#tabcontent',true,'#main_loader');\"\n                         id=\"tab\"> APi</a></li>\n                <li><a onclick=\"getContect('#tab22','main2.php?page=inactiveapisetting','','','#tabcontent',true,'#main_loader');\"\n                       id=\"tab22\">+Add APi</a></li>\n\n                <li><a onclick=\"getContect('#tab2','main2.php?page=cronsetting','','','#tabcontent',true,'#main_loader');\"\n                            id=\"tab2\">Cron Settings</a></li>\n                <li><a class='tabmenu_active'\n                       onclick=\"getContect('#tab4','main2.php?page=croninstall','','','#tabcontent',true,'#main_loader');\" id=\"tab4\" >Cron Auto Install</a></li>\n                <li><a onclick=\"getContect('#tab3','main2.php?page=apisynchistory','','','#tabcontent',true,'#main_loader');\"\n                       id=\"tab3\">APi Sync ";
    echo $LNG["history"];
    echo "</a></li>\n                <div style=\"clear: both;\"></div>\n            </ul>\n            ";
}
echo "\n        <div class=\"mt-2\">\n\n        <script>\n            function CronJobSetting(val){\n                if(val==2){\n                    \$(\".part1\").hide();\n                }else{\n                    \$(\".part1\").show();\n                }\n                \$.post( \"includes/main.save.php?page=settingother.save&cronpreference=\"+val, function( data ) {\n                });\n            }\n            function copyto(u1,u2){\n                var callbackDivId='#notification';\n                if(\$(\"input[name='cronjobs']:checked\"). val()==2){\n                    var el = document.createElement('textarea');\n                    el.value = u2;\n                    el.setAttribute('readonly', '');\n                    el.style = {position: 'absolute', left: '-9999px'};\n                    document.body.appendChild(el);\n                    el.select();\n                    document.execCommand('copy');\n                    document.body.removeChild(el);\n                    \$(callbackDivId).show();\n                    \$(callbackDivId).addClass('successbox');\n                    \$(callbackDivId).html('Copied to Clipboard');\n                }else{\n                    var el = document.createElement('textarea');\n                    el.value = u1+' '+u2;\n                    el.setAttribute('readonly', '');\n                    el.style = {position: 'absolute', left: '-9999px'};\n                    document.body.appendChild(el);\n                    el.select();\n                    document.execCommand('copy');\n                    document.body.removeChild(el);\n                    \$(callbackDivId).show();\n                    \$(callbackDivId).addClass('successbox');\n                    \$(callbackDivId).html('Copied to Clipboard');\n                }\n            }\n            function TestAPI(url)\n            {\n                \$(\"#main_loader\").show();\n                \$.ajax({\n                    url  : url+'&test=1',\n                    timeout: 20000,\n                    error: function(){\n                        alert(\"ERROR: Link is invalid or unable to access from public\")\n                        \$(\"#main_loader\").hide();\n                    },\n                    success: function(data) {\n                        alert(data);\n                        \$(\"#main_loader\").hide();\n                    }\n                });\n            }\n        </script>\n        <style>\n            .fa-copy{\n                cursor: pointer;\n            }\n            hr{\n                border-bottom: 1px dashed #ccc;\n                padding:0 !important;\n                margin:0 !important;\n            }\n        </style>\n        ";
if ($config["config_ssl_allow"]) {
    $config["site_address"] = $config["config_ssl_allow"];
}
if ($config["cronpreference"] == 2) {
    echo "            <script>\n                \$( document ).ready(function() {\n                    CronJobSetting(2);\n                });\n            </script>\n            ";
}
echo "        <div id=\"notification1\" class=\"info\"><strong>";
echo $LNG["enableapiautomation"];
echo "                ";
echo $LNG["createcron"];
echo " | <a target=\"_blank\"\n                                             href=\"https://support.dhru.com/Dhru-Fusion/article/API-/?aid=44&cid=7&pid=1\"\n                                             style=\"text-decoration: none; color: black\">How to setup a Cron job in\n                    cPanel</a><br />\n                Set Up separate cron jobs as listed below </strong>\n        </div>\n\n\n        <div id=\"notification\"></div>\n\n        <div  class=\"groupstabes\">\n            <h2>\n                <span>Cron Settings</span>&nbsp;\n            </h2>\n            <div class=\"groupstabescontant\">\n                ";
$sql = mysqli_fetch_assoc(dquery("select * from tbl_settings where attribute='config'"));
$config = unserialize($sql["value"]);
echo "                <form method=\"post\" id=\"frm\">\n                    <table  border=\"0\" cellpadding=\"3\" cellspacing=\"2\" width=\"100%\" class=\"form\">\n                        <tbody>\n\n                        <tr>\n                            <td  class=\"fieldlabel\">Separate Cron For Send and Get </td>\n                            <td class=\"fieldarea\">\n                                <input type='checkbox'\n                                       class=\"onoff {labelOn: 'Enable', labelOff: 'Disable',\n    easing: 'easeOutBounce', duration: 500}\"\n                                       name=\"seperatecron\" value=\"1\" id=\"tae\"\n                                    ";
if ($config["seperatecron"]) {
    echo "checked";
}
echo " />\n                                <br /><div style=\"clear: both;\"></div>\n                                <div>Turn on if you have a large number of orders or better APi Performance</div>\n                            </td>\n                        </tr>\n\n                        <tr>\n                            <td class=\"fieldlabel\">Cron ";
echo $LNG["password"];
echo "</td>\n                            <td class=\"fieldarea\">\n                                <input type=\"text\" name=\"cron_password\"\n                                       value=\"";
echo $config["cron_password"];
echo "\" />\n                                <small>For security reason we strongly\n                                    suggest you to set Cron password\n                                    (Only Numeric and Alphabets allowed)</small>   </td>\n                        </tr>\n\n\n                        <tr>\n                            <td class=\"fieldlabel\">Send Order Per Batch</td>\n                            <td class=\"fieldarea\">\n                                <input type=\"text\" name=\"cronsendbatchorder\"\n                                       value=\"";
echo $config["cronsendbatchorder"];
echo "\" />\n                                <small>Default Limit 100</small>\n                            </td>\n                        </tr>\n\n                        <tr>\n                            <td class=\"fieldlabel\">Get Order Per Batch</td>\n                            <td class=\"fieldarea\">\n                                <input type=\"text\" name=\"crongetbatchorder\"\n                                       value=\"";
echo $config["crongetbatchorder"];
echo "\" />\n                                <small>Default Limit 100</small> </td>\n                        </tr>\n                        <tr>\n                            <td >  </td>\n                            <td class=\"fieldarea\">\n                                <input type=\"button\"\n                                       class=\"addFromgallery\" id=\"btns\" name=\"save\"\n                                       value=\"";
echo $LNG["save"];
echo "\"\n                                       onclick=\"SubmitForm ('#btns','settingcron','#frm','#notification','true','#main_loader','main2.php?page=apisetting&defaultloadpage=cronsetting.php');\" />\n                            </td>\n                        </tr>\n                        </tbody>\n                    </table>\n            </div></div>\n        </form>\n        Cron Platform : <label><input type=\"radio\" name=\"cronjobs\" id=\"cronjobs\" onclick=\"CronJobSetting(this.value)\" value=\"1\" ";
if (!$config["cronpreference"] || $config["cronpreference"] == 1) {
    echo "checked";
}
echo " />cPanel/Hosting </label>\n\n        <label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type=\"radio\" name=\"cronjobs\" onclick=\"CronJobSetting(this.value)\" id=\"cronjobs\" value=\"2\" ";
if ($config["cronpreference"] == 2) {
    echo "checked";
}
echo " />SetCronJob.com (Recommended)</label>\n\n\n        <br/><br/>\n\n\n        <div class=\"wrapper center-block\" >\n            <div class=\"panel-group\" id=\"accordion\" role=\"tablist\" aria-multiselectable=\"true\">\n                <div class=\"panel panel-default\">\n                    <div class=\"panel-heading active\" role=\"tab\" id=\"headingOne\">\n                        <h4 class=\"panel-title\">\n                            <a role=\"button\" data-toggle=\"collapse\"  href=\"#collapseOne\" aria-expanded=\"true\" aria-controls=\"collapseOne\">\n                                Cron Commands for IMEI,Server and Remote Services\n                            </a>\n                        </h4>\n                    </div>\n                    <div id=\"collapseOne\" class=\"panel-collapse collapse show\" data-parent=\"#accordion\" role=\"tabpanel\" aria-labelledby=\"headingOne\">\n                        <div class=\"panel-body\">\n                            <table id=\"main_tbl\" >\n                                <thead>\n                                <tr>\n                                    <th> </th>\n                                    <th><strong>Cron Command</strong></th>\n                                    <th><strong>Run Manually</strong></th>\n                                </tr>\n\n                                </thead>\n                                <tbody>\n                                ";
$query = dquery("SELECT * FROM `tbl_apiservers` WHERE `setting`='name'");
echo "                                ";
$AutomationCron = "";
while ($Data = mysqli_fetch_assoc($query)) {
    $Data["value"] = str_replace(" ", "_", trim($Data["value"]));
    $Data["value"] = preg_replace("/[^a-zA-Z0-9_']/", "", trim($Data["value"]));
    $queryxx = dquery("SELECT value FROM `tbl_apiservers` WHERE `gateway`='" . $Data["gateway"] . "' AND `setting`='servicetype'");
    $queryxx = mysqli_fetch_assoc($queryxx);
    $configpass = $config["cron_password"] != "" ? "?a=" . $config["cron_password"] . "&action=" . $Data["gateway"] : "?action=" . $Data["gateway"];
    if ($queryxx["value"] == "file") {
        if ($config["seperatecron"]) {
            $configpass = $config["cron_password"] != "" ? "?a=" . $config["cron_password"] . "&service=file&action=" . $Data["gateway"] . "_send" : "?action=" . $Data["gateway"] . "_send";
            $url1 = "<span class='part1'>/usr/bin/wget -O - -q -t 1</span>";
            $url2 = "<span class='part2'>" . $config["site_address"] . "includes/cron.php" . $configpass . "&" . $Data["value"] . "=true&service=file</span>";
            $fileservices[] = $url1 . "___" . $url2;
            $configpass = $config["cron_password"] != "" ? "?a=" . $config["cron_password"] . "&service=file&action=" . $Data["gateway"] . "_get" : "?action=" . $Data["gateway"] . "_get";
            $url1 = "<span class='part1'>/usr/bin/wget -O - -q -t 1</span>";
            $url2 = "<span class='part2'>" . $config["site_address"] . "includes/cron.php" . $configpass . "&" . $Data["value"] . "=true&service=file</span>";
            $fileservices[] = $url1 . "___" . $url2;
        } else {
            $url1 = "<span class='part1'>/usr/bin/wget -O - -q -t 1</span>";
            $url2 = "<span class='part2'>" . $config["site_address"] . "includes/cron.php" . $configpass . "&service=file&" . $Data["value"] . "=true&service=file</span>";
            $fileservices[] = $url1 . "___" . $url2;
        }
    } else {
        if ($config["seperatecron"]) {
            $configpass = $config["cron_password"] != "" ? "?a=" . $config["cron_password"] . "&action=" . $Data["gateway"] . "_send" : "?action=" . $Data["gateway"] . "_send";
            $url1 = "<span class='part1'>/usr/bin/wget -O - -q -t 1</span>";
            $url2 = "<span class='part2'>" . $config["site_address"] . "includes/cron.php" . $configpass . "&" . $Data["value"] . "=true</span>";
            echo "                                            <tr>\n                                                <td>\n                                                    <i class=\"fa-copy fa\" onclick=\"copyto('";
            echo strip_tags($url1);
            echo "','";
            echo strip_tags($url2);
            echo "');\"></i>\n                                                </td>\n                                                <td>\n                                                    ";
            echo $url1 . " " . $url2;
            echo "                                                </td>\n                                                <td><a href=\"javascript: TestAPI('";
            echo strip_tags($url2);
            echo "')\">Run</a></td>\n                                            </tr>\n                                            <tr>\n                                                ";
            $configpass = $config["cron_password"] != "" ? "?a=" . $config["cron_password"] . "&action=" . $Data["gateway"] . "_get" : "?action=" . $Data["gateway"] . "_get";
            $url1 = "<span class='part1'>/usr/bin/wget -O - -q -t 1</span>";
            $url2 = "<span class='part2'>" . $config["site_address"] . "includes/cron.php" . $configpass . "&" . $Data["value"] . "=true</span>";
            echo "                                                <td>\n                                                    <i class=\"fa-copy fa\" onclick=\"copyto('";
            echo strip_tags($url1);
            echo "','";
            echo strip_tags($url2);
            echo "');\"></i>\n                                                </td>\n                                                <td>\n                                                    ";
            echo $url1 . " " . $url2;
            echo "                                                </td>\n                                                <td>\n                                                    <a href=\"javascript: TestAPI('";
            echo strip_tags($url2);
            echo "')\">Run</a>\n                                                </td>\n                                            </tr>\n                                            ";
        } else {
            $url1 = "<span class='part1'>/usr/bin/wget -O - -q -t 1</span>";
            $url2 = "<span class='part2'>" . $config["site_address"] . "includes/cron.php" . $configpass . "&" . $Data["value"] . "=true</span>";
            echo "                                            <tr>\n                                                <td>\n                                                    <i class=\"fa-copy fa\" onclick=\"copyto('";
            echo strip_tags($url1);
            echo "','";
            echo strip_tags($url2);
            echo "');\"></i>\n                                                </td>\n                                                <td>\n                                                    ";
            echo $url1 . " " . $url2;
            echo "                                                </td>\n                                                <td>\n                                                    <a href=\"javascript: TestAPI('";
            echo strip_tags($url2);
            echo "')\">Run</a>\n                                                </td>\n                                            </tr>\n                                            ";
        }
        $configpass = $config["cron_password"] != "" ? "?a=" . $config["cron_password"] . "&action=" . $Data["gateway"] . "_updateprice" : "?action=" . $Data["gateway"] . "_updateprice";
        $url1 = "<span class='part1'>/usr/bin/wget -O - -q -t 1</span>";
        $url2 = "<span class='part2'>" . $config["site_address"] . "includes/cron.php" . $configpass . "&" . $Data["value"] . "=true</span>";
        $u1 = strip_tags($url1);
        $u2 = strip_tags($url2);
        $AutomationCron .= "<tr>";
        $AutomationCron .= "<td><i class='fa-copy fa' onclick='copyto(\"" . $u1 . "\",\"" . $u2 . "\")'></i> </td>";
        $AutomationCron .= "<td>";
        $AutomationCron .= $url1 . " " . $url2 . "</td><td><a href=\"javascript: TestAPI('" . strip_tags((string) $url2) . "')\">Run</a></td></tr>";
    }
}
echo "                                </tbody>\n                            </table>\n                        </div>\n                    </div>\n                </div>\n\n\n                ";
if ($fileservices) {
    echo "\n                    <div class=\"panel panel-default\">\n                        <div class=\"panel-heading\" role=\"tab\" id=\"headingTwo\">\n                            <h4 class=\"panel-title\">\n                                <a class=\"collapsed\" role=\"button\" data-toggle=\"collapse\"  href=\"#collapseTwo\" aria-expanded=\"false\" aria-controls=\"collapseTwo\">\n                                    Cron Commands for File Services\n                                </a>\n                            </h4>\n                        </div>\n                        <div id=\"collapseTwo\" class=\"panel-collapse collapse\" data-parent=\"#accordion\" role=\"tabpanel\" aria-labelledby=\"headingTwo\">\n                            <div class=\"panel-body\">\n                                <div class=\"info\">For File Service api set up this crons separately and <strong>run every 10 minute</strong></div>\n                                <table id=\"main_tbl\">\n                                    <thead>\n                                    <tr>\n                                        <th> </th>\n                                        <th><strong>Cron Command</strong></th>\n                                        <th><strong>Run Manually</strong></th>\n                                    </tr>\n                                    </thead>\n\n                                    <tbody>\n                                    ";
    foreach ($fileservices as $v) {
        $vs = explode("___", $v);
        $u1 = strip_tags($vs[0]);
        $u2 = strip_tags($vs[1]);
        echo "<tr><td><i class='fa-copy fa' onclick='copyto(\"" . $u1 . "\",\"" . $u2 . "\")'></i></td><td>" . $vs[0] . " " . $vs[1] . "</td><td><a href=\"javascript: TestAPI('" . strip_tags((string) $vs[1]) . "')\">Run</a></td>";
    }
    echo "                                    </tbody>\n                                </table>\n                            </div>\n                        </div>\n                    </div>\n                ";
}
echo "\n\n\n\n\n                <div class=\"panel panel-default\">\n                    <div class=\"panel-heading\" role=\"tab\" id=\"headingThree\">\n                        <h4 class=\"panel-title\">\n                            <a class=\"collapsed\" role=\"button\" data-toggle=\"collapse\" href=\"#collapseThree\" aria-expanded=\"false\" aria-controls=\"collapseThree\">\n                                Cron Commands for Auto Price Update\n                            </a>\n                        </h4>\n                    </div>\n                    <div id=\"collapseThree\" class=\"panel-collapse collapse\" data-parent=\"#accordion\"  role=\"tabpanel\" aria-labelledby=\"headingThree\">\n                        <div class=\"panel-body\">\n                            <div id=\"notification1\" class=\"info\">\n                                <strong>To enable APi auto price update features, make sure you set up a cron job to run Every one hour. </strong><br />\n                            </div>\n                            <table id=\"main_tbl\" >\n                                <thead>\n                                <tr>\n                                    <th></th>\n                                    <th><strong>Cron Command</strong></th>\n                                    <th><strong>Run Manually</strong></th>\n                                </tr>\n                                </thead>\n                                <tbody>\n                                ";
echo $AutomationCron;
echo "                                </tbody>\n                            </table>\n\n                        </div>\n                    </div>\n                </div>\n            </div>\n        </div>\n\n        </div>\n\n    </div>\n";
$fileverioncheck = "6.1.0";
echo "\n\n<script>\n    \$(document).ready(function (){\n        \$('.panel-collapse').on('show.bs.collapse', function () {\n            \$(this).siblings('.panel-heading').addClass('active');\n        });\n\n        \$('.panel-collapse').on('hide.bs.collapse', function () {\n            \$(this).siblings('.panel-heading').removeClass('active');\n        });\n    })\n</script>\n\n\n<style>\n    .panel-default{\n        border: #ddd solid 1px;\n        border-radius: 3px;\n        margin-top: 10px;\n    }\n    .panel-title{\n        margin-bottom: 0;\n    }\n    .panel-title>a{\n        display: block;\n        color: #555;\n        font-size: 16px;\n        text-decoration: none;\n        background: #f5f5f5;\n        padding: 15px;\n        border-radius: 3px 3px 0 0;\n    }\n    .panel-heading.active .panel-title>a{\n        border-bottom: #ddd solid 1px;\n    }\n    .panel-heading  a:before {\n        font-family: 'FontAwesome';\n        content: '\\f107';\n        float: right;\n        transition: all 0.5s;\n    }\n    .panel-heading.active a:before {\n        -webkit-transform: rotate(180deg);\n        -moz-transform: rotate(180deg);\n        transform: rotate(180deg);\n    }\n    .panel-collapse{\n        padding: 10px;\n        overflow: auto;\n    }\n</style>\n";

?>