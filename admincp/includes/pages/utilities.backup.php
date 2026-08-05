<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

echo "<script>\nfunction restore(file){\n    var answer = confirm('";
echo $LNG["areyousuretorestore"];
echo "');\n    if(answer)\n    {\n        RestoreDatabase(file,'utilities.databaserestore','#frm','#notification','true','#main_loader');\n    }\n}\nfunction sortTable(f,n){\n  var rows = \$('#main_tbl tbody  tr').get();\n\n  rows.sort(function(a, b) {\n\n  var A = \$(a).children('td').eq(n).text().toUpperCase();\n  var B = \$(b).children('td').eq(n).text().toUpperCase();\n\n  if(A < B) {\n    return -1*f;\n  }\n  if(A > B) {\n    return 1*f;\n  }\n  return 0;\n  });\n\n  \$.each(rows, function(index, row) {\n    \$('#main_tbl').children('tbody').append(row);\n  });\n}\nvar f_sl = 1;\nvar f_nm = 1;\n\$(\"#sl\").click(function(){\n    f_sl *= -1;\n    var n = \$(this).prevAll().length;\n    sortTable(f_sl,n);\n});\n\$(\"#nm\").click(function(){\n    f_nm *= -1;\n    var n = \$(this).prevAll().length;\n    sortTable(f_nm,n);\n});\n</script>\n<style>\n#sl{\n    cursor:pointer;\n}\n</style>\n";
$pageid = 340;
checkPagePermission($pageid);
echo "<div id=\"notification\"></div>\n\n<form action=\"\" method=\"post\" style=\"text-align: center;\">\n<p class=\"fixedbtn\">\n    <input class=\"btn\" type=\"submit\" name=\"backup\" value=\"New Backup Now\"/>\n    </p>\n</form>\n<br />\n<div id=\"content\">\n<div id=\"content_padded\">\n\n";
if ($delete) {
    $key = array_keys($delete);
    unlink("includes/backup/" . $key[0]);
    echo "<div id='notification1' class=successbox>" . $key[0] . " " . $LNG["successfully"] . " " . $LNG["delete"] . "</div>";
}
if ($download) {
    $key = array_keys($download);
}
if ($backup) {
    require_once "../includes/phpzip.class.php";
    $file = date("d-m-Y") . "_" . date("H:i:s");
    $ziper = new zipfile();
    if ($config["backup_users"]) {
        $time = date("Y-M-d-h-i-s", time());
        $myFile = "includes/backup/" . $time . "_user.sql";
        $fh = fopen($myFile, "w+") or exit("can't open file");
        $database = mysqli_fetch_assoc(dquery("SELECT database() as db"));
        $result = dquery("SHOW TABLE STATUS FROM " . $database["db"]);
        while ($tablename = mysqli_fetch_assoc($result)) {
            $result1 = dquery("select * from " . $tablename["Name"]);
            while ($row = mysqli_fetch_assoc($result1)) {
                if ($tablename["Name"] == "tblUsers" || $tablename["Name"] == "tbl_statement_user" || $tablename["Name"] == "tbl_client_group" || $tablename["Name"] == "tbl_client_group_price" || $tablename["Name"] == "tbl_discount_imei" || $tablename["Name"] == "tbl_discount_file" || $tablename["Name"] == "tbl_discount_product" || $tablename["Name"] == "tbl_discount_server_log") {
                    $insert = "insert IGNORE into " . $tablename["Name"] . " values (";
                    foreach ($row as $value) {
                        $value = str_replace("\"", "\\\"", $value);
                        $value = str_replace("'", "''", $value);
                        $insert .= "'" . $value . "',";
                    }
                    $insert .= ");\n";
                    $insert = str_replace(",)", ")", $insert);
                    fwrite($fh, $insert);
                }
            }
        }
        fclose($fh);
        $fh = fopen("includes/backup/" . $time . "_user.sql", "r");
        $theData = fread($fh, filesize("includes/backup/" . $time . "_user.sql"));
        $ziper->addFile($theData, $time . "_user.sql");
        unlink("includes/backup/" . $time . "_user.sql");
    }
    if ($config["backup_service"]) {
        $time = date("Y-M-d-h-i-s", time());
        $myFile = "includes/backup/" . $time . "_service.sql";
        $fh = fopen($myFile, "w+") or exit("can't open file");
        $database = mysqli_fetch_assoc(dquery("SELECT database() as db"));
        $result = dquery("SHOW TABLE STATUS FROM " . $database["db"]);
        while ($tablename = mysqli_fetch_assoc($result)) {
            $result1 = dquery("select * from " . $tablename["Name"]);
            while ($row = mysqli_fetch_assoc($result1)) {
                if ($tablename["Name"] == "tbl_services_imei" || $tablename["Name"] == "tbl_services_file" || $tablename["Name"] == "tbl_server_log" || $tablename["Name"] == "tbl_products" || $tablename["Name"] == "tbl_imei_credit" || $tablename["Name"] == "tbl_file_credit" || $tablename["Name"] == "tbl_server_credit" || $tablename["Name"] == "tbl_product_credit") {
                    $insert = "insert IGNORE into " . $tablename["Name"] . " values (";
                    foreach ($row as $value) {
                        $value = str_replace("\"", "\\\"", $value);
                        $value = str_replace("'", "''", $value);
                        $insert .= "'" . $value . "',";
                    }
                    $insert .= ");\n";
                    $insert = str_replace(",)", ")", $insert);
                    fwrite($fh, $insert);
                }
            }
        }
        fclose($fh);
        $fh = fopen("includes/backup/" . $time . "_service.sql", "r");
        $theData = fread($fh, filesize("includes/backup/" . $time . "_service.sql"));
        $ziper->addFile($theData, $time . "_service.sql");
        unlink("includes/backup/" . $time . "_service.sql");
    }
    if ($config["backup_config"]) {
        $time = date("Y-M-d-h-i-s", time());
        $myFile = "includes/backup/" . $time . "_config.sql";
        $fh = fopen($myFile, "w+") or exit("can't open file");
        $database = mysqli_fetch_assoc(dquery("SELECT database() as db"));
        $result = dquery("SHOW TABLE STATUS FROM " . $database["db"]);
        while ($tablename = mysqli_fetch_assoc($result)) {
            $result1 = dquery("select * from " . $tablename["Name"]);
            while ($row = mysqli_fetch_assoc($result1)) {
                if ($tablename["Name"] == "tbl_settings" || $tablename["Name"] == "tbl_site_settings" || $tablename["Name"] == "tbl_paymentgateways") {
                    $insert = "insert IGNORE into " . $tablename["Name"] . " values (";
                    foreach ($row as $value) {
                        $value = str_replace("\"", "\\\"", $value);
                        $value = str_replace("'", "''", $value);
                        $insert .= "'" . $value . "',";
                    }
                    $insert .= ");\n";
                    $insert = str_replace(",)", ")", $insert);
                    fwrite($fh, $insert);
                }
            }
        }
        fclose($fh);
        $fh = fopen("includes/backup/" . $time . "_config.sql", "r");
        $theData = fread($fh, filesize("includes/backup/" . $time . "_config.sql"));
        $ziper->addFile($theData, $time . "_config.sql");
        unlink("includes/backup/" . $time . "_config.sql");
    }
    if ($config["backup_order"]) {
        $time = date("Y-M-d-h-i-s", time());
        $myFile = "includes/backup/" . $time . "_orders.sql";
        $fh = fopen($myFile, "w+") or exit("can't open file");
        $database = mysqli_fetch_assoc(dquery("SELECT database() as db"));
        $result = dquery("SHOW TABLE STATUS FROM " . $database["db"]);
        while ($tablename = mysqli_fetch_assoc($result)) {
            $result1 = dquery("select * from " . $tablename["Name"]);
            while ($row = mysqli_fetch_assoc($result1)) {
                if ($tablename["Name"] == "tbl_order_imei" || $tablename["Name"] == "tbl_order_file" || $tablename["Name"] == "tbl_order_server" || $tablename["Name"] == "tbl_order_product" || $tablename["Name"] == "tbl_order_server") {
                    $insert = "insert IGNORE into " . $tablename["Name"] . " values (";
                    foreach ($row as $value) {
                        $value = str_replace("\"", "\\\"", $value);
                        $value = str_replace("'", "''", $value);
                        $insert .= "'" . $value . "',";
                    }
                    $insert .= ");\n";
                    $insert = str_replace(",)", ")", $insert);
                    fwrite($fh, $insert);
                }
            }
        }
        fclose($fh);
        $fh = fopen("includes/backup/" . $time . "_orders.sql", "r");
        $theData = fread($fh, filesize("includes/backup/" . $time . "_orders.sql"));
        $ziper->addFile($theData, $time . "_orders.sql");
        unlink("includes/backup/" . $time . "_orders.sql");
    }
    if ($config["backup_email"]) {
        $time = date("Y-M-d-h-i-s", time());
        $myFile = "includes/backup/" . $time . "_email.sql";
        $fh = fopen($myFile, "w+") or exit("can't open file");
        $database = mysqli_fetch_assoc(dquery("SELECT database() as db"));
        $result = dquery("SHOW TABLE STATUS FROM " . $database["db"]);
        while ($tablename = mysqli_fetch_assoc($result)) {
            $result1 = dquery("select * from " . $tablename["Name"]);
            while ($row = mysqli_fetch_assoc($result1)) {
                if ($tablename["Name"] == "tbl_emailtemplates") {
                    $insert = "insert IGNORE into " . $tablename["Name"] . " values (";
                    foreach ($row as $value) {
                        $value = str_replace("\"", "\\\"", $value);
                        $value = str_replace("'", "''", $value);
                        $insert .= "'" . $value . "',";
                    }
                    $insert .= ");\n";
                    $insert = str_replace(",)", ")", $insert);
                    fwrite($fh, $insert);
                }
            }
        }
        fclose($fh);
        $fh = fopen("includes/backup/" . $time . "_email.sql", "r");
        $theData = fread($fh, filesize("includes/backup/" . $time . "_email.sql"));
        $ziper->addFile($theData, $time . "_email.sql");
        unlink("includes/backup/" . $time . "_email.sql");
    }
    $ziper->output("includes/backup/" . $file . ".zip");
}
echo "<form id=\"frmcleanup\" name=\"\" method=\"post\">\n";
echo generate_token("form");
echo "<table id=\"main_tbl\">\n<thead>\n  <tr><th id=\"sl\">";
echo $LNG["date"];
echo "</th><th><div  align=\"right\">";
echo $LNG["size"];
echo "</div> </th>\n   <th><div align=\"right\">";
echo $LNG["action"];
echo "</div></th>\n  </tr>\n</thead>\n<tbody>\n";
if ($handle = opendir("includes/backup/")) {
    while (false !== ($file = readdir($handle))) {
        if ($file != "." && $file != ".." && preg_match("/\\.zip\$/i", $file)) {
            $cls = fileatime("includes/backup/" . $file);
            echo "<tr class='" . $cls . "'><td>" . $file . "</td><td align='right'>" . round(filesize("includes/backup/" . $file) / 1048576, 2) . "MB</td><td align='right'>\n          <form   method='post'>\n          <input value='" . $LNG["delete"] . "'  onclick='javascript: return confirm(\"Are you sure want to remove ?\");' name='delete[" . $file . "]' class='button_remove' type='submit'>\n          <input value='" . $LNG["download"] . "' name='downloads[" . $file . "]' onclick=\"location.href='includes/pages/downloadsql.php?downloads=" . $file . "'\" class='button' type='button'>      \n          </form>\n          </td></tr>";
        }
    }
    closedir($handle);
}
echo "</tbody></table>\n</form>\n\n</div></div>";
$fileverioncheck = "6.1.0";

?>