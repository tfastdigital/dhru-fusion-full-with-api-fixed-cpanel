<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

define("DEFINE_MY_ACCESS", true);
define("DEFINE_DHRU_FILE", true);
define("ADMIN", true);
require "../../../comm.php";
require_once "../../includes/fun.inc.php";
if (!checkAdminlogin() || !$_SESSION["adminid"]) {
    echo "<div align=\"center\"><h3>Session expired. <a style=\"color: #666;\" href=\"index.php?main2redirect=true\">Please relogin</a></h3></div>";
    $_SESSION["admin_afterlogin_re"] = $_SERVER["REQUEST_URI"];
    exit;
}
if (isset($_POST["download"]) && $_GET["service"] == "file") {
    require_once "../../../includes/phpzip.class.php";
    $file = date("d-m-Y") . "_" . date("H:i:s");
    $ziper = new zipfile();
    $ziper->addDir("../../../" . $donloaddirpath . "/");
    $filesarr = explode(",", $_POST["data"]);
    foreach ($filesarr as $key => $f) {
        if ($f != "") {
            $filo = explode("-A-", $f);
            list($newf, $f) = $filo;
            $newf = $key . $newf;
            if (file_exists("../../../" . $donloaddirpath . "/" . $f)) {
                $fh = fopen("../../../" . $donloaddirpath . "/" . $f, "r");
                $theData = fread($fh, filesize("../../../" . $donloaddirpath . "/" . $f));
                rename("../../../" . $donloaddirpath . "/" . $f, "../../../" . $donloaddirpath . "/" . $newf);
                $ziper->addFile($theData, "../../../" . $donloaddirpath . "/" . $newf);
                fclose($fh);
            }
        }
    }
    $ziper->output("../../../" . $donloaddirpath . "/" . $file . ".zip");
    foreach ($filesarr as $key => $f) {
        if ($f != "") {
            $filo = explode("-A-", $f);
            list($newf, $f) = $filo;
            $newf = $key . $newf;
            rename("../../../" . $donloaddirpath . "/" . $newf, "../../../" . $donloaddirpath . "/" . $f);
        }
    }
    $fh = fopen("../../../" . $donloaddirpath . "/" . $file . ".zip", "r");
    $theData = fread($fh, filesize("../../../" . $donloaddirpath . "/" . $file . ".zip"));
    $mailarr = [];
    $file = date("d-m-Y") . "_" . date("H:i:s");
    header("Content-type: application/octet-stream");
    header("Content-Disposition: attachment; filename=\"" . $_POST["service"] . "_" . $file . ".zip\"");
    $data = NULL;
    $code1 = NULL;
    $data = $theData;
    echo $data;
    $data = NULL;
} else {
    if ($sampledownload) {
        $id = descape($id);
        $sql = mysqli_fetch_assoc(dquery("select `file`,`filename` from tbl_download where id='" . $id . "'"));
        if (file_exists("../../../" . $donloaddirpath . "/" . $sql["file"])) {
            $fh = fopen("../../../" . $donloaddirpath . "/" . $sql["file"], "r");
            $data = fread($fh, filesize("../../../" . $donloaddirpath . "/" . $sql["file"]));
            fclose($fh);
            header("Content-type: application/octet-stream");
            header("Content-Disposition: attachment; filename=\"" . $sql["filename"] . "\"");
            echo $data;
        } else {
            echo "Error : File Not Found";
        }
    } else {
        if ($downloadreply) {
            $orderid = descape($id);
            $sql = mysqli_fetch_assoc(dquery("select `reply`,`reply_enc` from tbl_order_file where md5(order_id)='" . $orderid . "'"));
            if (file_exists("../../../" . $donloaddirpath . "/" . $sql["reply_enc"])) {
                $fh = fopen("../../../" . $donloaddirpath . "/" . $sql["reply_enc"], "r");
                $data = fread($fh, filesize("../../../" . $donloaddirpath . "/" . $sql["reply_enc"]));
                fclose($fh);
                header("Content-type: application/octet-stream");
                header("Content-Disposition: attachment; filename=\"" . $sql["reply"] . "\"");
                echo $data;
            } else {
                echo "Error : File Not Found";
            }
        } else {
            if ($expocatalog) {
                $query = "SELECT * FROM `tbl_products`";
                $result = dquery($query);
                $buf = "ID,Product,Price,Stock,Group id,Status,Weight,Height,Width,Depth,Availability Date\n";
                while ($row = mysqli_fetch_assoc($result)) {
                    $buf .= $row["id"] . "," . $row["service_name"] . "," . $row["credit"] . "," . $row["stock"] . "," . $row["group_id"] . "," . $row["active"] . "," . $row["weight"] . "," . $row["height"] . "," . $row["width"] . "," . $row["depth"] . "," . $row["availability_date"] . "\n";
                }
                header("Content-type: application/octet-stream");
                header("Content-Disposition: attachment; filename=\"catalog.csv\"");
                echo $buf;
            } else {
                if (isset($_POST["download"])) {
                    $file = date("d-m-Y") . "_" . date("H:i:s");
                    header("Content-type: application/octet-stream");
                    header("Content-Disposition: attachment; filename=\"" . $_POST["service"] . "_" . $file . ".txt\"");
                    $data = NULL;
                    $code1 = NULL;
                    $data = $_POST["data"];
                    echo $data;
                    $data = NULL;
                } else {
                    if (isset($downloads)) {
                        $key = $downloads;
                        require_once "../../../includes/phpzip.class.php";
                        $file = date("d-m-Y") . "_" . date("H:i:s");
                        $ziper = new zipfile();
                        $ziper->addDir("../backup/");
                        $fh = fopen("../backup/" . $key, "r");
                        $theData = fread($fh, filesize("../backup/" . $key));
                        $ziper->addFile($theData, "../backup/" . $key);
                        fclose($fh);
                        $fi = substr($key, 0, strrpos($key, "."));
                        $ziper->output("../backup/" . $fi . ".zip");
                        $fh = fopen("../backup/" . $fi . ".zip", "r");
                        $theData = fread($fh, filesize("../backup/" . $fi . ".zip"));
                        fclose($fh);
                        header("Content-type: application/octet-stream");
                        header("Content-Disposition: attachment; filename=\"" . $fi . ".zip\"");
                        $data = NULL;
                        $code1 = NULL;
                        $data = $theData;
                        echo $data;
                        $data = NULL;
                        unlink("../backup/" . $fi . ".zip");
                    } else {
                        if ($downloadxml) {
                            $buff = "<?xml version='1.0' encoding='utf-8' ?>\n";
                            $buff .= "<feed xmlns='http://www.w3.org/2005/Atom' xmlns:g='http://base.google.com/ns/1.0'>\n";
                            $buff .= "<title>" . $config["companyname"] . "</title>\n";
                            $buff .= "<link rel='self' href='" . $config["site_address"] . "'/>\n";
                            $buff .= "<updated>" . date("Y-m-d") . "T" . date("H:i:s") . "Z</updated>\n\n\n\n";
                            $sql = dquery("select *  from tbl_products");
                            while ($row = mysqli_fetch_assoc($sql)) {
                                $productDetails = $row;
                                $productDetails["seourl"] = "cart/item/product/" . $row["id"] . "/" . md5($row["id"]) . "/" . str_replace(" ", "-", preg_replace("/[^a-zA-Z0-9 ]/", "", $row["service_name"])) . ".html";
                                if ($row["image_link1"] || $row["image_link2"] || $row["image_link3"] || $row["image_link4"] || $row["image_link5"]) {
                                    $_servicedtl["image_link"] = [1 => [$row["image_link1"], $row["default_image"] == 1 ? true : false], 2 => [$row["image_link2"], $row["default_image"] == 2 ? true : false], 3 => [$row["image_link3"], $row["default_image"] == 3 ? true : false], 4 => [$row["image_link4"], $row["default_image"] == 4 ? true : false], 5 => [$row["image_link5"], $row["default_image"] == 5 ? true : false]];
                                }
                                if ($row["default_image"] == 1) {
                                    $imagepath = $row["image_link1"];
                                } else {
                                    if ($row["default_image"] == 2) {
                                        $imagepath = $row["image_link2"];
                                    } else {
                                        if ($row["default_image"] == 3) {
                                            $imagepath = $row["image_link3"];
                                        } else {
                                            if ($row["default_image"] == 4) {
                                                $imagepath = $row["image_link4"];
                                            } else {
                                                if ($row["default_image"] == 5) {
                                                    $imagepath = $row["image_link5"];
                                                }
                                            }
                                        }
                                    }
                                }
                                $productDetails["default_imagepath"] = $imagepath;
                                $buff .= "<entry>\n";
                                $buff .= "<title>" . $productDetails["service_name"] . "</title>\n";
                                $buff .= "<link href='" . $config["site_address"] . "/" . $productDetails["seourl"] . "'/>\n";
                                $buff .= "<summary>" . $productDetails["seo_description"] . "</summary>\n";
                                $buff .= "<g:id>" . $productDetails["id"] . "</g:id>\n";
                                if ($productDetails["product_type"] == 1) {
                                    $types = "New";
                                } else {
                                    $types = "Refurbished";
                                }
                                $manu = mysqli_fetch_assoc(dquery("select name from tbl_manufacture where id='" . $row["manufacture_id"] . "'"));
                                $productDetails["manufacture_name"] = $manu["name"];
                                if ($productDetails["seo_description"]) {
                                    $buff .= "<description>" . $productDetails["seo_description"] . "</description>\n";
                                }
                                $buff .= "<g:condition>" . $types . "</g:condition>\n";
                                $buff .= "<g:price>" . $productDetails["credit"] . " " . $_SESSION["system_default_currency"]["code"] . "</g:price>\n";
                                if ($productDetails["stock"]) {
                                    $buff .= "<g:availability>in stock</g:availability>\n";
                                } else {
                                    $buff .= "<g:availability>out of stock</g:availability>\n";
                                }
                                $buff .= "<g:image_link>" . $config["site_address"] . "/" . $productDetails["default_imagepath"] . "</g:image_link>\n";
                                if ($productDetails["gtin"]) {
                                    $buff .= "<g:gtin>" . $productDetails["gtin"] . "</g:gtin>\n";
                                }
                                if ($productDetails["manufacture_name"]) {
                                    $buff .= "<g:brand>" . $productDetails["manufacture_name"] . "</g:brand>\n";
                                }
                                if ($productDetails["google_product_type"]) {
                                    $buff .= "<g:google_product_category>" . htmlspecialchars($productDetails["google_product_type"]) . "</g:google_product_category>\n";
                                }
                                if ($productDetails["mpn"]) {
                                    $buff .= "<g:mpn>" . $productDetails["mpn"] . "</g:mpn>\n";
                                }
                                $productype = "cart/item/product/" . $row["id"] . "/" . md5($row1["id"]) . "/" . str_replace(" ", "-", preg_replace("/[^a-zA-Z0-9 ]/", "", $row1["service_name"]));
                                $productype = str_replace("/", " > ", $productype);
                                $buff .= "<g:product_type>" . htmlspecialchars($productype) . "</g:product_type>\n";
                                $sh = dquery("select * from tbl_shipping_services where gateway='custom' and status='1'");
                                while ($rs = mysqli_fetch_assoc($sh)) {
                                    $cntr = explode(",", $rs["country"]);
                                    foreach ($cntr as $c) {
                                        $buff .= "\n\n<g:shipping>\n";
                                        $buff .= "<g:country>" . $c . "</g:country>\n";
                                        $buff .= "<g:service>" . $rs["value"] . "</g:service>\n";
                                        $buff .= "<g:price>" . $rs["cost"] . " " . $_SESSION["system_default_currency"]["code"] . "</g:price>\n";
                                        $buff .= "</g:shipping>\n\n";
                                    }
                                }
                                $buff .= "</entry>\n\n";
                            }
                            $buff .= "</feed>";
                            if ($buff) {
                                header("Content-type: application/octet-stream");
                                header("Content-Disposition: attachment; filename=\"base.xml\"");
                                echo $buff;
                            }
                        }
                    }
                }
            }
        }
    }
}
$fileverioncheck = "6.1.0";

?>