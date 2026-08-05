<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);

$db_host = "localhost";
$db_user = "dkmunssk_dhru10";
$db_pass = "dkmunssk_dhru10";
$db_name = "dkmunssk_dhru10";

$db_conn2 = mysqli_connect($db_host, $db_user, $db_pass, $db_name);
if (!$db_conn2) {
    die("Connection failed: " . mysqli_connect_error());
}

echo "<h1>Fixing Missing Tables...</h1>\n";

// Fix tbl_loginlog_admin
$sql = "CREATE TABLE IF NOT EXISTS `tbl_loginlog_admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(100) NOT NULL,
  `userid` int(11) NOT NULL,
  `ip` varchar(50) NOT NULL,
  `time` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;";

if (mysqli_query($db_conn2, $sql)) {
    echo "Table 'tbl_loginlog_admin' created or already exists.\n";
} else {
    echo "Error creating 'tbl_loginlog_admin': " . mysqli_error($db_conn2) . "\n";
}

// Fix tbl_loginlog (likely missing too)
$sql = "CREATE TABLE IF NOT EXISTS `tbl_loginlog` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(100) NOT NULL,
  `userid` int(11) NOT NULL,
  `ip` varchar(50) NOT NULL,
  `time` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;";

if (mysqli_query($db_conn2, $sql)) {
    echo "Table 'tbl_loginlog' created or already exists.\n";
} else {
    echo "Error creating 'tbl_loginlog': " . mysqli_error($db_conn2) . "\n";
}

// Fix tbl_system_activity
$sql = "CREATE TABLE IF NOT EXISTS `tbl_system_activity` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` datetime NOT NULL,
  `description` text NOT NULL,
  `user` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;";

if (mysqli_query($db_conn2, $sql)) {
    echo "Table 'tbl_system_activity' created or already exists.\n";
} else {
    echo "Error creating 'tbl_system_activity': " . mysqli_error($db_conn2) . "\n";
}

echo "\nDone. Please try logging in again.\n";
?>
