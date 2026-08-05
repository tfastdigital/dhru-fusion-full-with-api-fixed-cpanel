<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

defined("DEFINE_MY_ACCESS") or exit("<h1 style=\"color: #C00; text-align: center;\"><strong>Restricted Access</strong></h1>");
session_set_cookie_params(0, "/", NULL, false, true);
class UploadHandler
{
    protected $options = NULL;
    public function __construct($options = NULL)
    {
        $this->options = ["script_url" => $this->getFullUrl() . "/", "upload_dir" => dirname($_SERVER["SCRIPT_FILENAME"]) . "/" . $_SESSION["updirpath"] . "/", "upload_url" => $_SESSION["sitaddrs"] . "/" . str_replace("../../../../../../", "", $_SESSION["updirpath"]) . "/", "param_name" => "files", "delete_type" => "DELETE", "max_file_size" => NULL, "min_file_size" => 1, "accept_file_types" => $_SESSION["uploadtypes"], "max_number_of_files" => NULL, "discard_aborted_uploads" => true, "orient_image" => false, "image_versions" => []];
        if ($options) {
            $this->options = array_replace_recursive($this->options, $options);
        }
    }
    protected function getFullUrl()
    {
        return (isset($_SERVER["HTTPS"]) ? "https://" : "http://") . (isset($_SERVER["REMOTE_USER"]) ? $_SERVER["REMOTE_USER"] . "@" : "") . (isset($_SERVER["HTTP_HOST"]) ? $_SERVER["HTTP_HOST"] : $_SERVER["SERVER_NAME"] . (isset($_SERVER["HTTPS"]) && $_SERVER["SERVER_PORT"] === 443 || $_SERVER["SERVER_PORT"] === 80 ? "" : ":" . $_SERVER["SERVER_PORT"])) . substr($_SERVER["SCRIPT_NAME"], 0, strrpos($_SERVER["SCRIPT_NAME"], "/"));
    }
    protected function set_file_delete_url($file)
    {
        $file->delete_url = $this->options["script_url"] . "?file=" . rawurlencode($file->name);
        $file->delete_type = $this->options["delete_type"];
        if ($file->delete_type !== "DELETE") {
            $file->delete_url .= "&_method=DELETE";
        }
    }
    protected function get_file_object($file_name)
    {
        $file_path = $this->options["upload_dir"] . $file_name;
        if (is_file($file_path) && $file_name[0] !== ".") {
            $file = new stdClass();
            $file->name = $file_name;
            $file->size = filesize($file_path);
            list($width, $height, $type, $attr) = getimagesize($file_path);
            $file->width = $width;
            $file->height = $height;
            $file->url = $this->options["upload_url"] . rawurlencode($file->name);
            foreach ($this->options["image_versions"] as $version => $options) {
                if (is_file($options["upload_dir"] . $file_name)) {
                    $file->{$version . "_url"} = $options["upload_url"] . rawurlencode($file->name);
                }
            }
            $this->set_file_delete_url($file);
            return $file;
        } else {
            return NULL;
        }
    }
    protected function get_file_objects()
    {
        return array_values(array_filter(array_map([$this, "get_file_object"], scandir($this->options["upload_dir"]))));
    }
    protected function create_scaled_image($file_name, $options)
    {
        if (!function_exists('imagecreatetruecolor')) return false;
        $file_path = $this->options["upload_dir"] . $file_name;
        $new_file_path = $options["upload_dir"] . $file_name;
        list($img_width, $img_height) = @getimagesize($file_path);
        if (!$img_width || !$img_height) {
            return false;
        }
        $scale = min($options["max_width"] / $img_width, $options["max_height"] / $img_height);
        if (1 <= $scale) {
            if ($file_path !== $new_file_path) {
                return copy($file_path, $new_file_path);
            }
            return true;
        }
        $new_width = $img_width * $scale;
        $new_height = $img_height * $scale;
        $new_img = @imagecreatetruecolor($new_width, $new_height);
        strtolower(substr(strrchr($file_name, "."), 1));
        switch (strtolower(substr(strrchr($file_name, "."), 1))) {
            case "jpg":
            case "jpeg":
                if (!function_exists('imagecreatefromjpeg')) return false;
                $src_img = @imagecreatefromjpeg($file_path);
                $write_image = "imagejpeg";
                $image_quality = isset($options["jpeg_quality"]) ? $options["jpeg_quality"] : 75;
                break;
            case "gif":
                if (!function_exists('imagecreatefromgif')) return false;
                @imagecolortransparent($new_img, @imagecolorallocate($new_img, 0, 0, 0));
                $src_img = @imagecreatefromgif($file_path);
                $write_image = "imagegif";
                $image_quality = NULL;
                break;
            case "png":
                if (!function_exists('imagecreatefrompng')) return false;
                @imagecolortransparent($new_img, @imagecolorallocate($new_img, 0, 0, 0));
                @imagealphablending($new_img, false);
                @imagesavealpha($new_img, true);
                $src_img = @imagecreatefrompng($file_path);
                $write_image = "imagepng";
                $image_quality = isset($options["png_quality"]) ? $options["png_quality"] : 9;
                break;
            default:
                $src_img = NULL;
                if ($src_img && function_exists($write_image)) {
                     $success = @imagecopyresampled($new_img, $src_img, 0, 0, 0, 0, $new_width, $new_height, $img_width, $img_height) && $write_image($new_img, $new_file_path, $image_quality);
                } else {
                     $success = false;
                }
                @imagedestroy($src_img);
                @imagedestroy($new_img);
                return $success;
        }
        // Handle default case flow
        if ($src_img && function_exists($write_image)) {
             $success = @imagecopyresampled($new_img, $src_img, 0, 0, 0, 0, $new_width, $new_height, $img_width, $img_height) && $write_image($new_img, $new_file_path, $image_quality);
        } else {
             $success = false;
        }
        @imagedestroy($src_img);
        @imagedestroy($new_img);
        return $success;
    }
    protected function has_error($uploaded_file, $file, $error)
    {
        if ($error) {
            return $error;
        }
        if (!preg_match($this->options["accept_file_types"], $file->name)) {
            return "acceptFileTypes";
        }
        if ($uploaded_file && is_uploaded_file($uploaded_file)) {
            $file_size = filesize($uploaded_file);
        } else {
            $file_size = $_SERVER["CONTENT_LENGTH"];
        }
        if ($this->options["max_file_size"] && ($this->options["max_file_size"] < $file_size || $this->options["max_file_size"] < $file->size)) {
            return "maxFileSize";
        }
        if ($this->options["min_file_size"] && $file_size < $this->options["min_file_size"]) {
            return "minFileSize";
        }
        if (is_int($this->options["max_number_of_files"]) && $this->options["max_number_of_files"] <= count($this->get_file_objects())) {
            return "maxNumberOfFiles";
        }
        return $error;
    }
    protected function upcount_name_callback($matches)
    {
        $index = isset($matches[1]) ? intval($matches[1]) + 1 : 1;
        $ext = isset($matches[2]) ? $matches[2] : "";
        return " (" . $index . ")" . $ext;
    }
    protected function upcount_name($name)
    {
        return preg_replace_callback("/(?:(?: \\(([\\d]+)\\))?(\\.[^.]+))?\$/", [$this, "upcount_name_callback"], $name, 1);
    }
    protected function trim_file_name($name, $type)
    {
        $file_name = trim(basename(stripslashes($name)), ".\0.. ");
        if (strpos($file_name, ".") === false && preg_match("/^image\\/(gif|jpe?g|png)/", $type, $matches)) {
            $file_name .= "." . $matches[1];
        }
        if ($this->options["discard_aborted_uploads"]) {
            while (is_file($this->options["upload_dir"] . $file_name)) {
                $file_name = $this->upcount_name($file_name);
            }
        }
        return $file_name;
    }
    protected function orient_image($file_path)
    {
        if (!function_exists('exif_read_data')) return false;
        $exif = @exif_read_data($file_path);
        if ($exif === false) {
            return false;
        }
        $orientation = intval($exif["Orientation"]);
        if (!in_array($orientation, [3, 6, 8])) {
            return false;
        }
        if (!function_exists('imagecreatefromjpeg')) return false;
        $image = @imagecreatefromjpeg($file_path);
        switch ($orientation) {
            case 3:
                $image = @imagerotate($image, 180, 0);
                break;
            case 6:
                $image = @imagerotate($image, 270, 0);
                break;
            case 8:
                $image = @imagerotate($image, 90, 0);
                $success = imagejpeg($image, $file_path);
                @imagedestroy($image);
                return $success;
                break;
            default:
                return false;
        }
    }
    protected function handle_file_upload($uploaded_file, $name, $size, $type, $error)
    {
        $file = new stdClass();
        $file->name = $this->trim_file_name($name, $type);
        $file->size = intval($size);
        $file->type = $type;
        list($width, $height, $type, $attr) = getimagesize($uploaded_file);
        $file->width = $width;
        if (5 < $type || !$type) {
        }
        $file->height = $height;
        $error = $this->has_error($uploaded_file, $file, $error);
        if (!$error && $file->name) {
            $file_path = $this->options["upload_dir"] . $file->name;
            $append_file = !$this->options["discard_aborted_uploads"] && is_file($file_path) && filesize($file_path) < $file->size;
            clearstatcache();
            if ($uploaded_file && is_uploaded_file($uploaded_file)) {
                if ($append_file) {
                    file_put_contents($file_path, fopen($uploaded_file, "r"), FILE_APPEND);
                } else {
                    move_uploaded_file($uploaded_file, $file_path);
                    setRESIZED($file_path);
                }
            } else {
                file_put_contents($file_path, fopen("php://input", "r"), $append_file ? FILE_APPEND : 0);
            }
            $file_size = filesize($file_path);
            if (true) {
                if ($this->options["orient_image"]) {
                    $this->orient_image($file_path);
                }
                $file->url = $this->options["upload_url"] . rawurlencode($file->name);
                foreach ($this->options["image_versions"] as $version => $options) {
                    if ($this->create_scaled_image($file->name, $options)) {
                        if ($this->options["upload_dir"] !== $options["upload_dir"]) {
                            $file->{$version . "_url"} = $options["upload_url"] . rawurlencode($file->name);
                        } else {
                            clearstatcache();
                            $file_size = filesize($file_path);
                        }
                    }
                }
            } else {
                if ($this->options["discard_aborted_uploads"]) {
                    unlink($file_path);
                    $file->error = "abort";
                }
            }
            $file->size = $file_size;
            $this->set_file_delete_url($file);
        } else {
            $file->error = $error;
        }
        return $file;
    }
    public function get()
    {
        $file_name = isset($_REQUEST["file"]) ? basename(stripslashes($_REQUEST["file"])) : NULL;
        if ($file_name) {
            $info = $this->get_file_object($file_name);
        } else {
            $info = $this->get_file_objects();
        }
        header("Content-type: application/json");
        echo json_encode($info);
    }
    public function post()
    {
        if (isset($_REQUEST["_method"]) && $_REQUEST["_method"] === "DELETE") {
            return $this->delete();
        }
        $upload = isset($_FILES[$this->options["param_name"]]) ? $_FILES[$this->options["param_name"]] : NULL;
        $info = [];
        $su = 0;
        foreach ($upload as $k => $v) {
            $cont = file_get_contents($upload["tmp_name"][$su]);
            $contensts = explode("?php", $cont);
            if (1 < count($contensts)) {
                exit;
            }
            $su++;
        }
        if ($upload && is_array($upload["tmp_name"])) {
            foreach ($upload["tmp_name"] as $index => $value) {
                $info[] = $this->handle_file_upload($upload["tmp_name"][$index], isset($_SERVER["HTTP_X_FILE_NAME"]) ? $_SERVER["HTTP_X_FILE_NAME"] : $upload["name"][$index], isset($_SERVER["HTTP_X_FILE_SIZE"]) ? $_SERVER["HTTP_X_FILE_SIZE"] : $upload["size"][$index], isset($_SERVER["HTTP_X_FILE_TYPE"]) ? $_SERVER["HTTP_X_FILE_TYPE"] : $upload["type"][$index], $upload["error"][$index]);
            }
        } else {
            if ($upload || isset($_SERVER["HTTP_X_FILE_NAME"])) {
                $info[] = $this->handle_file_upload(isset($upload["tmp_name"]) ? $upload["tmp_name"] : NULL, isset($_SERVER["HTTP_X_FILE_NAME"]) ? $_SERVER["HTTP_X_FILE_NAME"] : (isset($upload["name"]) ? $upload["name"] : NULL), isset($_SERVER["HTTP_X_FILE_SIZE"]) ? $_SERVER["HTTP_X_FILE_SIZE"] : (isset($upload["size"]) ? $upload["size"] : NULL), isset($_SERVER["HTTP_X_FILE_TYPE"]) ? $_SERVER["HTTP_X_FILE_TYPE"] : (isset($upload["type"]) ? $upload["type"] : NULL), isset($upload["error"]) ? $upload["error"] : NULL);
            }
        }
        header("Vary: Accept");
        $json = json_encode($info);
        if (isset($_SERVER["HTTP_ACCEPT"]) && strpos($_SERVER["HTTP_ACCEPT"], "application/json") !== false) {
            header("Content-type: application/json");
        } else {
            header("Content-type: text/plain");
        }
        echo $json;
    }
    public function delete()
    {
        $file_name = isset($_REQUEST["file"]) ? basename(stripslashes($_REQUEST["file"])) : NULL;
        $file_path = $this->options["upload_dir"] . $file_name;
        $success = is_file($file_path) && $file_name[0] !== "." && unlink($file_path);
        if ($success) {
            foreach ($this->options["image_versions"] as $version => $options) {
                $file = $options["upload_dir"] . $file_name;
                if (is_file($file)) {
                    unlink($file);
                }
            }
        }
        header("Content-type: application/json");
        echo json_encode($success);
    }
}
function setRESIZED($file_path)
{
    $sizes = $_SESSION["sizeupload"];
    if ($sizes != "default") {
        $exp = explode("X", $sizes);
        list($rwidth, $rheight) = $exp;
        list($width, $height, $type, $attr) = getimagesize($file_path);
        $w = $height < $width ? $rwidth : $width * $rwidth / $height;
        $h = $width < $height ? $rheight : $height * $rheight / $width;
        ($im = @ImageCreateFromJPEG($file_path)) || ($im = @ImageCreateFromPNG($file_path)) || ($im = @ImageCreateFromGIF($file_path)) || ($im = false);
        if (!$im) {
            readfile($file_path);
        } else {
            $thumb = @ImageCreateTrueColor($w, $h);
            imagecolortransparent($thumb, imagecolorallocatealpha($thumb, 0, 0, 0, 127));
            imagealphablending($thumb, false);
            imagesavealpha($thumb, true);
            @ImageCopyResampled($thumb, $im, 0, 0, 0, 0, $w, $h, $width, $height);
            if ($type == 1) {
                imagegif($thumb, $file_path);
            } else {
                if ($type == 3) {
                    imagepng($thumb, $file_path);
                } else {
                    @ImageJPEG($thumb, $file_path);
                }
            }
            imagedestroy($thumb);
        }
    }
    if ($_SESSION["watermark"]) {
        $disp_width_max = 150;
        $disp_height_max = 80;
        $edgePadding = 15;
        $quality = 100;
        $default_watermark = dirname($_SERVER["SCRIPT_FILENAME"]) . "/../../../../../../images/gallery/watermarks/" . $_SESSION["watermark"];
        $ext = substr(strrchr($file_path, "."), 1);
        if ($ext == "jpg") {
            if (!isset($_POST["save_as"])) {
                $_POST["save_as"] = "jpeg";
            }
            if (!isset($_POST["v_position"])) {
                $_POST["v_position"] = "center";
            }
            if (!isset($_POST["h_position"])) {
                $_POST["h_position"] = "center";
            }
            if (!isset($_POST["wm_size"])) {
                $_POST["wm_size"] = "1";
            }
            if (!isset($_POST["watermark"])) {
                $_POST[""] = $default_watermark;
            }
            $size = getimagesize($file_path);
            if ($size[2] == 2 || $size[2] == 3) {
                $original = $file_path;
                $target = $file_path;
                $watermark = $default_watermark;
                $wmTarget = $watermark . ".tmp";
                $origInfo = getimagesize($original);
                list($origWidth, $origHeight) = $origInfo;
                $waterMarkInfo = getimagesize($watermark);
                list($waterMarkWidth, $waterMarkHeight) = $waterMarkInfo;
                if ($_POST["wm_size"] == "larger") {
                    $placementX = 0;
                    $placementY = 0;
                    $_POST["h_position"] = "center";
                    $_POST["v_position"] = "center";
                    $waterMarkDestWidth = $waterMarkWidth;
                    $waterMarkDestHeight = $waterMarkHeight;
                    if ($origWidth * 0 < $waterMarkWidth && $origHeight * 0 < $waterMarkHeight) {
                        $wdiff = $waterMarkDestWidth - $origWidth;
                        $hdiff = $waterMarkDestHeight - $origHeight;
                        if ($hdiff < $wdiff) {
                            $sizer = $wdiff / $waterMarkDestWidth - 0;
                        } else {
                            $sizer = $hdiff / $waterMarkDestHeight - 0;
                        }
                        $waterMarkDestWidth -= $waterMarkDestWidth * $sizer;
                        $waterMarkDestHeight -= $waterMarkDestHeight * $sizer;
                    } else {
                        $wdiff = $origWidth - $waterMarkDestWidth;
                        $hdiff = $origHeight - $waterMarkDestHeight;
                        if ($hdiff < $wdiff) {
                            $sizer = $wdiff / $waterMarkDestWidth + 0;
                        } else {
                            $sizer = $hdiff / $waterMarkDestHeight + 0;
                        }
                        $waterMarkDestWidth += $waterMarkDestWidth * $sizer;
                        $waterMarkDestHeight += $waterMarkDestHeight * $sizer;
                    }
                } else {
                    $waterMarkDestWidth = round($origWidth * floatval($_POST["wm_size"]));
                    $waterMarkDestHeight = round($origHeight * floatval($_POST["wm_size"]));
                    if ($_POST["wm_size"] == 1) {
                        $waterMarkDestWidth -= 2 * $edgePadding;
                        $waterMarkDestHeight -= 2 * $edgePadding;
                    }
                }
                resize_png_image($watermark, $waterMarkDestWidth, $waterMarkDestHeight, $wmTarget);
                $wmInfo = getimagesize($wmTarget);
                list($waterMarkDestWidth, $waterMarkDestHeight) = $wmInfo;
                $differenceX = $origWidth - $waterMarkDestWidth;
                $differenceY = $origHeight - $waterMarkDestHeight;
                switch ($_POST["h_position"]) {
                    case "left":
                        $placementX = $edgePadding;
                        break;
                    case "center":
                        $placementX = round($differenceX / 2);
                        break;
                    case "right":
                        $placementX = $origWidth - $waterMarkDestWidth - $edgePadding;
                        break;
                    default:
                        switch ($_POST["v_position"]) {
                            case "top":
                                $placementY = $edgePadding;
                                break;
                            case "center":
                                $placementY = round($differenceY / 2);
                                break;
                            case "bottom":
                                $placementY = $origHeight - $waterMarkDestHeight - $edgePadding;
                                break;
                            default:
                                if ($size[2] == 3) {
                                    $resultImage = imagecreatefrompng($original);
                                } else {
                                    $resultImage = imagecreatefromjpeg($original);
                                }
                                imagealphablending($resultImage, true);
                                $finalWaterMarkImage = imagecreatefrompng($wmTarget);
                                $finalWaterMarkWidth = imagesx($finalWaterMarkImage);
                                $finalWaterMarkHeight = imagesy($finalWaterMarkImage);
                                imagecopy($resultImage, $finalWaterMarkImage, $placementX, $placementY, 0, 0, $finalWaterMarkWidth, $finalWaterMarkHeight);
                                if ($size[2] == 3) {
                                    imagealphablending($resultImage, false);
                                    imagesavealpha($resultImage, true);
                                    imagepng($resultImage, $target, $quality);
                                } else {
                                    imagejpeg($resultImage, $target, $quality);
                                }
                                imagedestroy($resultImage);
                                imagedestroy($finalWaterMarkImage);
                                unlink($wmTarget);
                        }
                }
            }
        } else {
            if ($ext == "png") {
                if (!isset($_POST["save_as"])) {
                    $_POST["save_as"] = "png";
                }
                if (!isset($_POST["v_position"])) {
                    $_POST["v_position"] = "center";
                }
                if (!isset($_POST["h_position"])) {
                    $_POST["h_position"] = "center";
                }
                if (!isset($_POST["wm_size"])) {
                    $_POST["wm_size"] = "1";
                }
                if (!isset($_POST["watermark"])) {
                    $_POST[""] = $default_watermark;
                }
                $size = getimagesize($file_path);
                $original = $file_path;
                $target = $file_path;
                $watermark = $default_watermark;
                $wmTarget = $watermark . ".tmp";
                $origInfo = getimagesize($original);
                list($origWidth, $origHeight) = $origInfo;
                $waterMarkInfo = getimagesize($watermark);
                list($waterMarkWidth, $waterMarkHeight) = $waterMarkInfo;
                if ($_POST["wm_size"] == "larger") {
                    $placementX = 0;
                    $placementY = 0;
                    $_POST["h_position"] = "center";
                    $_POST["v_position"] = "center";
                    $waterMarkDestWidth = $waterMarkWidth;
                    $waterMarkDestHeight = $waterMarkHeight;
                    if ($origWidth * 0 < $waterMarkWidth && $origHeight * 0 < $waterMarkHeight) {
                        $wdiff = $waterMarkDestWidth - $origWidth;
                        $hdiff = $waterMarkDestHeight - $origHeight;
                        if ($hdiff < $wdiff) {
                            $sizer = $wdiff / $waterMarkDestWidth - 0;
                        } else {
                            $sizer = $hdiff / $waterMarkDestHeight - 0;
                        }
                        $waterMarkDestWidth -= $waterMarkDestWidth * $sizer;
                        $waterMarkDestHeight -= $waterMarkDestHeight * $sizer;
                    } else {
                        $wdiff = $origWidth - $waterMarkDestWidth;
                        $hdiff = $origHeight - $waterMarkDestHeight;
                        if ($hdiff < $wdiff) {
                            $sizer = $wdiff / $waterMarkDestWidth + 0;
                        } else {
                            $sizer = $hdiff / $waterMarkDestHeight + 0;
                        }
                        $waterMarkDestWidth += $waterMarkDestWidth * $sizer;
                        $waterMarkDestHeight += $waterMarkDestHeight * $sizer;
                    }
                } else {
                    $waterMarkDestWidth = round($origWidth * floatval($_POST["wm_size"]));
                    $waterMarkDestHeight = round($origHeight * floatval($_POST["wm_size"]));
                    if ($_POST["wm_size"] == 1) {
                        $waterMarkDestWidth -= 2 * $edgePadding;
                        $waterMarkDestHeight -= 2 * $edgePadding;
                    }
                }
                resize_png_image($watermark, $waterMarkDestWidth, $waterMarkDestHeight, $wmTarget);
                $wmInfo = getimagesize($wmTarget);
                list($waterMarkDestWidth, $waterMarkDestHeight) = $wmInfo;
                $differenceX = $origWidth - $waterMarkDestWidth;
                $differenceY = $origHeight - $waterMarkDestHeight;
                switch ($_POST["h_position"]) {
                    case "left":
                        $placementX = $edgePadding;
                        break;
                    case "center":
                        $placementX = round($differenceX / 2);
                        break;
                    case "right":
                        $placementX = $origWidth - $waterMarkDestWidth - $edgePadding;
                        break;
                    default:
                        switch ($_POST["v_position"]) {
                            case "top":
                                $placementY = $edgePadding;
                                break;
                            case "center":
                                $placementY = round($differenceY / 2);
                                break;
                            case "bottom":
                                $placementY = $origHeight - $waterMarkDestHeight - $edgePadding;
                                break;
                            default:
                                $resultImage = imagecreatefrompng($original);
                                $finalWaterMarkImage = imagecreatefrompng($wmTarget);
                                $finalWaterMarkWidth = imagesx($finalWaterMarkImage);
                                $finalWaterMarkHeight = imagesy($finalWaterMarkImage);
                                imagecopy($resultImage, $finalWaterMarkImage, $placementX, $placementY, 0, 0, $finalWaterMarkWidth, $finalWaterMarkHeight);
                                imagealphablending($resultImage, false);
                                imagesavealpha($resultImage, true);
                                imagepng($resultImage, $target, $quality);
                                imagedestroy($resultImage);
                                imagedestroy($finalWaterMarkImage);
                                unlink($wmTarget);
                        }
                }
            }
        }
    }
}
function resize_png_image($img, $newWidth, $newHeight, $target)
{
    $srcImage = imagecreatefrompng($img);
    if ($srcImage == "") {
        return false;
    }
    $srcWidth = imagesx($srcImage);
    $srcHeight = imagesy($srcImage);
    $percentage = (double) $newWidth / $srcWidth;
    $destHeight = round($srcHeight * $percentage) + 1;
    $destWidth = round($srcWidth * $percentage) + 1;
    if ($newHeight < $destHeight) {
        $percentage = (double) $newHeight / $srcHeight;
        $destHeight = round($srcHeight * $percentage) + 1;
        $destWidth = round($srcWidth * $percentage) + 1;
    }
    $destImage = imagecreatetruecolor($destWidth - 1, $destHeight - 1);
    if (!imagealphablending($destImage, false)) {
        return false;
    }
    if (!imagesavealpha($destImage, true)) {
        return false;
    }
    if (!imagecopyresampled($destImage, $srcImage, 0, 0, 0, 0, $destWidth, $destHeight, $srcWidth, $srcHeight)) {
        return false;
    }
    if (!imagepng($destImage, $target)) {
        return false;
    }
    imagedestroy($destImage);
    imagedestroy($srcImage);
    return true;
}

?>