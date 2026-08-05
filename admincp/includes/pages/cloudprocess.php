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
if ($DEMOMODE) {
    echo "error: This function not enabled in demo mode .";
    exit;
}
echo "<style>\n/* progress bar container */\n#progressbar{\n        border:1px solid black;\n        width:200px;\n        height:20px;\n        position:relative;\n        color:black; \n}\n/* color bar */\n#progressbar div.progress{\n        position:absolute;\n        width:0;\n        height:100%;\n        overflow:hidden;\n        background-color:#369;\n}\n/* text on bar */\n#progressbar div.progress .text{\n        position:absolute;\n        text-align:center;\n        color:white;\n}\n/* text off bar */\n#progressbar div.text{\n        position:absolute;\n        width:100%;\n        height:100%;\n        text-align:center;\n}\n</style>\n \n<script src=\"includes/js/iframe.js\" type=\"text/javascript\"></script>\t\n<script src=\"includes/js/progressbar.js\" type=\"text/javascript\"></script>\n<div id=\"sync_status\" style=\"display:none; width: 100% !important;\">\n<br /><img  src=\"images/syncloader.gif\" border=\"0\" /><br /> <h3 class=\"textred\">please do not close until Synchronize completed</h3> <br /> </div><br />\n<iframe id=\"sync_iframe\" scrolling=\"auto\" style=\"border:1px solid #CCC; display:none; width:100%; height: 300px;position: relative;\" src=\"\"></iframe>\n<script>\n\nDownloadBanners('";
echo $_GET["type"];
echo "'); \nfunction DownloadBanners(type)\n{    \n    \$(\"#sync_status\").show();\n\t\$(\"#sync_iframe\").show();\n\t\$(\"#sync_button\").hide();\n    if(type=='banner'){\n        \$page=\"includes/pages/bannerdownload.php?bid=";
echo $id;
echo "\";\n    }\n    else if(type=='theme'){\n        \$page=\"includes/pages/themedownload.php?bid=";
echo $id;
echo "&checkpurchase=";
echo $checkpurchase;
echo "\";\n    }\n    \$(\"#sync_iframe\").src(\$page , function(duration){\n\t\t\t\$(\"#sync_status\").hide();\t\t \n\t\t\t\$(\"#sync_button\").show();\n      \t}\n    );\n}\n \n\$(\"#progressbar\").reportprogress(10);\n \n</script>\n";
$fileverioncheck = "6.1.0";
echo " ";

?>