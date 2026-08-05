<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

if ($_ff_onSUBMIT_FILTER || $p) {
    include "imeiservice.head.php";
}
echo "<style>\n    /* Tooltip container */\n    .tooltip {\n        position: relative;\n        display: inline-block;\n        /* border-bottom: 1px dotted black; /* If you want dots under the hoverable text */\n    }\n    /* Tooltip text */\n    .tooltip .tooltiptext {\n        visibility: hidden;\n        width: 180px;\n        background-color: black;\n        color: #ffffff;\n        text-align: left;\n        padding: 10px;\n        font-size: 14px;\n        border-radius: 6px;\n        position: absolute;\n        z-index: 1;\n        top:29px;\n    }\n    .tooltip .tooltiptext:before {\n        position: absolute;\n        content: '';\n        width: 0;\n        height: 0;\n        border-left: 10px solid transparent;\n        border-right: 10px solid transparent;\n        border-bottom: 10px solid black;\n        top: -8px;\n    }\n    /* Show the tooltip text when you mouse over the tooltip container */\n    .tooltip:hover .tooltiptext {\n        visibility: visible;\n    }\n</style>\n<div id=\"tabcontent\">\n    ";
$pageid = 2;
checkPagePermission($pageid);
if ($server == 2) {
    $wherecond = " and useasserver=2";
    $wherecond2 = " where server=2";
} else {
    if ($server == 1) {
        $wherecond = " and useasserver=1";
        $wherecond2 = " where server=1";
    } else {
        $wherecond = " and useasserver=0";
        $wherecond2 = " where server=0";
    }
}
if ($Base_Enable) {
    $services = explode("-", $rid);
    foreach ($services as $sid) {
        if (mysqli_num_rows(dquery("select servicestatusid from tbl_service_status\n    where groupid='base' and serviceid='" . $sid . "'"))) {
            dquery("update tbl_service_status set status=1 where groupid='base'\n        and serviceid='" . $sid . "'");
        } else {
            dquery("insert into tbl_service_status (groupid,serviceid,status)\n            values ('base','" . $sid . "','1')");
        }
    }
    echo "<div id='notification1' class='successbox' ></div>";
}
if ($Base_Disable) {
    $services = explode("-", $rid);
    foreach ($services as $sid) {
        dquery("DELETE FROM tbl_service_status WHERE groupid='base' and serviceid='" . $sid . "'");
    }
}
echo "    <form method=\"post\">\n        <input type=\"hidden\" name=\"defaultpage\" value=\"imeiservice.list.php\" />\n        <input type=\"hidden\" name=\"server\" value=\"";
echo $server;
echo "\" />\n        <input type=\"hidden\" name=\"stype\"\n         value=\"";
if ($server == 2) {
    echo "remote";
} else {
    if ($server == 1) {
        echo "server";
    }
}
echo "\" />\n        <fieldset class=\"search-form\">\n            <legend>Quick Search</legend>\n            <div class=\"d-flex flex-wrap\">\n                <div class=\"flex-grow-1 mb-1\">\n                <select  name=\"groups\" class=\"chosen\" onchange=\"javascript:reloadcurrent('imeiservice','&sel=imeiservice.list";
if ($server) {
    echo "&server=" . $server;
}
echo "&grpid='+this.value+'";
if ($retail) {
    echo "&retail=1";
}
echo "')\">\n                    <option value=\"\">";
echo $LNG["select_"];
echo " ";
echo $LNG["group"];
echo "</option>\n           ";
$sql = dquery("SELECT id,group_name FROM tbl_imei_group \n                    " . $wherecond2 . " ORDER BY `display_order`,`group_name` asc");
while ($row = mysqli_fetch_assoc($sql)) {
    echo "                        <option ";
    if ($_GET["grpid"] == $row["id"]) {
        echo "selected";
    }
    echo " value=\"";
    echo $row["id"];
    echo "\">";
    echo html_entity_decode($row["group_name"]);
    echo "</option>\n                        ";
}
echo "                </select>\n                </div>\n\n                <div class=\"mb-1\">\n                <input type=\"text\" name=\"searchkey\" class=\"txt mr-1\" style=\"width: 300px\" placeholder=\"Search service from any group\" value=\"\" >\n                <input value=\"Search\" type=\"submit\" class=\"btn\" name=\"add\">\n                </div>\n            </div>\n        </fieldset>\n\n    </form>\n";
if ($searchkey) {
    $wherecond .= " and service_name like '%" . $searchkey . "%'";
}
if ($grpid) {
    $_ff_tbl_services_imei_group_id = $grpid;
    $_REQUEST["_ff_tbl_services_imei_group_id"] = $grpid;
    $_ff_tbl_services_imei_group_id_operator = urlencode("=");
    $_REQUEST["_ff_tbl_services_imei_group_id_operator"] = urlencode("=");
    $_ff_onSUBMIT_FILTER = "search";
    $_REQUEST["_ff_onSUBMIT_FILTER"] = "Search";
    $_ff_selSearchType = 0;
    $_REQUEST["_ff_selSearchType"] = 0;
}
include DATAGRID_DIR2 . "comm.php";
$sql = "SELECT  tbl_services_imei.id,\nservice_name as servoday,\nCONCAT( '<a class=\\'default_dg_a\\' href=\"javascript:load_fromsubpage(\\'editimeiservice&id=',tbl_services_imei.id,'\\',\\' ', concat(SUBSTR(tbl_services_imei.service_name,1,10),'...'),'\\')\">',tbl_services_imei.id,'</a>' )  AS ids,\n CONCAT( '<a class=\\'default_dg_a\\' href=\"javascript:load_fromsubpage(\\'editimeiservice&id=',tbl_services_imei.id,'\\',\\' ', concat(SUBSTR(tbl_services_imei.service_name,1,10),'...'),'\\')\">',CONCAT(IF(tbl_services_imei.id=0,concat('<span >',tbl_services_imei.service_name,'</span>'),concat(tbl_services_imei.service_name,''))),' <br /><i style=\"color:#b0b0b0\">#',tbl_services_imei.id,'</i></a>',' <div class=\"tooltip\"><span style=\"color:#b0b0b0\">',\n IF(tbl_services_imei.API!='' and tbl_services_imei.API_ID!='',concat(\n'<span class=\"tooltiptext\">','<strong>',\nconcat(IF((select value from tbl_apiservers \nwhere gateway=API and setting='name' limit 1),\n(select value from tbl_apiservers \nwhere gateway=API and setting='name' limit 1),'-'),'')\n\n,'</strong>','<br />',\n\nIF((select `name` from tbl_apiserversservices\n where gateway=tbl_services_imei.`API` \n and tbl_apiserversservices.id=tbl_services_imei.`API_ID`\n  and `type`='Tool' limit 1)!='',(select `name` from tbl_apiserversservices\n where gateway=tbl_services_imei.`API` \n and tbl_apiserversservices.id=tbl_services_imei.`API_ID`\n  and `type`='Tool' limit 1),' ')\n  ,'</span>'\n ) ,concat('  ') ),'</span></div>')  AS service_name,\n concat(\n IF((SELECT apiserverid from tbl_apiserversservices\n where gateway=tbl_services_imei.`API` \n and tbl_apiserversservices.id=tbl_services_imei.`API_ID`\n  and `type`='Tool' limit 1)>0,\n         concat(' ',(select (value) from tbl_apiservers \n         where gateway=API and setting='name' limit 1),'')\n         ,''\n  )\n ) as apicon,\n(select price from tbl_service_pricing\nwhere serviceid=tbl_services_imei.id and groupid='base' and \ncurrencyid='" . $_SESSION["system_default_currency"]["id"] . "' limit 1) as credit,time,tbl_services_imei.active,useasserver,\n(select group_name from tbl_imei_group where id=group_id) as groupname,\nIF(tbl_services_imei.useasserver=2,'Remote',IF(tbl_services_imei.useasserver=1,'Server','IMEI')) as servicetype,\n(select value from tbl_apiservers where gateway=API and setting='name' limit 1) as apiname,\nCONCAT('<a class=\\'default_dg_a2 editdata\\' href=\"javascript:load_fromsubpage(\\'editimeiservice&id=',tbl_services_imei.id,'\\',\\' ',concat( SUBSTR(tbl_services_imei.service_name,1,10),'...'),'\\')\">" . $LNG["edit"] . "</a>') as action_links,\n(select count(service_id) from tbl_order_imei where service_id=tbl_services_imei.id and user_can_c=4) as completed\nFROM tbl_services_imei left outer join tbl_imei_group\non group_id=tbl_imei_group.id where 1=1 " . $wherecond;
if ($_GET["Extract"] == "yes") {
    $rid = explode("-", $rid);
    $tr = "";
    foreach ($rid as $r) {
        $tr .= $r . ",";
    }
    $tr = trim($tr, ",");
    echo "        <script>\n            load_subpage('main2.php?page=extractimeiservices&service=";
    echo $tr;
    echo "','Extract Services');\n        </script>\n        ";
} else {
    if ($_GET["Generate_Link"] == "yes") {
        checkDemoMode(false);
        $rid = explode("-", $rid);
        $tr = "";
        foreach ($rid as $r) {
            if (mysqli_num_rows(dquery("select id from tbl_services_imei where id='" . $r . "' and retail='1'"))) {
                $tr .= $r . ",";
            }
        }
        $tr = trim($tr, ",");
        $data["link"] = $tr;
        $data["type"] = "imei";
        $lid = $db->insert("tbl_generatedlink", $data);
        $data = NULL;
        if ($config["cms_seofriendly"]) {
            echo "<div id='notification1' class='successbox' >" . $config["site_address"] . $lid . "/yourword-bestdeal.html</div>";
        } else {
            echo "<div id='notification1' class='successbox' >" . $config["site_address"] . "index.php?action=bestdeal&list=" . $rid . "</div>";
        }
    }
}
if ($debug_output) {
    $debug_mode = true;
} else {
    $debug_mode = true;
}
$DB_USER = "dkmunssk_dhru10";
$DB_PASS = "dkmunssk_dhru10";      
$DB_HOST = "localhost";      
$DB_NAME = "dkmunssk_dhru10";  

