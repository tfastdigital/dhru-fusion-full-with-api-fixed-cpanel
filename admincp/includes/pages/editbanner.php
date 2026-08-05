<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

if (!$_SESSION["adminid"]) {
    exit("error:invalid token");
}
echo "\n<link rel=\"stylesheet\" media=\"screen\" type=\"text/css\" href=\"../includes/colorpicker/css/colorpicker.css\" />\n<script type=\"text/javascript\" src=\"../includes/colorpicker/js/colorpicker.js\"></script>\n<script>\n    \$(document).ready(function() {\n        \$('#backgroundColor').ColorPicker({\n            onSubmit: function(hsb, hex, rgb, el) {\n                \$(el).val(\"#\"+hex);\n                \$(el).ColorPickerHide();\n            },\n            onBeforeShow: function () {\n                \$(this).ColorPickerSetColor(this.value);\n            },\n            onShow: function (colpkr) {\n                \$(colpkr).fadeIn(500);\n                return false;\n            },\n            onHide: function (colpkr) {\n                \$(colpkr).fadeOut(500);\n                return false;\n            },\n            onChange: function (hsb, hex, rgb) {\n                \$('#backgroundColor').css({'background-color':'#'+hex});\n            }\n        });\n\n    });\n\n    function bannerTypeSelection(type) {\n        \$('.bannertype.selected').removeClass('selected');\n        \$('.'+type).addClass('selected');\n    }\n\n</script>\n<style>\n    .bannertype{\n        display: none;\n    }\n    .bannertype.selected{\n        display: block;\n    }\n</style>\n";
$pageid = 94;
checkPagePermission($pageid);
require_once ROOTDIR . "/includes/clients.fun.inc.php";
require_once "includes/3rdparty/editor/editor.php";
echo "\n\n\n";
$ban = mysqli_fetch_assoc(dquery("SELECT  * FROM `tbl_bannerslider_banners` WHERE `id`='" . $_GET["edit"] . "' "));
$ban["data"] = json_decode($ban["data"], true);
if (!$ban["data"]["backgroundImage"]) {
    $ban["data"]["backgroundImage"] = $ban["img"];
    $image = "checked='checked'";
}
if (!$ban["data"]["info"]) {
    $ban["data"]["info"] = $ban["info"];
}
if ($ban["data"]["bg"] == "image") {
    $image = "checked='checked'";
} else {
    if ($ban["data"]["bg"] == "svg") {
        $svg = "checked='checked'";
    } else {
        if ($ban["data"]["bg"] == "color") {
            $color = "checked='checked'";
        } else {
            if ($ban["data"]["bg"] == "themedefault") {
                $themedefault = "checked='checked'";
            } else {
                if ($ban["data"]["bg"] == "none") {
                    $none = "checked='checked'";
                }
            }
        }
    }
}
$type = $ban["data"]["bg"];
echo "\n<div id=\"tabcontent\">\n    <div id=\"notification\"></div>\n    <div id=\"content\">\n        <div id=\"content_padded\">\n            <script language=\"JavaScript\">\n                function newWindow(file,window)\n                {\n                    msgWindow=open(file,window,'scrollbars=yes,resizable=no,width=550,height=400');\n                    if (msgWindow.opener == null) msgWindow.opener = self;\n                }\n\n            </script>\n\n            <form method=\"post\" id=\"frmBB\">\n                <input type=\"hidden\" name=\"id\" value=\"";
echo $_GET["edit"];
echo "\" />\n                <table class=\"form\" border=\"0\" cellpadding=\"3\" cellspacing=\"2\">\n                    <tbody>\n\n\n                    <tr>\n                        <td class=\"fieldlabel\">Name</td>\n                        <td class=\"fieldarea\"><span>\n    <input type=\"text\"  class=\"txt medium\" name=\"title\"  value=\"";
echo $ban["img_title"];
echo "\" />\n    </span></td>\n                    </tr>\n\n                    <tr>\n                        <td class=\"fieldlabel\" rowspan=\"2\">Background</td>\n                        <td class=\"fieldarea\">\n                            <div>\n                                <span><input type=\"radio\" id=\"image\" onclick=\"bannerTypeSelection('image')\" name=\"bg\" value=\"image\" ";
echo $image;
echo "/><label for=\"image\">";
echo $LNG["image"];
echo "</label></span>\n                                <span><input type=\"radio\" id=\"svg\" onclick=\"bannerTypeSelection('svg')\"  name=\"bg\" value=\"svg\" ";
echo $svg;
echo "/><label for=\"svg\">SVG or base64</label></span>&nbsp;&nbsp;&nbsp;\n                                <span><input type=\"radio\" id=\"color\" onclick=\"bannerTypeSelection('color')\"  name=\"bg\" value=\"color\" ";
echo $color;
echo " /><label for=\"color\">Color</label></span>&nbsp;&nbsp;&nbsp;\n                                <span><input type=\"radio\" id=\"themedefault\" onclick=\"bannerTypeSelection('themedefault')\"  name=\"bg\" value=\"themedefault\" ";
echo $themedefault;
echo " /><label for=\"themedefault\">Theme Default</label></span>&nbsp;&nbsp;&nbsp;\n                                <span><input type=\"radio\" id=\"none\" onclick=\"bannerTypeSelection('none')\"  name=\"bg\" value=\"none\" ";
echo $none;
echo " /><label for=\"none\">None</label></span>&nbsp;&nbsp;&nbsp;\n                            </div>\n                        </td>\n                    </tr>\n\n\n                    <tr>\n                        <td  class=\"fieldarea\">\n                            <div>\n                                <div  class=\"image bannertype ";
if ($type === "image") {
    echo "selected";
}
echo "\">\n                                    <input type=\"text\"  class=\"txt large\" name=\"backgroundImage\" id=\"banner\" value=\"";
echo $ban["data"]["backgroundImage"];
echo "\"/>\n                                    <input type=\"button\" class=\"addFromgallery\" value=\"";
echo $LNG["addgallery"];
echo "\" name=\"upload\" onclick=\"newWindow('includes/gallery.php?id=banner', 'windowname1')\" />\n                                </div>\n                                <div  class=\"svg bannertype ";
if ($type === "svg") {
    echo "selected";
}
echo "\">\n                                    <input type=\"text\" class=\"txt large\" name=\"backgroundSVG\" value=\"";
echo $ban["data"]["backgroundSVG"];
echo "\" />\n                                    <span class=\"text-muted\">ex. url(\"data:image/svg+xml,%3Csvg.....\")</span>\n                                </div>\n                                <div  class=\"color bannertype ";
if ($type === "color") {
    echo "selected";
}
echo "\">\n                                    <input type=\"text\"  class=\"txt small\" id=\"backgroundColor\" name=\"backgroundColor\" value=\"";
echo $ban["data"]["backgroundColor"];
echo "\" />\n                                </div>\n                            </div>\n                        </td>\n                    </tr>\n\n\n                    <!-- <tr>\n        <td class=\"fieldlabel\"> </td>\n        <td class=\"fieldarea\"><span>\n        <input type=\"text\"  class=\"txt small\" id=\"fontColor\" name=\"fontcolor\" value=\"\" style=\"background-color: ;\" /> <small>only for default4 template</small>\n        </span></td>\n    </tr>-->\n\n\n                    <tr>\n                        <td class=\"fieldlabel\">Onclick URL</td>\n                        <td class=\"fieldarea\"><span>\n    <input type=\"text\"  class=\"txt large\" name=\"readmore\" value=\"";
echo $ban["readmore_link"];
echo "\" />\n    </span></td>\n                    </tr>\n                    <!--<tr>\n    <td class=\"fieldlabel\"></td>\n    <td class=\"fieldarea\"><span>\n    <input type=\"text\"  class=\"txt large\" name=\"infoheader\" value=\"\" />\n    </span></td>\n</tr>-->\n                    <tr>\n                        <td class=\"fieldlabel\">Content</td>\n                        <td class=\"fieldarea\"><span>\n    <textarea name=\"info\" id=\"message\">\n        ";
echo $ban["info"];
echo "    </textarea>\n    </span></td>\n                    </tr>\n\n                    <!--<tr>\n    <td class=\"fieldlabel\">  </td>\n    <td class=\"fieldarea\"><span>\n    <input type=\"text\"  class=\"txt small\" name=\"infox_box_width\" value=\"\" />\n    </span>px <small>default width 400px</small></td>\n</tr>\n\n<tr>\n    <td class=\"fieldlabel\">   </td>\n    <td class=\"fieldarea\"><span>\n    <input type=\"text\"  class=\"txt small\" name=\"po_top\" value=\"\" />\n    </span>px <small>default from top 5px</small></td>\n</tr>\n\n<tr>\n    <td class=\"fieldlabel\">   </td>\n    <td class=\"fieldarea\"><span>\n    <input type=\"text\"  class=\"txt small\" name=\"po_left\" value=\"\" />\n    </span>px <small>default from left 484px</small></td>\n</tr>-->\n\n\n\n\n\n\n\n                    </tbody>\n                </table>\n\n                <div class=\"fixedbtn\">\n                    <input value=\"";
echo $LNG["save"];
echo "\" id=\"btnoverview\" class=\"btn save\"\n                           type=\"button\"\n                           onclick=\"tinyMCE.triggerSave();SubmitForm('#btnoverview','editbanner','#frmBB','#notification','true','#main_loader');\"/>\n                </div>\n\n            </form>\n\n        </div></div>\n</div>";
$fileverioncheck = "6.1.0";

?>