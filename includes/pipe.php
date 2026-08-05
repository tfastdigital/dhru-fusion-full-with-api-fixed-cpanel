<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

?>
#!/usr/local/bin/php -q
<?php 
define("DEFINE_MY_ACCESS", true);
define("DEFINE_DHRU_FILE", true);
define("API", true);
require dirname(__FILE__) . "/../comm.php";
require ROOTDIR . "/includes/fun.inc.php";
require ROOTDIR . "/includes/client.area.inc.php";
require ROOTDIR . "/includes/pipe.fun.php";
require ROOTDIR . "/includes/support.fun.php";
$config = mysqli_fetch_assoc(dquery("select value from tbl_settings where attribute='config'"));
$config = serialize($config["value"]);
$_emailoutput = [];
$fd = fopen("php://stdin", "r");
$input = "";
while (!feof($fd)) {
    $input .= fread($fd, 1024);
}
fclose($fd);
$decode_params["input"] = $input;
$decode_params["include_bodies"] = true;
$decode_params["decode_bodies"] = true;
$decode_params["decode_headers"] = true;
$decode = new Mail_mimeDecode($input, "");
$structure = $decode->decode($decode_params);
$_emailoutput["headers"] = $structure->headers;
interpret_structure($structure);
if ($_emailoutput["body"]["text/plain"]) {
    $body = $_emailoutput["body"]["text/plain"];
} else {
    if ($_emailoutput["body"]["text/html"]) {
        $body = strip_tags($_emailoutput["body"]["text/html"]);
    } else {
        $body = "No message found.";
    }
}
$from = $_emailoutput["headers"]["from"];
$to = $_emailoutput["headers"]["to"];
$cc = $_emailoutput["headers"]["cc"];
$bcc = $_emailoutput["headers"]["bcc"];
if (!$to) {
    $to = $_emailoutput["headers"]["resent-to"];
}
$subject = $_emailoutput["headers"]["subject"];
$fromname = preg_replace("/(.*)<(.*)>/", "\\1", $from);
$fromname = str_replace("\"", "", $fromname);
$fromemail = preg_replace("/(.*)<(.*)>/", "\\2", $from);
$to = explode(",", $to);
foreach ($to as $toemail) {
    if (strpos("." . $toemail, "<")) {
        $toemails[] = preg_replace("/(.*)<(.*)>/", "\\2", $toemail);
    } else {
        $toemails[] = $toemail;
    }
}
foreach ($toemails as $e) {
    $sql = mysqli_fetch_assoc(dquery("select id from tbl_support_department where email='" . $e . "'"));
    $tid = explode("[#", $subject);
    $tid = explode("]", $tid[1]);
    $tid = $tid[0];
    $ticket["subject"] = $subject;
    $ticket["message"] = $body;
    if ($sql["id"]) {
        ticket($tid, "", "", $fromname, $fromemail, $sql["id"], 2, $ticket, true);
    }
}

?>