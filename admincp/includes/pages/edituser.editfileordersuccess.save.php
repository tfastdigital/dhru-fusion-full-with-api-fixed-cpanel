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
$error = "";
$msg = "";
$fileElementName = $fileId;
if (!empty($_FILES[$fileElementName]["error"])) {
    switch ($_FILES[$fileElementName]["error"]) {
        case "1":
            $error = $msg = "The uploaded file exceeds the upload_max_filesize directive in php.ini";
            break;
        case "2":
            $error = $msg = "The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form";
            break;
        case "3":
            $error = $msg = "The uploaded file was only partially uploaded";
            break;
        case "4":
            $error = $msg = "No file was uploaded.";
            break;
        case "6":
            $error = $msg = "Missing a temporary folder";
            break;
        case "7":
            $error = $msg = "Failed to write file to disk";
            break;
        case "8":
            $error = $msg = "File upload stopped by extension";
            break;
        case "999":
        default:
            $error = $msg = "No error code avaiable";
    }
} else {
    if (empty($_FILES[$fileElementName]["tmp_name"]) || $_FILES[$fileElementName]["tmp_name"] == "none") {
        $error = $msg = "No file was uploaded..";
    } else {
        $filename = explode(".", $_FILES[$fileElementName]["name"]);
        $reply_encs = md5($orderId . $filename[0]) . "." . $filename[1];
        if (move_uploaded_file($_FILES[$fileElementName]["tmp_name"], "../../" . $donloaddirpath . "/" . $reply_encs)) {
            if ($fileId == "fileToreplace") {
                $time = time();
                $date = date("Y-m-d");
                if (dquery("update tbl_order_file set reply = '" . $filename[0] . "." . $filename[1] . "',reply_enc ='" . $reply_encs . "' ,reply_time = '" . $time . "',reply_date = '" . $date . "' where md5(order_id)='" . $orderId . "'")) {
                    $msg .= "<li>" . $LNG["new"] . " " . $LNG["file"] . " " . $LNG["uploaded"] . "</li>";
                } else {
                    $error .= $LNG["file"] . " " . $LNG["not"] . " " . $LNG["save"];
                }
            } else {
                require_once ROOTDIR . "/includes/fileservices.fun.php";
                $status = replySuccessFile($orderId, $filename[0] . "." . $filename[1], $_SESSION["adminid"]);
            }
            if ($status[0]) {
                $msg .= "<li>" . $filename[0] . "." . $filename[1] . " " . $LNG["successfully"] . " " . $LNG["upload"] . "</li>";
            } else {
                if (!$msg) {
                    $msg .= "<li>" . $LNG["low"] . " " . $LNG["creditbalance"] . "</li>";
                }
            }
        } else {
            $error .= $msg = $LNG["file"] . " " . $LNG["not"] . " " . $LNG["upload"];
        }
    }
}
echo "{";
echo "error: '" . $error . "',\n";
echo "msg: '" . $msg . "'\n";
echo "}";

?>