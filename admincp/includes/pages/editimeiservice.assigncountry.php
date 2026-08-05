<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

require_once "includes/fun.inc.php";
if (!$_SESSION["adminid"]) {
    echo "<div align=\"center\"><h3>Session expired. <a style=\"color: #666;\" href=\"index.php?main2redirect=true\">Please relogin</a></h3></div>";
    $_SESSION["admin_afterlogin_re"] = $_SERVER["REQUEST_URI"];
    exit;
}
if (isset($btnedituser)) {
    checkDemoMode(false);
    if ($country_check) {
        $country = implode(",", $country_check);
        if ($all_country == "ALL") {
            $data["assigned_country"] = "ALL";
        } else {
            $data["assigned_country"] = $country;
        }
        if ($db->update("tbl_services_imei", $data, "id=" . $id)) {
            echo "<div id=notification1 class=successbox> " . $LNG["countryassign"] . " " . $LNG["savesuccessfully"] . " </div>";
        } else {
            echo "<div id=notification1 class=errorbox> " . $LNG["datanotsave"] . " </div>";
        }
    } else {
        echo "<div id=notification1 class=errorbox>" . $LNG["service"] . " " . $LNG["not"] . "  " . $LNG["selected"] . " </div>";
    }
}
include_once ROOTDIR . "/includes/imeiservices.fun.php";
$md5id = md5($id);
$imeiserviceDetails = getIMEIServices("", $md5id);
echo "<script>\nfunction setUNchk(){\n    document.getElementById('alls').checked=false;\n}\n\nfunction SetAllCheckBoxesS(val)\n{\n\tif(val.checked)\n\t{\n\t\t\tvar cnt=\"\";\n\t\tvar array = document.getElementsByTagName(\"input\");\n\t\tfor(var ii = 0; ii < array.length; ii++)\n\t\t{\n\t\t   if(array[ii].type == \"checkbox\")\n\t\t   {\n\t\t\t    if(array[ii].value!='ALL'){\n\t\t\t\t\t   if(cnt!=\"\"){\n\t\t\t\t\t\t\tcnt= cnt+','+array[ii].value;\n\t\t\t\t\t\t}else{\n\t\t\t\t\t\t\tcnt= array[ii].value;\n\t\t\t\t\t\t}\n\t\t\t    }\n\t\t\t\tarray[ii].checked = true;\n\t\t   }\n\t\t}\n\t}\n\telse\n\t{\n\t\tvar array = document.getElementsByTagName(\"input\");\n\t\tfor(var ii = 0; ii < array.length; ii++)\n\t\t{\n\t\t   if(array[ii].type == \"checkbox\")\n\t\t   {\n\t\t\t\tarray[ii].checked = false;\n\t\t   }\n\t\t}\n\t}\t\n}\n\n</script>\n<form id=\"frmcountry\" name=\"\" method=\"post\">\n<input type=\"hidden\" value=\"";
echo $id;
echo "\" name=\"id\"/>\n";
echo generate_token("form");
$result = dquery("select ID,Name from tbl_provider_country where api='" . $imeiserviceDetails["listing"] . "'");
$numrows = mysqli_num_rows($result);
echo "<table id=\"main_tbl\" style=\"display: table;\">\n<thead>\n  <tr class=\"singletd\">\n    <th> <input value=\"ALL\" class=\"check-all\"  \n    id=\"alls\" name=\"all_country\" onclick=\"SetAllCheckBoxesS(this)\" type=\"checkbox\"/> \n    <label for=\"alls\"></label></th><th>";
echo $LNG["id"];
echo "</th><th><div align=\"left\">";
echo $LNG["country"];
echo " ";
echo $LNG["name"];
echo "</div> </th>\n    <th></th>\n  </tr>\n</thead>\n<tbody>\n";
if ($numrows) {
    $country = explode(",", $imeiserviceDetails["reqredfield"]["assigned_country"]);
    while ($row = mysqli_fetch_assoc($result)) {
        if (in_array($row["ID"], $country) || $imeiserviceDetails["reqredfield"]["assigned_country"] == "ALL" || $imeiserviceDetails["reqredfield"]["assigned_country"] == "") {
            $checked = "checked";
        } else {
            $checked = "";
        }
        echo "<tr  class='singletd'><td><input onclick='setUNchk();' \n    name=country_check[" . $row["ID"] . "] value=" . $row["ID"] . " type=checkbox " . $checked . " id='i_" . $row["ID"] . "'><label for='i_" . $row["ID"] . "'></label></td><td>" . $row["ID"] . "</td><td>" . $row["Name"] . "</td> <td></td> </tr>";
    }
}
echo "</tbody></table>\n\n<p class=\"fixedbtn\"><input name=\"btnedituser\" value=\"";
echo $LNG["save"];
echo "\" id=\"btnedituser\" class=\"btn save\" type=\"submit\" /></p>\n\n</form>\n<br /><br /><br />";
$fileverioncheck = "6.1.0";

?>