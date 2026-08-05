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
if (!is_file("../../.htaccess")) {
    rename("../../_.htaccess", "../../.htaccess");
    echo "Admin htaccess updated";
} else {
    $data = file_get_contents("../../.htaccess");
    if (!strpos($data, "Allow from all")) {
        $data .= "\n<Files \"*\">    \n    Allow from all\n</Files>";
        if (file_put_contents("../../.htaccess", $data)) {
            echo "Admin htaccess updated";
        } else {
            echo "Error in Admin htaccess update";
        }
    } else {
        echo "Admin htaccess is up to date";
    }
}
echo "<br /><br />";
if (is_file("../../../.htaccess")) {
    $data = file_get_contents("../../../.htaccess");
    if (strpos($data, "AddHandler") !== false) {
        if (is_file("../../../_.htaccess")) {
            $accs = file_get_contents("../../../_.htaccess");
            $accs = str_replace("#AddHandler", "AddHandler", $accs);
            if (file_put_contents("../../../.htaccess", $accs)) {
                echo "Htaccess Updated with php5 handler";
            } else {
                echo "error in htaccess update";
            }
        }
    } else {
        $accs = file_get_contents("../../../_.htaccess");
        if (file_put_contents("../../../.htaccess", $accs)) {
            echo "Htaccess Updated";
        } else {
            echo "error in htaccess update";
        }
    }
} else {
    rename("../../../_.htaccess", "../../../.htaccess");
    echo "Htaccess Updated";
}

?>