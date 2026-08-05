<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

echo "<!--<iframe id=\"content_\"  frameborder=\"0\" src=\"main2.php\"></iframe>-->\n\n <div class=\"header-group\">\n    <h1 style=\"width: 249px; position: absolute;\" title=\"";
echo $shownewvermsg ? "New version available" : "";
echo "\" class=\"logo\"><div style=\"float: left;width:60%\"><img src=\"templates/default/images/dhru-logo2.png\" style=\"max-width: 100%;\"/></div> <div style=\"float: left;font-weight:normal;font-size: 13px;font-weight:100;text-align:left;letter-spacing: 1px;padding: 8px;\"> Fusion <br /> <span class=\"version ";
if ($shownewvermsg) {
    echo " new ";
}
echo "\"> ";
if ($shownewvermsg) {
    echo "<span style='cursor:pointer;' onclick='javascript:load_page(\"help.selfupdate\",\"Self Update\")'>  v " . $licinfo["current"] . " " . $licinfo["releasecandidate"] . "</span>";
} else {
    echo "v " . $config["version"] . " " . $config["release_candidate"];
}
echo "</span></div> </h1>\n     \n     <div style=\"position: relative; left: 0px; right: 0px; margin: 0 68px 0 256px;height:60px;overflow: hidden;\"> \n        <a href=\"#\" onclick=\"slideleftin('#tabs-group','fullwidth')\" class=\"btn btn-default tab-ctrl\" style=\"position: absolute;left:0;width:22px;\"> &lang;</a>\n          <ul class=\"nav nav-tabs\" id=\"tabs-group\" style=\"\">\n           \n            <div class=\"tabs-controlar\">    \n                <div class=\"btn-group btn-group-sm pull-right\">    \n                      \n                </div>\n            </div>\n         \n          </ul>  \n      <a onclick=\"slideleftout('#tabs-group','fullwidth')\" class=\"btn btn-default  tab-ctrl\" href=\"#\"  style=\"position: absolute;right:35px;width:22px;\">&rang;</a> \n      <span style=\"position: absolute; color: white; cursor: pointer;  top: 15px;border-radius: 50%; font-size: 14px; padding: 5px 10px; right: 0px;display:none !important\" class=\"tab-close\" title=\"Close Active Tab\" onclick=\"javascript:closeCurrent();\"> <i class=\"flaticon-close-1\"></i> </span>\n  </div>\n <div class=\"ap\" style=\"position: absolute; right: 0px; top: 0px; text-align: right; height: 60px; \">   \n        <span style=\"color: white; position: absolute; bottom: 4px; left: 5px; font-size: 14px;\"></span>\n         ";
if (is_file("../images/avtar/" . $_SESSION["adminid"] . "_avtar.jpg")) {
    $avatar = "../images/avtar/" . $_SESSION["adminid"] . "_avtar.jpg";
    echo "                    <img src=\"";
    echo $avatar;
    echo "\" style=\"width: 35px; margin-top: 13px; border-radius: 50%; opacity: 1; margin-left: 16px; margin-right: 16px;cursor: pointer;box-shadow:0px 0 5px rgba(0,0,0,0.3)\" onclick=\"\$('.header-dropdown').toggle()\" />\n                ";
} else {
    echo "                    <div style=\"text-transform: uppercase;font-size: 13px;margin:7px 7px 0 0; padding:14px;background:#ee6c22;color:white;border-radius:50%;cursor: pointer;\"  onclick=\"\$('.header-dropdown').toggle()\">\n                        ";
    echo substr($_SESSION["adminname"], 0, 2);
    echo "                    </div>\n                ";
}
echo "              \n        <ul class=\"header-dropdown\" style=\"display: none;width:350px;border-radius:0 0 0 10px\">\n            <div style=\"float: left;\">\n                ";
if ($avatar) {
    echo "                            <img src=\"";
    echo $avatar;
    echo "\" style=\"width: 70px; margin: 13px; border-radius: 50%; opacity: 1;\"/>\n                        ";
} else {
    echo "                <div style=\"text-transform: uppercase;font-size: 30px;padding:20px 20px;background:#ee6c22;color:white;border-radius:50%\">\n                    ";
    echo substr($_SESSION["adminname"], 0, 2);
    echo "                </div>                \n                ";
}
echo "                \n            </div>\n            <div class=\"admin-links\" style=\"text-align: left; float: left; margin-left: 10px; margin-top: 10px;\"><span style=\"font-size:18px\">";
echo $_SESSION["adminname"];
echo "</span> <br />  <small>(";
echo $_SESSION["adminrole"];
echo ")</small> <br />\n                 ";
$sql = dquery("SELECT tbl_loginlog_admin.username as loginfrom,tbl_loginlog_admin.ip,time \nFROM `tbl_loginlog_admin`,tbl_admin where userid=tbl_admin.id and tbl_admin.id=" . $_SESSION["adminid"] . " order by time DESC limit 1,1");
while ($row = mysqli_fetch_assoc($sql)) {
    $ip = $row["ip"];
    $date = $row["time"];
}
echo "     \n                 <small>Last Login ip : ";
echo $ip;
echo "</small>   <br />\n                 <small>Last Login Time : ";
echo date("d-m-Y h:i", $date);
echo "</small>          \n                 <div style=\"height: 1px;border-top: #ccc solid 1px;margin:10px 0\"></div>\n                \n                <a href=\"";
echo $config["site_address"];
echo "\" target=\"_blank\">";
echo $LNG["clientarea"];
echo "</a>                                             \n                <a  href=\"javascript:load_page('editadmin&admn=";
echo $_SESSION["adminid"];
echo "','";
echo $LNG["myaccount"];
echo "','";
echo $token;
echo "','";
echo rand(100, 1000);
echo "')\">My Account </a> \n                <a href=\"logout.php\" style=\"color: black;\">";
echo $LNG["logout"];
echo "</a> \n                 \n            </div>\n            \n            <div class=\"clear\"></div>\n                                      \n         </ul>        \n  </div> \n  \n  </div>\n  \n  <style>    \n    .admin-links{padding-bottom:10px}\n    .admin-links a{font-size:14px;color:#777;margin-right: 10px;text-decoration: none;}\n  </style>\n     \n  <div class=\"tab-content\" id=\"tabContent\"></div> ";

?>