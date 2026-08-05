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
echo "<style>\n.form{margin-bottom: 4px !important;}\n.list{\n    cursor: pointer;\n}\n.list:hover{\n    background-color: #E9E9E9;\n}\n#clientlist{\n    background: none repeat scroll 0 0 white;\n    border: 1px solid #F4F4F4;\n    box-shadow: 0 0 10px #F4F4F4;\n    padding: 5px;\n    width: 152px;\n}\n#clientlist li{padding:5px;list-style: none;font-size:13px;}\n</style>\n<script>\n\$(document).ready(function(){\t\n     \$('#cid').keyup(function() {\n            var search=\$(this).val();\n       \n            \$.post('includes/pages/pos.sales.product.php?directorder='+search, function(data) {\n                if(data){\n                     \$('#clientlist').show();\n                     \$('#clientlist').html(data);\n                 }\n            });\n         \n    });\n});\nfunction setValse(vals){\n    var part;\n    part=vals.split(\"=\");\n    \$('#email').val(part[0]);\n    \$('#cid').val(part[1]);\n    \$('#clientlist').hide();\n}\n</script>\n";
$pageid = 519;
checkPagePermission($pageid);
if (!$nottab) {
    echo "<ul id=\"tabmenu\">     \n    <li><a ";
    if (!$ids && !$seltab) {
        echo " class='tabmenu_active' ";
    }
    echo "  onclick=\"getContect('#tab','main2.php?page=ebayorder&nottab=1','','','#tabcontent',true,'#main_loader');\" id=\"tab\" >";
    echo $LNG["create"];
    echo " ";
    echo $LNG["imei"];
    echo " ";
    echo $LNG["order"];
    echo "</a></li>\n    <li><a ";
    if ($server == 1) {
        echo " class='tabmenu_active' ";
    }
    echo "  onclick=\"getContect('#tab5','main2.php?page=ebayorder&nottab=1&server=1','','','#tabcontent',true,'#main_loader');\" id=\"tab5\" >";
    echo $LNG["create"];
    echo " ";
    echo $LNG["server"];
    echo " ";
    echo $LNG["order"];
    echo "</a></li>\n    <li><a ";
    if ($server == 2) {
        echo " class='tabmenu_active' ";
    }
    echo "  onclick=\"getContect('#tab6','main2.php?page=ebayorder&nottab=1&server=2','','','#tabcontent',true,'#main_loader');\" id=\"tab6\" >";
    echo $LNG["create"];
    echo " ";
    echo $LNG["remote"];
    echo " ";
    echo $LNG["order"];
    echo "</a></li>\n    <li><a ";
    if ($seltab == 1) {
        echo " class='tabmenu_active' ";
    }
    echo " onclick=\"getContect('#tab1','main2.php?page=ebayorderlist&nottab=1','','','#tabcontent',true,'#main_loader');\" id=\"tab1\" >";
    echo $LNG["pending"];
    echo " ";
    echo $LNG["order"];
    echo " ";
    echo $LNG["list"];
    echo "</a></li>\n    <li><a ";
    if ($seltab == 2) {
        echo " class='tabmenu_active' ";
    }
    echo "   onclick=\"getContect('#tab3','main2.php?page=ebayorderused&nottab=1','','','#tabcontent',true,'#main_loader');\" id=\"tab3\" >";
    echo $LNG["used"];
    echo " ";
    echo $LNG["order"];
    echo " ";
    echo $LNG["list"];
    echo "</a></li>\n   <div style=\"clear: both;\"></div>\n</ul>\n\n<div id=\"tabcontent\">\n";
}
if ($loadpage) {
    include (string) $loadpage;
} else {
    $where = " `server`='0'";
    $wheres = " useasserver='0'";
    if ($server == 1) {
        $where = " `server`='1'";
        $wheres = " useasserver='1'";
    } else {
        if ($server == 2) {
            $where = " `server`='2'";
            $wheres = " useasserver='2'";
        }
    }
    echo "<div id=\"content\">\n<div id=\"notification\"></div>\n<form id=\"frm\" name=\"\" method=\"post\">\n";
    echo generate_token("form");
    echo "\n<table class=\"form\" border=\"0\" cellpadding=\"3\" cellspacing=\"2\" width=\"100%\">\n<tbody>\n\n<tr>\n    <td class=\"fieldlabel\">";
    echo $LNG["select_"];
    echo " ";
    echo $LNG["service"];
    echo "</td>\n    <td class=\"fieldarea\"><span>\n    <select name=\"sid\" class=\"chosen\">\n        <option value=\"\">";
    echo $LNG["select"];
    echo "</option>\n        ";
    $gr = dquery("select * from tbl_imei_group where " . $where . " order by display_order");
    while ($gt = mysqli_fetch_assoc($gr)) {
        echo "           <optgroup  label=\"";
        echo $gt["group_name"];
        echo "\">\n         ";
        $s = dquery("select id,service_name from tbl_services_imei \n            where id in (select serviceid from tbl_service_status where groupid='base' and status='1') \n            and group_id='" . $gt["id"] . "' and " . $wheres . " ORDER by sort");
        while ($r = mysqli_fetch_assoc($s)) {
            echo "                        <option   value=\"";
            echo $r["id"];
            echo "\">";
            echo $r["service_name"];
            echo "</option>\n              ";
        }
        echo "            </optgroup>\n        ";
    }
    echo "    </select>\n    </span>\n    <span style=\"float: right;\"><a class=\"btn\" style=\"text-decoration: none;\" href=\"javascript: load_subpage('main2.php?page=emailtemplate.edit&id=68','Edit IMEI Direct Order Template')\">";
    echo $LNG["edit"];
    echo " ";
    echo $LNG["mail"];
    echo " ";
    echo $LNG["template"];
    echo "</a></span>\n    </td>\n</tr>\n\n<tr>\n    <td class=\"fieldlabel\">";
    echo $LNG["quantity"];
    echo "</td>\n    <td class=\"fieldarea\"><span>\n   <input type=\"text\"  class=\"txt small\" name=\"qnt\" value=\"1\" />\n    </span></td>\n</tr>\n\n\n\n\n\n<tr>\n    <td class=\"fieldlabel\">";
    echo $LNG["client"];
    echo "</td>\n    <td class=\"fieldarea\"><span>\n    <input type=\"text\"  class=\"txt medium\" name=\"cid\" id=\"cid\" value=\"";
    echo $LNG["search"];
    echo " ";
    echo $LNG["client"];
    echo "\"\n    onfocus=\"if(this.value=='";
    echo $LNG["search"];
    echo " ";
    echo $LNG["client"];
    echo "')value='';\"\n           autocomplete=\"off\"\n onblur=\"if(this.value=='')this.value='";
    echo $LNG["search"];
    echo " ";
    echo $LNG["client"];
    echo "';\" />\n    <div style=\"display: none;position: absolute;z-index:99\" id=\"clientlist\"></div>            \n   </span>\n   OR  &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;  \n   <input type=\"text\"  class=\"txt large\" placeholder=\"";
    echo $LNG["client"];
    echo " ";
    echo $LNG["email"];
    echo "\" name=\"email\" id=\"email\" />\n   </td>\n</tr>\n\n<tr>\n    <td class=\"fieldlabel\">Chargeable</td>\n    <td class=\"fieldarea\"><span>\n  <input type=\"checkbox\" class=\"onoff {labelOn: 'Yes', labelOff: 'No'}\"  name=\"chargeable\" value=\"1\" id=\"see\" /><label for=\"see\"></label>\n\n    </span></td>\n</tr>\n\n\n<tr>\n<td></td>\n<td class=\"fieldarea\">\n<input value=\"";
    echo $LNG["send"];
    echo " ";
    echo $LNG["mail"];
    echo "\" id=\"btnoverview\" class=\"btn save\" type=\"button\"  \nonclick=\"SubmitForm ('#btnoverview','ebayorder','#frm','#notification','true','#main_loader');\"/>\n</td>\n</tr>\n</tbody>\n</table>\n\n\n\n</form>\n\n</div>\n";
}
if (!$nottab) {
    echo "</div>\n";
}
$fileverioncheck = "6.1.0";

?>