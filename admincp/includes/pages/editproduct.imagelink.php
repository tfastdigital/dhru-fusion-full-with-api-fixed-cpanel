<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

include_once ROOTDIR . "/includes/products.fun.php";
if (!$_SESSION["adminid"]) {
    exit("error:invalid token");
}
if ($imglin) {
    checkDemoMode(false);
    $data["image_link1"] = $imagelink1;
    $data["image_link2"] = $imagelink2;
    $data["image_link3"] = $imagelink3;
    $data["image_link4"] = $imagelink4;
    $data["image_link5"] = $imagelink5;
    $data["image_hotdeal"] = $image_hotdeal;
    $data["default_image"] = $default_image;
    if ($default_image == 1) {
        $imagepath1 = $imagelink1;
    } else {
        if ($default_image == 2) {
            $imagepath1 = $imagelink2;
        } else {
            if ($default_image == 3) {
                $imagepath1 = $imagelink3;
            } else {
                if ($default_image == 4) {
                    $imagepath1 = $imagelink4;
                } else {
                    if ($default_image == 5) {
                        $imagepath1 = $imagelink5;
                    }
                }
            }
        }
    }
    if (is_file(ROOTDIR . "/" . $imagepath1)) {
        list($width, $height, $type, $attr) = getimagesize(ROOTDIR . "/" . $imagepath1);
        $imageexp = explode("/", $imagepath1);
        $imageexp = end($imageexp);
        $imagepath = str_replace($imageexp, "", $imagepath1);
        if ($imagepath && (150 < $width || 150 < $height)) {
            $newimage = "/images/gallery/thumb" . $imageexp;
            $w = $height < $width ? 150 : $width * 150 / $height;
            $h = $width < $height ? 150 : $height * 150 / $width;
            ($im = @ImageCreateFromJPEG(ROOTDIR . "/" . $imagepath1)) || ($im = @ImageCreateFromPNG(ROOTDIR . "/" . $imagepath1)) || ($im = @ImageCreateFromGIF(ROOTDIR . "/" . $imagepath1)) || ($im = false);
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
                        imagecolortransparent($thumb, imagecolorallocatealpha($thumb, 0, 0, 0, 127));
                        imagealphablending($thumb, false);
                        imagesavealpha($thumb, true);
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
            copy(ROOTDIR . "/" . $imagepath1, ROOTDIR . "/images/gallery/thumb" . $imageexp);
        }
    }
    if ($db->update("tbl_products", $data, "id=" . $id)) {
        echo "<div id='notification1' class='successbox'>" . $LNG["datasavesuccessfully"] . "</div>";
    } else {
        echo "<div id='notification1' class='errorbox'>" . $LNG["datanotsave"] . "</div>";
    }
}
echo "  \n<script language=\"JavaScript\"> \nfunction newWindow(file,window)\n {msgWindow=open(file,window,'scrollbars=yes,resizable=no,width=550,height=400');\n    if (msgWindow.opener == null) msgWindow.opener = self;\n } \n</script>\n";
$group = getProductGroup();
$md5id = md5($id);
if (isset($save) && $images) {
    foreach ($images as $i) {
        if ($i) {
            $buf = $buf . "|" . $i;
        }
    }
    $buf = trim($buf, "|");
    dquery("UPDATE tbl_products SET images='" . $buf . "' WHERE id='" . $id . "'");
    echo "<div id='notification' class='successbox'>" . $LNG["datasavesuccessfully"] . "</div>";
}
if (isset($savev) && $videos) {
    foreach ($videos as $i) {
        if ($i) {
            $buf = $buf . "|" . $i;
        }
    }
    $buf = trim($buf, "|");
    dquery("UPDATE tbl_products SET videos='" . $buf . "' WHERE id='" . $id . "'");
    echo "<div id='notification' class='successbox'>" . $LNG["datasavesuccessfully"] . "</div>";
}
$prod = mysqli_fetch_assoc(dquery("select `images`,`videos` from tbl_products where id='" . $id . "'"));
$productDetails = getProducts("", $md5id);
echo " \n<div id=\"notification\"></div>\n<div id=\"content\">\n<div id=\"content_padded\">\n<form id=\"frmi\" name=\"\" method=\"post\">\n<input type=\"hidden\" value=\"";
echo $id;
echo "\" name=\"id\"/>\n\n";
echo generate_token("form");
echo "\n<table class=\"form\" border=\"0\" cellpadding=\"3\" cellspacing=\"2\" width=\"100%\">\n<tbody>\n \n<tr> \n    <td class=\"fieldlabel\">";
echo $LNG["image"];
echo " ";
echo $LNG["link"];
echo "1</td> \n   <td class=\"fieldarea\"><input type=\"text\"  class=\"txt large\" value=\"";
echo $productDetails["image_link1"];
echo "\" name=\"imagelink1\" id=\"imagelink1\" /> <input value=\"";
echo $LNG["add"];
echo " ";
echo $LNG["from"];
echo " ";
echo $LNG["gallery"];
echo "\" type=\"button\" class=\"addFromgallery\" name=\"add\" onclick=\"newWindow('includes/gallery.php?id=imagelink1', 'windowname1')\"/> &nbsp;&nbsp;&nbsp; <input type=\"radio\" name=\"default_image\" value=\"1\" id=\"default1\" checked=\"checked\"/> <label for=\"default1\">";
echo $LNG["default"];
echo "</label></td> \n</tr>\n\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["image"];
echo " ";
echo $LNG["link"];
echo "2</td> \n   <td class=\"fieldarea\"><input type=\"text\"  class=\"txt large\" value=\"";
echo $productDetails["image_link2"];
echo "\" name=\"imagelink2\" id=\"imagelink2\" /> <input value=\"";
echo $LNG["add"];
echo " ";
echo $LNG["from"];
echo " ";
echo $LNG["gallery"];
echo "\" type=\"button\" class=\"addFromgallery\" name=\"add\" onclick=\"newWindow('includes/gallery.php?id=imagelink2', 'windowname1')\"/> &nbsp;&nbsp;&nbsp; <input type=\"radio\" name=\"default_image\" value=\"2\" id=\"default2\" ";
if ($productDetails["default_image"] == "2") {
    echo "checked=checked";
}
echo "/> <label for=\"default2\">";
echo $LNG["default"];
echo "</label></td> \n</tr>\n\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["image"];
echo " ";
echo $LNG["link"];
echo "3</td> \n   <td class=\"fieldarea\"><input type=\"text\"  class=\"txt large\" value=\"";
echo $productDetails["image_link3"];
echo "\" name=\"imagelink3\" id=\"imagelink3\" /> <input value=\"";
echo $LNG["add"];
echo " ";
echo $LNG["from"];
echo " ";
echo $LNG["gallery"];
echo "\" type=\"button\" name=\"add\" class=\"addFromgallery\" onclick=\"newWindow('includes/gallery.php?id=imagelink3', 'windowname1')\"/> &nbsp;&nbsp;&nbsp; <input type=\"radio\" name=\"default_image\" value=\"3\" id=\"default3\" ";
if ($productDetails["default_image"] == "3") {
    echo "checked=checked";
}
echo "/> <label for=\"default3\">";
echo $LNG["default"];
echo "</label></td> \n</tr>\n\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["image"];
echo " ";
echo $LNG["link"];
echo "4</td> \n   <td class=\"fieldarea\"><input type=\"text\"  class=\"txt large\" value=\"";
echo $productDetails["image_link4"];
echo "\" name=\"imagelink4\" id=\"imagelink4\" /> <input value=\"";
echo $LNG["add"];
echo " ";
echo $LNG["from"];
echo " ";
echo $LNG["gallery"];
echo "\" type=\"button\" class=\"addFromgallery\" name=\"add\" onclick=\"newWindow('includes/gallery.php?id=imagelink4', 'windowname1')\"/> &nbsp;&nbsp;&nbsp; <input type=\"radio\" name=\"default_image\" value=\"4\" id=\"default4\" ";
if ($productDetails["default_image"] == "4") {
    echo "checked=checked";
}
echo "/> <label for=\"default4\">";
echo $LNG["default"];
echo "</label></td> \n</tr>\n\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["image"];
echo " ";
echo $LNG["link"];
echo "5</td>  \n   <td class=\"fieldarea\"><input type=\"text\"  class=\"txt large\" value=\"";
echo $productDetails["image_link5"];
echo "\" name=\"imagelink5\" id=\"imagelink5\" /> <input value=\"";
echo $LNG["add"];
echo " ";
echo $LNG["from"];
echo " ";
echo $LNG["gallery"];
echo "\" type=\"button\" class=\"addFromgallery\" name=\"add\" onclick=\"newWindow('includes/gallery.php?id=imagelink5', 'windowname1')\"/> &nbsp;&nbsp;&nbsp; <input type=\"radio\" name=\"default_image\" value=\"5\" id=\"default5\" ";
if ($productDetails["default_image"] == "5") {
    echo "checked=checked";
}
echo "/> <label for=\"default5\">";
echo $LNG["default"];
echo "</label></td> \n</tr>\n\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["image"];
echo " For ";
echo $LNG["hotdeals"];
echo "</td>  \n   <td class=\"fieldarea\"><input type=\"text\"  class=\"txt large\" value=\"";
echo $productDetails["image_hotdeal"];
echo "\" name=\"image_hotdeal\" id=\"image_hotdeal\" /> <input value=\"";
echo $LNG["add"];
echo " ";
echo $LNG["from"];
echo " ";
echo $LNG["gallery"];
echo "\" type=\"button\" name=\"add\" class=\"addFromgallery\" onclick=\"newWindow('includes/gallery.php?id=image_hotdeal', 'windowname1')\"/> <small>Max 685px width of Hot deals banner for default template</small> </td>  \n</tr>\n\n<tr>\n    <td class=\"fieldlabel\"></td>  \n   <td class=\"fieldarea\"><input value=\"";
echo $LNG["save"];
echo "\" id=\"btnoverview\" name=\"imglin\" class=\"btn save\" type=\"submit\" /></td> \n</tr>\n</tbody>\n</table>\n</form>\n<hr />\n\n<form id=\"frm\" name=\"\" method=\"post\">\n<input type=\"hidden\" name=\"defaultloadpage\" value=\"editproduct.imagelink.php\" />\n<input type=\"hidden\" value=\"";
echo $id;
echo "\" name=\"id\"/>\n<input type=\"hidden\" name=\"imgcnt\" id=\"imgcnt\" value=\"";
if (count(explode("|", $prod["images"]))) {
    echo count(explode("|", $prod["images"]));
} else {
    echo "1";
}
echo "\" />\n\n<table  class=\"form\" border=\"0\" cellpadding=\"3\" cellspacing=\"2\" width=\"100%\" id=\"imgadd\">\n";
$imgs = explode("|", $prod["images"]);
if ($prod["images"]) {
    $cnt = count($imgs);
} else {
    $cnt = 0;
}
for ($i = 1; $i <= $cnt; $i++) {
    echo "<tbody id='d" . $i . "'><tr><td class='fieldlabel'>Image " . $i . "</td><td class='fieldarea'><input type='text' class='txt large' name='images[" . $i . "]' id='images" . $i . "' value='" . $imgs[$i - 1] . "' />&nbsp;&nbsp;&nbsp;<input type='button' class='addFromgallery' value='Add' onclick='newWindow(\"includes/gallery.php?id=images" . $i . "\",\"windowname1\")' />  &nbsp;&nbsp;&nbsp;&nbsp; <input type='button' class='button_remove' name='remove' value='Remove' onclick='removes(\"" . $i . "\");' /></td></tr></tbody>";
}
if ($cnt == 0) {
    echo "<tbody id='d1'><tr><td class='fieldlabel'>Image 1</td><td class='fieldarea'><input type='text' name='images[1]' id='images1' value='' />&nbsp;&nbsp;&nbsp;<input type='button' class='addFromgallery' value='Add' onclick='newWindow(\"includes/gallery.php?id=images1\",\"windowname1\")' />&nbsp;&nbsp;&nbsp;&nbsp;<input type='button' class='button_remove'  name='remove' value='Remove' onclick='removes(\"1\");' /></td></tr></tbody>";
}
echo "<tfoot>\n<tr>\n<td></td><td class=\"fieldarea\"><a onclick=\"moreimage()\">Add More Images</a></td>\n</tr>\n<tr>\n<td></td><td  class=\"fieldarea\"> <input type=\"submit\" name=\"save\" value=\"Save\" class=\"btn save\" /></td>\n</tr>\n</tfoot>\n</table>\n\n\n</form>\n\n<form id=\"frm\" name=\"\" method=\"post\">\n<input type=\"hidden\" name=\"defaultloadpage\" value=\"editproduct.imagelink.php\" />\n<input type=\"hidden\" value=\"";
echo $id;
echo "\" name=\"id\"/>\n<input type=\"hidden\" name=\"videocnt\" id=\"videocnt\" value=\"";
if ($prod["videos"]) {
    echo count(explode("|", $prod["videos"]));
} else {
    echo "1";
}
echo "\" />\n<table class=\"form\" border=\"0\" cellpadding=\"3\" cellspacing=\"2\" width=\"100%\">\n\n<tr>\n   <td >Videos ( YouTube Code Only e.g. \"JVaSMMHOBYI\" )&nbsp;&nbsp;&nbsp;</td> \n   <td class=\"fieldarea\"></td> \n</tr>\n\n</table>\n<table  class=\"form\" border=\"0\" cellpadding=\"3\" cellspacing=\"2\" width=\"100%\" id=\"videoadd\">\n";
$imgs = explode("|", $prod["videos"]);
if ($prod["videos"]) {
    $cnt = count($imgs);
} else {
    $cnt = 0;
}
for ($i = 1; $i <= $cnt; $i++) {
    echo "<tbody id='t" . $i . "'><tr><td class='fieldlabel'>Video " . $i . "</td><td class='fieldarea'><input type='text' name='videos[" . $i . "]' id='videos" . $i . "' value='" . $imgs[$i - 1] . "' /> &nbsp;&nbsp;&nbsp;&nbsp; <input type='button' class='button_remove' name='remove' value='Remove' onclick='vremoves(\"" . $i . "\");' /></td></tr></tbody>";
}
if ($cnt == 0) {
    echo "<tbody id='t1'><tr><td class='fieldlabel'>Video 1</td><td class='fieldarea'><input type='text' name='videos[1]' id='videos1' value='' /> &nbsp;&nbsp;&nbsp;&nbsp; <input type='button' name='remove' class='button_remove' value='Remove' onclick='vremoves(\"1\");' /></td></tr></tbody>";
}
echo "<tfoot>\n\n<tr><td></td><td class=\"fieldarea\">\n<a  onclick=\"morevideo()\" >Add More Videos</a></td></tr>\n<tr><td class=\"fieldlabel\"></td><td class=\"fieldarea\"><input type=\"submit\" name=\"savev\" value=\"Save\" class=\"btn save\" /></td></tr>\n</tfoot>\n</table>\n</form>\n<div id=\"test\">\n</div>\n</div></div>\n<script language=\"JavaScript\">\nfunction moreimage(){\n   var r=document.getElementById(\"imgcnt\").value;\n   document.getElementById(\"imgcnt\").value=Number(r)+1;\n   r=Number(r)+1;\n   var buf=document.getElementById('imgadd').innerHTML;\n   \n   try{\n   document.getElementById('imgadd').innerHTML=buf+\"<tbody id='d\"+r+\"'><tr><td class='fieldlabel'>Image \"+r+\"</td><td class='fieldarea'><input type='text' name='images[\"+r+\"]' id='images\"+r+\"' />&nbsp;&nbsp;&nbsp;<input type='button' value='Add' onclick='newWindow(\\\"includes/gallery.php?id=images\"+r+\"\\\",\\\"windowname1\\\")' />&nbsp;&nbsp;&nbsp;&nbsp;<input type='button' class='button_remove' name='remove' value='Remove' onclick='removes(\\\"\"+r+\"\\\");' /></td></tr></tbody>\";\n   }catch(e){\n\t  \n\t   var table= document.getElementById('imgadd');\n\t   var tbody=document.createElement(\"tbody\");\n\t   tbody.setAttribute(\"id\",\"d\"+r);  \n       var row = document.createElement(\"tr\");\n       var td1 = document.createElement(\"td\");\n       td1.setAttribute(\"class\",\"fieldlabel\");  \n       td1.appendChild(document.createTextNode(\"Image \"+r));\n       var td2 = document.createElement(\"td\")\n       td2.setAttribute(\"class\",\"fieldlabel\"); \n       \n       var inp=document.createElement(\"input\");\n       inp.setAttribute(\"type\",\"text\");\n       inp.setAttribute(\"name\",\"images[\"+r+\"]\");\n       inp.setAttribute(\"id\",\"images\"+r);\n       \n       var inp2=document.createElement(\"input\");\n       inp2.setAttribute(\"type\",\"button\");\n       inp2.setAttribute(\"value\",\"Add\");\n       inp2.setAttribute(\"onclick\",'newWindow(\\\"includes/gallery.php?id=images'+r+'\\\",\\\"windowname1\\\")');\n\n       var inp3=document.createElement(\"input\");\n       inp3.setAttribute(\"type\",\"button\");\n       inp3.setAttribute(\"name\",\"remove\");\n       inp3.setAttribute(\"value\",\"Remove\");\n       inp3.setAttribute(\"onclick\",'removes(\\\"'+r+'\\\")');\n              \n       td2.appendChild (inp);\n       td2.appendChild (inp2);\n       td2.appendChild (inp3);\n       \n       row.appendChild(td1);\n       row.appendChild(td2);\n       tbody.appendChild(row);\t   \n       table.appendChild(tbody);\n   }\n  \n}\nfunction morevideo(){\n   var r=document.getElementById(\"videocnt\").value;\n   document.getElementById(\"videocnt\").value=Number(r)+1;\n   r=Number(r)+1;\n   var buf=document.getElementById('videoadd').innerHTML;\n   try{\n   document.getElementById('videoadd').innerHTML=buf+\n   \"<tbody id='t\"+r+\"'><tr><td class='fieldlabel'>Video \"+r+\"</td><td class='fieldarea'><input type='text' name='videos[\"+r+\"]' id='videos\"+r+\"' />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type='button' name='remove' class='button_remove' value='Remove' onclick='vremoves(\\\"\"+r+\"\\\");' /></td></tr></tbody>\";\n   }catch(e){\n\t   var table= document.getElementById('videoadd');\n\t   var tbody=document.createElement(\"tbody\");\n\t   tbody.setAttribute(\"id\",\"t\"+r);  \n       var row = document.createElement(\"tr\");\n       var td1 = document.createElement(\"td\");\n       td1.setAttribute(\"class\",\"fieldlabel\");  \n       td1.appendChild(document.createTextNode(\"Video \"+r));\n       var td2 = document.createElement(\"td\")\n       td2.setAttribute(\"class\",\"fieldlabel\"); \n       \n       var inp=document.createElement(\"input\");\n       inp.setAttribute(\"type\",\"text\");\n       inp.setAttribute(\"name\",\"videos[\"+r+\"]\");\n       inp.setAttribute(\"id\",\"videos\"+r);\n       \n      \n\n       var inp3=document.createElement(\"input\");\n       inp3.setAttribute(\"type\",\"button\");\n       inp3.setAttribute(\"name\",\"remove\");\n       inp3.setAttribute(\"value\",\"Remove\");\n       inp3.setAttribute(\"onclick\",'vremoves(\\\"'+r+'\\\")');\n              \n       td2.appendChild (inp);\n       td2.appendChild (inp3);\n       \n       row.appendChild(td1);\n       row.appendChild(td2);\n       tbody.appendChild(row);\t   \n       table.appendChild(tbody);\n   }\n}\nfunction vremoves(ids){\n   var buf=document.getElementById(\"t\"+ids).innerHTML;\n   try{\n   \tdocument.getElementById('videoadd').innerHTML=document.getElementById('videoadd').innerHTML.replace(buf,\"\");\n   }catch(e){\n\t   var table= document.getElementById('videoadd');\n\t   table.removeChild(document.getElementById(\"t\"+ids));   } \n}\nfunction removes(ids){\n   var buf=document.getElementById(\"d\"+ids).innerHTML;\n   try{\n   \tdocument.getElementById('imgadd').innerHTML=document.getElementById('imgadd').innerHTML.replace(buf,\"\");\n   }catch(e){\n\t   var table= document.getElementById('imgadd');\n\t   table.removeChild(document.getElementById(\"d\"+ids));\n   } \n}\nfunction rimage(){ \n   var r=document.getElementById(\"imgcnt\").value;\n   document.getElementById(\"imgcnt\").value=Number(r)-1;\n   var buf=document.getElementById(\"d\"+r).innerHTML;\n   document.getElementById('imgadd').innerHTML=document.getElementById('imgadd').innerHTML.replace(buf,\"\"); \n }\n</script>\n ";
$fileverioncheck = "6.1.0";

?>