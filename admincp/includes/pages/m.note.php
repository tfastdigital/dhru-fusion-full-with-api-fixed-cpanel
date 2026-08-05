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
$sql = mysqli_fetch_assoc(dquery("select notes from tbl_admin where id=" . $_SESSION["adminid"]));
echo "  <div id=\"notificationdt\"></div>\n\n<div class=\"content\">\n        <div class=\"panel\">\n\n  <form method=\"post\" id=\"frmadd\">\n  <input type=\"hidden\" name=\"id\" value=\"";
echo $id;
echo "\" />\n            <h2>Admin Note</h2>\n            <ol>\n                <li class=\"field\">\n                    <label>\n           <textarea style=\"height: 80%;\" name=\"note\">";
echo $sql["notes"];
echo "</textarea>\n                    </label>\n                </li>\n                <li class=\"field\">\n                    <label>\n<a class=\"btn\" id=\"btnedituser\"\n onclick=\"SubmitForm ('#btnedituser','m.note','#frmadd','#notificationdt','false','');\" >";
echo $LNG["save"];
echo "</a>\n                    </label>\n                </li>\n\n            </ol>\n   </form>\n        </div>\n</div>\n\n\n\n\n\n\n\n\n\n\n";

?>