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
require_once "../../../comm.php";
require_once "../../../includes/fun.inc.php";
require_once "../../includes/fun.inc.php";
if (!checkAdminlogin() || !$_SESSION["adminid"]) {
    echo "<div align=\"center\"><h3>Session expired. <a style=\"color: #666;\" href=\"index.php?main2redirect=true\">Please relogin</a></h3></div>";
    $_SESSION["admin_afterlogin_re"] = $_SERVER["REQUEST_URI"];
    exit;
}
if ($apidet && $gateway) {
    echo "    <script>\r\n        function myFunction(uniqva) {\r\n            /* Get the text field */\r\n            var copyText = \$('#field'+uniqva).html();\r\n\r\n            /* Select the text field */\r\n            var \$temp = \$(\"<input>\");\r\n            \$(\"body\").append(\$temp);\r\n            \$temp.val(copyText).select();\r\n            document.execCommand(\"copy\");\r\n            \$temp.remove();\r\n\r\n\r\n            alert(\"Copied the text: \" + copyText);\r\n        }\r\n    </script>\r\n";
    $data = explode("_", $apidet);
    if (2 < count($data)) {
        $data[0] = $data[0] . "_" . $data[1];
        $data[1] = $data[2];
    }
    if (!$data[1]) {
        $data[1] = "";
    }
    $apis = mysqli_fetch_assoc(dquery("select *\r\n    from tbl_apiserversservices where gateway='" . $gateway . "' and `type`='Tool' and id='" . $data[0] . "' and type_id='" . $data[1] . "'"));
    if ($apis["requires_custom"]) {
        echo "<div>Custom Field Required</div>";
        $custom = json_decode($apis["requires_custom"], true);
        foreach ($custom as $key => $v) {
            $flag = "<span style='color:red;'>Not installed</span>";
            if (mysqli_num_rows(dquery("select id from tbl_customfields \r\n           where `type`='serviceimei' and relid='" . $serviceid . "' and BINARY  fieldname='" . $v["fieldname"] . "'\r\n           and BINARY  fieldoptions='" . $v["fieldoptions"] . "'"))) {
                $flag = "";
            }
            echo "<div><i onclick='myFunction(" . $key . ")' class=\"fa fa-clipboard\"> <strong  id='field" . $key . "'>" . $v["fieldname"] . "</strong></i> " . $v["fieldtype"] . " <i>" . $v["fieldoptions"] . "</i> " . $flag . " </div>";
        }
    }
}

?>