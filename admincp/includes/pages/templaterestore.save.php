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
if ($action == "restoreoriginal") {
    if ($template && $file) {
        $tlog = file("../../templates/tlog.txt");
        foreach ($tlog as $tl) {
            $te = explode("=", $tl);
            if (trim($te[1]) == $template) {
                $original = trim($te[0]);
                $tpl = mysqli_fetch_assoc(dquery("select tpl from tbl_templates where id='" . $file . "'"));
                if (deregi("css/", $tpl["tpl"])) {
                    $arg = end(explode("/", $tpl["tpl"]));
                } else {
                    $arg = $tpl["tpl"];
                }
                if (deregi("css/", $tpl["tpl"])) {
                    $content = file_get_contents("../../templates/" . $original . "/" . $tpl["tpl"], FILE_USE_INCLUDE_PATH);
                } else {
                    $content = file_get_contents("../../templates/" . $original . "/" . $tpl["tpl"] . ".tpl", FILE_USE_INCLUDE_PATH);
                }
                if (deregi("cart/default", $tpl["tpl"])) {
                    $path = "../../templates/" . $original . "/cart/default/ver/";
                } else {
                    if (deregi("cart/SingalPage", $tpl["tpl"])) {
                        $path = "../../templates/" . $original . "/cart/SingalPage/ver/";
                    } else {
                        if (deregi("cart/Steps", $tpl["tpl"])) {
                            $path = "../../templates/" . $original . "/cart/Steps/ver/";
                        } else {
                            if (deregi("css/", $tpl["tpl"])) {
                                $path = "../../templates/" . $original . "/css/ver/";
                            } else {
                                $path = "../../templates/" . $original . "/ver/";
                            }
                        }
                    }
                }
                if (is_file($path . $arg . ".txt")) {
                    $ogiv = file_get_contents($path . "/" . $arg . ".txt", FILE_USE_INCLUDE_PATH);
                    $ogiv = trim($ogiv);
                    $ogiv = unserialize($ogiv);
                }
            }
        }
        $tpl = mysqli_fetch_assoc(dquery("select tpl from tbl_templates where id='" . $file . "'"));
        if (deregi("css/", $tpl["tpl"])) {
            $content2 = file_get_contents("../../templates/" . $template . "/" . $tpl["tpl"], FILE_USE_INCLUDE_PATH);
        } else {
            $content2 = file_get_contents("../../templates/" . $template . "/" . $tpl["tpl"] . ".tpl", FILE_USE_INCLUDE_PATH);
        }
        if (deregi("css/", $tpl["tpl"])) {
            $my_file = "../../templates/" . $template . "/" . $tpl["tpl"];
        } else {
            $my_file = "../../templates/" . $template . "/" . $tpl["tpl"] . ".tpl";
        }
        $handle = fopen($my_file, "w");
        fwrite($handle, html_entity_decode($content));
        $my_file = "../../templates/" . $template . "/" . $tpl["tpl"] . "." . time();
        $handle = fopen($my_file, "w");
        fwrite($handle, $content2);
        $path = str_replace($original, $template, $path);
        if (is_file($path . $arg . ".txt")) {
            $log = file_get_contents($path . $arg . ".txt", FILE_USE_INCLUDE_PATH);
            $log = trim($log);
            $loga = unserialize($log);
            $loga["version"] = $ogiv["version"];
            $loga[$time] = [$time, "Restored from original", $loga["version"]];
            $updatedlog = serialize($loga);
            file_put_contents($path . $arg . ".txt", $updatedlog);
        } else {
            if (!is_dir($path)) {
                mkdir($path);
            }
            $loga["version"] = $ogiv["version"];
            $loga[$time] = [$time, "Restored from original", $loga["version"]];
            $updatedlog = serialize($loga);
            $myFile = $path . $arg . ".txt";
            $fh = fopen($myFile, "w");
            fwrite($fh, $updatedlog);
            fclose($fh);
        }
        echo "success: " . $LNG["template"] . " restored successfully";
    }
} else {
    if ($version && $template && $file && $content) {
        $tpl = mysqli_fetch_assoc(dquery("select tpl from tbl_templates where id='" . $file . "'"));
        if (deregi("css/", $tpl["tpl"])) {
            $content2 = file_get_contents("../../templates/" . $template . "/" . $tpl["tpl"], FILE_USE_INCLUDE_PATH);
            $my_file = "../../templates/" . $template . "/" . $tpl["tpl"];
            $handle = fopen($my_file, "w");
            fwrite($handle, html_entity_decode($content));
        } else {
            $content2 = file_get_contents("../../templates/" . $template . "/" . $tpl["tpl"] . ".tpl", FILE_USE_INCLUDE_PATH);
            $my_file = "../../templates/" . $template . "/" . $tpl["tpl"] . ".tpl";
            $handle = fopen($my_file, "w");
            fwrite($handle, html_entity_decode($content));
        }
        $time = time();
        $my_file = "../../templates/" . $template . "/" . $tpl["tpl"] . "." . $time;
        $handle = fopen($my_file, "w");
        fwrite($handle, $content2);
        if (deregi("cart/default", $tpl["tpl"])) {
            $arg = end(explode("/", $tpl["tpl"]));
            $path = "../../templates/" . $template . "/cart/default/ver/";
        } else {
            if (deregi("cart/SingalPage", $tpl["tpl"])) {
                $arg = end(explode("/", $tpl["tpl"]));
                $path = "../../templates/" . $template . "/cart/SingalPage/ver/";
            } else {
                if (deregi("cart/Steps", $tpl["tpl"])) {
                    $arg = end(explode("/", $tpl["tpl"]));
                    $path = "../../templates/" . $template . "/cart/Steps/ver/";
                } else {
                    if (deregi("css/", $tpl["tpl"])) {
                        $arg = end(explode("/", $tpl["tpl"]));
                        $path = "../../templates/" . $template . "/css/ver/";
                    } else {
                        $arg = $tpl["tpl"];
                        $path = "../../templates/" . $template . "/ver/";
                    }
                }
            }
        }
        if (is_file($path . $arg . ".txt")) {
            $ogi = file_get_contents($path . $arg . ".txt", FILE_USE_INCLUDE_PATH);
            $ogi = trim($ogi);
            $ogi = unserialize($ogi);
            $ogi["version"] = $ogi[$version];
            $ogi[$time] = [$time, "Restored from original", $loga["version"]];
            $updatedlog = serialize($ogi);
            file_put_contents($path . $arg . ".txt", $updatedlog);
        }
        unlink("../../templates/" . $template . "/" . $tpl["tpl"] . "." . $version);
        echo "success: " . $LNG["template"] . " restored successfully";
    }
}

?>