$pdo = new PDO("mysql:host=localhost;dbname=dkmunssk_dhru10", "dkmunssk_dhru10", "dkmunssk_dhru10");
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$stmt = $pdo->query("SELECT * FROM tbl_services_imei ORDER BY id DESC");
$users = $stmt->fetchAll();
?>
<link rel="stylesheet" type="text/css" href="/datatables/jquery.dataTables.min.css">
<script type="text/javascript" language="javascript" src="/datatables/jquery.dataTables.min.js"></script>
<script>$(document).ready(function () {
    $('#example').DataTable();
});</script>
<table id="example" class="display" style="width:100%">
    <thead>
        <tr>
			<th></th>
            <th>ID</th>
            <th>Service Name</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
    <?php
    foreach ($users as $user) {
    ?>
        <tr>
            <td>
                <input type="checkbox" name="checkbox_name[]" value="<?=$user['id']?>">
            </td>
            <td>#<?=$user['id']?></td>
            <td><?=$user['service_name']?></td>
            <td>
                <a style="
				display: flex;
				justify-content: center;
				align-items: center;
				height: 100%;
				text-decoration: none; /* Remove underlines */
				padding: 5px 10px; /* Add padding for better styling */
				background-color: #FFD700; /* Set background color */
				color: #fff; /* Set text color */
				border-radius: 5px;
				" href="main2.php?page=editimeiservice&amp;id=<?=$user['id']?>">
                    Edit
                </a>
            </td>
        </tr>
    <?php
    }
    ?>
	</tbody>
</table>