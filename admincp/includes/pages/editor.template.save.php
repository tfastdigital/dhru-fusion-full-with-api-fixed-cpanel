<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

if ($save_token != sha1(session_id() . $_SESSION["adminid"] . ":SaveMe123122sds2")) {
    exit("error:invalid token");
}
if ($DEMOMODE) {
    echo "error: This function not enabled in demo mode .";
    exit;
}
if ($coder && $template && $file) {
    $tpl = mysqli_fetch_assoc(dquery("select tpl from tbl_templates where id='" . $file . "'"));
    if (deregi("css/", $tpl["tpl"])) {
        $content = file_get_contents("../../templates/" . $template . "/" . $tpl["tpl"], FILE_USE_INCLUDE_PATH);
        $time = time();
        $my_file = "../../templates/" . $template . "/" . $tpl["tpl"] . "." . $time;
        $handle = fopen($my_file, "w");
        fwrite($handle, $content);
        $my_file = "../../templates/" . $template . "/" . $tpl["tpl"];
        $handle = fopen($my_file, "w");
        fwrite($handle, html_entity_decode($coder));
    } else {
        $content = file_get_contents("../../templates/" . $template . "/" . $tpl["tpl"] . ".tpl", FILE_USE_INCLUDE_PATH);
        $time = time();
        $my_file = "../../templates/" . $template . "/" . $tpl["tpl"] . "." . $time;
        $handle = fopen($my_file, "w");
        fwrite($handle, $content);
        $my_file = "../../templates/" . $template . "/" . $tpl["tpl"] . ".tpl";
        $handle = fopen($my_file, "w");
        fwrite($handle, html_entity_decode($coder));
    }
    if (deregi("cart/default/", $tpl["tpl"])) {
        $expr = explode("/", $tpl["tpl"]);
        $path = "../../templates/" . $template . "/cart/default/ver/" . end($expr) . ".txt";
        $ndir = "../../templates/" . $template . "/cart/default/ver";
    } else {
        if (deregi("cart/Steps/", $tpl["tpl"])) {
            $expr = explode("/", $tpl["tpl"]);
            $path = "../../templates/" . $template . "/cart/Steps/ver/" . end($expr) . ".txt";
            $ndir = "../../templates/" . $template . "/cart/Steps/ver";
        } else {
            if (deregi("cart/SingalPage/", $tpl["tpl"])) {
                $expr = explode("/", $tpl["tpl"]);
                $path = "../../templates/" . $template . "/cart/SingalPage/ver/" . end($expr) . ".txt";
                $ndir = "../../templates/" . $template . "/cart/SingalPage/ver";
            } else {
                if (deregi("css/", $tpl["tpl"])) {
                    $expr = explode("/", $tpl["tpl"]);
                    $path = "../../templates/" . $template . "/css/ver/" . end($expr) . ".txt";
                    $ndir = "../../templates/" . $template . "/css/ver";
                } else {
                    $path = "../../templates/" . $template . "/ver/" . $tpl["tpl"] . ".txt";
                    $ndir = "../../templates/" . $template . "/ver";
                }
            }
        }
    }
    if (is_file($path)) {
        $log = file_get_contents($path, FILE_USE_INCLUDE_PATH);
        $log = trim($log);
        $loga = unserialize($log);
        $loga[$time] = [$time, $notes, $loga["version"]];
        $updatedlog = serialize($loga);
        file_put_contents($path, $updatedlog);
    } else {
        if (!is_dir($ndir)) {
            mkdir($ndir);
        }
        $loga["version"] = "1.0";
        $loga[$time] = [$time, $notes, $loga["version"]];
        $updatedlog = serialize($loga);
        $myFile = $path;
        $fh = fopen($myFile, "w");
        fwrite($fh, $updatedlog);
        fclose($fh);
    }
    echo "success: " . $LNG["template"] . " edited successfully";
} else {
    echo "error: No changes made by you";
}

?>