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
$data["retail"] = $retail;
$data["retail_credit"] = $retail_credit;
$data["image_link"] = $imagelink;
$data["hot"] = $hot;
$data["image_hotdeal"] = $image_hotdeal;
$data["taxed"] = $taxed;
$data["review"] = $review;
$data["show_onhome"] = $showhomepage;
$data["customhtml"] = $customhtml;
$data["store"] = $store;
$data["resellerdisc"] = $resellerdisc;
list($width, $height, $type, $attr) = getimagesize(ROOTDIR . "/" . $imagelink);
$imageexp = explode("/", $imagelink);
$imageexp = end($imageexp);
$imagepath = str_replace($imageexp, "", $imagelink);
if ($imagepath && (150 < $width || 150 < $height)) {
    $newimage = $imagepath . "/thumb" . $imageexp;
    $w = $height < $width ? 150 : $width * 150 / $height;
    $h = $width < $height ? 150 : $height * 150 / $width;
    ($im = @ImageCreateFromJPEG(ROOTDIR . "/" . $imagelink)) || ($im = @ImageCreateFromPNG(ROOTDIR . "/" . $imagelink)) || ($im = @ImageCreateFromGIF(ROOTDIR . "/" . $imagelink)) || ($im = false);
    if (!$im) {
        readfile(ROOTDIR . "/" . $imagepath1);
    } else {
        $thumb = @ImageCreateTrueColor($w, $h);
        if ($type == 1) {
            imagecolortransparent($thumb, imagecolorallocatealpha($thumb, 0, 0, 0, 127));
            imagealphablending($thumb, false);
            imagesavealpha($thumb, true);
            @ImageCopyResampled($thumb, $im, 0, 0, 0, 0, $w, $h, $width, $height);
            imagegif($thumb, ROOTDIR . "/" . $newimage);
            imagedestroy($thumb);
        } else {
            if ($type == 3) {
                $trans = imagecolorallocate($thumb, 255, 99, 140);
                imagecolortransparent($thumb, $trans);
                imagecopy($thumb, $im, 0, 0, 0, 0, 16, 16);
                imagetruecolortopalette($thumb, true, 256);
                imageinterlace($thumb);
                @ImageCopyResampled($thumb, $im, 0, 0, 0, 0, $w, $h, $width, $height);
                imagepng($thumb, ROOTDIR . "/" . $newimage);
                imagedestroy($thumb);
            } else {
                @ImageCopyResampled($thumb, $im, 0, 0, 0, 0, $w, $h, $width, $height);
                @ImageJPEG($thumb, ROOTDIR . "/" . $newimage);
            }
        }
    }
} else {
    if ($imagelink) {
        copy(ROOTDIR . "/" . $imagelink, ROOTDIR . "/" . $imagepath . "/thumb" . $imageexp);
    }
}
$data["affiliate_comission"] = $affiliate_comission;
if ($db->update("tbl_server_log", $data, "id=" . $id)) {
    echo "success:" . $LNG["datasavesuccessfully"];
} else {
    echo "error:" . $LNG["datanotsave"];
}
echo " ";

?>