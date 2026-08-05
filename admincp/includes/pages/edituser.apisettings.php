<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

echo "<script>\nfunction removeIP(){\n    var answer = confirm('";
echo $LNG["areyousureresetallip"];
echo "');\n    if(answer)\n    {\n        document.getElementById('connectionallowapi').value='';\n        SubmitForm ('#btnedituser','edituser.apisettings','#frmedituser','#notification','true','#main_loader');\n    }\n}\nfunction mask(str,textbox,loc,delim){\n    var locs = loc.split(',');\n    for (var i = 0; i <= locs.length; i++){\n        for (var k = 0; k <= str.length; k++){\n            if (k == locs[i]){\n                if (str.substring(k, k+1) != delim){\n                    str = str.substring(0,k) + delim + str.substring(k,str.length);\n                }\n            }\n        }\n    }\n    textbox.value = str;\n}\nfunction apik() {\n\tvar chars = \"0123456789ABCDEFGHIJKLMNOPQRSTUVWXTZ\";\n\tvar string_length = 3;\n\tvar randomstring = '';\n\tfor (var i=0; i<string_length; i++) {\n\t\tvar rnum = Math.floor(Math.random() * chars.length);\n\t\trandomstring += chars.substring(rnum,rnum+1);\n\t}\n\trandomstring +='-';\n\tfor (var i=0; i<string_length; i++) {\n\t\tvar rnum = Math.floor(Math.random() * chars.length);\n\t\trandomstring += chars.substring(rnum,rnum+1);\n\t}\n\trandomstring +='-';\n\tfor (var i=0; i<string_length; i++) {\n\t\tvar rnum = Math.floor(Math.random() * chars.length);\n\t\trandomstring += chars.substring(rnum,rnum+1);\n\t}\n\trandomstring +='-';\n\tfor (var i=0; i<string_length; i++) {\n\t\tvar rnum = Math.floor(Math.random() * chars.length);\n\t\trandomstring += chars.substring(rnum,rnum+1);\n\t}\n\trandomstring +='-';\n\tfor (var i=0; i<string_length; i++) {\n\t\tvar rnum = Math.floor(Math.random() * chars.length);\n\t\trandomstring += chars.substring(rnum,rnum+1);\n\t}\n\trandomstring +='-';\n\tfor (var i=0; i<string_length; i++) {\n\t\tvar rnum = Math.floor(Math.random() * chars.length);\n\t\trandomstring += chars.substring(rnum,rnum+1);\n\t}\n\trandomstring +='-';\n\tfor (var i=0; i<string_length; i++) {\n\t\tvar rnum = Math.floor(Math.random() * chars.length);\n\t\trandomstring += chars.substring(rnum,rnum+1);\n\t}\n\trandomstring +='-';\n\tfor (var i=0; i<string_length; i++) {\n\t\tvar rnum = Math.floor(Math.random() * chars.length);\n\t\trandomstring += chars.substring(rnum,rnum+1);\n\t}\n\n\tdocument.getElementById('apiaccesskey').value = randomstring;\n}\n</script>\n";
$pageid = 14;
checkPagePermission($pageid);
include_once ROOTDIR . "/includes/clients.fun.inc.php";
$clientDetails = getClientsDetails($id);
if ($addcloudflare && $cloudflareip) {
    $DATA["mode"] = "whitelist";
    $ConfigIP["target"] = "ip";
    $ConfigIP["value"] = trim($cloudflareip);
    $DATA["configuration"] = $ConfigIP;
    $DATA["notes"] = "Added From Fusion APi for User - " . $clientDetails["username"];
    $POST = json_encode($DATA);
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://api.cloudflare.com/client/v4/zones/" . $config["cloudflarezoneid"] . "/firewall/access_rules/rules");
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $POST);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $headers = ["Content-Type:application/json", "X-Auth-Key:" . $config["cloudflareapikey"], "X-Auth-Email:" . $config["cloudflareemail"]];
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    $server_output = curl_exec($ch);
    curl_close($ch);
    echo "<div id='notification1' class='successbox'>IP added to Cloudflare</div>";
}
$CLoudFlar = [];
if ($config["cloudflareapikey"] && $config["cloudflareemail"]) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://api.cloudflare.com/client/v4/zones/" . $config["cloudflarezoneid"] . "/firewall/access_rules/rules/?page=1&per_page=1000");
    curl_setopt($ch, CURLOPT_GET, 1);
    curl_setopt($ch, CURLOPT_GETFIELDS, $vars);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $headers = ["Content-Type:application/json", "X-Auth-Key:" . $config["cloudflareapikey"], "X-Auth-Email:" . $config["cloudflareemail"]];
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    $server_output = curl_exec($ch);
    curl_close($ch);
    $result = json_decode($server_output, true);
    foreach ($result["result"] as $detail) {
        $CLoudFlar[$detail["configuration"]["value"]] = $detail["mode"];
    }
}
if ($clientDetails["userstatus"] != "0") {
    echo "<div id=\"notification1\" class=\"info\">";
    if ($clientDetails["userstatus"] == "1") {
        $status = $LNG["thisaccounthasbeen"] . " " . $LNG["blocked"];
    } else {
        if ($clientDetails["userstatus"] == "2") {
            $status = $LNG["thisaccounthasbeen"] . " " . $LNG["inactive"];
        }
    }
    echo "<span><strong>";
    echo $status;
    echo "</strong></span></div>";
}
echo "<div id=\"notification\"></div>\n<div id=\"content\">\n<div id=\"content_padded\">\n\n<form id=\"frmedituser\" name=\"\" method=\"post\">\n";
echo generate_token("form");
echo "<div  class=\"groupstabes\" >\n  <h2>\n    <img src=\"data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAkAAAAJCAYAAADgkQYQAAAAAXNSR0IArs4c6QAAAAlwSFlzAAALEwAACxMBAJqcGAAAAAd0SU1FB9oIGRQbOY8MjgMAAAA8SURBVBjTY2BAAzdv3vwPBAzImAGbInSFWBU9f/4cRSFWRb9+/UJRiFMRTOGNGzf+k28SUW4iynfo4QQAj22WmutXxVsAAAAASUVORK5CYII=\">\n    <span class=\"groupstabesheadertext\">API Settings</span>&nbsp;<font class=\"backline\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</font>\n  </h2>\n  <div class=\"groupstabescontant\">\n<input type=\"hidden\" name=\"id\" value=\"";
echo $id;
echo "\"/>\n\n<table class=\"form\">\n    <tr>\n    <td class=\"fieldlabel\">";
echo $LNG["apiallow"];
echo "</td>\n    <td class=\"fieldarea\"><span><input type=\"checkbox\" class=\"onoff {labelOn: 'Enable', labelOff: 'Disable'}\" name=\"apiallow\" id=\"hs\" value=\"1\" ";
if ($clientDetails["access"]["api"]) {
    echo "checked";
}
echo "/><label for=\"hs\"></label></span>\n     </td>\n</tr>\n</table>\n\n<table class=\"form hs\" border=\"0\"  cellspacing=\"2\" width=\"100%\">\n<tbody>\n\n\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["apiaccesskey"];
echo "</td>\n    <td class=\"fieldarea\"><input id=\"apiaccesskey\" name=\"apiaccesskey\"  value=\"";
echo $clientDetails["access"]["api_access_key"];
echo "\" type=\"text\"  class=\"txt\" style=\"width: 300px;\"/><input type=\"button\" class=\"addFromgallery\" value=\"";
echo $LNG["generateapi"];
echo "\" name=\"generateapi\" onclick=\"apik();\"/>\n    <a href=\"javascript: load_subpage('main2.php?page=emailtemplate.edit&id=11','";
echo $LNG["edit"];
echo " ";
echo $LNG["mail"];
echo " ";
echo $LNG["template"];
echo "')\" class=\"btn\"> ";
echo $LNG["edit"];
echo " ";
echo $LNG["mail"];
echo " ";
echo $LNG["template"];
echo "</a>\n    </td>\n</tr>\n\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["connectionallowapi"];
echo "</td>\n    <td class=\"fieldarea\">\n        <div>\n        <textarea name=\"connectionallowapi\"   id=\"connectionallowapi\" rows='5'  >";
echo $clientDetails["access"]["api_remote_ip"];
echo "</textarea>\n        </div>\n        <div class=\"mt-2\">\n        <input class=\"btn\" name=\"IP\" onclick=\"removeIP()\" value=\"";
echo $LNG["reset"];
echo "\" type=\"button\"    /> <small>";
echo $LNG["iploginsecurity"];
echo "</small>\n        </div>\n    </td>\n</tr>\n\n\n<tr>\n    <td></td>\n    <td class=\"fieldarea\"><input type=\"checkbox\" id=\"sendmail\" name=\"sendmail\" checked=\"checked\"/><label for=\"sendmail\">Send API Access Details Via Email</label></td>\n</tr>\n</tbody>\n</table>\n    </div>\n\n<p  class=\"fixedbtn\"><input value=\"";
echo $LNG["save"];
echo "\"\nid=\"btnedituser\" class=\"btn\" type=\"button\"\nonclick=\"SubmitForm ('#btnedituser','edituser.apisettings','#frmedituser','#notification','true','#main_loader');\"/></p>\n</div></div>\n</form>\n    ";
if ($config["cloudflareapikey"] && $config["cloudflareemail"]) {
    echo "    <table id=\"main_tbl\">\n        <thead>\n        <tr>\n            <th>";
    echo $LNG["ip"];
    echo "</th>\n            <th>Mode</th>\n            <th>\n            <div align=\"right\">";
    echo $LNG["action"];
    echo "</div>\n            </th>\n        </tr>\n        </thead>\n        <tbody>\n    ";
    $ips = $clientDetails["access"]["api_remote_ip"];
    $ips = explode("\n", $ips);
    foreach ($ips as $ip) {
        if ($ip) {
            echo " <tr>\n                <td>";
            echo $ip;
            echo "</td>\n ";
            if (array_key_exists($ip, $CLoudFlar)) {
                echo "                <td>";
                echo $CLoudFlar[$ip];
                echo "  in Cloudflare</td>\n                <td>-</td>\n                ";
            } else {
                echo "                <td>\n                    whitelist\n                </td>\n                <td>\n            <form method=\"post\">\n                <input type=\"hidden\" name=\"cloudflareip\" value=\"";
                echo $ip;
                echo "\" />\n                <input type=\"hidden\" name=\"laoddefaultpage\" value=\"edituser.apisettings.php\" />\n                <input type=\"submit\" name=\"addcloudflare\" value=\"";
                echo $LNG["add"];
                echo " ";
                echo $LNG["to"];
                echo " Cloudflare\" />\n            </form>\n                </td>\n                ";
            }
            echo "\n            </tr>\n        ";
        }
    }
}
echo "        </tbody>\n    </table>\n</div>\n\n\n<div id=\"pageinfo\" class=\"pageinfo\">\n<li>Allow or Deny APi connection and set its access</li>\n</div>";
$fileverioncheck = "6.1.0";

?>