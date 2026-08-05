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
if ($reset) {
    $key = array_keys($reset);
    $shoppingcartFile = "../templates/default/css/style.css";
    $resetFile = "../templates/default/css/" . $key[0] . ".css";
    $data = file_get_contents($resetFile);
    $handle = fopen($shoppingcartFile, "w+");
    fwrite($handle, $data);
    require "tmp/color_default.txt";
    $color = ${"_" . $key[0]};
    $newcolor = "\$color=array(";
    foreach ($color as $key => $value) {
        $newcolor .= "'" . $key . "'=>'" . $value . "',";
    }
    $newcolor .= ") ?>";
    $newvariableFile = "tmp/color_default.txt";
    $handle = fopen($newvariableFile, "r");
    $data = file_get_contents($newvariableFile);
    fclose($handle);
    $data = preg_replace("/\\\$color=.*/", $newcolor, $data);
    $data = preg_replace("/(^[\r\n]*|[\r\n]+)[\\s\t]*[\r\n]+/", "\n", $data);
    $handlew = fopen($newvariableFile, "w");
    fwrite($handlew, $data);
    fclose($handlew);
    echo "<div id=notification1 class=successbox>" . $LNG["successfully"] . " " . $LNG["reset"] . "</div>";
}
if ($delete) {
    $key = array_keys($delete);
    unlink("../templates/default/css/" . $key[0] . ".css");
    require "tmp/color_default.txt";
    $newvariableFile = "tmp/color_default.txt";
    $handle = fopen($newvariableFile, "r");
    $data = file_get_contents($newvariableFile);
    fclose($handle);
    $data = preg_replace("/ [\$]*_" . $key[0] . "=.*/", " ?>", $data);
    $data = preg_replace("/\\<\\? \\?\\>/", "", $data);
    $data = preg_replace("/(^[\r\n]*|[\r\n]+)[\\s\t]*[\r\n]+/", "\n", $data);
    $handlew = fopen($newvariableFile, "w");
    fwrite($handlew, $data);
    fclose($handlew);
    echo "<div id=notification1 class=successbox>" . $LNG["successfully"] . " " . $LNG["delete"] . "</div>";
}
echo "\n<input type=\"hidden\" value=\"";
echo $id;
echo "\" name=\"id\"/>\n";
echo generate_token("form");
echo "<table id=\"main_tbl\" border=\"0\">\n            <thead>\n              <tr>        \n                <th>";
echo $LNG["preview"];
echo "</th>                          \n                <th>";
echo $LNG["created"];
echo " ";
echo $LNG["date"];
echo "</th>\n                <th>";
echo $LNG["action"];
echo "</th>               \n              </tr>\n            </thead>\n            <tbody>              \n                ";
$handle = opendir("../templates/default/css");
$i = 0;
while (false !== ($file = readdir($handle))) {
    if ($file != "." && $file != ".." && $file != "style.css" && $file != "master.css" && $file != "invoice.css" && $file != "tooltip.css" && $file != "tm.css") {
        $time = explode(".", $file);
        if ($time[0] != "") {
            $datetime = date("Y-M-d h:i", $time[0]);
            echo "<tr><td><a href=includes/pages/templatepreviewdefault.php?id=" . $time[0] . "  class=jTip id=" . $time[0] . ">View</a></td><td>" . $datetime . "</td><td>";
            echo "\t                            <form id=\"frmtemplate\" name=\"form[";
            echo $time[0];
            echo "]\" method=\"post\">\n\t                                <input type=\"hidden\" value=\"templatelist.php\" name=\"laoddefaultpage\"/>\n\t                                <input value='";
            echo $LNG["rollback"];
            echo "' name='reset[";
            echo $time[0];
            echo "]' class='button' type='submit'/>\n\t                                <input value='";
            echo $LNG["delete"];
            echo "' name='delete[";
            echo $time[0];
            echo "]' class=\"button_remove\" type='submit'/>\n\t                           </form>                                \n\t                            ";
        }
    }
}
echo "</tbody></table>\n</div></div> \n</div>";
$fileverioncheck = "6.1.0";

?>