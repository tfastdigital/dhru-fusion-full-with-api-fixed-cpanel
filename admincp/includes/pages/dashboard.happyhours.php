<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

if (!$_SESSION["adminid"]) {
    exit("error:invalid token");
}
if ($config["happyhours"]) {
    $day = date("D", time());
    $time = date("Y-m-d H:i", time());
    $result = dquery("select 1 as tbl,promotiondis,happy_hours_start,happy_hours_end,\nhappy_hours_weekdays,credit,service_name,id from tbl_services_imei WHERE \n('" . $time . "' between happy_hours_start and happy_hours_end) or \n(happy_hours_weekdays like '%" . $day . "%') union select 2,promotiondis,happy_hours_start,\nhappy_hours_end,happy_hours_weekdays,credit,service_name,id from tbl_services_file\nWHERE ('" . $time . "' between happy_hours_start and happy_hours_end) or \n(happy_hours_weekdays like '%" . $day . "%') union select 3,\npromotiondis,happy_hours_start,happy_hours_end,happy_hours_weekdays,credit,service_name,id\nfrom tbl_server_log WHERE ('" . $time . "' between happy_hours_start and happy_hours_end) or \n(happy_hours_weekdays like '%" . $day . "%') union select 4,\npromotiondis,happy_hours_start,happy_hours_end,happy_hours_weekdays,credit,service_name,id from \ntbl_products WHERE ('" . $time . "' between happy_hours_start and happy_hours_end) or\n(happy_hours_weekdays like '%" . $day . "%')");
    if (mysqli_num_rows($result)) {
        echo "<table cellspacing=\"0\" cellpadding=\"4\"  id=\"main_tbl\">\n<thead>\n    <tr><th>";
        echo $LNG["id"];
        echo "</th>\n    <th align=\"left\">";
        echo $LNG["service"];
        echo " ";
        echo $LNG["name"];
        echo "    </th><th align=\"center\">";
        echo $LNG["credit"];
        echo "</th>\n    <th align=\"center\">";
        echo $LNG["promotion"];
        echo " ";
        echo $LNG["credit"];
        echo "    </th>\n    <th align=\"center\">";
        echo $LNG["start"];
        echo " ";
        echo $LNG["date"];
        echo "    </th><th align=\"center\">";
        echo $LNG["end"];
        echo " ";
        echo $LNG["date"];
        echo "</th><th align=\"center\">";
        echo $LNG["days"];
        echo "</th></tr>\n</thead>    \n    ";
        while ($row = mysqli_fetch_assoc($result)) {
            if (!$row["happy_hours_start"]) {
                $row["happy_hours_start"] = "---";
            }
            if (!$row["happy_hours_end"]) {
                $row["happy_hours_end"] = "---";
            }
            if (!$row["happy_hours_weekdays"]) {
                $row["happy_hours_weekdays"] = "---";
            }
            if (!($IsFileOnly && $row["tbl"] != 2)) {
                if ($row["tbl"] == "1") {
                    echo "                <tr><td>";
                    echo $row["id"];
                    echo "</td><td align=\"left\">";
                    echo $row["service_name"];
                    echo " </td><td align=\"center\">";
                    echo formatCurrency($row["credit"]);
                    echo "</td><td align=\"center\">";
                    echo formatCurrency($row["promotiondis"]);
                    echo "</td><td align=\"center\">";
                    echo $row["happy_hours_start"];
                    echo "</td><td align=\"center\">";
                    echo $row["happy_hours_end"];
                    echo "</td><td align='center'><a href=\"javascript:load_fromsubpage('editimeiservice.happyhours&id=";
                    echo $row["id"];
                    echo "','";
                    echo $row["service_name"];
                    echo "')\">";
                    echo $row["happy_hours_weekdays"];
                    echo "</a></td></tr>\n            ";
                }
                if ($row["tbl"] == "2") {
                    echo "                <tr><td>";
                    echo $row["id"];
                    echo "</td><td align=\"left\">";
                    echo $row["service_name"];
                    echo " </td><td align=\"center\">";
                    echo formatCurrency($row["credit"]);
                    echo "</td><td align=\"center\">";
                    echo formatCurrency($row["promotiondis"]);
                    echo "</td><td align=\"center\">";
                    echo $row["happy_hours_start"];
                    echo "</td><td align=\"center\">";
                    echo $row["happy_hours_end"];
                    echo "</td><td align='center'><a href=\"javascript:load_fromsubpage('editfileservice.happyhours&id=";
                    echo $row["id"];
                    echo "','";
                    echo $row["service_name"];
                    echo "')\">";
                    echo $row["happy_hours_weekdays"];
                    echo "</a></td></tr>\n            ";
                }
                if ($row["tbl"] == "3") {
                    echo "                <tr><td>";
                    echo $row["id"];
                    echo "</td><td align=\"left\">";
                    echo $row["service_name"];
                    echo " </td><td align=\"center\">";
                    echo formatCurrency($row["credit"]);
                    echo "</td><td align=\"center\">";
                    echo formatCurrency($row["promotiondis"]);
                    echo "</td><td align=\"center\">";
                    echo $row["happy_hours_start"];
                    echo "</td><td align=\"center\">";
                    echo $row["happy_hours_end"];
                    echo "</td><td align='center'><a href=\"javascript:load_fromsubpage('editserverservice.happyhours&id=";
                    echo $row["id"];
                    echo "','";
                    echo $row["service_name"];
                    echo "')\">";
                    echo $row["happy_hours_weekdays"];
                    echo "</a></td></tr>\n            ";
                }
                if ($row["tbl"] == "4") {
                    echo "                <tr><td>";
                    echo $row["id"];
                    echo "</td><td align=\"left\">";
                    echo $row["service_name"];
                    echo " </td><td align=\"center\">";
                    echo formatCurrency($row["credit"]);
                    echo "</td><td align=\"center\">";
                    echo formatCurrency($row["promotiondis"]);
                    echo "</td><td align=\"center\">";
                    echo $row["happy_hours_start"];
                    echo "</td><td align=\"center\">";
                    echo $row["happy_hours_end"];
                    echo "</td><td align='center'><a href=\"javascript:load_fromsubpage('editproduct.happyhours&id=";
                    echo $row["id"];
                    echo "','";
                    echo $row["service_name"];
                    echo "')\">";
                    echo $row["happy_hours_weekdays"];
                    echo "</a></td></tr>\n            ";
                }
            }
        }
        echo "    \n    </table>\n    <br />\n    ";
    }
} else {
    echo "    <div>";
    echo $LNG["happy"];
    echo " ";
    echo $LNG["hours"];
    echo " ";
    echo $LNG["is"];
    echo " ";
    echo $LNG["now"];
    echo " ";
    echo $LNG["disable"];
    echo " ";
    echo $LNG["please"];
    echo " ";
    echo $LNG["go"];
    echo " ";
    echo $LNG["on"];
    echo " Settings > General Settings > Orders ";
    echo $LNG["to"];
    echo " ";
    echo $LNG["enable"];
    echo " it</div>\n";
}
$fileverioncheck = "6.1.0";

?>