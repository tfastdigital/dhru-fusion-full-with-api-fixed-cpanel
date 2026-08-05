<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

define("DEFINE_MY_ACCESS", true);
define("ADMIN", true);
define("DEFINE_DHRU_FILE", true);
require "../../../comm.php";
require ROOTDIR . "/includes/fun.inc.php";
echo "<html>\n<head>\n<script>\nfunction printdiv(printpage)\n{\n    var headstr = \"<html><head><title></title></head><body>\";\n    var footstr = \"</body>\";\n    var newstr = document.getElementById(printpage).innerHTML;\n    var oldstr = document.body.innerHTML;\n    document.body.innerHTML = headstr+newstr+footstr;\n    window.print(); \n    document.body.innerHTML = oldstr;\n    return false;\n}\n\n</script>\n<style>\n    .br{width:50%;height:2.0cm;margin:0;float:left;border:#ccc solid 0px}\n</style>\n</head>\n<body style=\"text-align: center;\">\n<div align=\"center\">\n";
if ($print && $no) {
    require_once "../3rdparty/Barcode.php";
    $ids = explode("-", $ids);
    if ($size == 2) {
        $width = 100;
        $height = 65;
        $font = 3;
        $barcode_bar_thick = 3;
        $barcode_bar_thin = 2;
    } else {
        if ($size == 3) {
            $width = 160;
            $height = 90;
            $font = 4;
            $barcode_bar_thick = 5;
            $barcode_bar_thin = 2;
        } else {
            $width = 50;
            $height = 55;
            $font = 2;
            $barcode_bar_thick = 2;
            $barcode_bar_thin = 1;
        }
    }
    if ($type == 2) {
        $width = $wd;
        $height = $hd;
        $font = 3;
        $barcode_bar_thick = ceil($width / 90);
        $barcode_bar_thin = ceil($width / 220);
    }
    echo "<div><input type='button' name='print' onclick=printdiv('mainprint') value='Print Barcode' /></div><div style=\"clear: both;\">&nbsp;</div>\n<div id='mainprint' style='width: 10.8cm;'>";
    if ($from && $to) {
        while ($from <= $to) {
            for ($do = $no; $do; $do--) {
                $c = $from;
                $barcodes = str_replace("\$code", $c, $code);
                $pr = str_replace("\$price", "", $price);
                $bc = new Barcode39($c, (string) $company, $pr, $width, $barcodes, $height);
                $bc->barcode_text_size = $font;
                $bc->barcode_bar_thick = $barcode_bar_thick;
                $bc->barcode_bar_thin = $barcode_bar_thin;
                $bc->draw("../../tmp/" . $c . "barcode.gif");
                if ($type == 2) {
                    echo "<div class='br'><img src='../../tmp/" . $c . "barcode.gif?" . time() . "' /></div>";
                } else {
                    if ($width == 50) {
                        $ws = $width + 35 . "px";
                    } else {
                        if ($width == 100) {
                            $ws = $width + 55 . "px";
                        } else {
                            $ws = $width + 35 . "px";
                        }
                    }
                    echo "<div style='float:left; margin:8px; min-width:" . $ws . ";' ><img src='../../tmp/" . $c . "barcode.gif'  /></div>";
                }
            }
            $from++;
        }
    } else {
        foreach ($ids as $i) {
            for ($do = $no; $do; $do--) {
                $sql = mysqli_fetch_assoc(dquery("select credit from tbl_products where id='" . $i . "'"));
                $c = ($i + 497) * 2;
                $barcodes = str_replace("\$code", $c, $code);
                $p = mysqli_fetch_assoc(dquery("select code from tbl_currencies \n        where code='" . $config["base_currency"] . "'"));
                $pr = str_replace("\$price", $sql["credit"] . " " . $p["code"], $price);
                $bc = new Barcode39($c, (string) $company, $pr, $width, $barcodes, $height);
                $bc->barcode_text_size = $font;
                $bc->barcode_bar_thick = $barcode_bar_thick;
                $bc->barcode_bar_thin = $barcode_bar_thin;
                $bc->draw("../../tmp/" . $c . "barcode.gif");
                if ($type == 2) {
                    echo "<div class='br'><img src='../../tmp/" . $c . "barcode.gif'  /></div> ";
                } else {
                    if ($width == 50) {
                        $ws = $width + 35 . "px";
                    } else {
                        if ($width == 100) {
                            $ws = $width + 55 . "px";
                        } else {
                            $ws = $width + 35 . "px";
                        }
                    }
                    echo "<div style='float:left; margin:8px; min-width:" . $ws . ";' ><img src='../../tmp/" . $c . "barcode.gif?" . time() . "' /></div>";
                }
            }
        }
    }
    echo "</div>";
} else {
    echo "    <script>\n    window.close();\n    </script>\n    ";
}
echo "</div>\n</body>\n</html>";
$fileverioncheck = "6.1.0";

?>