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
require_once "../../../comm.php";
require_once "../../../includes/fun.inc.php";
require_once "../../includes/fun.inc.php";
if (!checkAdminlogin() || !$_SESSION["adminid"]) {
    echo "<div align=\"center\"><h3>Session expired. <a style=\"color: #666;\" href=\"index.php?main2redirect=true\">Please relogin</a></h3></div>";
    $_SESSION["admin_afterlogin_re"] = $_SERVER["REQUEST_URI"];
    exit;
}
if ($save) {
    $_SESSION["pickeduser"] = $_POST["selected"];
    echo "<div id='notification1' class='successbox'>" . $LNG["user"] . " " . $LNG["selected"] . " " . $LNG["successfully"] . " </div>";
}
echo "<script>\nfunction loopSelected()\n{\n  var txtSelectedValuesObj = document.getElementById('selected');\n  var selectedArray = new Array();\n  var selObj = document.getElementById('imei');\n  var i;\n  var count = 0;\n  for (i=0; i<selObj.options.length; i++) {\n    if (selObj.options[i].selected) {\n      selectedArray[count] = selObj.options[i].value;\n      count++;\n    }\n  }\n  txtSelectedValuesObj.value = selectedArray;\n}\n</script>\n<script> \nfunction sendtoopener()   \n{ \n    opener.document.getElementById('imei').value=document.getElementById('selected').value; \n    opener.document.getElementById('server').value=\"\";\n    opener.document.getElementById('product').value=\"\";\n    self.close();    \n}\n</script>\n<style>\n.list{\n    cursor: pointer;\n}\n.list:hover{\n    background-color: #E9E9E9;\n}\n#clientlist{\n    background: none repeat scroll 0 0 white;\n    border: 1px solid #F4F4F4;\n    box-shadow: 0 0 5px rgba(0,0,0,0.2);\n    padding: 5px;\n    width: 152px;\n    z-index:9;\n}\n#clientlist li{padding:5px;list-style: none;}\n.red{\n    color:red;\n}\n.clickon{\n    cursor: pointer;\n    display: none;\n}\n.tag{\n    background-color: #F4F4F4;\n}\n</style>\n<script src=\"../../includes/js/jquery.js\"></script>\n<script>\n\$(document).ready(function(){\t\n    \$('#cid').keyup(function() {\n        var search=\$(this).val();\n        if(search.length>2){\n            \$.post('../../includes/pages/pos.sales.product.php?directorder='+search, function(data) {\n               \n                if(data){\n                     \$('#clientlist').show();\n                     \$('#clientlist').html(data);\n                 }\n            });\n        }\n    });\n});\nfunction removeMail(email){\n\n    \$(\".id_\"+email.trim()).hide();\n}\nfunction setValse(vals){\n    var part;\n    part=vals.split(\"=\");\n    var tag='<span  class=\"tag id_'+part[0]+'\">'+part[0].trim()+'<span onclick=\"javascript: removeMail(\\''+part[0]+'\\')\" class=\"red clickon\" >X</span><span><div style=\"clear:both\"></div>';\n    \$('#clients').append(tag);\n    var selc=\$(\"#selected\").val();\n    if(selc){\n        \$(\"#selected\").val(selc+\",\"+part[2]);\n    }else{\n        \$(\"#selected\").val(part[2]);\n    }\n    \$('#clientlist').hide();\n    \$('#cid').val('');\n}\n</script>\n<link rel=\"stylesheet\" href=\"../../templates/";
echo $_SESSION["admin_template"];
echo "/x-main2.css\" />\n<div id=\"notification\"></div>\n<div id=\"content\">\n<div id=\"content_padded\">\n<form id=\"frm\" name=\"\" method=\"post\">\n<input type=\"hidden\" name=\"id\" value=\"";
echo $id;
echo "\" />\n<table class=\"form\" border=\"0\" cellpadding=\"3\" cellspacing=\"2\" width=\"100%\">\n<tbody>\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["search"];
echo " ";
echo $LNG["client"];
echo "</td>\n    <td class=\"fieldarea\"><span>\n    <input type=\"text\"  class=\"txt medium\" name=\"client\" id=\"cid\" \n    value=\"";
echo $LNG["search"];
echo " ";
echo $LNG["client"];
echo "\"\n    onfocus=\"if(this.value=='";
echo $LNG["search"];
echo " ";
echo $LNG["client"];
echo "')value='';\"\n    autocomplete=\"off\"\n onblur=\"if(this.value=='')this.value='";
echo $LNG["search"];
echo " ";
echo $LNG["client"];
echo "';\" />\n    <div style=\"display: none;position: absolute;\" id=\"clientlist\"></div>            \n   </span>\n\n   </td>\n</tr>\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["email"];
echo " ";
echo $LNG["to"];
echo "</td>\n    <td class=\"fieldarea\">\n    <input type='hidden' name='selected' id='selected' />\n    <div id=\"clients\" style=\"min-height: 300px;\"> \n    </div>\n    </td>\n</tr>\n<!--\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["user"];
echo " ";
echo $LNG["list"];
echo "</td>\n    <td class=\"fieldarea\">\n<select name='imei' id='imei' multiple=\"multiple\" size=\"40\" onchange=\"loopSelected();\">\n";
$picuser = explode(",", $_SESSION["pickeduser"]);
$cg = dquery("select * from tbl_client_group order by displayorder asc");
while ($rcg = mysqli_fetch_assoc($cg)) {
    echo "    <optgroup label=\"";
    echo $LNG["default"];
    echo "\">\n    ";
    $sql = dquery("select username ,id from tblUsers where guest=0\n        and client_group='0' ORDER BY username asc");
    while ($row = mysqli_fetch_assoc($sql)) {
        if (in_array($row["id"], $picuser)) {
            $selected = "selected";
        } else {
            $selected = "";
        }
        echo "<option " . $selected . " value='" . $row["id"] . "'>" . $row["username"] . "</option>";
    }
    echo "    </optgroup>\n    ";
    $sql = dquery("select username ,id from tblUsers where guest=0\n    and client_group='" . $rcg["id"] . "' ORDER BY username asc");
    echo "    <optgroup label=\"";
    echo $rcg["groupname"];
    echo "\">\n    ";
    while ($row = mysqli_fetch_assoc($sql)) {
        if (in_array($row["id"], $picuser)) {
            $selected = "selected";
        } else {
            $selected = "";
        }
        echo "<option " . $selected . " value='" . $row["id"] . "'>" . $row["username"] . "</option>";
    }
    echo "    </optgroup>\n";
}
echo "</select>\n    <input type='hidden' name='selected' id='selected' />\n</td>\n</tr>\n-->\n<tr> \n    <td class=\"fieldlabel\"></td>\n    <td class=\"fieldarea\">\n      <input type='submit' class=\"btn save\" name='save' value='Add User' />\n    </td>\n</tr>\n</tbody>\n</table>\n\n</form>\n\n\n</div></div>\n ";
$fileverioncheck = "6.1.0";

?>