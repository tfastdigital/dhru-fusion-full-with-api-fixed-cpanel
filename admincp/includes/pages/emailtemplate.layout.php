<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

echo "<script>\nfunction redirect(){\n    if(document.getElementById('layout').value){\n        javascript:redirectedit('emaillayout.edit','&newlayoutd='+document.getElementById('layout').value);\n    }else{\n        alert('Page Name Required');\n    }\n}\n</script>\n<div id=\"notification\"></div>\n<div id=\"content\">\n<div id=\"content_padded\" >\n";
$pageid = 541;
checkPagePermission($pageid);
if (!$_SESSION["adminid"]) {
    exit("error:invalid token");
}
if ($delete && $id) {
    dquery("DELETE from tbl_email_layout WHERE id='" . $id . "'");
    echo "<div id='notification' class='successbox'>" . $LNG["datadeletesuccessfully"] . "</div>";
}
if ($copy) {
    $layout = mysqli_fetch_assoc(dquery("select * from tbl_email_layout where id=1"));
    $LA["header"] = $layout["header"];
    $LA["footer"] = $layout["footer"];
    $LA["name"] = "Copy Default-" . rand(9, 99);
    $db->insert("tbl_email_layout", $LA);
    echo "<div id='notification' class='successbox'>" . $LNG["datadeletesuccessfully"] . "</div>";
}
echo "\n\n<div class=\"groupstabes first\" >\n  <h2>\n    <span class=\"groupstabesheadertext\">Mail Template Layout</span>\n  </h2>\n  <div class=\"groupstabescontant\">\n\n  <table id=\"main_tbl\" >\n\n<tr>\n     <td>\n         <form id=\"newpage\" name=\"\" method=\"post\" class=\"py-3\">\n            <input type=\"text\" align=\"right\" id=\"layout\" name=\"layout\" placeholder=\"Layout Name\" />\n            <input type=\"button\" name=\"go\" value=\"Add\" onclick=\"redirect();\"/>\n         </form>\n    </td>\n    <td></td>\n</tr>\n\n\n";
$req1 = dquery("SELECT * from tbl_email_layout");
while ($data1 = mysqli_fetch_assoc($req1)) {
    echo "<tr>        <td>\n        ";
    echo $data1["name"];
    echo "        ";
    if ($data1["id"] == 1) {
        echo "&nbsp; &nbsp; (You can not delete or edit default layout, you can copy and create your custom layout)";
    }
    echo "        </td>\n\n           <td align='right' class='action'>\n\n";
    if ($data1["id"] == 1) {
        echo "    <a class=' default_dg_a2 copydata'\n       href=\"javascript:load_subpage('main2.php?page=emailtemplate.layout&copy=";
        echo $data1["id"];
        echo "','Copy Layout')\">\n       Copy </a>\n    ";
    } else {
        echo "    <a class='default_dg_a2 editdata'\n       href=\"javascript:load_subpage('main2.php?page=emaillayout.edit&id=";
        echo $data1["id"];
        echo "','Edit Template Layout')\">\n        ";
        echo $LNG["edit"];
        echo " </a>\n\n<a class='default_dg_a2 deletedata' style='color:red !important;'\nonclick=\"return confirm('Are you sure want to remove  template layout?');\"\n href=\"javascript:redirectedit('mailsetting','";
        echo $data1["id"];
        echo "&laoddefaultpage=emailtemplate.layout.php&delete=true')\">";
        echo $LNG["delete"];
        echo "</a> </td>\n";
    }
    echo "</tr>";
}
echo "</table>\n</div></div>\n\n\n</div></div>\n";
$fileverioncheck = "6.1.0";

?>