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
    $result = dquery("select 4 as tbl,promotiondis,happy_hours_start,happy_hours_end,happy_hours_weekdays,credit,service_name,id from tbl_products WHERE ('" . $time . "' between happy_hours_start and happy_hours_end) or (happy_hours_weekdays like '%" . $day . "%')");
    $numrows = mysqli_num_rows(dquery("select 4 as tbl,promotiondis,happy_hours_start,happy_hours_end,happy_hours_weekdays,credit,service_name,id from tbl_products WHERE ('" . $time . "' between happy_hours_start and happy_hours_end) or (happy_hours_weekdays like '%" . $day . "%')"));
    if ($numrows) {
        echo "    <table cellspacing=\"0\" cellpadding=\"4\" id=\"deshbordsub\">\n    <!--\n<thead align=\"left\"><td colspan=\"7\"><strong style=\"color:#4572A7;\">";
        echo $LNG["currently"];
        echo " ";
        echo $LNG["running"];
        echo " ";
        echo $LNG["happy"];
        echo " ";
        echo $LNG["hours"];
        echo " ";
        echo $LNG["service"];
        echo " </strong></td></thead>\n-->\n<thead>\n    <tr><th><strong>";
        echo $LNG["id"];
        echo "</strong></th><th align=\"left\"><strong>";
        echo $LNG["service"];
        echo " ";
        echo $LNG["name"];
        echo "</strong></th><th align=\"center\"><strong>";
        echo $LNG["credit"];
        echo "</strong></th><th align=\"center\"><strong>";
        echo $LNG["promotion"];
        echo " ";
        echo $LNG["credit"];
        echo "</strong></th><th align=\"center\"><strong>";
        echo $LNG["start"];
        echo " ";
        echo $LNG["date"];
        echo "</strong></th><th align=\"center\"><strong>";
        echo $LNG["end"];
        echo " ";
        echo $LNG["date"];
        echo "</strong></th><th align=\"center\"><strong>";
        echo $LNG["days"];
        echo "</strong></th></tr>\n</thead>    \n    ";
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
            if ($row["tbl"] == "4") {
                echo "<tr><td>" . $row["id"] . "</td><td align='left'><a href=javascript:redirectedit('editproduct','" . $row["id"] . "')> " . $row["service_name"] . "</a></td><td align=center>" . formatCurrency($row["credit"]) . "</td><td align=center>" . formatCurrency($row["promotiondis"]) . "</td><td align=center>" . $row["happy_hours_start"] . "</td><td align=center>" . $row["happy_hours_end"] . "</td><td align=center><a href=javascript:redirectedit('editproduct.happyhours','" . $row["id"] . "')>" . $row["happy_hours_weekdays"] . "</a></td></tr>";
            }
        }
        echo "    \n    </table>\n    <br />\n    ";
    }
} else {
    echo "    <div><strong>";
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
    echo "</strong> Settings > General Settings > Orders <strong>";
    echo $LNG["to"];
    echo " ";
    echo $LNG["enable"];
    echo " it</strong></div>\n";
}
echo "\n";
$fileverioncheck = "6.1.0";

?>