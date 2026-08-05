<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

require_once "settings.inc.php";
require_once "functions.inc.php";
error_reporting(15);
if (EI_MODE == "debug") {
    error_reporting(15);
}
$completed = false;
$error_mg = [];
if ($_POST["submit"] == "step2") {
    $database_host = isset($_POST["database_host"]) ? $_POST["database_host"] : "";
    $database_name = isset($_POST["database_name"]) ? $_POST["database_name"] : "";
    $database_username = isset($_POST["database_username"]) ? $_POST["database_username"] : "";
    $database_password = isset($_POST["database_password"]) ? $_POST["database_password"] : "";
    $install_type = isset($_POST["install_type"]) ? $_POST["install_type"] : "new";
    $sql_dump_file = $install_type == "new" ? EI_SQL_DUMP_FILE_NEW : EI_SQL_DUMP_FILE_UPDATE;
    $site_url = isset($_POST["site_url"]) ? $_POST["site_url"] : "";
    if ($install_type == "new") {
        if (file_exists(EI_CONFIG_FILE_PATH)) {
            header("location: " . EI_APPLICATION_START_FILE);
            exit;
        }
        if (empty($database_host)) {
            $error_mg[] = "Database host can not be empty! Please re-enter.";
        }
        if (empty($database_name)) {
            $error_mg[] = "Database name can not be empty! Please re-enter.";
        }
        if (empty($database_username)) {
            $error_mg[] = "Database username can not be empty! Please re-enter.";
        }
        if (empty($database_password)) {
            $error_mg[] = "Database password can not be empty! Please re-enter.";
        }
        if (empty($site_url)) {
            $error_mg[] = "Site URL can not be empty! Please re-enter.";
        }
        if (empty($error_mg)) {
            if (EI_MODE == "demo") {
                if ($database_host == "localhost" && $database_name == "db_name" && $database_username == "test" && $database_password == "test") {
                    $completed = true;
                } else {
                    $error_mg[] = "Testing parameters are wrong! Please enter valid parameters.";
                }
            } else {
                $config_file = file_get_contents(EI_CONFIG_FILE_TEMPLATE, true);
                $config_file = str_replace("<DB_HOST>", $database_host, $config_file);
                $config_file = str_replace("<DB_NAME>", $database_name, $config_file);
                $config_file = str_replace("<DB_USER>", $database_username, $config_file);
                $config_file = str_replace("<DB_PASSWORD>", $database_password, $config_file);
                @chmod(EI_CONFIG_FILE_PATH, 493);
                $f = @fopen(EI_CONFIG_FILE_PATH, "w");
                if (0 < @fwrite($f, $config_file)) {
                    @chmod(EI_CONFIG_FILE_DIRECTORY, 420);
                    $link1 = @mysqli_connect($database_host, $database_username, $database_password, $database_name);
                    $link = $link1;
                    if ($link1) {
                        if ($link1) {
                            $sql_dump = file_get_contents($sql_dump_file);
                            if ($sql_dump != "") {
                                if (!($db_error = apphp_db_install($sql_dump_file))) {
                                    $error_mg[] = "SQL execution error! Please check carefully a syntax of SQL dump file.";
                                    @unlink(EI_CONFIG_FILE_PATH);
                                }
                                $completed = true;
                            } else {
                                $error_mg[] = "Could not read file " . $sql_dump_file . "! Please check if a file exists.";
                                @unlink(EI_CONFIG_FILE_PATH);
                            }
                            $sql_dump = file_get_contents("sql_dump/update_date.sql");
                            if ($sql_dump != "") {
                                if (!($db_error = apphp_db_install("sql_dump/update_date.sql"))) {
                                    $error_mg[] = "SQL execution error! Please check carefully a syntax of SQL update_date file.";
                                } else {
                                    $completed = true;
                                }
                            } else {
                                $error_mg[] = "Could not read file " . $sql_dump_file . "! Please check if a file exists.";
                            }
                            $sql_dump = file_get_contents("sql_dump/update_date_new.sql");
                            if ($sql_dump != "") {
                                if (!($db_error = apphp_db_install("sql_dump/update_date_new.sql"))) {
                                    $error_mg[] = "SQL execution error! Please check carefully a syntax of SQL update_date file.";
                                } else {
                                    $completed = true;
                                }
                            } else {
                                $error_mg[] = "Could not read file " . $sql_dump_file . "! Please check if a file exists.";
                            }
                            if ($_POST["knowledge"]) {
                                $sql_dump = file_get_contents("sql_dump/knowledge.sql");
                                if ($sql_dump != "") {
                                    if (!($db_error = apphp_db_install("sql_dump/knowledge.sql"))) {
                                        $error_mg[] = "SQL execution error! Please check carefully a syntax of SQL update_date file.";
                                    } else {
                                        $completed = true;
                                    }
                                } else {
                                    $error_mg[] = "Could not read file " . $sql_dump_file . "! Please check if a file exists.";
                                }
                            }
                            $result = _dquery("select * from tbl_configer", $link);
                            while ($data = @mysqli_fetch_assoc($result)) {
                                $config_["" . $data["attribute"]] = "" . $data["value"];
                            }
                            $sercon = serialize($config_);
                            _dquery("insert into tbl_settings\n                             values ('config','" . $sercon . "')", $link1);
                        } else {
                            if (EI_MODE == "debug") {
                                $error_mg[] = "Database connecting error! Please check your database exists. <br />Error: " . mysqli_error() . "</span><br />";
                            } else {
                                $error_mg[] = "Database connecting error! Please check your database exists.</span><br />";
                            }
                            @unlink(EI_CONFIG_FILE_PATH);
                        }
                    } else {
                        if (EI_MODE == "debug") {
                            $error_mg[] = "Database connecting error! Please check your connection parameters. <br />Error: " . mysqli_error() . "</span><br />";
                        } else {
                            $error_mg[] = "Database connecting error! Please check your connection parameters.</span><br />";
                        }
                        @unlink(EI_CONFIG_FILE_PATH);
                    }
                } else {
                    $error_mg[] = "Can not open configuration file " . EI_CONFIG_FILE_PATH;
                }
                @fclose($f);
            }
        }
    } else {
        error_reporting(1);
        $backup = new MySQLDump1();
        $backup->connect($config["server"], $config["user"], $config["pass"], $config["database"]);
        if (!$backup->connected) {
            $error_mg[] = $backup->mysqli_error;
        }
        $backup->dump();
        $_table_old = htmlspecialchars($backup->output);
        $_table_old = str_replace("CREATE TABLE IF NOT EXISTS", "CREATE TABLE", $_table_old);
        $_table_old = str_replace("CREATE TABLE", "CREATE TABLE IF NOT EXISTS", $_table_old);
        $_table_old = str_replace("DEFAULT '0'", "DEFAULT 0", $_table_old);
        $_table_old = str_replace("DEFAULT '1.00000'", "DEFAULT 1.00000", $_table_old);
        $_table_old = str_replace("DEFAULT '0.00'", "DEFAULT 0.00", $_table_old);
        $_table_old = str_replace("DEFAULT '1'", "DEFAULT 1", $_table_old);
        $_table_old = str_replace("unsigned", "UNSIGNED", $_table_old);
        $myFile = EI_SQL_DUMP_FILE_UPDATE;
        $fh = fopen($myFile, "r");
        $_table_new = fread($fh, filesize($myFile));
        fclose($fh);
        $updater = new dbStructUpdater();
        $res = $updater->getUpdates($_table_old, $_table_new);
        $_table_update = "";
        foreach ($res as $value) {
            $value = str_replace("int(11) NOT NULL NOT 0", "int(11) NOT NULL DEFAULT 0", $value);
            $value = str_replace("int(1) NOT NULL NOT 0", "int(1) NOT NULL DEFAULT 0", $value);
            $value = str_replace("int(10) NOT NULL NOT 0", "int(10) NOT NULL DEFAULT 0", $value);
            $_table_update .= $value . ";";
            if (!(stripos($value, "DROP") !== false || stripos($value, "ADD INDEX") !== false || stripos($value, "AUTO_INCREMENT") !== false || stripos($value, "MODIFY PRIMARY KEY") !== false)) {
                if (EI_RELEASE_STATUS == "BETA") {
                    echo $value . " <br />";
                }
                $result = $backup->dquery($value . ";");
                if (!$result) {
                    $error_mg[] = "Invalid query: " . mysqli_error();
                } else {
                    $completed = true;
                }
            }
            if (stripos($value, "CREATE TABLE") !== false) {
                if (EI_RELEASE_STATUS == "BETA") {
                    echo $value . " <br />";
                }
                $result = $backup->dquery($value . ";");
                if (!$result) {
                    $error_mg[] = "Invalid CREATE TABLE query: " . mysqli_error();
                } else {
                    $completed = true;
                }
            }
        }
        if ($_table_update == NULL) {
            $completed = true;
        }
        $link1 = @mysqli_connect($config["server"], $config["user"], $config["pass"], $config["database"]);
        exit(mysqli_error());
    }
}
echo "<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.01 Transitional//EN\">\n<html>\n<head>\n    <title>Installation Guide</title>\n    <meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\"/>\n    <link rel=\"stylesheet\" type=\"text/css\" href=\"img/styles.css\"></link>\n</head>\n<body>\n<div style=\"width: 960px; margin: auto;\">\n    <br/>\n    <br/>\n    <br/>\n    <h2 align=\"left\">New Installation of ";
echo EI_APPLICATION_NAME;
echo "!</h2>\n\n\n    <table cellspacing=\"0\" cellpadding=\"0\" width=\"100%\" border=\"0\">\n        <tbody>\n        <tr>\n            <td>&nbsp;</td>\n        </tr>\n        <tr>\n            <td class=\"text\" valign=\"top\">\n\n                ";
if (!$completed) {
    echo "Oops, something went wrong...";
} else {
    echo "Follow the wizard to setup your database.";
}
echo "\n                <br/> <br/>\n                <table width=\"100%\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\">\n                    <tbody>\n                    <tr>\n                        <td class=\"gray_table\">\n                            <table width=\"100%\" cellspacing=\"0\" cellpadding=\"0\"\n                                   border=\"0\">\n                                <tbody>\n                                <tr>\n                                    <td></td>\n                                    <td align=\"middle\">\n                                        <table width=\"100%\" cellspacing=\"0\" cellpadding=\"0\"\n                                               border=\"0\">\n                                            <tbody>\n                                            ";
if (!$completed) {
    echo "<tr><td colspan=\"2\" ><div id=\"notification\" class=\"errorbox\">";
    foreach ($error_mg as $msg) {
        echo "<li>" . $msg . "</li>";
    }
    echo "</div><td/></tr>                                            </tbody>\n                                        </table>\n                                        <p align=\"right\">\n                                            <input type=\"button\" class=\"btn remove\"\n                                                   onclick=\"javascript: history.go(-1);\" value=\"Back\"/> <input\n                                                    type=\"button\" class=\"btn save\"\n                                                    onclick=\"javascript: location.reload();\" value=\"Retry\"/>\n                                        </p>\n                                        ";
} else {
    if ($install_type == "new") {
        echo "                                <tr>\n                                    <td>&nbsp;</td>\n                                </tr>\n                                <tr>\n                                    <td class=\"text\" align=\"left\"><b>Step 2. Installation\n                                            Completed</b></td>\n                                </tr>\n                                <tr>\n                                    <td class=\"text\" align=\"left\">Installation Successfull <br/>\n                                        <br/>\n                                        ";
        if (EI_APPLICATION_START_FILE != "") {
            echo "<p align=\"right\">\n                                            <A class=\"btn save\"\n                                               href=\"";
            echo EI_APPLICATION_START_FILE;
            echo "\">Proceed to index page</A>\n                                            </p>\n\n                                            ";
        }
        echo "                                    </td>\n                                </tr>\n                                ";
    } else {
        echo "                                    <tr>\n                                        <td>&nbsp;</td>\n                                    </tr>\n                                    <TR>\n                                        <TD class=\"text\" align=\"left\"><b>Step 2. Updation\n                                                Completed</b></td>\n                                    </tr>\n                                    <tr>\n                                        <td>&nbsp;</td>\n                                    </tr>\n                                    <tr>\n                                        <TD class=\"text\" align=\"left\">System updated successfully\n                                            ! <br/> <br/>\n                                            <p align=\"right\">\n                                                <A class=\"btn save\"\n                                                   href=\"";
        echo EI_APPLICATION_START_FILE;
        echo "\">Proceed to index page</A>\n                                            </p>\n\n                                        </td>\n                                    </tr>\n                                    ";
    }
    if ($_POST["selfupgrade"]) {
        rrmdir("../../installer");
    }
}
echo "                                </tbody>\n                            </table>\n\n                        <td></td>\n                    </tr>\n                    </tbody>\n                </table>\n            </td>\n        </tr>\n        </tbody>\n    </table>\n</div>\n";
include_once "footer.php";
echo "</td>\n</tr>\n</tbody>\n</table>\n\n</body>\n</html>";
function rrmdir($dir)
{
    if (is_dir($dir)) {
        $objects = scandir($dir);
        foreach ($objects as $object) {
            if ($object != "." && $object != "..") {
                if (filetype($dir . "/" . $object) == "dir") {
                    rrmdir($dir . "/" . $object);
                } else {
                    unlink($dir . "/" . $object);
                }
            }
        }
        reset($objects);
        rmdir($dir);
    }
}

?>