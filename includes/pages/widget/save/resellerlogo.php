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
require "./comm.php";
if (!isset($_SESSION["uid"])) {
    echo "error: Something Wrong #99821";
    exit;
}
$error = "";
$msg = "";
$fileElementName = "fileToUpload1";
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
    if (empty($_FILES["fileToUpload1"]["tmp_name"]) || $_FILES["fileToUpload1"]["tmp_name"] == "none") {
        $error = "No file was uploaded..";
    } else {
        require_once ROOTDIR . "/includes/resizeimage.fun.php";
        require_once ROOTDIR . "/includes/fun.inc.php";
        $NAME = $_SESSION["uid"] . "_" . $_FILES["fileToUpload1"]["name"];
        $NAME = preg_replace("/[^0-9a-zA-Z-_\\.]/i", "", $NAME);
        $SIZE = filesize($_FILES["fileToUpload1"]["tmp_name"]);
        list($width, $height, $type, $attr) = getimagesize($_FILES["fileToUpload1"]["tmp_name"]);
        if ($type < 4 && 0 < $type) {
            if (50 <= $height) {
                $image = new SimpleImage();
                $image->load($_FILES["fileToUpload1"]["tmp_name"]);
                $image->resizeToHeight(50);
                $image->save("../../images/resellerstore/" . $NAME);
            } else {
                if (isValidExtension($_FILES["fileToUpload1"]["name"])) {
                    move_uploaded_file($_FILES["fileToUpload1"]["tmp_name"], "../../images/resellerstore/" . $NAME);
                }
            }
            $store["logo_link"] = "images/resellerstore/" . $NAME;
            if ($error = saveStoreConfig($_SESSION["uid"], $store)) {
                $error = (string) $error;
            } else {
                $msg = "Logo uploaded successfully";
                $img = "images/resellerstore/" . $NAME;
            }
        } else {
            $error = "Wrong Logo format";
        }
        unlink($_FILES["fileToUpload1"]);
    }
}
echo "{";
echo "error: '" . $error . "',\n";
echo "msg: '" . $msg . "',\n";
echo "img: '" . $img . "',\n";
echo "avtar: '" . $avtar . "',\n";
echo "}";

?>