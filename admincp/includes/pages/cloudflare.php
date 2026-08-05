<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

$pageid = 461;
checkPagePermission($pageid);
echo "\r\n    <div id=\"notification\"></div>\r\n\r\n    <div id=\"content\" style=\"width: 100%;!important \">\r\n    <div id=\"content_padded\" style=\"width: 100%;!important \">\r\n\r\n\r\n        <div  class=\"groupstabes\" >\r\n\r\n            ";
if ($config["cloudflarezoneid"] && $config["cloudflareapikey"]) {
    echo "    <h2>\r\n        <img src=\"data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAkAAAAJCAYAAADgkQYQAAAAAXNSR0IArs4c6QAAAAlwSFlzAAALEwAACxMBAJqcGAAAAAd0SU1FB9oIGRQbOY8MjgMAAAA8SURBVBjTY2BAAzdv3vwPBAzImAGbInSFWBU9f/4cRSFWRb9+/UJRiFMRTOGNGzf+k28SUW4iynfo4QQAj22WmutXxVsAAAAASUVORK5CYII=\">\r\n        <span class=\"groupstabesheadertext\">Add IPs</span>&nbsp;<font\r\n                class=\"backline\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</font>\r\n    </h2>\r\n    <div class=\"groupstabescontant\">\r\n\r\n        <form method=\"post\" id=\"frms\">\r\n            <table class=\"form\">\r\n                <tbody>\r\n                <tr>\r\n                    <td class=\"fieldlabel\">";
    echo $LNG["add"];
    echo " ";
    echo $LNG["ip"];
    echo " *</td>\r\n                    <td class=\"fieldarea\"><textarea name=\"ips\" style=\"height: 100px;\" rows=\"3\"></textarea>\r\n                        <small>";
    echo $LNG["iplistmessage"];
    echo "</small>\r\n                    </td>\r\n                </tr>\r\n                <tr>\r\n                    <td class=\"fieldlabel\">Mode</td>\r\n                    <td class=\"fieldarea\">\r\n                        <select name=\"mode\">\r\n                            <option>whitelist</option>\r\n                            <option>block</option>\r\n                            <option>challenge</option>\r\n                        </select>\r\n                    </td>\r\n                </tr>\r\n                </tbody>\r\n            </table>\r\n            <p class=\"fixedbtn\"><input value=\"";
    echo $LNG["save"];
    echo "\" id=\"btnaddgroup\" class=\"btn\" type=\"button\"\r\n                                       onclick=\"SubmitForm ('#btnaddgroup','cloudflare','#frms','#notification','true','#main_loader');\"/>\r\n            <form method=\"post\">\r\n                <input type=\"hidden\" name=\"laoddefaultpage\" value=\"cloudflare.php\" />\r\n                <input type=\"submit\" value=\"Fetch List from Cloudflare\"\r\n                       name=\"fetchcloudflare\"/>\r\n            </form>\r\n\r\n            </p>\r\n\r\n        </form>\r\n    </div></div>\r\n\r\n\r\n    ";
    if ($remove && $removeip) {
        $POST["cascade"] = "none";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://api.cloudflare.com/client/v4/zones/" . $config["cloudflarezoneid"] . "/firewall/access_rules/rules/" . $removeip);
        curl_setopt($ch, CURLOPT_GET, 1);
        curl_setopt($ch, CURLOPT_GETFIELDS, json_encode($POST));
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $headers = ["Content-Type:application/json", "X-Auth-Key:" . $config["cloudflareapikey"], "X-Auth-Email:" . $config["cloudflareemail"]];
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $server_output = curl_exec($ch);
        curl_close($ch);
        $result = json_decode($server_output, true);
    }
    if ($fetchcloudflare || $remove) {
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
        echo "        <table id=\"main_tbl\">\r\n            <thead>\r\n            <tr>\r\n                <th>";
        echo $LNG["ip"];
        echo "</th>\r\n                <th>Mode</th>\r\n                <th>Notes</th>\r\n                <th>\r\n                <div align=\"right\">";
        echo $LNG["action"];
        echo "</div>\r\n                </th>\r\n            </tr>\r\n            </thead>\r\n            <tbody>\r\n            ";
        foreach ($result["result"] as $detail) {
            echo "                <tr>\r\n                    <td>";
            echo $detail["configuration"]["value"];
            echo "</td>\r\n                    <td>";
            echo $detail["mode"];
            echo "</td>\r\n                    <td>";
            echo $detail["notes"];
            echo "</td>\r\n                    <td>\r\n<form method=\"post\" onsubmit=\"return confirm('Are you sure want to Remove ?');\">\r\n    <input type=\"hidden\" name=\"laoddefaultpage\" value=\"cloudflare.php\" />\r\n    <input type=\"hidden\" name=\"removeip\" value=\"";
            echo $detail["id"];
            echo "\" />\r\n    <input type=\"submit\" class=\"button_remove\"\r\n    value=\"";
            echo $LNG["remove"];
            echo "\" name=\"remove\" />\r\n</form>\r\n                    </td>\r\n                </tr>\r\n";
        }
        echo "            </tbody>\r\n        </table>\r\n        ";
    }
    echo "    </div>\r\n    ";
} else {
    echo "    <div id=\"notification1\" class=\"errorbox\">Set credentials in Cloudflare APi tab</div>\r\n                    ";
}
echo "    </div>";
$fileverioncheck = "6.1.0";

?>