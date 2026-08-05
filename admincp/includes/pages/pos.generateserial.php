<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

if (!isset($_SESSION[adminid])) {
    exit;
}
echo "<script>\nfunction printdiv(printpage)\n{\n    var headstr = \"<html><head><title></title></head><body>\";\n    var footstr = \"</body>\";\n    var newstr = document.getElementById(printpage).innerHTML;\n    var oldstr = document.body.innerHTML;\n    document.body.innerHTML = headstr+newstr+footstr;\n    window.print();\n    document.body.innerHTML = oldstr;\n    return false;\n}\n\n</script>";
error_reporting(0);
if ($print && $no) {
    require_once "includes/3rdparty/Barcode.php";
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
    echo "<div align='left'><input type='button' name='print' onclick=printdiv('mainprint') value='Print Barcode' /></div><div style=\"clear: both;\">&nbsp;</div>\n<div id='mainprint' style='width: 750px;'>";
    while ($from <= $to) {
        for ($do = $no; $do; $do--) {
            $c = $from;
            $barcodes = str_replace("\$code", $c, $code);
            $pr = str_replace("\$price", "", $price);
            $bc = new Barcode39($c, (string) $company, $pr, $width, $barcodes, $height);
            $bc->barcode_text_size = $font;
            $bc->barcode_bar_thick = $barcode_bar_thick;
            $bc->barcode_bar_thin = $barcode_bar_thin;
            $bc->draw("tmp/" . $c . "barcode.gif");
            if ($type == 2) {
                echo "<img src='tmp/" . $c . "barcode.gif' /> <br />";
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
                echo "<div style='float:left; margin:8px; min-width:" . $ws . ";' ><img src='tmp/" . $c . "barcode.gif' /></div>";
            }
        }
        $from++;
    }
    echo "</div>";
} else {
    $set = mysqli_fetch_assoc(dquery("select * from tbl_pos_setting"));
    echo "<style>\n.form{margin-bottom: 4px !important;}\n</style>\n<div id=\"notification\"></div>\n<div id=\"content\">\n<div id=\"content_padded\">\n<script>\nfunction showPrv(val){\n    if(val!=''){\n        document.getElementById('prev').style.display='';\n    }else{\n        document.getElementById('prev').style.display='none';\n    }\n     if(val==1){\n            document.getElementById('size').style.display='';\n            document.getElementById('size2').style.display='none';\n     }else if(val==2){\n            document.getElementById('size2').style.display='';\n            document.getElementById('size').style.display='none';\n     }else{\n           document.getElementById('size2').style.display='none';\n            document.getElementById('size').style.display='none';\n     }\n}\nfunction setSizer(val){\n    if(val==1){\n        document.getElementById('bars').src='images/sbarcode.png';\n    }else if(val==2){\n        document.getElementById('bars').src='images/mbarcode.png';\n    }else if(val==3){\n        document.getElementById('bars').src='images/lbarcode.png';\n    }\n}\n\n</script>\n<h1>";
    echo $sql["service_name"];
    echo "</h1>\n<form id=\"frm\" name=\"\" method=\"post\" target=\"_blank\" action=\"includes/pages/printbarcode.php\">\n<input type=\"hidden\" name=\"ids\" value=\"";
    echo $ids;
    echo "\" />\n<input type=\"hidden\" name=\"from\" value=\"";
    echo $from;
    echo "\" />\n<input type=\"hidden\" name=\"to\" value=\"";
    echo $to;
    echo "\" />\n";
    echo generate_token("form");
    echo "<table class=\"form\" border=\"0\" cellpadding=\"3\" cellspacing=\"2\" width=\"100%\">\n<tbody>\n\n<tr>\n    <td  class=\"fieldlabel\" width=\"25%\">";
    echo $LNG["paper"];
    echo " ";
    echo $LNG["type"];
    echo "</td>\n    <td class=\"fieldarea\">\n   <select name=\"type\" onchange=\"showPrv(this.value)\">\n    <option value=\"\">";
    echo $LNG["select"];
    echo "</option>\n    <option value=\"1\" ";
    if ($set["papertype"] == 1) {
        echo "selected";
    }
    echo ">A4 Size</option>\n    <option value=\"2\" ";
    if ($set["papertype"] == 2) {
        echo "selected";
    }
    echo ">Label Print</option>\n   </select>\n    </td>\n</tr>\n<tr>\n    <td  class=\"fieldlabel\" width=\"25%\">";
    echo $LNG["no"];
    echo ". ";
    echo $LNG["of"];
    echo " ";
    echo $LNG["print"];
    echo "</td>\n    <td class=\"fieldarea\"><input type=\"text\" name=\"no\" value=\"1\" style=\"width: 50px;\" /> </td>\n</tr>\n<tr id=\"size\" style=\"display: none;\">\n    <td  class=\"fieldlabel\" width=\"25%\">";
    echo $LNG["size"];
    echo "</td>\n    <td class=\"fieldarea\">\n    <select name=\"size\" onchange=\"setSizer(this.value)\">\n    <option value=\"1\">Small</option>\n    <option value=\"2\">Medium</option>\n    <option value=\"3\">Large</option>\n    </select>\n    </td>\n</tr>\n<tr id=\"size2\" style=\"display: none;\">\n    <td  class=\"fieldlabel\" width=\"25%\">";
    echo $LNG["size"];
    echo "</td>\n    <td class=\"fieldarea\">\n\n  <input type=\"text\" name=\"wd\" style=\"width: 80px;\" placeholder=\"Width\" /> x  <input type=\"text\" name=\"hd\" style=\"width: 80px;\" placeholder=\"Height\" /> <small style=\"display: inline;\">(in px)</small>\n    </td>\n</tr>\n<tr id=\"prev\" style=\"display: none;\">\n<td class=\"fieldlabel\">";
    echo $LNG["preview"];
    echo "</td>\n<td width=\"30%\" style=\"float: left;\">\n<table  width=\"30%\">\n    <tr>\n    <td colspan=\"2\"><input type=\"text\" name=\"company\" value=\"";
    echo $config["companyname"];
    echo "\" /></td>\n    </tr>\n    <tr>\n    <td colspan=\"2\"><img id=\"bars\" src=\"images/sbarcode.png\" /></td>\n    </tr>\n    <tr>\n    <td><input type=\"text\" style=\"width: 100px;\" name=\"code\" value=\"\$code\" /></td>\n    <td>&nbsp;</td>\n    </tr>\n</table>\n</td>\n</tr>\n<tr>\n    <td  class=\"fieldlabel\" width=\"25%\">&nbsp;</td>\n    <td class=\"fieldarea\">\n<input value=\"";
    echo $LNG["print"];
    echo "\" name=\"print\" id=\"btnaddgroup\"\nclass=\"btn\" type=\"submit\"\n/>\n    </td>\n</tr>\n</tbody>\n</table>\n\n</form>\n\n</div></div>\n<script>\nshowPrv('";
    echo $set["papertype"];
    echo "');\n</script>\n";
}
$fileverioncheck = "6.1.0";

?>