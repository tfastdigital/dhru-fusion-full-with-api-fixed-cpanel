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
echo "<script>\n \$(\"#group\").change(function () {\n  var t=\$(\"#type\").val();\n  \$.post('includes/pages/getAffiliate.php',{group: \$(this).val(),types: t}, function(data) {\n      \$('#services').html(data);\n  });\n});\n</script>\n";
if ($type == "imei") {
    echo "<select name='group' id='group'><option value=''>Select</option>";
    $sql = dquery("select * from tbl_imei_group");
    while ($r = mysqli_fetch_assoc($sql)) {
        echo "<option value='" . $r["id"] . "'>" . $r["group_name"] . "</option>";
    }
    echo "</select>";
}
if ($type == "file") {
    echo "<select name='group' id='group'><option value=''>Select</option>";
    $sql = dquery("select * from tbl_file_group");
    while ($r = mysqli_fetch_assoc($sql)) {
        echo "<option value='" . $r["id"] . "'>" . $r["group_name"] . "</option>";
    }
    echo "</select>";
}
if ($type == "server") {
    echo "<select name='group' id='group'><option value=''>Select</option>";
    $sql = dquery("select * from tbl_server_group");
    while ($r = mysqli_fetch_assoc($sql)) {
        echo "<option value='" . $r["id"] . "'>" . $r["group_name"] . "</option>";
    }
    echo "</select>";
}
if ($type == "product") {
    echo "<select name='group' id='group'><option value=''>Select</option>";
    $sql = dquery("select * from tbl_product_group");
    while ($r = mysqli_fetch_assoc($sql)) {
        echo "<option value='" . $r["id"] . "'>" . $r["group_name"] . "</option>";
    }
    echo "</select>";
}
if ($group && $types == "imei") {
    echo "<select name='service'><option value=''>Select</option>";
    $sql = dquery("select * from tbl_services_imei where group_id='" . $group . "'");
    while ($r = mysqli_fetch_assoc($sql)) {
        echo "<option value='" . $r["id"] . "'>" . $r["service_name"] . "</option>";
    }
    echo "</select>";
}
if ($group && $types == "file") {
    echo "<select name='service'><option value=''>Select</option>";
    $sql = dquery("select * from tbl_services_file where group_id='" . $group . "'");
    while ($r = mysqli_fetch_assoc($sql)) {
        echo "<option value='" . $r["id"] . "'>" . $r["service_name"] . "</option>";
    }
    echo "</select>";
}
if ($group && $types == "server") {
    echo "<select name='service'><option value=''>Select</option>";
    $sql = dquery("select * from tbl_server_log where group_id='" . $group . "'");
    while ($r = mysqli_fetch_assoc($sql)) {
        echo "<option value='" . $r["id"] . "'>" . $r["service_name"] . "</option>";
    }
    echo "</select>";
}
if ($group && $types == "product") {
    echo "<select name='service'><option value=''>Select</option>";
    $sql = dquery("select * from tbl_products where group_id='" . $group . "'");
    while ($r = mysqli_fetch_assoc($sql)) {
        echo "<option value='" . $r["id"] . "'>" . $r["service_name"] . "</option>";
    }
    echo "</select>";
}
$fileverioncheck = "6.1.0";

?>