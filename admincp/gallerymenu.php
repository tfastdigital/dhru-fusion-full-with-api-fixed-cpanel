<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

namespace gmenu;

include "3rdparty/phpfiletree/php_file_tree.php";
echo "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.1//EN\" \"http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd\">\n\n<html xmlns=\"http://www.w3.org/1999/xhtml\">\n\t<head>\n\t\t<title>Fusion Dhru</title>\n\t\t<meta http-equiv=\"Content-Type\" content=\"text/html;charset=utf-8\" />\n\t\t<link href=\"3rdparty/phpfiletree/styles/default/default.css\" rel=\"stylesheet\" type=\"text/css\" media=\"screen\" />\n\t\t<script src=\"3rdparty/phpfiletree/php_file_tree.js\" type=\"text/javascript\"></script>\n\t</head>\n";
echo php_file_tree("../../images/gallery/", "javascript:alert('You clicked on [link]');");
echo "\t</body>\n</html>";
class gmenu
{
}

?>