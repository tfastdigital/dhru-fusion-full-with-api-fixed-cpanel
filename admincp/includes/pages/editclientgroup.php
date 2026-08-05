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
if ($group) {
    if ($DEMOMODE) {
        echo "<div id=notification1 class=errorbox>This function not enabled in demo mode .</div>";
        exit;
    }
    $data["groupname"] = $group;
    $data["type"] = $membershiptype;
    $data["fee"] = $fee;
    $data["days"] = $days;
    $data["settings"] = json_encode($settings);
    foreach ($charge as $k => $v) {
        $ins = NULL;
        if (mysqli_num_rows(dquery("select * from tbl_membership_fee\n         where cid='" . $k . "' and gid='" . $id . "'"))) {
            $ins["fee"] = $v;
            $db->update("tbl_membership_fee", $ins, "gid='" . $id . "' and cid='" . $k . "'");
        } else {
            $ins["cid"] = $k;
            $ins["gid"] = $id;
            $ins["fee"] = $v;
            $db->insert("tbl_membership_fee", $ins);
        }
    }
    $data["maxaddfund"] = $maxaddfund;
    $data["minaddfund"] = $minaddfund;
    if ($db->update("tbl_client_group", $data, "id='" . $id . "'")) {
        echo "<div id=notification1 class=successbox> " . $LNG["datasave"] . " " . $LNG["savesuccessfully"] . " </div>";
    } else {
        echo "<div id=notification1 class=errorbox> " . $LNG["datanotsave"] . " </div>";
    }
}
$cntr = mysqli_fetch_assoc(dquery("SELECT * FROM tbl_client_group WHERE id='" . $id . "'"));
if ($cntr["settings"]) {
    $settings = json_decode($cntr["settings"], true);
}
echo "\n<script>\nfunction setCustoms(ob){    \n    if(ob==3){\n        \$(\"#customdays\").show();        \n    }else{\n        \$(\"#customdays\").hide();\n    }\n}\n</script>\n<div id=\"notification\"></div>\n<div id=\"content\">\n<div id=\"content_padded\">\n<form id=\"frm\" name=\"\" method=\"post\">\n<input type=\"hidden\" name=\"id\" value=\"";
echo $id;
echo "\" />\n<table class=\"form\" border=\"0\" cellpadding=\"3\" cellspacing=\"2\" width=\"100%\">\n<tbody>\n\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["group"];
echo " </td>\n    <td class=\"fieldarea\"><input type=\"text\" name=\"group\" value=\"";
echo $cntr["groupname"];
echo "\" /></td>\n</tr>\n\n<tr>\n    <td  class=\"fieldlabel\">Show Group pricing</td>\n    <td class=\"fieldarea\">\n    <input type='checkbox' \n    class=\"onoff {labelOn: 'Enable', labelOff: 'Disable', easing: 'easeOutBounce', duration: 500}\" \n    name=\"showon\" value=\"1\" id=\"tae\" ";
if ($cntr["showon"]) {
    echo "checked";
}
echo " />    \n    <small>Show this Group pricing on Products and Services</small>\n    </td>\n</tr>\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["membership"];
echo " ";
echo $LNG["type"];
echo " </td>\n    <td class=\"fieldarea\">\n    <select name=\"membershiptype\" onchange=\"setCustoms(this.value);\">\n        <option value=\"2\" ";
if ($cntr["type"] == 2) {
    echo "selected";
}
echo " >Onetime</option>\n        <option value=\"1\" ";
if ($cntr["type"] == 1) {
    echo "selected";
}
echo " >Monthly</option>        \n        <option value=\"3\" ";
if ($cntr["type"] == 3) {
    echo "selected";
}
echo " >Custom</option>\n    </select>\n    </td>\n</tr>\n<tr id=\"customdays\" style=\"";
if ($cntr["type"] != 3) {
    echo "display: none;";
}
echo "\">\n    <td class=\"fieldlabel\">";
echo $LNG["membership"];
echo " ";
echo $LNG["time"];
echo " </td>\n    <td class=\"fieldarea\">\n    <input type=\"text\" class=\"small\" id=\"days\" value=\"";
echo $cntr["days"];
echo "\" name=\"days\" /> ";
echo $LNG["days"];
echo "    </td>\n</tr>\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["membership"];
echo " ";
echo $LNG["fee"];
echo " </td>\n    <td class=\"fieldarea\">\n    \n    <input type=\"text\" class=\"small\"  name=\"fee\" value=\"";
echo $cntr["fee"] ? $cntr["fee"] : 0;
echo "\" />\n    <span class=\"preforms\">";
echo $_SESSION["system_default_currency"]["code"];
echo "</span>\n     ";
$cur = dquery("select * from tbl_currencies where `default`!='1'");
while ($r = mysqli_fetch_assoc($cur)) {
    $curwp = mysqli_fetch_assoc(dquery("select fee from tbl_membership_fee \n        where cid='" . $r["id"] . "' and gid='" . $id . "'"));
    echo "     \n    <input type=\"text\" class=\"small\" name=\"charge[";
    echo $r["id"];
    echo "]\" value=\"";
    echo $curwp["fee"];
    echo "\" />\n    <span class=\"preforms\">";
    echo $r["code"];
    echo "</span> \n    ";
}
echo "    </td>\n</tr>\n\n<tr  >\n    <td class=\"fieldlabel\">Max ";
echo $LNG["credit"];
echo " ";
echo $LNG["limit"];
echo "</td>\n    <td class=\"fieldarea\">\n    <input type=\"text\" class=\"small\" \n    value=\"";
echo $cntr["maxcredit"];
echo "\" name=\"maxcredit\" /> \n    </td>\n</tr>\n\n<tr  >\n    <td class=\"fieldlabel\">";
echo $LNG["membershipupgrade"];
echo "</td>\n    <td class=\"fieldarea\">\n        <input type=\"text\" class=\"small\"\n               value=\"";
echo $settings["totalreceipt"];
echo "\" name=\"settings[totalreceipt]\" /> ";
echo $_SESSION["system_default_currency"]["code"];
echo "        <small>";
echo $LNG["automembershipupgradedetail"];
echo "</small>\n    </td>\n</tr>\n\n\n<tr >\n    <td class=\"fieldlabel\">";
echo $LNG["add"];
echo " ";
echo $LNG["fund"];
echo " ";
echo $LNG["minimum"];
echo " ";
echo $LNG["limit"];
echo "</td>\n    <td class=\"fieldarea\">\n        <input type=\"text\" class=\"small\"\n               value=\"";
echo $cntr["minaddfund"];
echo "\" name=\"minaddfund\" />\n    </td>\n</tr>\n\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["add"];
echo " ";
echo $LNG["fund"];
echo " ";
echo $LNG["maximum"];
echo " ";
echo $LNG["limit"];
echo "</td>\n    <td class=\"fieldarea\">\n        <input type=\"text\" class=\"small\"\n               value=\"";
echo $cntr["maxaddfund"];
echo "\" name=\"maxaddfund\" />\n    </td>\n</tr>\n<tr>\n    <td  class=\"fieldlabel\">Retail Group</td>\n    <td class=\"fieldarea\">\n        <input type='checkbox'\n               class=\"onoff {labelOn: 'Enable', labelOff: 'Disable', easing: 'easeOutBounce', duration: 500}\"\n\n               name=\"retail\" value=\"1\" id=\"tae\" ";
if ($cntr["retail"]) {
    echo "checked";
}
echo " />\n        <small>Auto update Retail service price to this group</small>\n    </td>\n</tr>\n\n\n";
if ($config["idverification"]) {
    echo "    <tr>\n        <td class=\"fieldlabel\">ID Verification/KYC</td>\n        <td class=\"fieldarea\">\n            <input type='checkbox'\n                   class=\"onoff {labelOn: 'Enable', labelOff: 'Disable', easing: 'easeOutBounce', duration: 500}\"\n\n                   name=\"idverification\" value=\"1\" id=\"taes\" ";
    if ($cntr["idverification"]) {
        echo "checked";
    }
    echo " />\n        </td>\n    </tr>\n    ";
}
echo "</tbody>\n</table>\n \n <p class=\"fixedbtn\">\n     <input value=\"";
echo $LNG["save"];
echo "\" id=\"btnaddgroup\" class=\"btn save\" \n   type=\"submit\"  onclick=\"SubmitForm ('#btnaddgroup','editclientgroup','#frm','#notification','true','#main_loader');\"/> \n\n </p>\n\n</form>\n\n\n</div></div>\n";
$fileverioncheck = "6.1.0";

?>