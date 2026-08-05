<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

define("DEFINE_MY_ACCESS", true);
define("DEFINE_DHRU_FILE", true);
define("ADMIN", true);
if ($other) {
    require_once "../comm.php";
    require_once "../includes/fun.inc.php";
    require_once "includes/fun.inc.php";
} else {
    require_once "../../../comm.php";
    require_once "../../../includes/fun.inc.php";
    require_once "../../includes/fun.inc.php";
}
if (!checkAdminlogin() || !$_SESSION["adminid"]) {
    echo "<div align=\"center\"><h3>Session expired. <a style=\"color: #666;\" href=\"index.php?main2redirect=true\">Please relogin</a></h3></div>";
    $_SESSION["admin_afterlogin_re"] = $_SERVER["REQUEST_URI"];
    exit;
}
if ($pid && $mid && $mep && ($mep1 || $mep4)) {
    checkDemoMode(false);
    $data["pid"] = $pid;
    $data["mid"] = $mid;
    $data["mep"] = $mep;
    if ($mep1) {
        $str .= "2,";
    }
    if ($mep4) {
        $str .= "4,";
    }
    $str = trim($str, ",");
    $data["mepl"] = $str;
    if ($db->update("tbl_provider_model_mep", $data, "id='" . $id . "'")) {
        echo "<div id=notification1 class=successbox> " . $LNG["datasave"] . " " . $LNG["savesuccessfully"] . " </div>";
    } else {
        echo "<div id=notification1 class=errorbox> " . $LNG["datanotsave"] . " </div>";
    }
}
$cntr = mysqli_fetch_assoc(dquery("SELECT *,(select api from tbl_mobile \nwhere ID=mid) as api FROM tbl_provider_model_mep WHERE id='" . $id . "'"));
echo "<link rel=\"stylesheet\" href=\"../../templates/";
echo $_SESSION["admin_template"];
echo "/x-main2.css\" />\n<script src=\"../js/jquery.js\" language=\"javascript\"></script>\n<script src=\"../../templates/";
echo $_SESSION["admin_template"];
echo "/js/x-main2.fun.js\" language=\"javascript\"></script>\n<div id=\"notification\"></div>\n<div  class=\"groupstabes\" >\n\n  <div class=\"groupstabescontant\">\n\n<script>\n \$(document).ready(function() {\n\n    \$('#country').change(function() {\n        var str;\n        str = \$(this).val();\n         if(str!=''){\n             \$.get(\"getFields.php\", { id: str,type: 'country'},\n             function(data){\n                \$(\"#provider\").html(data);\n            });\n       }\n    });\n    \$('#brand').change(function() {\n        var str;\n        str = \$(this).val();\n         if(str!=''){\n             \$.get(\"getFields.php\", { id: str,type: 'brand'},\n             function(data){\n                \$(\"#model\").html(data);\n            });\n       }\n    });\n\n });\n</script>\n<div id=\"content\">\n<div id=\"content_padded\" style=\"padding: 20px;\">\n <h2>\n    <img src=\"data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAkAAAAJCAYAAADgkQYQAAAAAXNSR0IArs4c6QAAAAlwSFlzAAALEwAACxMBAJqcGAAAAAd0SU1FB9oIGRQbOY8MjgMAAAA8SURBVBjTY2BAAzdv3vwPBAzImAGbInSFWBU9f/4cRSFWRb9+/UJRiFMRTOGNGzf+k28SUW4iynfo4QQAj22WmutXxVsAAAAASUVORK5CYII=\">\n    <span class=\"groupstabesheadertext\">";
echo $cntr["mep"];
echo "</span>&nbsp;<font class=\"backline\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</font>\n  </h2>\n<form id=\"frm\" name=\"\" method=\"post\">\n<input type=\"hidden\" name=\"id\" value=\"";
echo $id;
echo "\" />\n<table class=\"form\" border=\"0\" cellpadding=\"3\" cellspacing=\"2\" width=\"100%\">\n<tbody>\n";
$cid = mysqli_fetch_assoc(dquery("select C_ID from tbl_provider where ID='" . $cntr["pid"] . "'"));
$bid = mysqli_fetch_assoc(dquery("select B_ID from tbl_mobile where ID='" . $cntr["mid"] . "'"));
echo "<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["listing"];
echo "  </td>\n    <td class=\"fieldarea\" colspan=\"3\">\n";
if ($other) {
    echo "<select name=\"api\" onchange=\"javascript:location.href='main2.php?page=editprovidermodelmep&id=";
    echo $id;
    echo "&tiptop=true&other='+this.value\">\n";
} else {
    echo "<select name=\"api\" onchange=\"javascript:location.href='../../main2.php?page=editprovidermodelmep&id=";
    echo $id;
    echo "&other='+this.value\">\n";
}
echo "\n";
$api = dquery("select distinct gateway,value from tbl_apiservers  where  tbl_apiservers.setting='name'");
while ($rowapi = mysqli_fetch_assoc($api)) {
    echo "    <option value='";
    echo $rowapi["gateway"];
    echo "' ";
    if ($rowapi["gateway"] == $other || $cntr["api"] == $rowapi["gateway"]) {
        echo "selected";
    }
    echo " >";
    echo $rowapi["value"];
    echo "</option>\n    ";
}
echo "</select>\n</td>\n</tr>\n<tr>\n         <td class=\"fieldlabel\">";
echo $LNG["brand"];
echo "</td>\n     <td class=\"fieldarea\" >\n     <select name=\"brand\" id=\"brand\">\n        <option value=\"\">";
echo $LNG["select"];
echo "</option>\n     ";
if ($other) {
    $d = dquery("SELECT * from tbl_model_brand WHERE api='" . $other . "'");
    while ($row = mysqli_fetch_assoc($d)) {
    }
    echo "     </select>\n     </td>\n</tr>\n<tr>\n    <td class=\"fieldlabel\">";
    echo $LNG["model"];
    echo "</td>\n     <td class=\"fieldarea\" id=\"model\" >\n\n     <select name=\"mid\" >\n        <option value=\"\">";
    echo $LNG["select"];
    echo "</option>\n     ";
    $d = dquery("SELECT * from tbl_mobile WHERE B_ID='" . $bid["B_ID"] . "'");
    while ($row = mysqli_fetch_assoc($d)) {
        echo "        <option value=\"";
        echo $row["ID"];
        echo "\"  ";
        if ($cntr["mid"] == $row["ID"]) {
            echo "selected";
        }
        echo "  >";
        echo $row["Name"];
        echo "</option>\n     ";
    }
    echo "     </select>\n     </td>\n</tr>\n<tr>\n    <td class=\"fieldlabel\">";
    echo $LNG["country"];
    echo "</td>\n     <td class=\"fieldarea\" >\n     <select name=\"country\" id=\"country\">\n        <option value=\"\">";
    echo $LNG["select"];
    echo "</option>\n     ";
    if ($other) {
        $d = dquery("SELECT * from tbl_provider_country WHERE api='" . $other . "'");
        while ($row = mysqli_fetch_assoc($d)) {
        }
        echo "     </select>\n     </td>\n\n</tr>\n<tr >\n    <td class=\"fieldlabel\">";
        echo $LNG["provider"];
        echo "</td>\n     <td class=\"fieldarea\" id=\"provider\" >\n   <select name=\"pid\" >\n        <option value=\"\">";
        echo $LNG["select"];
        echo "</option>\n     ";
        $d = dquery("SELECT * from tbl_provider WHERE C_ID='" . $cid["C_ID"] . "'");
        while ($row = mysqli_fetch_assoc($d)) {
            echo "        <option value=\"";
            echo $row["ID"];
            echo "\"  ";
            if ($cntr["pid"] == $row["ID"]) {
                echo "selected";
            }
            echo "  >";
            echo $row["Name"];
            echo "</option>\n     ";
        }
        echo "     </select>\n\n     </td>\n\n</tr>\n<tr>\n    <td  class=\"fieldlabel\">";
        echo $LNG["mep"];
        echo "</td>\n    <td colspan=\"3\" class=\"fieldarea\">\n    <input type=\"text\" name=\"mep\" value=\"";
        echo $cntr["mep"];
        echo "\" />\n</td>\n</tr>\n\n<tr>\n    <td  class=\"fieldlabel\">";
        echo $LNG["mep"];
        echo " ";
        echo $LNG["listing"];
        echo "</td>\n    <td colspan=\"3\" class=\"fieldarea\">\n<input type=\"checkbox\" value=\"1\" name=\"mep1\" id=\"mep1\" ";
        if (stripos($cntr["mepl"], "2") !== false) {
            echo "checked";
        }
        echo " /> <label for=\"mep1\">";
        echo $LNG["mep"];
        echo " 2</label>\n&nbsp;\n<input type=\"checkbox\" value=\"1\" name=\"mep4\" id=\"mep4\" ";
        if (stripos($cntr["mepl"], "4") !== false) {
            echo "checked";
        }
        echo " /> <label for=\"mep4\">";
        echo $LNG["mep"];
        echo " 4</label>\n</td>\n</tr>\n\n\n</tbody>\n</table>\n\n<div class=\"fixedbtn\">\n    <input value=\"";
        echo $LNG["save"];
        echo "\" id=\"btnaddgroup\" class=\"btn save\" type=\"submit\" />\n</div>\n\n</form>\n\n\n</div></div></div></div>\n ";
        $fileverioncheck = "6.1.0";
    } else {
        $d = dquery("SELECT * from tbl_provider_country");
    }
    echo "        <option value=\"";
    echo $row["ID"];
    echo "\" ";
    if ($cid["C_ID"] == $row["ID"]) {
        echo "selected";
    }
    echo " >";
    echo $row["Name"];
    echo "</option>\n     ";
} else {
    $d = dquery("SELECT * from tbl_model_brand");
}
echo "        <option value=\"";
echo $row["ID"];
echo "\" ";
if ($bid["B_ID"] == $row["ID"]) {
    echo "selected";
}
echo " >";
echo $row["Name"];
echo "</option>\n     ";

?>