<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

define("DEFINE_MY_ACCESS", true);
define("DEFINE_DHRU_FILE", true);
define("CLIENT", true);
define("SSLON", true);
require "../comm.php";
$id = preg_replace("/[^0-9\\-a-zA-Z]/i", "", $id);
$row = mysqli_fetch_assoc(dquery("select * from tbl_knowledgebase where id=" . $id));
echo "\n    <div class=\"sInfo knowledgebase\" style=\"\">  \n        <div class=\"creditCost\">         \n            <h3>" . $row["title"] . "</h3>         \n        </div>\n        <div class=\"know-content\">                                     \n           " . $row["content"] . "                                \n      </div>\n    </div>";

?>