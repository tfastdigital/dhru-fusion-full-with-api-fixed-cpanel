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
if (isset($_SESSION["adminid"])) {
    $id = $_SESSION["adminid"];
    $admin_info = mysqli_fetch_assoc(dquery("SELECT * FROM `tbl_admin` WHERE `id`='" . $id . "' "));
}
echo "<div id=\"notificationmy\"></div>\n<div class=\"content\">\n     <div class=\"panel\">\n     <h2>My Account [";
echo $admin_info["username"];
echo "]</h2>\n<form method=\"post\" id=\"frmadd\">\n<input type=\"hidden\" name=\"mobile\" value=\"true\" />\n  <input type=\"hidden\" name=\"id\" value=\"";
echo $id;
echo "\" />\n    <input type=\"hidden\" name=\"admn\" value=\"";
echo $id;
echo "\" />\n";
echo generate_token("form");
echo "             <ol>\n                 <li class=\"field\">\n                 <label>";
echo $LNG["password"];
echo ":\n    <input name=\"password\"  value=\"\" type=\"password\" />\n                 </label>\n                </li>                 \n                 <li class=\"field\">\n                 <label>";
echo $LNG["firstname"];
echo ":\n    <input name=\"firstname\"  value=\"";
echo $admin_info["firstname"];
echo "\" type=\"text\" />\n                 </label>\n                </li>   \n                <li class=\"field\">\n                 <label>";
echo $LNG["lastname"];
echo ":\n    <input name=\"lastname\"  value=\"";
echo $admin_info["lastname"];
echo "\" type=\"text\" />\n                 </label>\n                </li>  \n                <li class=\"field\">\n                 <label>";
echo $LNG["contact"];
echo " ";
echo $LNG["no"];
echo "    <input name=\"contact\" value=\"";
echo $admin_info["contact"];
echo "\" type=\"text\" />\n                 </label>\n                </li>    \n                 <li class=\"field\">\n                 <label>";
echo $LNG["email"];
echo "   <input name=\"email\" value=\"";
echo $admin_info["email"];
echo "\" type=\"text\" />\n                 </label>\n                </li>   \n                 <li class=\"field\">\n                 <label>\n<a class=\"btn\" id=\"btneditadmin\" onclick=\"SubmitForm ('#btneditadmin','editadmin','#frmadd','#notificationmy','false','');\" >";
echo $LNG["save"];
echo "</a>\n                 </label>\n                </li>                                                                            \n             </ol>\n</form>             \n     </div>\n</div>       \n";

?>