<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

echo "<style>\n    img{margin-left:10px;margin-top:10px}\n</style>\n";
include DATAGRID_DIR . "comm.php";
$pageid = 458;
checkPagePermission($pageid);
if ($generate) {
    echo "<ul id=\"tabmenu\"> \n    <li><a  onclick=\"getContect('#tab','main2.php?page=support.department','";
    echo $id;
    echo "','','#tabcontent',true,'#main_loader');\" id=\"tab\" >";
    echo $LNG["support"];
    echo " / ";
    echo $LNG["livehelp"];
    echo " ";
    echo $LNG["department"];
    echo "</a></li> \n    <li><a  onclick=\"getContect('#tab1','main2.php?page=support.status','";
    echo $id;
    echo "','','#tabcontent',true,'#main_loader');\" id=\"tab1\" >";
    echo $LNG["ticket"] . " " . $LNG["status"];
    echo "</a></li> \n    <li><a onclick=\"getContect('#tab2','main2.php?page=support.priority','";
    echo $id;
    echo "','','#tabcontent',true,'#main_loader');\" id=\"tab2\" >";
    echo $LNG["ticket"] . " " . $LNG["priority"];
    echo "</a></li>\n    <li><a class='tabmenu_active' onclick=\"getContect('#tab3','main2.php?page=support.tag','";
    echo $id;
    echo "','','#tabcontent',true,'#main_loader');\" id=\"tab3\" >";
    echo $LNG["taggenerator"];
    echo "</a></li>\n    \n<div style=\"clear: both;\"></div>\n</ul>  \n    <div id='tabcontent'>\n";
}
echo "    \n\n<div id=\"notification\"></div>\n<div id=\"content\">\n<div id=\"content_padded\">\n";
if ($generate) {
    if ($style == 1) {
        $type = "";
    } else {
        if ($style == 3) {
            $type = "&type=" . base64_encode("text");
        } else {
            if ($style == 2) {
                $type = "&type=" . base64_encode("html");
            }
        }
    }
    echo "<textarea style='width:100%;' rows='4'><!--Dhru Fusion Live Help Script Start --><script type=\"text/javascript\" src=\"";
    echo $config["site_address"];
    echo "/includes/livehelp/status.php?position=";
    echo $position;
    echo $type;
    echo "\"></script><div id=\"livechatstatus\" >Chat Loading...</div><script type=\"text/javascript\">loadStatus('livechatstatus',";
    echo $visitortrack == 1 ? "'true'" : "'false'";
    echo ");</script><!--End-->        </textarea>";
} else {
    echo "<form id=\"frm\" name=\"\" method=\"post\">\n";
    echo generate_token("form");
    echo "<input type=\"hidden\" name=\"page\" value=\"support.tag\" />\n<table id=\"main_tbl\"  border=\"0\" cellpadding=\"3\" cellspacing=\"2\" width=\"100%\">\n<tbody> \n<tr>\n    <td><img  src=\"images/live_style.png\" style=\"vertical-align: middle;\"/></td>\n    <td ><input type=\"radio\" checked=\"checked\" name=\"style\" id=\"rs\" value=\"1\"   />\n    \n   <label for='rs'><strong>";
    echo $LNG["sitebadge"];
    echo "</strong><br /> \n    </label></td>\n    <td>";
    echo $LNG["sitebadgeinfo"];
    echo "</td>\n    <td></td>\n</tr>\n \n<tr>\n    <td>\n    <img src=\"images/htmltype.jpg\" style=\"vertical-align: middle;\"/></td>\n    <td>\n    <input type=\"radio\" id=\"rh\" name=\"style\" value=\"2\"   />\n     \n    <label for='rh'><strong>";
    echo $LNG["htmlbutton"];
    echo "</strong><br />\n    </label></td>\n    <td>";
    echo $LNG["htmlinfo"];
    echo "    </td>\n    <td></td>\n</tr>\n\n<tr>\n    <td><img src=\"images/textlink.jpg\" style=\"vertical-align: middle;\" /></td>\n    <td><input type=\"radio\" id=\"rt\" name=\"style\" value=\"3\"   />\n     \n    <label for='rt'><strong>";
    echo $LNG["textlink"];
    echo "</strong><br />\n    </label></td>\n    <td>\n        ";
    echo $LNG["textlinkinfo"];
    echo "    </td>\n    <td></td>\n</tr>\n\n<tr>\n    <td>";
    echo $LNG["position"];
    echo " :</td>\n    <td>\n        \n      <select id=\"position\" name=\"position\" >\n    <option value=\"left\">Left Center</option>\n    <option value=\"right\">Right Center</option>\n    <option value=\"rightbottom\">Right Bottom</option>\n    <option value=\"leftbottom\">Left Bottom</option>\n    <option value=\"disable\">Disable</option>\n    </select>\n    </td>\n    <td></td>\n</tr>\n\n<tr><td> </td>\n<td>\n      <input type=\"checkbox\" name=\"visitortrack\" value=\"1\" checked=\"checked\" />\n      <label>\n      ";
    echo $LNG["visitor"];
    echo " ";
    echo $LNG["tracker"];
    echo "  \n      </label>  \n</td>\n<td></td>\n</tr>\n \n</tbody>\n \n</table>\n\n\n\n  \n     \n <p class=\"fixedbtn\">   \n    <input type=\"submit\" name=\"generate\" value=\"";
    echo $LNG["generate"];
    echo "\" />\n</p>\n\n</form>\n";
}
if ($generate) {
    echo "</div>";
}
echo "</div></div>";
$fileverioncheck = "6.1.0";

?>