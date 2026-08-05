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
require "../../comm.php";
if (!isset($_SESSION["uid"])) {
    echo "error: Something Wrong #99821";
    exit;
}
$error = "";
$msg = "";
$fileElementName = "fileToUpload";
if (!empty($_FILES[$fileElementName]["error"])) {
    switch ($_FILES[$fileElementName]["error"]) {
        case "1":
            $error = "The uploaded file exceeds the upload_max_filesize directive in php.ini";
            break;
        case "2":
            $error = "The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form";
            break;
        case "3":
            $error = "The uploaded file was only partially uploaded";
            break;
        case "4":
            $error = "No file was uploaded.";
            break;
        case "6":
            $error = "Missing a temporary folder";
            break;
        case "7":
            $error = "Failed to write file to disk";
            break;
        case "8":
            $error = "File upload stopped by extension";
            break;
        case "999":
        default:
            $error = "No error code avaiable";
    }
} else {
    if (empty($_FILES["fileToUpload"]["tmp_name"]) || $_FILES["fileToUpload"]["tmp_name"] == "none") {
        $error = "No file was uploaded...";
    } else {
        if ($action == "avtar") {
            require_once ROOTDIR . "/includes/resizeimage.fun.php";
            $SIZE = filesize($_FILES["fileToUpload"]["tmp_name"]);
            list($width, $height, $type, $attr) = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
            if ($type < 4 && 0 < $type && $SIZE <= 102400) {
                if ($type == 1) {
                    $ext = ".gif";
                } else {
                    if ($type == 2) {
                        $ext = ".jpg";
                    } else {
                        if ($type == 3) {
                            $ext = ".png";
                        }
                    }
                }
                $NAME = md5($_SESSION["uid"] . md5($_SESSION["username"])) . $ext;
                if (100 <= $width || 100 <= $height) {
                    $image = new SimpleImage();
                    $image->load($_FILES["fileToUpload"]["tmp_name"]);
                    $image->resize(100, 100);
                    $image->save("../../images/avtar/" . $NAME);
                } else {
                    if (isValidExtension($_FILES["fileToUpload"]["name"])) {
                        move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], "../../images/avtar/" . $NAME);
                    }
                }
                dquery("UPDATE tblUsers SET avtar='" . $NAME . "' WHERE id='" . $_SESSION["uid"] . "'");
                $msg = "Avtar Uploaded successfully";
                $avtar = $NAME;
            } else {
                $error = "Wrong image format. ( Only jpg, png, gif and size max 100 Kb allowed )";
            }
        } else {
            $NAME = $_SESSION["uid"] . "_" . $_FILES["fileToUpload"]["name"];
            $NAME = preg_replace("/[^0-9a-zA-Z-_\\.]/i", "", $NAME);
            $SIZE = filesize($_FILES["fileToUpload"]["tmp_name"]);
            list($width, $height, $type, $attr) = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
            if ($type < 4 && 0 < $type && $SIZE < 512000 && isValidExtension($_FILES["fileToUpload"]["name"])) {
                move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], "../../images/resellerstore/" . $NAME);
                $time = time();
                $data["img"] = "images/resellerstore/" . $NAME;
                $data["store"] = $_SESSION["uid"];
                $db->insert("tbl_bannerslider_banners", $data);
                $msg = "Banner uploaded successfully";
            } else {
                $error = "Wrong banner format";
            }
        }
        unlink($_FILES["fileToUpload"]);
    }
}
echo "{";
echo "error: '" . $error . "',\n";
echo "msg: '" . $msg . "',\n";
echo "avtar: '" . $avtar . "',\n";
echo "}";

?>