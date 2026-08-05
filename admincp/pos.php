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
require "../comm.php";
if (!$_SESSION["adminid"]) {
    echo "<div align=\"center\"><h3>Session expired. <a style=\"color: #666;\" href=\"index.php?main2redirect=true\">Please relogin</a></h3></div>";
    $_SESSION["admin_afterlogin_re"] = $_SERVER["REQUEST_URI"];
    exit;
}
print_r($_SESSION["SALES"]);
echo "<html  >\r\n<head>\r\n\r\n\r\n\r\n</head>\r\n<body ng-app='pos' ng-controller='posCntr' >\r\n\r\n\r\n<input type=\"text\" name=\"serial\"  ng-model=\"serial\"\r\nng-enter='postSerial()' placeholder=\"Enter Serial Number\" />\r\n {{RESULT}}\r\n<div style=\"clear: both;\"></div>\r\n\r\n<div ng-controller=\"safeCtrl\">\r\n<!--\r\n<button type=\"button\" ng-click=\"addRandomItem(row)\"  \r\nclass=\"btn btn-sm btn-success\">\r\n<i class=\"glyphicon glyphicon-plus\"></i> Add Item\r\n</button>\r\n-->\r\n<table st-table=\"displayedCollection\" st-safe-src=\"rowCollection\" \r\nclass=\"table table-striped\">\r\n<thead>\r\n<tr>\r\n\t<th st-sort=\"Item\">Item</th>\r\n\t<th st-sort=\"Qnt\">Qnt</th>\r\n\t<th st-sort=\"Price\">Price</th>\r\n\t<th st-sort=\"Discount\">Discount</th>\r\n    <th st-sort=\"Total\">Toal</th>\r\n</tr>\r\n</thead>\r\n<tbody>\r\n<tr ng-repeat=\"row in displayedCollection\">\r\n\t<td>{{row.Item}}</td>\r\n\t<td><input ng:model=\"row.Qnt\" size=\"2\" type=\"text\" \r\n        name=\"qnt[]\" value=\"{{row.Qnt}}\" /></td>\r\n\t<td><input ng:model=\"row.Price\" size=\"8\" type=\"text\" \r\n        name=\"price[]\" value=\"{{row.Price}}\" /></td>\r\n\t<td><input ng:model=\"row.Discount\" size=\"2\" type=\"text\" \r\n        name=\"disc[]\" value=\"{{row.Discount}}\" /></td>\r\n    <td>{{(row.Qnt*row.Price)-((row.Qnt*row.Price)*row.Discount/100)}}</td>\r\n\t<td>\r\n\t<button type=\"button\" ng-click=\"removeItem(row)\" \r\n           class=\"btn btn-sm btn-danger\">\r\n\t\t<i class=\"glyphicon glyphicon-remove-circle\">X</i>\r\n\t</button>\r\n\t</td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n\r\n</div>\r\n\r\nSubtotal: {{sub()}} <br />\r\n<div ng-repeat=\"tax in Taxes\">\r\n    {{tax.name}} {{tax.rate}} %:  {{(sub()*tax.rate/100)}}\r\n</div>\r\nTotal   : {{total()}} <br />\r\n\r\n\r\n<script src=\"includes/js/angular.min.js\"></script>\r\n<script src=\"includes/js/angular-route.min.js\"></script>\r\n<script src=\"includes/js/pos.js\"></script>\r\n\r\n</body>\r\n</html>\r\n\r\n<!---\r\n\r\nhttp://codepen.io/BrianGenisio/pen/xdBca?editors=101\r\n\r\n-->";

?>