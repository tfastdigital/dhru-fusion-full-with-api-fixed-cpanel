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
require "../../comm.php";
require "../../includes/fun.inc.php";
require "fun.inc.php";
if (!checkAdminlogin() || !$_SESSION["adminid"]) {
    echo "<div align=\"center\"><h3>Session expired. <a style=\"color: #666;\" href=\"index.php?main2redirect=true\">Please relogin</a></h3></div>";
    $_SESSION["admin_afterlogin_re"] = $_SERVER["REQUEST_URI"];
    exit;
}
if ($id) {
    $_SESSION["obid"] = $id;
} else {
    $id = $_SESSION["obid"];
}
if (isset($tab)) {
    $_SESSION["tabd"] = $tab;
} else {
    if (!$_SESSION["tabd"]) {
        $_SESSION["tabd"] = "gallery";
    }
}
if (!isset($_SESSION["gallary"])) {
    $_SESSION["gallary"] = "/";
}
echo " \n<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">\n<html xmlns=\"http://www.w3.org/1999/xhtml\"> \n<head>\n<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />\n<title>GSMBACKBASE</title>\n<style>\nbody {\n    margin: 0 !important;\n}\nli a {\n    color: white !important;\n}\n.paging td {\n    color: silver !important;\n}\n.paging a {\n    color: gray !important;\n    text-decoration: none;\n}\n.paging .selected {\n    border: 1px solid #CCCCCC !important;\n    color: black;\n    margin: 2px;\n    padding: 2px 4px;\n}\n.paging .pager {\n    background: none repeat scroll 0 0 #F4F4F4;\n    border: 1px solid #CCCCCC !important;\n    margin: 3px;\n    padding: 1px 5px !important;\n}\n#tabmenu {\n    border-radius: 0 0 0 0 !important;\n    background: #222 !important;\n    height:50px;\n    line-height:30px;\n    box-shadow:none !important;\n    border: none !important;\n    \n}\n#tabmenu li {\n    color: #666666;\n    float: left;\n    font-size: 13px;\n    list-style: none outside none;\n    margin: 0 !important;\n    padding: 0 !important;\n    text-decoration: none;\n}\n#tabmenu li a {\n    color: #CCCCCC;\n    display: block;\n    padding:0 15px !important;\n    text-decoration: none;\n    height:50px;\n    line-height:50px;\n}\n#tabmenu li a:hover {\n    color: black !important;    \n}\na.tabmenu_active {\n    background: none repeat scroll 0 0 white;\n    border: none !important;\n    color: #222222 !important;\n    cursor: default !important;\n}\n.block {\n    background: none repeat scroll 0 0 #FAFAFA;\n    border: 1px solid #F4F4F4;\n    float: left;\n    margin: 5px;\n    padding: 5px;\n    position: relative;\n}\n.block_img {\n    background-position: center center;\n    background-repeat: no-repeat;\n    height: 150px;\n    width: 150px;\n}\n.block .block_text {\n    background: url(\"../images/block_bg.png\") repeat scroll 0 0 transparent;\n    color: white;\n    display: none;\n    left: 0;\n    position: absolute;\n    top: 0;\n}\n.block:hover .block_text {\n    display: block;\n    height: 150px;\n    padding: 5px;\n    width: 150px;\n}\n</style>\n<link rel=\"stylesheet\" href=\"css/main2.css\" />\n<script src=\"js/jquery.js\" type=\"text/javascript\"></script>\n<script src=\"js/main2.fun.js\" type=\"text/javascript\"></script>\n<script src=\"js/jquery.fileupload.extend.js\" type=\"text/javascript\"></script>\n\n</head>\n<body style=\"position:  absolute;left:0;right:0;top:0px;bottom:0px\"> \n<form action=\"\" method=\"post\">\n\n<div>\n\n<div id=\"main_loader\" style=\"display: none;\">\n<div  id=\"main_loader_sub\">\n    <table summary=\"Loader Layout\" width=\"100%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">\n    <tbody><tr>\n    <td><p style=\"font:Arial, Helvetica, sans-serif; font-size:12px;\"><img src=\"images/ajax_loading.gif\" alt=\"clocks\" width=\"32\" height=\"32\" /><strong>Loading...</strong> <br /> Please wait until this completely loaded.</p></td>\n    </tr>\n    </tbody>\n    </table>\n</div>\n</div>\n<ul style=\"padding-right: 20px !important;\" id=\"tabmenu\"> \n    <li><a  href=\"gallerymn.php?id=";
echo $id;
echo "&dir=";
echo $dir;
echo "&tab=gallery\">";
echo $LNG["images"];
echo "</a></li> \n    <li><a ";
if ($_SESSION["tabd"] == "thumb") {
    echo "class='tabmenu_active'";
}
echo "  href=\"thumb.php?id=";
echo $id;
echo "&dir=";
echo $dir;
echo "&tab=thumb\">Thumb</a></li>\n    <li><a ";
if ($_SESSION["tabd"] == "upload") {
    echo "class='tabmenu_active'";
}
echo "  href=\"gallery.upload2.php?id=";
echo $id;
echo "&dir=";
echo $dir;
echo "&tab=upload\" >";
echo $LNG["upload"];
echo " ";
echo $LNG["file"];
echo "</a></li>             \n    <li style=\"float: right !important;\"><a ";
if ($_SESSION["tabd"] == "folder") {
    echo "class='tabmenu_active'";
}
echo " href=\"gallery.folder.php?id=";
echo $id;
echo "&dir=";
echo $dir;
echo "&tab=folder\" >";
echo $LNG["folder"];
echo " ";
echo $LNG["option"];
echo "</a></li>\n    <div style=\"margin-top:8px;float:right\"><input type=\"text\" name=\"search_image\"/><input type=\"submit\" value=\"";
echo $LNG["search"];
echo "\" style=\"border: none;\" name=\"search\"/></div>\n    <div style=\"clear: both;\"></div>\n</ul>\n \n<form action=\"\" method=\"post\">\n<div style=\"padding:0 10px\">\n    <span>You are here: \n        ";
if ($_SESSION["gallary"] == "/" || $_SESSION["gallary"] == "") {
    echo "gallery/";
} else {
    echo str_replace("../../", "", $_SESSION["gallary"]);
}
echo "    </span>\n</div>\n</form>\n<div style=\"clear: both;\"></div>\n<script> \nfunction sendtoopener(val)   \n{ \n    val=val.replace('//','/');\n    val=val.replace('//','/');\n    val=val.replace('images/gallery/../../','');\n    parent.opener.document.getElementById('";
echo $id;
echo "').value=val; \n    parent.self.close();   \n}\nfunction setImages(myValue){\n    \n  var myField = parent.opener.tinyMCE.get('message').getDoc();\n\n  \n    myValue=\"<img src='\"+myValue+\"' />\";\n\n    if(parent.opener.tinyMCE!=undefined){\n       \n        var ed = parent.opener.tinyMCE.get('message');             \n        var range = ed.selection.getRng();                  \n        var newNode = ed.getDoc().createElement(\"span\"); \n        newNode.innerHTML =myValue;\n         try{\n            range.insertNode(newNode);\n        }catch(e){ \n            range.pasteHTML (myValue);\n        }   \n    }else{\n       \n        if (parent.opener.document.selection) {\n            myField.focus();\n            sel = parent.opener.document.selection.createRange();\n            sel.text = myValue;\n        }\n        else if (myField.selectionStart || myField.selectionStart == 0) {\n            var startPos = myField.selectionStart;\n            var endPos = myField.selectionEnd;\n            myField.value = myField.value.substring(0, startPos) + myValue + myField.value.substring(endPos,myField.value.length);\n        }else{\n            myField.value += myValue;\n        }\n    }\n  \n    parent.self.close();\n}\n</script>\n<div style=\"padding:0 10px\">  \n<form method=\"post\">      \n";
if (isset($delete) && is_file(base64_decode($delete))) {
    unlink(base64_decode($delete));
    echo "<div id=notification1 class=successbox> Removed Successfully </div>";
}
if ($moveto && $del) {
    foreach ($del as $d) {
        $files = base64_decode($d);
        $name = explode("/", $files);
        $c = count($name);
        $f = $name[$c - 1];
        rename(base64_decode($d), $movedir . "/" . $f);
    }
}
if ($deletes && !isset($delete) && $del) {
    foreach ($del as $d) {
        unlink(base64_decode($d));
    }
    echo "<div id=notification1 class=successbox> Removed Successfully </div>";
}
$myDirectory = opendir("../../images/gallery/" . $_SESSION["gallary"]);
if ($search_image) {
    while ($entryName = readdir($myDirectory)) {
        if (false !== strpos($entryName, $search_image) && $entryName != ".." && $entryName != "." && $entryName != "tmpImages" && ($out = strpos($entryName, "humb") == 1 && $entryName != "background" && is_file("../../images/gallery/" . $_SESSION["gallary"] . "/" . $entryName))) {
            list($width, $height) = getimagesize("../../images/gallery/" . $_SESSION["gallary"] . "/" . $entryName);
            $size = filesize("../../images/gallery/" . $_SESSION["gallary"] . "/" . $entryName);
            if (1048576 <= $size) {
                $size = round($size / 1048576) . " mb";
            } else {
                if (1024 <= $size) {
                    $size = round($size / 1024) . " kb";
                } else {
                    $size = $size . " byts";
                }
            }
            echo "   <div class=\"block\" title=\"";
            echo $entryName;
            echo "\">\n        <div class=\"block_img\" style=\"background: url('../../images/gallery/";
            echo $_SESSION["gallary"];
            echo "/";
            echo $entryName;
            echo "') center no-repeat;\"></div><br />         \n<div class=\"block_text\" align=\"center\">\n<div align=\"center\">";
            echo $entryName;
            echo "</div>\n      <div style=\"text-align: center;\">";
            echo $width . " X " . $height;
            echo " (";
            echo $size;
            echo ")</div>\n        <div style=\"padding-top: 55px;\"><a href=\"javascript:void(0);\" \n        onclick=\"javascript:\n    ";
            if ($_SESSION["opid"] == "tnmeditor") {
                echo "    setImages('images/gallery/";
                echo $_SESSION["gallary"];
                echo "/";
                echo $entryName;
                echo "');\n    ";
            } else {
                echo "    sendtoopener('images/gallery/";
                echo $_SESSION["gallary"];
                echo "/";
                echo $entryName;
                echo "');\n    ";
            }
            echo "\" style=\"color: black;text-decoration: none;background: white;padding:3px 5px\">select</a></div> \n        <div align=\"left\" style=\"float: left;\"><a onclick=\"window.open('gallery.view.php?file=";
            echo base64_encode("../../images/gallery/" . $_SESSION["gallary"] . "/" . $entryName);
            echo "','Ratting','status=0,fullscreen=yes');\">view</a></div>        \n        <div align=\"right\" style=\"float: right;\"><a href=\"?delete=";
            echo base64_encode("../../images/gallery/" . $_SESSION["gallary"] . "/" . $entryName);
            echo "&id=";
            echo $id;
            echo "\" style=\"color: red;text-decoration: none;\">delete</a></div>\n</div>     \n <input type=\"checkbox\" name=\"del[";
            echo base64_encode("../../images/gallery/" . $_SESSION["gallary"] . "/" . $entryName);
            echo "]\" value=\"";
            echo base64_encode("../../images/gallery/" . $_SESSION["gallary"] . "/" . $entryName);
            echo "\" />  ";
            if (10 < strlen($entryName)) {
                echo substr($entryName, 0, 10) . "...";
            } else {
                echo $entryName;
            }
            echo " \n    </div>\n    ";
        }
    }
    echo "<div style=\"clear: both;\">&nbsp;</div>\n";
} else {
    $start = $_GET["start"];
    if (0 >= $start) {
        $start = 0;
    }
    $eu = $start - 0;
    $limit = 10;
    $this1 = $eu + $limit;
    $back = $eu - $limit;
    $next = $eu + $limit;
    $cnt = 0;
    while ($entryName = readdir($myDirectory)) {
        if ($entryName != ".." && $entryName != "." && $entryName != "tmpImages" && $entryName != "background") {
            $out = strpos($entryName, "humb");
            if ($out == 1) {
                $cnt++;
            }
        }
    }
    closedir($myDirectory);
    $nume = $cnt;
    $page_name = "thumb.php";
    $myDirectory = opendir("../../images/gallery/" . $_SESSION["gallary"]);
    $d = 0;
    $ki = 0;
    while ($entryName = readdir($myDirectory)) {
        if ($entryName != ".." && $entryName != "." && $entryName != "tmpImages" && $entryName != "background" && strpos($entryName, "humb") == 1) {
            list($width, $height) = getimagesize("../../images/gallery/" . $_SESSION["gallary"] . "/" . $entryName);
            $size = filesize("../../images/gallery/" . $_SESSION["gallary"] . "/" . $entryName);
            if (1048576 <= $size) {
                $size = round($size / 1048576) . " mb";
            } else {
                if (1024 <= $size) {
                    $size = round($size / 1024) . " kb";
                } else {
                    $size = $size . " byts";
                }
            }
            $d++;
            if ($eu <= $d && $ki < $limit) {
                $ki++;
                echo "   <div class=\"block\" title=\"";
                echo $entryName;
                echo "\">\n        <div class=\"block_img\" style=\"background: url('../../images/gallery/";
                echo $_SESSION["gallary"];
                echo "/";
                echo $entryName;
                echo "') center no-repeat;\"></div> <br />        \n<div class=\"block_text\" align=\"center\">\n    <div align=\"center\">";
                echo $entryName;
                echo "</div>\n        <div style=\"text-align: center;\">";
                echo $width . " X " . $height;
                echo " (";
                echo $size;
                echo ")</div>\n        <div style=\"padding-top: 55px;\"><a href=\"javascript:void(0);\" \n        onclick=\"javascript:\n    ";
                if ($_SESSION["opid"] == "tnmeditor") {
                    echo "    setImages('images/gallery/";
                    echo $_SESSION["gallary"];
                    echo "/";
                    echo $entryName;
                    echo "');\n    ";
                } else {
                    echo "    sendtoopener('images/gallery/";
                    echo $_SESSION["gallary"];
                    echo "/";
                    echo $entryName;
                    echo "');\n    ";
                }
                echo "\" style=\"color: black;text-decoration: none;background: white;padding:3px 5px\">select</a></div>\n        <div align=\"left\" style=\"float: left;\"><a onclick=\"window.open('gallery.view.php?file=";
                echo base64_encode("../../images/gallery/" . $_SESSION["gallary"] . "/" . $entryName);
                echo "','Ratting','status=0,fullscreen=yes');\">view</a></div>        \n        <div align=\"right\" style=\"float: right;\"><a href=\"?delete=";
                echo base64_encode("../../images/gallery/" . $_SESSION["gallary"] . "/" . $entryName);
                echo "&id=";
                echo $id;
                echo "\" style=\"color: red;text-decoration: none;\">delete</a></div>\n</div>     \n <input type=\"checkbox\" name=\"del[";
                echo base64_encode("../../images/gallery/" . $_SESSION["gallary"] . "/" . $entryName);
                echo "]\" value=\"";
                echo base64_encode("../../images/gallery/" . $_SESSION["gallary"] . "/" . $entryName);
                echo "\" />  ";
                if (10 < strlen($entryName)) {
                    echo substr($entryName, 0, 10) . "...";
                } else {
                    echo $entryName;
                }
                echo " \n    </div>\n    ";
            }
        }
    }
    echo "<div style=\"clear: both;\">&nbsp;</div>\n";
    $p_limit = 10;
    $p_f = $_GET["p_f"];
    if (0 >= $p_f) {
        $p_f = 0;
    }
    $p_fwd = $p_f + $p_limit;
    $p_back = $p_f - $p_limit;
    echo "<div style=\"clear: both;\">&nbsp;</div>\n<div style=\"bottom: 0px; background: none repeat scroll 0% 0% rgb(244, 244, 244); padding: 10px; position: fixed; left: 0px; right: 0px;\">\n<table align = 'center' class='paging'  ><tr><td  align='left' width='20%'>";
    if (0 <= $back) {
        echo "<a href='" . $page_name . "?start=" . $back . "&p_f=" . $p_f . "&id=" . $id . "' style='text-decoration:none;'>PREV</a>";
    }
    echo "</td><td align=center width='40%'>";
    $dnd = 1;
    $i = $p_f;
    while ($i < $nume) {
        if ($i != $eu) {
            $i2 = $i + $p_f;
            echo "<span class='pager'><a href='" . $page_name . "?start=" . $i . "&p_f=" . $p_f . "&id=" . $id . "'>" . $dnd . "</a></span>";
        } else {
            echo "<span class='selected' >" . $dnd . "</span>";
        }
        $dnd++;
        $i = $i + $limit;
    }
    echo "</td><td  align='right' width='20%'>";
    if ($this1 < $nume) {
        echo "<a href='" . $page_name . "?start=" . $next . "&p_f=" . $p_f . "&id=" . $id . "' >NEXT</a>";
    }
    echo "</td></tr></table>";
}
closedir($myDirectory);
echo "\n<br />\n\n<table cellpadding=\"0\" cellspacing=\"0\" border=\"0\"><tr><td style=\"text-align: center;\">    \n Action On Selected Item : <select name=\"movedir\">\n<option value='../../images/gallery/'>Gallery</option>\n";
$dh = opendir("../../images/gallery/");
$files = [];
while (($file = readdir($dh)) !== false) {
    if (is_dir("../../images/gallery/" . $file) && $file != "." && $file != "..") {
        echo "<option value='../../images/gallery/" . $file . "'>" . $file . "</option>";
        $dhR = opendir("../../images/gallery/" . $file . "/");
        while (($filed = readdir($dhR)) !== false) {
            if (is_dir("../../images/gallery/" . $file . "/" . $filed) && $filed != "." && $filed != "..") {
                echo "<option value='../../images/gallery/" . $file . "/" . $filed . "'>" . $file . "/" . $filed . "</option>";
                $dhT = opendir("../../images/gallery/" . $file . "/" . $filed);
                while (($filet = readdir($dhT)) !== false) {
                    if (is_dir("../../images/gallery/" . $file . "/" . $filed . "/" . $filet) && $filet != "." && $filet != "..") {
                        echo "<option value='../../images/gallery/" . $file . "/" . $filed . "/" . $filet . "'>" . $file . "/" . $filed . "/" . $filet . "</option>";
                    }
                }
            }
        }
    }
}
echo "</select>\n<input type=\"hidden\" name=\"id\" value=\"";
echo $id;
echo "\" />\n<input type=\"submit\"  name=\"moveto\" value=\"Move to\" />\n<input type=\"submit\" class=\"button_remove\"  name=\"deletes\" value=\"Delete Selected\" />\n</td>\n</tr></table>\n\n</div>\n</div></div>\n</form>\n</body>\n</html>\n";

?>