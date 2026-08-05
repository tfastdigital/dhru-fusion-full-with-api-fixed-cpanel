<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

define("EI_MODE", "production");
define("EI_CHECK_PHP_MINIMAL_VERSION", true);
define("EI_PHP_MINIMAL_VERSION", "7.2");
define("EI_IONCUBE_MINIMAL_VERSION", "10.1");
define("EI_CHECK_CONFIG_DIR_WRITABILITY", true);
define("EI_USE_USERNAME_AND_PASWORD", true);
define("EI_USE_PASSWORD_ENCRYPTION", true);
define("EI_PASSWORD_ENCRYPTION_TYPE", "MD5");
define("EI_PASSWORD_ENCRYPTION_KEY", "php_easy_installer");
define("EI_CONFIG_FILE_DIRECTORY", "");
define("EI_CONFIG_FILE_NAME", "../../configs/config.php");
if (!is_file(EI_CONFIG_FILE_NAME)) {
    define("EI_CONFIG_AVAILABLE", false);
} else {
    define("EI_CONFIG_AVAILABLE", true);
    define("DEFINE_MY_ACCESS", 1);
    define("DEFINE_DHRU_FILE", true);
    require_once "../../configs/config.php";
    require_once "../../includes/mysqlfunction.inc.php";
    require_once "../../includes/mysqlclass.php";
    require_once "dump.class.php";
}
define("EI_CONFIG_FILE_PATH", EI_CONFIG_FILE_DIRECTORY . EI_CONFIG_FILE_NAME);
define("EI_SQL_DUMP_FILE_NEW", "sql_dump/structure.sql");
define("EI_SQL_DUMP_FILE_UPDATE", "sql_dump/structure.sql");
define("EI_USE_ENCODING", true);
define("EI_DUMP_FILE_ENCODING", "utf8");
define("EI_DUMP_FILE_COLLATION", "utf8_unicode_ci");
define("EI_CONFIG_FILE_TEMPLATE", "config.tpl");
define("EI_APPLICATION_NAME", "Dhru Fusion");
define("EI_APPLICATION_VERSION", "<VERSION>");
define("EI_RELEASE_CANDIDATE", "<RC>");
define("EI_RELEASE_STATUS", "RC");
define("EI_APPLICATION_START_FILE", "../../index.php");
define("EI_LICENSE_AGREEMENT_PAGE", "http://dhru.com/cms/toc/");

?>