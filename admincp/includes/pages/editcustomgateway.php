<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

if (!$_SESSION["adminid"]) {
    echo "<div align=\"center\"><h3>Session expired. <a style=\"color: #666;\" href=\"index.php?main2redirect=true\">Please relogin</a></h3></div>";
    $_SESSION["admin_afterlogin_re"] = $_SERVER["REQUEST_URI"];
    exit;
}
if (isset($save) && $weight != "") {
    checkDemoMode(false);
    $def = mysqli_fetch_assoc(dquery("select code from tbl_currencies where `default`='1'"));
    if (${$def["code"]} != "") {
        $data["weight"] = $weight;
        $data["gid"] = $id;
        $alrd = mysqli_num_rows(dquery("select * from tbl_customgatewayprice where weight='" . $weight . "' and gid='" . $id . "'"));
        if (!$alrd) {
            $sql = dquery("select * from tbl_currencies");
            while ($row = mysqli_fetch_assoc($sql)) {
                if (${$row["code"]} != "") {
                    $data["currency_id"] = $row["id"];
                    $data["credit"] = ${$row["code"]};
                    $db->insert("tbl_customgatewayprice", $data);
                }
            }
            echo "<div id='notification1' class='successbox'>" . $LNG["datasavesuccessfully"] . "</div>";
        } else {
            echo "<div id='notification1' class='errorbox'>" . $LNG["weight"] . " " . $LNG["already"] . " " . $LNG["exists"] . "</div>";
        }
    } else {
        echo "<div id='notification1' class='errorbox'>" . $LNG["defaultcurnotblank"] . "</div>";
    }
}
if ($delete) {
    checkDemoMode(false);
    foreach ($delete as $rem => $v) {
        dquery("delete from tbl_customgatewayprice where gid='" . $id . "' and weight='" . $rem . "'");
        echo "<div id='notification1' class='successbox'>Weight removed successfully</div>";
    }
}
if (isset($update) && isset($group)) {
    checkDemoMode(false);
    $def = mysqli_fetch_assoc(dquery("select code from tbl_currencies where `default`='1'"));
    foreach ($group as $q => $a) {
        if (${$def["code"]}[$q]) {
            $data["weight"] = $_POST["weight"][$q];
            $sql = dquery("select * from tbl_currencies");
            while ($row = mysqli_fetch_assoc($sql)) {
                $data["credit"] = ${$row["code"]}[$q];
                $check = mysqli_num_rows(dquery("select * from tbl_customgatewayprice where weight='" . $data["weight"] . "' and gid='" . $id . "' and currency_id='" . $row["id"] . "'"));
                if ($check) {
                    $db->update("tbl_customgatewayprice", $data, "weight='" . $data["weight"] . "' and gid='" . $id . "' and currency_id='" . $row["id"] . "'");
                } else {
                    $data["currency_id"] = $row["id"];
                    $data["gid"] = $id;
                    $db->insert("tbl_customgatewayprice", $data);
                    $data["gid"] = NULL;
                    $data["currency_id"] = NULL;
                    unset($data["gid"]);
                    unset($data["currency_id"]);
                }
            }
            $data = NULL;
        }
    }
    echo "<div id='notification1' class='successbox'>" . $LNG["datasavesuccessfully"] . "</div>";
}
if ($value) {
    checkDemoMode(false);
    $data["value"] = $value;
    $data["trackingurl"] = $trackingurl;
    $data["country"] = $selgatway;
    $data["deliverytime"] = $deliverytime;
    if ($db->update("tbl_shipping_services", $data, "id='" . $id . "'")) {
        echo "<div id=notification1 class=successbox> " . $LNG["datasave"] . " " . $LNG["savesuccessfully"] . " </div>";
    } else {
        echo "<div id=notification1 class=errorbox> " . $LNG["datanotsave"] . " </div>";
    }
}
$cntr = mysqli_fetch_assoc(dquery("SELECT * FROM tbl_shipping_services WHERE id='" . $id . "'"));
echo "<script>\nfunction loopSelected()\n{\n  var txtSelectedValuesObj = document.getElementById('selgatway');\n  var selectedArray = new Array();\n  var selObj = document.getElementById('gatway');\n  var i;\n  var count = 0;\n  for (i=0; i<selObj.options.length; i++) {\n    if (selObj.options[i].selected) {\n      selectedArray[count] = selObj.options[i].value;\n      count++;\n    }\n  }\n  txtSelectedValuesObj.value = selectedArray;\n}\n</script>\n\n\n<div id=\"notification\"></div>\n<div id=\"content\">\n<div id=\"content_padded\">\n<form id=\"frm\" name=\"\" method=\"post\">\n<div  class=\"groupstabes\" >\n  <h2>\n    <img src=\"data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAkAAAAJCAYAAADgkQYQAAAAAXNSR0IArs4c6QAAAAlwSFlzAAALEwAACxMBAJqcGAAAAAd0SU1FB9oIGRQbOY8MjgMAAAA8SURBVBjTY2BAAzdv3vwPBAzImAGbInSFWBU9f/4cRSFWRb9+/UJRiFMRTOGNGzf+k28SUW4iynfo4QQAj22WmutXxVsAAAAASUVORK5CYII=\">\n    <span class=\"groupstabesheadertext\">";
echo $cntr["value"];
echo "</span>&nbsp;<font class=\"backline\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</font>\n  </h2>\n  <div class=\"groupstabescontant\">\n<input type=\"hidden\" name=\"id\" value=\"";
echo $id;
echo "\" />\n<table class=\"form\" border=\"0\" cellpadding=\"3\" cellspacing=\"2\" width=\"100%\">\n<tbody>\n\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["service"];
echo " </td>\n    <td class=\"fieldarea\"><input type=\"text\" name=\"value\" value=\"";
echo $cntr["value"];
echo "\" /></td>\n</tr>\n\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["delivery"];
echo " ";
echo $LNG["time"];
echo " </td>\n    <td class=\"fieldarea\"><input type=\"text\" name=\"deliverytime\" \n    value=\"";
echo $cntr["deliverytime"];
echo "\" />\n    <small>e.g. 8 days,10-12 days</small>\n    </td>\n</tr>\n\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["trackingurl"];
echo "</td>\n    <td class=\"fieldarea\"><input type=\"text\" name=\"trackingurl\" value=\"";
echo $cntr["trackingurl"];
echo "\" />\n        <br />\n    <small>Use \"[TID]\" variable which replaced by Reply code from product order edit<br />\n   e.g. http://www.dhl.co.in/content/in/en/express/tracking.shtml?brand=DHL&AWB=[TID]%0D%0A</small>\n    \n    </td>\n</tr>\n\n\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["country"];
echo "</td>\n    <td class=\"fieldarea\">\n";
require "../includes/countries.php";
$cin = explode(",", $cntr["country"]);
echo "    \n<select name=\"gatway\" style=\"height: 200px;\" id=\"gatway\" multiple  onchange=\"loopSelected();\" onblur=\"loopSelected();\">\n";
foreach ($countries as $key => $val) {
    if ($key != "") {
        if (in_array($key, $cin)) {
            $isselected = "selected='selected'";
        } else {
            $isselected = "";
        }
        echo "          <option ";
        echo $isselected;
        echo " value=\"";
        echo $key;
        echo "\">";
        echo $val;
        echo "</option>\n        ";
    }
}
echo " </select>\n<input type=\"hidden\" id=\"selgatway\" name=\"selgatway\" value=\"";
echo $cntr["country"];
echo "\" />    \n    </td>\n</tr>\n\n<tr> \n    <td class=\"fieldlabel\"> </td>\n    <td class=\"fieldarea\">\n        <input value=\"";
echo $LNG["save"];
echo "\" id=\"btnaddgroup\" class=\"btn save\" type=\"submit\"  /> \n    </td>\n</tr>\n</tbody>\n</table>\n\n</div></div>\n</form>\n<br>\n\n\n  \n  <div  class=\"groupstabes\" >\n  <h2>    \n    <span class=\"groupstabesheadertext\">Pricing</span>\n  </h2>\n  <div class=\"groupstabescontant\">\n   \n\n<table id=\"main_tbl\">\n<thead><tr>\n<th>";
echo $LNG["weight"];
echo " in [<small>Kg</small>]</th>\n";
$sql = dquery("select * from tbl_currencies");
while ($row = mysqli_fetch_assoc($sql)) {
    echo "<th>";
    echo $row["code"];
    echo "</th>\n";
}
echo "<th align=\"right\">";
echo $LNG["action"];
echo "</th></tr>\n</thead>\n<tbody>\n\n<tr>\n \n    <form id=\"frm\" name=\"\" method=\"post\">\n        <input type=\"hidden\" value=\"";
echo $id;
echo "\" name=\"id\"/>\n        ";
echo generate_token("form");
echo "        \n        <td align=\"left\"><input type=\"text\" style=\"width: 50px;\" name=\"weight\" value=\"\" /></td>\n        ";
$sql = dquery("select * from tbl_currencies");
while ($row = mysqli_fetch_assoc($sql)) {
    echo "        <td align=\"left\"><input style=\"width: 50px !important;\" type=\"text\" name=\"";
    echo $row["code"];
    echo "\" /></td>\n        ";
}
echo "        <td align=\"right\"><input value=\"+ ";
echo $LNG["add"];
echo "\" id=\"btnsubscribe\" class=\"btn add\" type=\"submit\" name=\"save\" /></td>  \n    </form>\n\n</tr>\n\n<form method=\"post\">\n\n";
$result = dquery("select * from tbl_customgatewayprice where gid='" . $id . "' group by weight");
while ($row = mysqli_fetch_assoc($result)) {
    echo "<input type=\"hidden\" name=\"group[]\" />\n<tr>\n<td><input style=\"width: 50px !important;\" type=\"hidden\" name=\"weight[]\" value=\"";
    echo $row["weight"];
    echo "\" />\n ";
    echo $row["weight"];
    echo " Kg </td>\n    ";
    $sql = dquery("select * from tbl_currencies");
    while ($cur = mysqli_fetch_assoc($sql)) {
        $d = mysqli_fetch_assoc(dquery("select credit from tbl_customgatewayprice where weight='" . $row["weight"] . "' and gid='" . $id . "' and currency_id='" . $cur["id"] . "'"));
        echo "        <td><input style=\"width: 50px !important;\" type=\"text\" name=\"";
        echo $cur["code"];
        echo "[]\" value=\"";
        echo $d["credit"];
        echo "\" /></td>\n    ";
    }
    echo "<td align=\"right\"><input type=\"submit\" class=\"button delete deletedata\" name=\"delete[";
    echo $row["weight"];
    echo "]\" value=\"Delete\" /></td></tr>\n";
}
echo "\n</tbody>\n</table>\n<br /><p align=\"left\"><input value=\"";
echo $LNG["save"];
echo "\" id=\"btnsubscribe\" class=\"btn save\" type=\"submit\" name=\"update\" /></p>\n\n</form>\n\n</div></div>\n</div></div>\n ";
$fileverioncheck = "6.1.0";

?>