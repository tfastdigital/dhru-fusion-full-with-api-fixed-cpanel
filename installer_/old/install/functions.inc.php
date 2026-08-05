<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

function apphp_db_install($sql_dump_file)
{
    global $error_mg;
    global $username;
    global $password;
    global $database_prefix;
    global $password_encryption;
    global $site_url;
    global $template;
    global $ssl;
    global $language;
    global $admin_mail;
    global $admin_dir;
    $sql_array = [];
    $query = "";
    $sql_dump = file($sql_dump_file);
    $sql_dump = str_replace("<DB_PREFIX>", $database_prefix, $sql_dump);
    $sql_dump = str_replace("<SITE_URL>", $site_url, $sql_dump);
    $sql_dump = str_replace("<TEMPLATE>", $template, $sql_dump);
    $sql_dump = str_replace("<SSL>", $ssl, $sql_dump);
    $sql_dump = str_replace("<LANGUAGE>", $language, $sql_dump);
    $sql_dump = str_replace("<ADMIN_MAIL>", $admin_mail, $sql_dump);
    $sql_dump = str_replace("<ADMIN_DIR>", $admin_dir, $sql_dump);
    if (EI_USE_USERNAME_AND_PASWORD) {
        $sql_dump = str_replace("<USER_NAME>", $username, $sql_dump);
        if (EI_USE_PASSWORD_ENCRYPTION) {
            if ($password_encryption == "AES") {
                $sql_dump = str_replace("<PASSWORD>", "AES_ENCRYPT('" . $password . "', '" . EI_PASSWORD_ENCRYPTION_KEY . "')", $sql_dump);
            } else {
                if ($password_encryption == "MD5") {
                    $sql_dump = str_replace("<PASSWORD>", "MD5('" . $password . "')", $sql_dump);
                }
            }
        } else {
            $sql_dump = str_replace("<PASSWORD>", "'" . $password . "'", $sql_dump);
        }
    }
    if (EI_USE_ENCODING) {
        $sql_variables = ["character_set_client" => EI_DUMP_FILE_ENCODING, "character_set_server" => EI_DUMP_FILE_ENCODING, "character_set_results" => EI_DUMP_FILE_ENCODING, "character_set_database" => EI_DUMP_FILE_ENCODING, "character_set_connection" => EI_DUMP_FILE_ENCODING, "collation_server" => EI_DUMP_FILE_COLLATION, "collation_database" => EI_DUMP_FILE_COLLATION, "collation_connection" => EI_DUMP_FILE_COLLATION];
        foreach ($sql_variables as $var => $value) {
            $sql = "SET " . $var . "=" . $value . ";";
            apphp_db_query($sql);
        }
    }
    foreach ($sql_dump as $sql_line) {
        $tsl = trim(utf8_decode($sql_line));
        if ($sql_line != "" && substr($tsl, 0, 2) != "--" && substr($tsl, 0, 1) != "?" && substr($tsl, 0, 1) != "#") {
            $query .= $sql_line;
            if (preg_match("/;\\s*\$/", $sql_line)) {
                if (!apphp_db_query($query)) {
                    $error_mg[] = mysqli_error();
                    return false;
                }
                $query = "";
            }
        }
    }
    return true;
}
function apphp_db_install_old($sql_dump_file)
{
    global $error_mg;
    global $username;
    global $password;
    global $database_prefix;
    $sql_dump = file($sql_dump_file);
    $sql_dump = str_replace("<DB_PREFIX>", $database_prefix, $sql_dump);
    if (EI_USE_USERNAME_AND_PASWORD) {
        $sql_dump = str_replace("<USER_NAME>", $username, $sql_dump);
        $sql_dump = str_replace("<PASSWORD>", $password, $sql_dump);
    }
    $query = "";
    $sql_array = [];
    $sql_length = strlen($sql_dump);
    $pos = strpos($sql_dump, ";");
    for ($i = $pos; $i < $sql_length; $i++) {
        if ($sql_dump[0] == "#") {
            $sql_dump = ltrim(substr($sql_dump, strpos($sql_dump, "\n")));
            $sql_length = strlen($sql_dump);
            $i = strpos($sql_dump, ";") - 1;
        } else {
            if ($sql_dump[$i + 1] == "\n") {
                $j = $i + 2;
                while ($j < $sql_length) {
                    if (trim($sql_dump[$j]) != "") {
                        $next = substr($sql_dump, $j, 6);
                        if ($next[0] == "#") {
                            $k = $j;
                            while ($k < $sql_length) {
                                if ($sql_dump[$k] != "\n") {
                                    $k++;
                                }
                            }
                            $query = substr($sql_dump, 0, $i + 1);
                            $sql_dump = substr($sql_dump, $k);
                            $sql_dump = $query . $sql_dump;
                            $sql_length = strlen($sql_dump);
                            $i = strpos($sql_dump, ";") - 1;
                        }
                    } else {
                        $j++;
                    }
                }
                if ($next == "") {
                    $next = "insert";
                }
                if (stripos($next, "create") !== false || stripos($next, "insert") !== false || stripos($next, "drop t") !== false) {
                    $next = "";
                    $sql_array[] = substr($sql_dump, 0, $i);
                    $sql_dump = ltrim(substr($sql_dump, $i + 1));
                    $sql_length = strlen($sql_dump);
                    $i = strpos($sql_dump, ";") - 1;
                }
            }
        }
    }
    for ($i = 0; $i < sizeof($sql_array); $i++) {
        if (!apphp_db_query($sql_array[$i])) {
            $error_mg[] = mysqli_error();
            return false;
        }
    }
    return true;
}
function apphp_db_select_db($database)
{
    return mysql_select_db($database);
}
function apphp_db_query($query)
{
    global $link1;
    $res = _dquery($query, $link1);
    return $res;
}
function _dquery($query, $conn = "")
{
    global $link1;
    if ($conn) {
        $link1 = $conn;
    }
    mysqli_set_charset($link1, "utf8");
    return mysqli_query($link1, $query);
}

?>