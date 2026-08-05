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
if (isset($counter)) {
    checkDemoMode(false);
    if ($id) {
        $data["assigned_mep"] = $counter;
        if ($db->update("tbl_services_imei", $data, "id=" . $id)) {
            echo "<div id=notification1 class=successbox> " . $LNG["modelassign"] . " " . $LNG["savesuccessfully"] . " </div>";
        } else {
            echo "<div id=notification1 class=errorbox> " . $LNG["datanotsave"] . " </div>";
        }
    } else {
        echo "<div id=notification1 class=errorbox>" . $LNG["service"] . " " . $LNG["not"] . "  " . $LNG["selected"] . " </div>";
    }
}
if (isset($btnedituser)) {
    checkDemoMode(false);
    if ($mep_check) {
        $mep = implode(",", $mep_check);
        if ($all_mep == "ALL") {
            $data["assigned_mep"] = "ALL";
        } else {
            $data["assigned_mep"] = $mep;
        }
        if ($db->update("tbl_services_imei", $data, "id=" . $id)) {
            echo "<div id=notification1 class=successbox> " . $LNG["mepassign"] . " " . $LNG["savesuccessfully"] . " </div>";
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
echo "<script>\nfunction setUNchk(){\n    document.getElementById('alls').checked=false;\n}\n</script>\n<script>\nfunction setvals(ob){\n\tvar cnt=document.getElementById('counter').value;\n\tif(ob.checked){\n\t\tif(cnt!=\"\"){\n\t\t\tcnt= cnt+','+ob.value;\n\t\t}else{\n\t\t\tcnt= ob.value;\n\t\t}\n\t}else{\n\t\tvar spl=cnt.split(',');\n\t\tlen=spl.length;\n\t\tvar news=new Array(); \n\t\tfor(var i=0; i<len; i++) {\n\t\t\tvals=spl[i];\n\t\t\tif(vals!=ob.value){\n\t\t\t\tnews[i]=vals;\t\n\t\t\t}\n\t\t}\n\t\tcnt=\"\";\n\t\tlen=news.length;\n\t\tfor(var i=0;i<len; i++) {\n\t\t\tif(news[i]!=undefined){\n\t\t\t\t\n\t\t\t\tvals=news[i];\n\t\t\t\tif(cnt!=\"\"){\n\t\t\t\t\tcnt= cnt+','+vals;\n\t\t\t\t}else{\n\t\t\t\t\tcnt= vals;\n\t\t\t\t}\n\t\t\t\t\n\t\t\t}\n\t\t}\n\t}\n\t\n\tdocument.getElementById('counter').value=cnt;\n}\nfunction SetAllCheckBoxesS(val)\n{\n\tif(val.checked)\n\t{\n\t\t\tvar cnt=\"\";\n\t\tvar array = document.getElementsByTagName(\"input\");\n\t\tfor(var ii = 0; ii < array.length; ii++)\n\t\t{\n\t\t   if(array[ii].type == \"checkbox\")\n\t\t   {\n\t\t\t    if(array[ii].value!='ALL'){\n\t\t\t\t\t   if(cnt!=\"\"){\n\t\t\t\t\t\t\tcnt= cnt+','+array[ii].value;\n\t\t\t\t\t\t}else{\n\t\t\t\t\t\t\tcnt= array[ii].value;\n\t\t\t\t\t\t}\n\t\t\t    }\n\t\t\t\tarray[ii].checked = true;\n\t\t   }\n\t\t   document.getElementById('counter').value=cnt;\n\t\t}\n\t}\n\telse\n\t{\n\t\tdocument.getElementById('counter').value=\"\";\n\t\tvar array = document.getElementsByTagName(\"input\");\n\t\tfor(var ii = 0; ii < array.length; ii++)\n\t\t{\n\t\t   if(array[ii].type == \"checkbox\")\n\t\t   {\n\t\t\t\tarray[ii].checked = false;\n\t\t   }\n\t\t}\n\t}\t\n}\n</script>\n\n<form id=\"submitori\" method=\"post\">\n<input type=\"hidden\" value=\"";
echo $id;
echo "\" name=\"id\"/>\n<input type=\"hidden\" value=\"";
echo $imeiserviceDetails["reqredfield"]["assigned_mep"];
echo "\" name=\"counter\" id=\"counter\" />\n</form>\n\n<form id=\"frmmep\" name=\"\" method=\"post\">\n<input type=\"hidden\" value=\"";
echo $id;
echo "\" name=\"id\"/>\n";
echo generate_token("form");
$result = dquery("select ID,mep from tbl_mep where api='" . $imeiserviceDetails["listing"] . "'");
$numrows = mysqli_num_rows($result);
echo "<table id=\"main_tbl\" style=\"display: table;\">\n            <thead>\n              <tr class=\"singletd\">\n                <th> <input value=\"ALL\" class=\"check-all\"  id=\"alls\" name=\"all_mep\" onclick=\"SetAllCheckBoxesS(this)\" type=\"checkbox\"/> <label for=\"alls\"></label></th><th width=\"20px\">";
echo $LNG["id"];
echo "</th><th><div align=\"left\">";
echo $LNG["mep"];
echo " ";
echo $LNG["name"];
echo "</div> </th>\n                <th></th>\n              </tr>\n            </thead>\n            <tbody>\n";
if ($numrows) {
    $mep = explode(",", $imeiserviceDetails["reqredfield"]["assigned_mep"]);
    while ($row = mysqli_fetch_assoc($result)) {
        if (in_array($row["ID"], $mep) || $imeiserviceDetails["reqredfield"]["assigned_mep"] == "ALL" || $imeiserviceDetails["reqredfield"]["assigned_mep"] == "") {
            $checked = "checked";
        } else {
            $checked = "";
        }
        echo "<tr class='singletd'><td><input  onclick='setvals(this);' \n        name=mep_check[" . $row["ID"] . "] value=" . $row["ID"] . " type=checkbox " . $checked . " id='i_" . $row["ID"] . "'><label for='i_" . $row["ID"] . "'></label></td><td>" . $row["ID"] . "</td><td>" . $row["mep"] . "</td> <td></td> </tr>";
    }
}
echo "</tbody></table>\n\n<p class=\"fixedbtn\"><input name=\"btnedituser\" value=\"";
echo $LNG["save"];
echo "\" id=\"btnedituser\" class=\"btn save\"\nonclick=\"document.getElementById('submitori').submit();\" type=\"button\" /></p>\n</form>\n<br /><br /><br />";
$fileverioncheck = "6.1.0";

?>