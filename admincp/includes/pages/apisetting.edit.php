<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

namespace ns1;

$pageid = 13;
checkPagePermission($pageid);
if ($loadstatus) {
    echo "    <script>\n        \$( document ).ready(function() {\n            \$(\"#clickme\").trigger('click');\n        });\n    </script>\n    ";
}
if ($loadnew) {
    echo "    <script>\n        \$( document ).ready(function() {\n            \$(\"#clicknew\").trigger('click');\n        });\n    </script>\n    ";
}
echo "    <div id=\"tabcontent\">\n        <ul id=\"tabmenu\">\n            <li class=\"tabmenu-header\"><span>Submenu</span></li>\n            <li><a class=\"tabmenu_active\" onclick=\"getContect('#tab1','main2.php?page=apisetting.edit','";
echo $id;
echo "','','#tabcontent',true,'#main_loader');\" id=\"tab1\" >Synchronize</a></li>\n            <li><a id=\"clickme\" onclick=\"getContect('#tab3','main2.php?page=apisetting.status','";
echo $id;
echo "','','#tabcontent',true,'#main_loader');\" id=\"tab3\" >";
echo $LNG["status"];
echo "</a></li>\n            <li><a id=\"clicknew\" onclick=\"getContect('#tab4','main2.php?page=apisetting.quickadd','";
echo $id;
echo "','','#tabcontent',true,'#main_loader');\" id=\"tab4\" >";
echo $LNG["quick"];
echo " ";
echo $LNG["add"];
echo " ";
echo $LNG["new"];
echo " ";
echo $LNG["service"];
echo "</a></li>\n\n            <li><a onclick=\"getContect('#tab5','main2.php?page=apiautomation','";
echo $id;
echo "','','#tabcontent',true,'#main_loader');\" id=\"tab5\" >";
echo $LNG["pricing"];
echo " ";
echo $LNG["automation"];
echo "</a></li>\n\n        </ul>\n\n        ";
if ($id == "blackberry") {
    reqaddon("Blackberry");
}
echo "        <script src=\"includes/js/iframe.js\" type=\"text/javascript\"></script>\n        <script src=\"includes/js/progressbar.js\" type=\"text/javascript\"></script>\n        <style>\n            .badge{\n                margin-right:5px;\n                color: white;\n            }\n            .deleteclass{\n                display: none;\n            }\n            .deleteclass2{\n                display: none;\n            }\n            .deleteclass3{\n                display: none;\n            }\n        </style>\n        <script>\n            function showdeleteCond(obj){\n                if(document.getElementById('setupmyserver').checked){\n                    \$('.deleteclass').show();\n                }else{\n                    \$('.deleteclass').hide();\n                }\n            }\n            function showdeleteCond2(obj){\n                if(document.getElementById('setupmyserverserver').checked){\n                    \$('.deleteclass2').show();\n                }else{\n                    \$('.deleteclass2').hide();\n                }\n            }\n            function showdeleteCond3(obj){\n                if(document.getElementById('setupmyremote').checked){\n                    \$('.deleteclass3').show();\n                }else{\n                    \$('.deleteclass3').hide();\n                }\n            }\n            function sync_load_page(pagename) {\n\n                var flag=false;\n                var imeifixed=parseFloat(\$('#imeiincfixed').val());\n                var imeiper=parseFloat( \$('#imeiincper').val() );\n\n                var serverfixed=parseFloat( \$('#serverincfixed').val() );\n                var serverper=parseFloat( \$('#serverincper').val() );\n\n                var remotefixed=parseFloat( \$('#remoteincfixed').val() );\n                var remoteper=parseFloat( \$('#remoteincper').val() );\n\n                if(document.getElementById('deleteservicesserver').checked\n                    || document.getElementById('deleteservices').checked\n                    || document.getElementById('deletecurrentimei').checked\n                    || document.getElementById('deletecurrentserver').checked\n                    || document.getElementById('deletecurrentremote').checked\n                    || document.getElementById('deleteremote').checked)\n                {\n                    flag=true;\n                }\n                if(flag){\n                    if(confirm('Are you sure want to Remove Services ?')){\n                        flag=false;\n                    }\n                }\n\n                if(!flag) {\n                    try {\n                        if (document.getElementById('setupmyserver').checked) {\n                            pagename = pagename + \"&setupmyserver=1\";\n\n                        }\n                        if (document.getElementById('setupmyserverserver').checked) {\n                            pagename = pagename + \"&setupmyserverserver=1\";\n                        }\n                        if (document.getElementById('deleteservices').checked) {\n                            pagename = pagename + \"&deleteservices=1\";\n                        }\n                        if (document.getElementById('deletecurrentremote').checked) {\n                            pagename = pagename + \"&deletecurrentremote=1\";\n                        }\n                        if (document.getElementById('deletecurrentimei').checked) {\n                            pagename = pagename + \"&deletecurrentimei=1\";\n                        }\n                        if (document.getElementById('deleteservices').checked) {\n                            pagename = pagename + \"&deleteservices=1\";\n                        }\n                        if (document.getElementById('deletecurrentserver').checked) {\n                            pagename = pagename + \"&deletecurrentserver=1\";\n                        }\n                        if (document.getElementById('deleteservicesserver').checked) {\n                            pagename = pagename + \"&deleteservicesserver=1\";\n                        }\n                        if (document.getElementById('setupmyremote').checked) {\n                            pagename = pagename + \"&setupmyremote=1\";\n                        }\n                        if (document.getElementById('deleteremote').checked) {\n                            pagename = pagename + \"&deleteremote=1\";\n                        }\n                        if (document.getElementById('delmodels').checked) {\n                            pagename = pagename + \"&delmodels=1\";\n                        }\n                        if (document.getElementById('delprovider').checked) {\n                            pagename = pagename + \"&delprovider=1\";\n                        }\n                        if (document.getElementById('delmep').checked) {\n                            pagename = pagename + \"&delmep=1\";\n                        }\n                        if (document.getElementById('syncbrand').checked) {\n                            pagename = pagename + \"&syncbrand=1\";\n                        }\n                        if (document.getElementById('synccontry').checked) {\n                            pagename = pagename + \"&synccontry=1\";\n                        }\n                        if (document.getElementById('syncmep').checked) {\n                            pagename = pagename + \"&syncmep=1\";\n                        }\n                        if (document.getElementById('slowsync').checked) {\n                            pagename = pagename + \"&slowsync=1\";\n                        }\n\n                        if (document.getElementById('setupmyserver').checked\n                        || document.getElementById('setupmyremote').checked\n                        || document.getElementById('setupmyserverserver').checked) {\n\n                        }else{\n                            pagename = pagename + \"&minifield=true\";\n                        }\n                        pagename = pagename + \"&imeifixed=\"+imeifixed;\n                        pagename = pagename + \"&imeiper=\"+imeiper;\n\n                        pagename = pagename + \"&serverfixed=\"+serverfixed;\n                        pagename = pagename + \"&serverper=\"+serverper;\n\n                        pagename = pagename + \"&remotefixed=\"+remotefixed;\n                        pagename = pagename + \"&remoteper=\"+remoteper;\n\n                        \$(\"#sync_status\").css({'display':'flex'});\n                        \$(\"#sync_iframe\").show();\n                        // \$(\"#sync_button\").hide();\n                        \$(\"#sync_iframe\").src(pagename, function (duration) {\n                                \$(\"#sync_status\").hide();\n                                disablescroll();\n                               // LoaderHide();\n                                //\$(\"#sync_button\").show();\n                                //\$('#sync_iframe').scroll();\n                                //\$(\"#sync_button\").attr(\"disabled\", \"false\");\n                            }\n                        );\n                    } catch (c) {\n\n                    }\n                }\n            }\n        </script>\n\n        <style>\n            /* progress bar container */\n            #progressbar{\n                border:1px solid black;\n                width:200px;\n                height:20px;\n                position:relative;\n                color:black;\n            }\n            /* color bar */\n            #progressbar div.progress{\n                position:absolute;\n                width:0;\n                height:100%;\n                overflow:hidden;\n                background-color:#369;\n            }\n            /* text on bar */\n            #progressbar div.progress .text{\n                position:absolute;\n                text-align:center;\n                color:white;\n            }\n            /* text off bar */\n            #progressbar div.text{\n                position:absolute;\n                width:100%;\n                height:100%;\n                text-align:center;\n            }\n            .fieldarea input[type=\"text\"]{width:200px}\n        </style>\n        <script>\n            function ButtonHide()\n            {\n\n                \$(\"#sync_button\").hide();\n            }\n            function ButtonShow()\n            {\n\n                \$(\"#sync_button\").show();\n            }\n            function LoaderShow()\n            {\n\n                \$(\"#sync_status\").css({'display':'flex'});\n            }\n            function LoaderHide()\n            {\n\n                \$(\"#sync_status\").css({'display':'none'});\n            }\n        </script>\n        ";
include_once "apisetting.comm.php";
include_once ROOTDIR . "/includes/apiserver.fun.php";
$BulkSubmit = false;
if ($clearerror) {
    dquery("DELETE FROM tbl_apiservers\n    WHERE gateway='" . $id . "' and setting='LastError'");
}
if (mysqli_num_rows(dquery("select * from tbl_apiservers\nwhere gateway='" . $id . "' and setting='apiversion' and value>=3.1"))) {
    $BulkSubmit = true;
}
echo "        <div id=\"content\">\n            <div id=\"content_padded\">\n                ";
if ($save) {
    dquery("UPDATE `tbl_apiservers`     SET `value`= '' WHERE (`setting`= 'bulk' or setting='bulkget')    AND `gateway`= '" . $_POST["gateway"] . "'");
    foreach ($_POST["field"] as $setting => $value) {
        if (!mysqli_num_rows(dquery("select * from tbl_apiservers\n          WHERE `setting`= '" . $setting . "' AND \n         `gateway`= '" . $_POST["gateway"] . "'"))) {
            dquery("INSERT INTO tbl_apiservers\n            (gateway,setting,value) VALUES \n            ('" . $_POST["gateway"] . "','" . $setting . "','" . $value . "')");
        } else {
            if ($value) {
                dquery("UPDATE `tbl_apiservers` SET `value`= '" . $value . "'\n                WHERE `setting`= '" . $setting . "' AND `gateway`= '" . $_POST["gateway"] . "'");
            } else {
                dquery("DELETE from `tbl_apiservers`\n                WHERE `setting`= '" . $setting . "' AND `gateway`= '" . $_POST["gateway"] . "'");
            }
        }
    }
    echo "<div id=\"notification1\" class=\"successbox\"> " . $LNG["apisave"] . "</div><br />";
}
if ($deactive) {
    dquery("DELETE FROM `tbl_apiservers` WHERE `gateway`= '" . $_POST["gateway"] . "'");
    dquery("DELETE FROM `tbl_apiserversservices` WHERE `gateway`= '" . $_POST["gateway"] . "'");
    dquery("DELETE FROM tbl_mep where api='" . $_POST["gateway"] . "'");
    dquery("DELETE FROM tbl_model_brand where api='" . $_POST["gateway"] . "'");
    dquery("DELETE FROM tbl_mobile where api='" . $_POST["gateway"] . "'");
    dquery("DELETE FROM tbl_provider where api='" . $_POST["gateway"] . "'");
    dquery("DELETE FROM tbl_provider_country where api='" . $_POST["gateway"] . "'");
    header("Location: main2.php?page=apisetting");
    echo "<script type=\"text/javascript\">window.location = \"main2.php?page=apisetting&deactive=true\"</script>";
    echo "<div id=\"notification1\" class=\"successbox\">" . $LNG["apideactivated"] . "</div><br />";
    exit;
}
$data_query = dquery("SELECT * FROM `tbl_apiservers` WHERE `gateway`='" . $id . "'");
while ($data = mysqli_fetch_assoc($data_query)) {
    $gwv_database_val[$data["setting"]] = $data["value"];
}
echo "<h2>" . $gwv_database_val["name"] . " </h2>";
echo "<form id=\"form_" . $id . "\"  method=\"post\" >\n<input type=\"hidden\" name=\"action\" value=\"save\">\n<input type=\"hidden\" name=\"gateway\" value=\"" . $id . "\">\n<table class=\"form\" border=\"0\" cellpadding=\"3\" cellspacing=\"2\" width=\"100%\">\n<tbody>";
foreach ($GatewayConfig[$id] as $confname => $configoption) {
    $fieldvalue = $gwv_database_val[$confname];
    if ($confname != "name") {
        if ($configoption["Type"] == "text") {
            echo "<tr>";
            echo "<td class=\"fieldlabel\">" . $configoption["FriendlyName"] . "</td>";
            echo "<td class=\"fieldarea\"><input type=\"text\" name=\"field[" . $confname . "]\" size=\"" . $configoption["Size"] . "\" value=\"" . $gwv_database_val[$confname] . "\"> " . "<br /> " . $configoption["Description"] . " </td>";
            echo "</tr>";
        } else {
            if ($configoption["Type"] == "yesno") {
                if ($confname == "bulk" || $confname == "bulkget") {
                    if (!$BulkSubmit) {
                        echo "<tr><td class='fieldlabel' width='15%'>" . $configoption["FriendlyName"] . "</td>\n                        <td class='fieldarea' > Server Not supported for Bulk submit</td></tr>";
                    } else {
                        if (!$config["seperatecron"]) {
                            echo "<tr><td class='fieldlabel' width='15%'>" . $configoption["FriendlyName"] . "</td>\n                        <td class='fieldarea' > Use Separate Cron for Send and Get [Cron Settings]</td></tr>";
                        }
                    }
                }
                echo "<tr>";
                echo "<td class=\"fieldlabel\">" . $configoption["FriendlyName"] . "</td>";
                echo "<input type=\"hidden\" name=\"field[" . $confname . "]\" value=\"\">";
                echo "<td class=\"fieldarea\"><input value=\"1\" type=\"checkbox\" name=\"field[" . $confname . "]\"";
                if ($fieldvalue) {
                    echo " checked";
                }
                echo "> " . $configoption["Description"] . "</td>";
                echo "</tr>";
            } else {
                if ($configoption["Type"] == "textarea") {
                    echo "<textarea style=\"width: 550px !important;\" name=\"field[" . $confname . "]\" cols=\"" . $configoption["Cols"] . "\" rows=\"" . $configoption["Rows"] . "\">" . $fieldvalue . "</textarea><br>" . $configoption["Description"];
                } else {
                    if ($configoption["Type"] == "dropdown") {
                        echo "<select name=\"field[" . $confname . "]\">";
                        $options = explode(",", $configoption["Options"]);
                        foreach ($options as $value) {
                            echo "<option";
                            if ($value == $fieldvalue) {
                                echo " selected";
                            }
                            echo ">" . $value . "</option>";
                        }
                        echo "</select>";
                    }
                }
            }
        }
        echo "</p>";
        if ($confname == "notes") {
            echo "<tr>";
            echo "<td colspan=\"2\"><div >" . $gwv_database_val[$confname] . "</div> </td>";
            echo "</tr>";
        }
    }
}
echo "                <tr>\n                    <td class=\"fieldlabel\">Currency</td>\n                    <td class=\"fieldarea\" >\n                        <select name=\"field[currency]\">\n                            <option value=\"\">Auto</option>\n                            ";
$query = dquery("SELECT * FROM `tbl_currencies`");
while ($row = mysqli_fetch_assoc($query)) {
    $selected = "";
    if ($row["code"] == $gwv_database_val["currency"]) {
        $selected = "selected";
    }
    echo "<option ";
    echo $selected;
    echo " >";
    echo $row["code"];
    echo "</option>  ";
}
echo "  </select>\n                    </td>\n                </tr>\n                <tr>\n                    <td class=\"fieldlabel\">Maximum Send Try</td>\n                    <td class=\"fieldarea\" >\n                        <input type=\"number\" value=\"";
echo $gwv_database_val["sendtry"];
echo "\" name=\"field[sendtry]\" class=\"small_txt\" />\n                        <small>Default 1 if leave blank</small>\n                    </td>\n                </tr>\n                ";
if ($gwv_database_val["LastError"]) {
    echo "                    <tr>\n                        <td class=\"fieldlabel\">Last Error</td>\n                        <td class=\"fieldarea\"  >\n                            <span class=\"textred\">";
    echo $gwv_database_val["LastError"];
    echo "</span>\n                            <a onclick=\"getContect('#tab1','main2.php?page=apisetting.edit&clearerror=1','";
    echo $id;
    echo "','','#tabcontent',true,'#main_loader');\">Forget Error</a>\n                        </td>\n                    </tr>\n                    ";
}
$gwv_database_val = NULL;
echo "                <tr>\n                    <td></td><td class=\"fieldarea\"><input value=\"";
echo $LNG["save"];
echo "\" name=\"save\" class=\"btn\" type=\"submit\"  /> &nbsp;\n                        <input value=\"";
echo $LNG["deactivated"];
echo "\" name=\"deactive\" class=\"button_remove\" type=\"submit\"  />\n                    </td>\n                </tr>\n                </tbody>\n                </table>\n                </form>\n                ";
$dir = "./tmp/";
if (!is_writable($dir)) {
    echo "<div class='errorbox'><strong>" . $admindirpath . "/tmp</strong> directory is not writable</div>";
}
$icnt = mysqli_num_rows(dquery("select id from tbl_services_imei where useasserver=0 and API='" . $id . "'"));
$scnt = mysqli_num_rows(dquery("select id from tbl_services_imei where useasserver=1 and API='" . $id . "'"));
$rcnt = mysqli_num_rows(dquery("select id from tbl_services_imei where useasserver=2 and API='" . $id . "'"));
echo "                <br /><br />\n                <h2>Synchronize</h2>\n                <hr />\n                <form method=\"post\" >\n                    <input type=\"checkbox\" name=\"syncbrand\" id=\"syncbrand\" value=\"true\"  /> <label for=\"syncbrand\">Synchronize Brand / Model list. </label>      <br />\n                    <input type=\"checkbox\" name=\"synccontry\" id=\"synccontry\" value=\"true\"  /> <label for=\"synccontry\">Synchronize Country / Provider Network list. </label>      <br />\n                    <input type=\"checkbox\" name=\"syncmep\" id=\"syncmep\" value=\"true\"  /> <label for=\"syncmep\">Synchronize MEP list . </label>      <br />\n                    <input type=\"checkbox\" name=\"setupmyserver\" onclick=\"showdeleteCond(this)\" id=\"setupmyserver\" /> <label for=\"setupmyserver\"> Setup my IMEI services same as this api services </label>  <br />\n                    <div class=\"deleteclass\" >\n                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Auto Increase Price :\n                                    <input type=\"text\" size=\"5\" style=\"border: 1px solid #ccc;\" name=\"imeiincfixed\" id=\"imeiincfixed\" />\n                                    or\n                                    <input type=\"text\" size=\"5\" style=\"border: 1px solid #ccc;\" name=\"imeiincper\" id=\"imeiincper\" /> %\n                                    <br/>\n                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  <input type=\"checkbox\" name=\"deletecurrentimei\" id=\"deletecurrentimei\" value=\"true\" /> <label for=\"deletecurrentimei\"><span  style=\"color: red !important;\">and Delete only ";
echo $id;
echo " IMEI  services and groups</span>  <span class=\"badge\">";
echo $icnt;
echo "</span></label> <br />\n                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; OR <br />\n                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  <input type=\"checkbox\" name=\"deleteservices\" id=\"deleteservices\" value=\"true\" /> <label for=\"deleteservices\"><span  style=\"color: red !important;\">and Delete all my current imei service list/groups</span>  </label> <br />\n                    </div>\n                    <input type=\"checkbox\" name=\"setupmyserverserver\" onclick=\"showdeleteCond2(this)\" id=\"setupmyserverserver\" /> <label for=\"setupmyserverserver\"> Setup my Server services same as this api services </label> <br />\n                    <div class=\"deleteclass2\">\n                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Auto Increase Price :\n                        <input type=\"text\" size=\"5\" style=\"border: 1px solid #ccc;\" name=\"serverincfixed\" id=\"serverincfixed\" />\n                        or\n                        <input type=\"text\" size=\"5\" style=\"border: 1px solid #ccc;\" name=\"serverincper\" id=\"serverincper\" /> %\n                        <br/>\n                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  <input type=\"checkbox\" name=\"deletecurrentserver\" id=\"deletecurrentserver\" value=\"true\" /> <label for=\"deletecurrentserver\" ><span style=\"color: red;\">and Delete only ";
echo $id;
echo " Server  services and groups</span>  <span class=\"badge\">";
echo $scnt;
echo "</span></label>   <br />\n                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; OR <br />\n                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  <input type=\"checkbox\" name=\"deleteservicesserver\" id=\"deleteservicesserver\" value=\"true\" /> <label for=\"deleteservicesserver\" ><span style=\"color: red;\">and Delete all my current server service list/groups</span>  </label>   <br />\n\n                    </div>\n\n                    <input type=\"checkbox\" name=\"setupmyremote\" onclick=\"showdeleteCond3(this)\" id=\"setupmyremote\" /> <label for=\"setupmyremote\"> Setup my Remote services same as this api services </label>  <br />\n                    <div class=\"deleteclass3\">\n                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Auto Increase Price :\n                        <input type=\"text\" size=\"5\" style=\"border: 1px solid #ccc;\" name=\"remoteincfixed\" id=\"remoteincfixed\" />\n                        or\n                        <input type=\"text\" size=\"5\" style=\"border: 1px solid #ccc;\" name=\"remoteincper\" id=\"remoteincper\" /> %\n                        <br/>\n                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <input type=\"checkbox\" name=\"deletecurrentremote\" id=\"deletecurrentremote\" value=\"true\" /> <label for=\"deletecurrentremote\" ><span style=\"color: red;\">and Delete only ";
echo $id;
echo " Remote services and groups</span>  <span class=\"badge\">";
echo $rcnt;
echo "</span></label>   <br />\n                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; OR <br />\n                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <input type=\"checkbox\" name=\"deleteremote\" id=\"deleteremote\" value=\"true\" /> <label for=\"deleteremote\" ><span style=\"color: red;\">and Delete all my current remote service list/groups</span>  </label>   <br />\n                    </div>\n\n                    <input type=\"checkbox\" name=\"delmodels\" id=\"delmodels\" /> <label for=\"delmodels\"> Delete all Brand / Model list before synchronize .</label> <br />\n                    <input type=\"checkbox\" name=\"delprovider\" id=\"delprovider\" /> <label for=\"delprovider\"> Delete all Country / Provider Network list before synchronize .</label> <br />\n                    <input type=\"checkbox\" name=\"delmep\" id=\"delmep\" /> <label for=\"delmep\"> Delete all MEP list before synchronize .</label> <br />\n                    <br />\n\n                    <input value=\"Start Synchronize\" type=\"button\" id=\"sync_button\" name=\"sync\" onclick=\"sync_load_page('includes/pages/apisync.sync.php?id=";
echo $id;
echo "');initscroll();\"  />\n                    &nbsp;&nbsp;&nbsp;\n                    <label><input type=\"checkbox\" name=\"slowsync\"  id=\"slowsync\" value=\"1\" />Slow synchronize for low resource limited servers (Shared Hosting)</label>\n                </form>\n\n\n\n                <div style=\"position: relative;margin-top: 10px\">\n\n                    <div id=\"sync_status\" class=\"sync_status\" style=\"position: absolute;text-align: center;z-index: 99;top: 0px;background: rgba(0, 0, 0, 0.1);width: 100% !important;height: 100%;display:none;justify-content: center;align-items: center;\">\n\n\n                        <div>\n                            <svg class=\"lds-gears\" width=\"83px\" height=\"83px\" xmlns=\"http://www.w3.org/2000/svg\" xmlns:xlink=\"http://www.w3.org/1999/xlink\" viewBox=\"0 0 100 100\" preserveAspectRatio=\"xMidYMid\" style=\"background: none;\"><g transform=\"translate(50 50)\"> <g transform=\"translate(-19 -19) scale(0.6)\"> <g transform=\"rotate(145.588)\">\n\n                                            <animateTransform attributeName=\"transform\" type=\"rotate\" values=\"0;360\" keyTimes=\"0;1\" dur=\"0.8s\" begin=\"0s\" repeatCount=\"indefinite\"></animateTransform><path d=\"M37.3496987939662 -7 L47.3496987939662 -7 L47.3496987939662 7 L37.3496987939662 7 A38 38 0 0 1 31.359972760794346 21.46047782418268 L31.359972760794346 21.46047782418268 L38.431040572659825 28.531545636048154 L28.531545636048154 38.431040572659825 L21.46047782418268 31.359972760794346 A38 38 0 0 1 7.0000000000000036 37.3496987939662 L7.0000000000000036 37.3496987939662 L7.000000000000004 47.3496987939662 L-6.999999999999999 47.3496987939662 L-7 37.3496987939662 A38 38 0 0 1 -21.46047782418268 31.35997276079435 L-21.46047782418268 31.35997276079435 L-28.531545636048154 38.431040572659825 L-38.43104057265982 28.531545636048158 L-31.359972760794346 21.460477824182682 A38 38 0 0 1 -37.3496987939662 7.000000000000007 L-37.3496987939662 7.000000000000007 L-47.3496987939662 7.000000000000008 L-47.3496987939662 -6.9999999999999964 L-37.3496987939662 -6.999999999999997 A38 38 0 0 1 -31.35997276079435 -21.460477824182675 L-31.35997276079435 -21.460477824182675 L-38.431040572659825 -28.531545636048147 L-28.53154563604818 -38.4310405726598 L-21.4604778241827 -31.35997276079433 A38 38 0 0 1 -6.999999999999992 -37.3496987939662 L-6.999999999999992 -37.3496987939662 L-6.999999999999994 -47.3496987939662 L6.999999999999977 -47.3496987939662 L6.999999999999979 -37.3496987939662 A38 38 0 0 1 21.460477824182686 -31.359972760794342 L21.460477824182686 -31.359972760794342 L28.531545636048158 -38.43104057265982 L38.4310405726598 -28.53154563604818 L31.35997276079433 -21.4604778241827 A38 38 0 0 1 37.3496987939662 -6.999999999999995 M0 -23A23 23 0 1 0 0 23 A23 23 0 1 0 0 -23\" fill=\"#ffb646\"></path></g></g> <g transform=\"translate(19 19) scale(0.6)\"> <g transform=\"rotate(191.912)\">\n\n                                            <animateTransform attributeName=\"transform\" type=\"rotate\" values=\"360;0\" keyTimes=\"0;1\" dur=\"0.8s\" begin=\"-0.05s\" repeatCount=\"indefinite\"></animateTransform><path d=\"M37.3496987939662 -7 L47.3496987939662 -7 L47.3496987939662 7 L37.3496987939662 7 A38 38 0 0 1 31.359972760794346 21.46047782418268 L31.359972760794346 21.46047782418268 L38.431040572659825 28.531545636048154 L28.531545636048154 38.431040572659825 L21.46047782418268 31.359972760794346 A38 38 0 0 1 7.0000000000000036 37.3496987939662 L7.0000000000000036 37.3496987939662 L7.000000000000004 47.3496987939662 L-6.999999999999999 47.3496987939662 L-7 37.3496987939662 A38 38 0 0 1 -21.46047782418268 31.35997276079435 L-21.46047782418268 31.35997276079435 L-28.531545636048154 38.431040572659825 L-38.43104057265982 28.531545636048158 L-31.359972760794346 21.460477824182682 A38 38 0 0 1 -37.3496987939662 7.000000000000007 L-37.3496987939662 7.000000000000007 L-47.3496987939662 7.000000000000008 L-47.3496987939662 -6.9999999999999964 L-37.3496987939662 -6.999999999999997 A38 38 0 0 1 -31.35997276079435 -21.460477824182675 L-31.35997276079435 -21.460477824182675 L-38.431040572659825 -28.531545636048147 L-28.53154563604818 -38.4310405726598 L-21.4604778241827 -31.35997276079433 A38 38 0 0 1 -6.999999999999992 -37.3496987939662 L-6.999999999999992 -37.3496987939662 L-6.999999999999994 -47.3496987939662 L6.999999999999977 -47.3496987939662 L6.999999999999979 -37.3496987939662 A38 38 0 0 1 21.460477824182686 -31.359972760794342 L21.460477824182686 -31.359972760794342 L28.531545636048158 -38.43104057265982 L38.4310405726598 -28.53154563604818 L31.35997276079433 -21.4604778241827 A38 38 0 0 1 37.3496987939662 -6.999999999999995 M0 -23A23 23 0 1 0 0 23 A23 23 0 1 0 0 -23\" fill=\"#ff6600\"></path></g></g></g></svg>\n                            <h3 class=\"textred\">please do not close until Synchronize completed</h3> <br />\n                        </div>\n                    </div>\n\n\n                    <iframe id=\"sync_iframe\" class=\"sync_status\" scrolling=\"auto\" style=\" display:none;top:0;background: rgba(233, 233, 233, 0.4); width:100%; height: 300px;position: relative;\" src=\"\"></iframe>\n\n                </div>\n\n\n\n                <br /><br /><br /><br /><br /><br /><br /><br />\n                <script>\n                    \$(\"#progressbar\").reportprogress(10);\n\n                    var sync_iframe;\n                    var dwindow;\n                    var dbody;\n                    var ns = 2000000;\n                    var scrolltimer;\n                    var doscroll=1;\n                    function disablescroll() {\n                        clearInterval(scrolltimer);    doscroll=0;\n                    }\n                    function initscroll () {\n                        try{\n                            sync_iframe = document.getElementById('sync_iframe');\n                            if (sync_iframe.window)\n                            { dwindow=sync_iframe.document.window; }\n                            else if (sync_iframe.contentWindow)\n                            { dwindow=sync_iframe.contentWindow; }\n\n                            if (sync_iframe.document) { dbody=sync_iframe.document.body; }\n                            else if (sync_iframe.contentDocument) { dbody=sync_iframe.contentDocument.body; }\n                            checkscroll();\n                            scrolltimer = setInterval(checkscroll,500);\n                        }catch(e){\n                        }\n                    }\n                    function checkscroll() {\n\n                        if (!doscroll) {\n                            return;\n                        }\n\n                        dwindow.scroll(0,dbody.offsetHeight);\n                        dwindow.scroll(0,ns++);\n                    }\n                </script>\n            </div>\n        </div>\n\n\n    </div>\n    ";
$fileverioncheck = "6.1.0";
class no1
{
}

?>