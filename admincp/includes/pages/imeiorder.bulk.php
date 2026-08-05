<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

$pageid = 266;
checkPagePermission($pageid);
include_once ROOTDIR . "/includes/clients.fun.inc.php";
include_once ROOTDIR . "/includes/imeiservices.fun.php";
echo "    <style>\n        .boxreply{\n            border:1px solid #0B7500 !important;\n            background-color: hsla(120, 60%, 70%, 0.1) !important;\n        }\n        .boxreject{\n            border:1px solid red !important;\n            background-color: hsla(0, 100%, 90%, 0.1) !important;\n        }\n        .autoaccept {\n            position: relative;\n            display: inline-block;\n        }\n\n        /* Tooltip text */\n        .autoaccept .autotext {\n            visibility: hidden;\n            width: 120px;\n            background-color: black;\n            color: #fff;\n            text-align: center;\n            padding: 5px 0;\n            border-radius: 6px;\n\n            /* Position the tooltip text - see examples below! */\n            position: absolute;\n            z-index: 1;\n        }\n\n        /* Show the tooltip text when you mouse over the tooltip container */\n        .autoaccept:hover .autotext {\n            visibility: visible;\n        }\n    </style>\n<script>\nfunction setReply(val)\n{   try{\n    var len=document.replied.replies.length;\n\tfor(var i=0;i<len;i++)\n\t{\n        document.replied.replies[i].value=val;\n\t}\n\n    }catch(es){\n      //  alert(es);\n    }\n}\n</script>\n<div id=\"notification\"></div>\n<div id=\"content\">\n<div id=\"content_padded\">\n";
if ($stype == "remote") {
    $where .= " and server=2";
    $commonwhere = " and useasserver=2";
} else {
    if ($stype == "server") {
        $where .= " and server=1";
        $commonwhere = " and useasserver=1";
    } else {
        $where .= " and server=0";
        $commonwhere = " and useasserver=0";
    }
}
if (!isset($bulksubmit) || $bulkreply == "" && $bulksubmit && 0 < $_FILES["filereply"]["error"]) {
    if (0 < $_FILES["filereply"]["error"] && $bulkreply == "") {
        echo "<div id=notification1 class=errorbox>" . $LNG["upload"] . " " . $LNG["file"] . "  " . $LNG["or"] . " " . $LNG["input"] . " " . $LNG["bulk"] . " " . $LNG["reply"] . "</div>";
    }
    echo "<form method=\"post\" enctype=\"multipart/form-data\" >\n<input type=\"hidden\" name=\"laoddefaultpage\" value=\"imeiorder.bulk.php\" />\n<input type=\"hidden\" name=\"loaddefaultpage\" value=\"imeiorder.bulk.php\" />\n";
    echo generate_token("form");
    echo "\n<div  class=\"groupstabes\" >\n  <h2>\n    <span class=\"groupstabesheadertext\">Bulk Reply</span>\n  </h2>\n  <div class=\"groupstabescontant\">\n\n<table class=\"form\" border=\"0\" cellpadding=\"3\" cellspacing=\"2\" width=\"100%\">\n<tbody>\n  <tr>\n    <td class=\"fieldlabel\">";
    echo $LNG["select_"];
    echo " ";
    echo $LNG["service"];
    echo "</td>\n       <td class=\"fieldarea\">\n       <select name=\"sid\" class=\"chosen\">\n       <option value=\"\">";
    echo $LNG["all"];
    echo " ";
    echo $LNG["services"];
    echo "</option>\n       ";
    $pq = dquery("select id,group_name from tbl_imei_group where active=1");
    while ($pr = mysqli_fetch_assoc($pq)) {
        echo "            <optgroup label=\"";
        echo html_entity_decode($pr["group_name"]);
        echo "\">\n        ";
        $ps = dquery("select id,service_name from tbl_services_imei\n              where group_id='" . $pr["id"] . "' " . $commonwhere);
        while ($sr = mysqli_fetch_assoc($ps)) {
            echo "                <option value=\"";
            echo $sr["id"];
            echo "\">";
            echo html_entity_decode($sr["service_name"]);
            echo "</option>\n                ";
        }
        echo "              </optgroup>\n              ";
    }
    echo "       </select>\n       </td>\n      <td></td>\n      <td></td>\n   </tr>\n\n   <tr>\n    <td class=\"fieldlabel\">";
    echo $LNG["bulkreply"];
    echo "</td>\n    <td class=\"fieldarea\">\n       <input type=\"radio\" checked=\"\" onclick=\"\$('#file').show();\$('#text').hide();\" value=\"1\" name=\"br\"/> <label>Upload file</label>\n       <input type=\"radio\" onclick=\"\$('#file').hide();\$('#text').show();\" value=\"1\" name=\"br\"/> <label>By textarea</label>\n    </td>\n       <td></td>\n       <td></td>\n  </tr>\n  <tr>\n       <td  class=\"fieldlabel\"></td>\n       <td  class=\"fieldarea\">\n          <div id=\"file\">\n           <input type=\"file\" name=\"filereply\" />\n          </div>\n          <div id=\"text\" style=\"display: none;\">\n            <textarea name=\"bulkreply\" style=\"height: 200px;\" class=\"textarea large\"></textarea>\n            <a href=\"#\" onclick=\"load_subpage('includes/pages/helpupload.html','Help Bulk Upload');\"> <i class=\"flaticon-info-1\"></i> </a>\n          </div>\n      </td>\n      <td></td>\n      <td></td>\n  </tr>\n  <tr>\n       <td class=\"fieldlabel\">";
    echo $LNG["replyseperated"];
    echo "</td>\n       <td class=\"fieldarea\"><input  type=\"text\"  class=\"txt medium \" name=\"seperator\" /></td>\n      <td></td>\n      <td></td>\n  </tr>\n\n  <tr>\n      <td class=\"fieldlabel\"></td>\n      <td class=\"fieldarea\">\n\n          <div  style=\"float: left;color: green\">\n              ";
    echo $LNG["reply"];
    echo " ";
    echo $LNG["with"];
    echo "              <input  type=\"text\"  class=\"txt medium boxreply\" name=\"replyword\" />\n          </div>\n\n\n\n          <div style=\"float: left;color: red\">\n              &nbsp;&nbsp;&nbsp;&nbsp;\n              ";
    echo $LNG["reject"];
    echo " ";
    echo $LNG["with"];
    echo "              <input  type=\"text\"  class=\"txt medium boxreject\" name=\"rejected\" />\n\n          </div>\n\n      </td>\n\n  </tr>\n</tbody>\n</table>\n</div></div>\n<p align=\"center\" class=\"fixedbtn\"><input type=\"submit\" name=\"bulksubmit\"  value=\"";
    echo $LNG["submit"];
    echo "\"/>\nOnly ";
    echo $LNG["for"];
    echo " ";
    echo $LNG["accepted"];
    echo " ";
    echo $LNG["orders"];
    echo " </p>\n</form>\n";
} else {
    if ($_FILES["filereply"]["error"] <= 0 && $_FILES["filereply"]["error"]) {
        $fh = fopen($_FILES["filereply"]["tmp_name"], "r");
        $cont = fread($fh, filesize($_FILES["filereply"]["tmp_name"]));
        $imeilist = explode("\r\n", $cont);
    } else {
        $imeilist = explode("\r\n", $bulkreply);
    }
    $imei = [];
    $reply = [];
    foreach ($imeilist as $list) {
        if ($list != "") {
            if ($seperator) {
                $arr = explode($seperator, $list);
            } else {
                $arr = preg_split("/\\s+/", $list);
            }
            $im = $arr[0];
            unset($arr[0]);
            if (!$arr[1] && $replyword) {
                $imei[] = ["imei" => $im, "code" => $replyword];
            } else {
                $imei[] = ["imei" => $im, "code" => implode($arr) ? implode($arr, " ") : $rejected];
            }
        }
    }
    if ($sid != "") {
        $where = " and service_id='" . $sid . "'";
    }
    foreach ($imei as $_imei) {
        $OID = mysqli_fetch_assoc(dquery("SELECT `order_id`,(select service_name\n        from tbl_services_imei where id=service_id) as service,\n        date,(select username from tblUsers where id=user_id) as user,imei,credit,discount,reply,adminnote\n        FROM `tbl_order_imei` WHERE `imei`='" . $_imei["imei"] . "' " . $where . " AND `user_can_c`='1'"));
        if ($OID) {
            $orderarr[$OID["order_id"]] = $OID;
            $orderarr[$OID["order_id"]]["newreply"] = trim($_imei["code"]);
        }
        $OID = NULL;
    }
    if ($orderarr) {
        echo "<form id=\"replied\" name=\"replied\" method=\"post\" >\n";
        echo generate_token("form");
        echo "<table id=\"main_tbl\" >\n<thead>\n  <tr>\n        <th><input type=\"checkbox\" name=\"checkall\" onclick=\"CheckAll();\" />";
        echo $LNG["all"];
        echo "</th>\n        <th>";
        echo $LNG["servicename"];
        echo "</th>\n        <th>";
        echo $LNG["date"];
        echo " </th>\n        <th>";
        echo $LNG["price"];
        echo " </th>\n        <th>";
        echo $LNG["username"];
        echo " </th>\n        <th>";
        echo $LNG["imei"];
        echo " </th>\n        <th>\n        <select name=\"rpl\" style=\"width: 110px;\" onchange=\"setReply(this.value);\">\n            <option value=\"\">-";
        echo $LNG["reply"];
        echo "-</option>\n            ";
        $dt = explode("\n", $config["orderreplyword"]);
        foreach ($dt as $d) {
            $d = trim($d);
            echo "                    <option value=\"";
            echo $d;
            echo "\">";
            echo $d;
            echo "</option>\n                ";
        }
        echo "        </select> </th>\n        <th><input type=\"checkbox\" name=\"reject\" onclick=\"RCheckAll();\" />";
        echo $LNG["reject"];
        echo "</th>\n  </tr>\n</thead>\n<tbody>\n";
        foreach ($orderarr as $id => $Orders) {
            echo "<tr id=\"hide_";
            echo $id;
            echo "\">\n        <td><input type=\"checkbox\" name=\"select[]\" checked=\"checked\" id=\"select\" value=\"";
            echo $id;
            echo "\" /></td>\n        <td>\n        ";
            if ($Orders["reply"] != "" && $Orders["adminnote"] != "") {
                echo "                <span class=\"autoaccept\">";
                echo $Orders["service"];
                echo "<span class=\"autotext\">";
                echo $Orders["adminnote"];
                echo "</span></span>\n                ";
            } else {
                echo $Orders["service"];
            }
            echo "        </td>\n        <td>";
            echo $Orders["date"];
            echo "</td>\n        <td>";
            echo $Orders["credit"] - $Orders["discount"];
            echo "         ";
            echo $Orders["code"];
            echo "</td>\n        <td>";
            echo $Orders["user"];
            echo "</td>\n        <td>";
            echo $Orders["imei"];
            echo "</td>\n        <td><input type=\"text\"  class=\"txt medium\"\n         style=\"width:100px !important;\"\n         name=\"reply[";
            echo $id;
            echo "]\" value=\"";
            echo $Orders["newreply"];
            echo "\" id=\"replies\"   /></td>\n        <td><input type=\"checkbox\" name=\"reject[";
            echo $id;
            echo "]\" id=\"reject\"\n        ";
            if (trim($Orders["newreply"]) == "" || trim($Orders["newreply"]) == $rejected) {
                echo "checked=\"checked\"";
            }
            echo "  value=\"";
            echo $id;
            echo "\" /></td>\n    </tr>";
        }
        echo "<tr><td align=\"left\" colspan=\"7\">\n<input type=\"button\" name=\"replyorders\" id=\"replyorders\" class=\"btn\"  value=\"Reply Selected\"\n onclick=\"SubmitForm ('#replyorders','imeireplied','#replied','#notification','true','#main_loader');\"/></td>\n    <td></td>\n</tr>\n</tbody></table>\n<p class=\"fixedbtn\">&nbsp;</p>\n</form>\n";
    } else {
        echo "<div id=notification1 class=errorbox>" . $LNG["no"] . " " . $LNG["imei"] . "  " . $LNG["match"] . "</div>";
    }
}
echo "\n</div></div>\n<script>\nfunction CheckAll()\n{\n\t\tvar i=document.replied.select.length;\n\t\tvar k;\n\t\tfor (k=0 ; k < i; k++)\n\t\t{\n\t\t\tif(document.replied.select[k].checked==true)\n\t\t\t{\n\t\t\t\tdocument.replied.select[k].checked=false;\n\t\t\t}\n\t\t\telse\n\t\t\t{\n\t\t\t\tdocument.replied.select[k].checked=true;\n\t\t\t}\n\t\t}\n}\nfunction RCheckAll()\n{\n\t\tvar i=document.replied.reject.length;\n\t\tvar k;\n\t\tfor (k=0 ; k < i; k++)\n\t\t{\n\t\t\tif(document.replied.reject[k].checked==true)\n\t\t\t{\n\t\t\t\tdocument.replied.reject[k].checked=false;\n\t\t\t}\n\t\t\telse\n\t\t\t{\n\t\t\t\tdocument.replied.reject[k].checked=true;\n\t\t\t}\n\t\t}\n}\n</script>\n\n<div id=\"page_info\" class=\"page_info\">\n\t<li>This page allows you to reply bulk imei in single file or in bulk number</li>\n\t<li>Bulk number seperated by new line and reply code seperated by ',' , '-' etc. default seperator is space ex.(111111111111119 999999999999)</li>\n\t<li>specify rejected word for reply reject order with imei number</li>\n</div>";
$fileverioncheck = "6.1.0";

?>