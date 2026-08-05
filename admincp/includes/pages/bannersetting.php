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
echo "<style>\n.form{margin-bottom: 4px !important;}\n.colorpicker{display:none}\n</style>\n<script type=\"text/javascript\" src=\"includes/3rdparty/sort/jquery.tablednd.js\"></script>\n<script>\n\$(document).ready(function() {\n\t\$('#main_tbl').tableDnD({\n\t    onDrop: function(table, row) {\n\t       var serialized= \$.tableDnD.serialize();\n\t        \$.ajax({\n\t\t\t\ttype: 'POST',\n\t\t\t\turl: \"includes/pages/banner.order.save.php\",\n\t\t\t\tdata: serialized,\n\t\t\t\tsuccess: function(data) {\n\t\t\t\t\t \$(\"#notification1\").addClass('successbox');\n\t\t\t\t     \$(\"#notification1\").html(data).show();\n\t\t\t\t}\n\t\t\t});\n\t    }\n\t});\n});\n</script>\n<div id=\"notification\"></div>\n<div id=\"content\" style=\"width: 100%;!important \">\n\n";
$rotationduration = mysqli_fetch_assoc(dquery("SELECT value FROM tbl_bannerslider WHERE attribute='duration'"));
$autorotate = mysqli_fetch_assoc(dquery("SELECT value FROM tbl_bannerslider WHERE attribute='auto'"));
$transition = mysqli_fetch_assoc(dquery("SELECT value FROM tbl_bannerslider WHERE attribute='transition'"));
$easing = mysqli_fetch_assoc(dquery("SELECT value FROM tbl_bannerslider WHERE attribute='easing'"));
$info_box_effect = mysqli_fetch_assoc(dquery("SELECT value FROM tbl_bannerslider WHERE attribute='info_box_effect'"));
$navPosition = mysqli_fetch_assoc(dquery("SELECT value FROM tbl_bannerslider WHERE attribute='cp-pos'"));
$cpalignments = mysqli_fetch_assoc(dquery("SELECT value FROM tbl_bannerslider WHERE attribute='cpalignments'"));
$thumbnails = mysqli_fetch_assoc(dquery("SELECT value FROM tbl_bannerslider WHERE attribute='thumbnails'"));
$timer = mysqli_fetch_assoc(dquery("SELECT value FROM tbl_bannerslider WHERE attribute='timer'"));
$navbuttons = mysqli_fetch_assoc(dquery("SELECT value FROM tbl_bannerslider WHERE attribute='navbuttons'"));
$nav_auto_hide = mysqli_fetch_assoc(dquery("SELECT value FROM tbl_bannerslider WHERE attribute='nav_auto_hide'"));
$display_side_buttons = mysqli_fetch_assoc(dquery("SELECT value FROM tbl_bannerslider WHERE attribute='display_side_buttons'"));
$mainWidth = mysqli_fetch_assoc(dquery("SELECT value FROM tbl_bannerslider WHERE attribute='mainWidth'"));
$mainHeight = mysqli_fetch_assoc(dquery("SELECT value FROM tbl_bannerslider WHERE attribute='mainHeight'"));
$fullWidth = mysqli_fetch_assoc(dquery("SELECT value FROM tbl_bannerslider WHERE attribute='fullWidth'"));
echo "\n<form method=\"post\" id=\"frmbanner\">\n<div  class=\"groupstabes\" >\n  <h2>\n    <span class=\"groupstabesheadertext\">Banner Settings</span>\n  </h2>\n  <div class=\"groupstabescontant\">\n\n<table class=\"form\">\n<tbody>\n\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["rotationduration"];
echo "</td>\n    <td class=\"fieldarea\"><span><input type=\"text\"  class=\"txt small\" name=\"duration\" value=\"";
echo $rotationduration["value"];
echo "\" /></span></td>\n</tr>\n\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["autorotate"];
echo "</td>\n    <td class=\"fieldarea\"><span>\n    <input type=\"radio\" name=\"auto\" value=\"true\" id=\"autot\" ";
if ($autorotate["value"] == "true") {
    echo "checked";
}
echo "/><label for=\"autot\">";
echo $LNG["true"];
echo "</label>\n    <input type=\"radio\" name=\"auto\" value=\"false\" id=\"autof\" ";
if ($autorotate["value"] == "false") {
    echo "checked";
}
echo "/><label for=\"autof\">";
echo $LNG["false"];
echo "</label>\n    </span></td>\n</tr>\n\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["transition"];
echo "</td>\n    <td class=\"fieldarea\">\n\t    <span>\n\t    ";
$str = "<select name=\"transition\" id=\"transitions\">                        \n                    <option value=\"random\" selected=\"selected\">random</option>\n                    <option value=\"fade\">fade</option>\n                    <option value=\"horizontalSlide\">horizontal slide</option>\n                    <option value=\"verticalSlide\">vertical slide</option>\n                    <option value=\"coverDown\">cover down</option>\n                    <option value=\"coverUp\">cover up</option>\n                    <option value=\"coverRight\">cover right</option>\n                    <option value=\"coverLeft\">cover left</option>                            \n                    <option value=\"zoomIn\">zoom in </option>\n                    <option value=\"zoomOut\">zoom out</option>\n                    <optgroup label=\"blocks\">                                    \n                        <option value=\"blockExpandDown\">expand down</option>\n                        <option value=\"blockExpandUp\">expand up</option>\n                        <option value=\"blockExpandRight\">expand right</option>\n                        <option value=\"blockExpandLeft\">expand left</option>\n                        <option value=\"diagonalFade\">diagional fade</option> \n                        <option value=\"diagonalExpand\">diagional expand</option>                                \n                        <option value=\"diagonalShift\">diagional shift</option>\n                        <option value=\"reverseDiagonalFade\">reverse diagional fade</option> \n                        <option value=\"reverseDiagonalExpand\">reverse diagional expand</option> \n                        <option value=\"reverseDiagonalShift\">reverse diagional shift</option>\n                        <option value=\"blockRandomFade\">random fade</option>\n                        <option value=\"blockRandomExpand\">random expand</option>\n                        <option value=\"blockRandomDrop\">random drop</option>                                    \n                        <option value=\"zigZagDown\">zig zag down</option>\n                        <option value=\"zigZagUp\">zig zag up</option>\n                        <option value=\"zigZagRight\">zig zag right</option>\n                        <option value=\"zigZagLeft\">zig zag left</option>\n                        <option value=\"spiralIn\">spiral in</option>\n                        <option value=\"spiralOut\">spiral out</option>\n                    </optgroup>\n                    <optgroup label=\"vertical slices\">                                \n                        <option value=\"sliceDownRight\">slice down right</option>\n                        <option value=\"sliceDownLeft\">slice down left</option>\n                        <option value=\"sliceDownRandom\">slice down random</option>\n                        <option value=\"sliceUpRight\">slice up right</option>\n                        <option value=\"sliceUpLeft\">slice up left</option>\n                        <option value=\"sliceUpRandom\">slice up random</option>\n                        <option value=\"sliceFadeRight\">fade right</option>\n                        <option value=\"sliceFadeLeft\">fade left</option>\n                        <option value=\"verticalRandomFade\">random fade</option>                                   \n                        <option value=\"sliceAltRight\">alternate right</option>\n                        <option value=\"sliceAltLeft\">alternate left</option>  \n                        <option value=\"blindsRight\">blinds right</option>\n                        <option value=\"blindsLeft\">blinds left</option>\n                        <option value=\"verticalRandomBlinds\">random blinds</option>                                    \n                       \t<option value=\"sliceMoveRight\">slice move right</option>\n                        <option value=\"sliceMoveLeft\">slice move left</option>\n                    </optgroup>\n                    <optgroup label=\"horizontal stripes\">\n                        <option value=\"sliceRightDown\">slice right down</option>\n                        <option value=\"sliceRightUp\">slice right up</option>\n                        <option value=\"sliceRightRandom\">slice right random</option>\n                        <option value=\"sliceLeftDown\">slice left down</option>\n                        <option value=\"sliceLeftUp\">slice left up</option>\t\n                        <option value=\"sliceLeftRandom\">slice left random</option>\n                        <option value=\"sliceFadeDown\">fade down</option> \n                        <option value=\"sliceFadeUp\">fade up</option>\n                        <option value=\"horizontalRandomFade\">random fade</option>\n                        <option value=\"sliceAltDown\">alternate down</option>\n                        <option value=\"sliceAltUp\">alternate up</option>\n                        <option value=\"blindsDown\">blinds down</option>\n                        <option value=\"blindsUp\">blinds up</option>                                    \n                        <option value=\"horizontalRandomBlinds\">random blinds</option>\n                        <option value=\"sliceMoveDown\">slice move down</option>\n                        <option value=\"sliceMoveUp\">slice move up</option>                \n                    </optgroup>  \n                 </select>";
echo str_replace("<option value=\"" . $transition["value"] . "\"", "<option value=\"" . $transition["value"] . "\" selected=\"selected\"", $str);
echo "\n\t    </span>\n    </td>\n</tr>\n\n\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["transition"];
echo " ";
echo $LNG["easing"];
echo "</td>\n    <td class=\"fieldarea\">\n\t    <span>\n\t    \t ";
$str = "<select name=\"easing\" id=\"easing\">\n                    \t<option value=\"none\">none</option>\n                        <option value=\"linear\">linear</option>\n                        <option value=\"easeInElastic\">easeInElastic</option> \n                        <option value=\"easeOutElastic\">easeOutElastic</option> \n                        <option value=\"easeInOutElastic\">easeInOutElastic</option> \n                        <option value=\"easeInBack\">easeInBack</option> \n                        <option value=\"easeOutBack\">easeOutBack</option> \n                        <option value=\"easeInOutBack\">easeInOutBack</option> \n                        <option value=\"easeInBounce\">easeInBounce</option> \n                        <option value=\"easeOutBounce\">easeOutBounce</option> \n                        <option value=\"easeInOutBounce\">easeInOutBounce</option>                         \n                        <option value=\"easeInCirc\">easeInCirc</option> \n                        <option value=\"easeOutCirc\">easeOutCirc</option> \n                        <option value=\"easeInOutCirc\">easeInOutCirc</option>  \n                        <option value=\"easeInQuad\">easeInQuad</option> \n                        <option value=\"easeOutQuad\">easeOutQuad</option> \n                        <option value=\"easeInOutQuad\">easeInOutQuad</option> \n                        <option value=\"easeInCubic\">easeInCubic</option> \n                        <option value=\"easeOutCubic\">easeOutCubic</option> \n                        <option value=\"easeInOutCubic\">easeInOutCubic</option> \n                        <option value=\"easeInQuart\">easeInQuart</option> \n                        <option value=\"easeOutQuart\">easeOutQuart</option> \n                        <option value=\"easeInOutQuart\">easeInOutQuart</option> \n                        <option value=\"easeInQuint\">easeInQuint</option> \n                        <option value=\"easeOutQuint\">easeOutQuint</option> \n                        <option value=\"easeInOutQuint\">easeInOutQuint</option> \n                        <option value=\"easeInSine\">easeInSine</option> \n                        <option value=\"easeOutSine\">easeOutSine</option> \n                        <option value=\"easeInOutSine\">easeInOutSine</option> \n                        <option value=\"easeInExpo\">easeInExpo</option> \n                        <option value=\"easeOutExpo\">easeOutExpo</option> \n                        <option value=\"easeInOutExpo\">easeInOutExpo</option>\n                    </select>";
echo str_replace("<option value=\"" . $easing["value"] . "\"", "<option value=\"" . $easing["value"] . "\" selected=\"selected\"", $str);
echo "\t    </span>\n    </td>\n</tr>\n\n\n<!--\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["txteffect"];
echo "</td>\n    <td class=\"fieldarea\">\n\t    <span>\n\t    \t";
$str = "<select name=\"info_box_effect\" id=\"texteffects\">\n\t                    <option value=\"none\">none</option>\n                        <option value=\"fade\">fade</option>\n                        <option value=\"up\">expand up</option>\n                        <option value=\"down\">expand down</option>\n                        <option value=\"left\">expand left</option>                        \n                        <option value=\"right\">expand right</option>                       \t\n                    </select>";
echo str_replace("<option value=\"" . $info_box_effect["value"] . "\"", "<option value=\"" . $info_box_effect["value"] . "\" selected=\"selected\"", $str);
echo "\t    </span>\n    </td>\n</tr>\n-->\n\n\n\n\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["navigation"];
echo "</td>\n    <td class=\"fieldarea\"><span>\n    <input type=\"radio\" name=\"navPosition\" value=\"inside\" id=\"hor\" ";
if ($navPosition["value"] == "inside") {
    echo "checked";
}
echo "/><label for=\"hor\">";
echo $LNG["inside"];
echo "</label>\n    <input type=\"radio\" name=\"navPosition\" value=\"outside\" id=\"ver\" ";
if ($navPosition["value"] == "outside") {
    echo "checked";
}
echo "/><label for=\"ver\">";
echo $LNG["outside"];
echo "</label>\n    </span></td>\n</tr>\n\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["navigation"];
echo " ";
echo $LNG["button"];
echo "</td>\n    <td class=\"fieldarea\"><span>\n                        ";
$str = "<select name=\"navbuttons\" id=\"navbuttons\">                        \n                        <option value=\"none\">none</option>\n                        <option value=\"small\" selected=\"selected\">normal</option>\n                        <option value=\"large\">side</option>                            \n                    </select> ";
echo str_replace("<option value=\"" . $navbuttons["value"] . "\"", "<option value=\"" . $navbuttons["value"] . "\" selected=\"selected\"", $str);
echo "</span>\n\t</td>\n</tr>\n\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["navigation"];
echo " ";
echo $LNG["control"];
echo " ";
echo $LNG["position"];
echo "</td>\n    <td class=\"fieldarea\"><span>\n                        ";
$str = "<select name=\"cpalignments\" id=\"cpalignments\">\n                        <option value=\"bottom\" selected=\"selected\">bottom</option>                    \n                        <option value=\"bottomLeft\">bottom left</option>\n                        <option value=\"bottomRight\">bottom right</option>\n                        <option value=\"top\">top</option>\n                        <option value=\"topLeft\">top left</option>                    \n                        <option value=\"topRight\">top right</option>                            \n                        <option value=\"left\">left</option>\n                        <option value=\"leftTop\">left top</option>                    \n                        <option value=\"leftBottom\">left bottom</option>\n                        <option value=\"right\">right</option>\n                        <option value=\"rightTop\">right top</option>                    \n                        <option value=\"rightBottom\">right bottom</option>\n                    </select> ";
echo str_replace("<option value=\"" . $cpalignments["value"] . "\"", "<option value=\"" . $cpalignments["value"] . "\" selected=\"selected\"", $str);
echo "</span>\n\t</td>\n</tr>\n\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["thumbnail"];
echo "</td>\n    <td class=\"fieldarea\"><span>\n                        ";
$str = "<select name=\"thumbnails\" id=\"thumbnails\">                                                \n                        <option value=\"none\">none</option>\n                        <option value=\"number\" selected=\"selected\">number</option>\n                        <option value=\"image\">image</option>\n                        <option value=\"bullet\">bullet</option>                            \n                        <option value=\"text\">text</option>\n                        <option value=\"empty\">empty</option>                                                                                                                        \n                    </select> ";
echo str_replace("<option value=\"" . $thumbnails["value"] . "\"", "<option value=\"" . $thumbnails["value"] . "\" selected=\"selected\"", $str);
echo "</span>\n\t</td>\n</tr>\n\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["timer"];
echo "</td>\n    <td class=\"fieldarea\"><span>\n                        ";
$str = "<select name=\"timer\" id=\"timer\">                                                                        \n                        <option value=\"none\">none</option>\n                        <option value=\"bar\">bar</option>\n                        <option value=\"pie\" selected=\"selected\">pie</option>                                                                                                                                                                                              \n                    </select> ";
echo str_replace("<option value=\"" . $timer["value"] . "\"", "<option value=\"" . $timer["value"] . "\" selected=\"selected\"", $str);
echo "</span>\n\t</td>\n</tr>\n\n\n<!--\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["navigation"];
echo " ";
echo $LNG["auto"];
echo " ";
echo $LNG["hide"];
echo "</td>\n    <td class=\"fieldarea\"><span>\n    <input type=\"radio\" name=\"nav_auto_hide\" value=\"true\" id=\"tr\" ";
if ($nav_auto_hide["value"] == "true") {
    echo "checked";
}
echo "/><label for=\"tr\">";
echo $LNG["true"];
echo "</label>\n    <input type=\"radio\" name=\"nav_auto_hide\" value=\"false\" id=\"fl\" ";
if ($nav_auto_hide["value"] == "false") {
    echo "checked";
}
echo "/><label for=\"fl\">";
echo $LNG["false"];
echo "</label>\n    </span></td>\n</tr>\n\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["next"];
echo " ";
echo $LNG["previous"];
echo " ";
echo $LNG["button"];
echo " </td>\n    <td class=\"fieldarea\"><span>\n    <input type=\"radio\" name=\"display_side_buttons\" value=\"true\" id=\"ntr\" ";
if ($display_side_buttons["value"] == "true") {
    echo "checked";
}
echo "/><label for=\"ntr\">";
echo $LNG["true"];
echo "</label>\n    <input type=\"radio\" name=\"display_side_buttons\" value=\"false\" id=\"pfl\" ";
if ($display_side_buttons["value"] == "false") {
    echo "checked";
}
echo "/><label for=\"pfl\">";
echo $LNG["false"];
echo "</label>\n    </span></td>\n</tr>\n-->\n\n";
if ($fullWidth["value"] == "1") {
    $checked = "checked='checked'";
}
echo "<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["mainWidth"];
echo "</td>\n    <td class=\"fieldarea\"><span><input type=\"text\"  class=\"txt small\" name=\"mainWidth\" value=\"";
echo $mainWidth["value"];
echo "\" /></span>px  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\n<input type=\"checkbox\" value=\"1\" name=\"fullWidth\" id=\"fullwidth\" ";
echo $checked;
echo "/><label for=\"fullwidth\">Full Width 100%</label>\n </td>\n</tr>\n\n<!--\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["mainHeight"];
echo "</td>\n    <td class=\"fieldarea\"><span><input type=\"text\"  class=\"txt small\"  name=\"mainHeight\" value=\"";
echo $mainHeight["value"];
echo "\" /></span>px</td>\n</tr>\n-->\n\n</tbody>\n</table>\n<p class=\"fixedbtn\">\n<input value=\"";
echo $LNG["save"];
echo "\" id=\"btnoverview\" class=\"btn\" type=\"button\"  onclick=\"SubmitForm ('#btnoverview','indexbanner','#frmbanner','#notification','true','#main_loader');\"/>\n</p>\n</div></div>\n</form>\n\n</div>\n";
$fileverioncheck = "6.1.0";

?>