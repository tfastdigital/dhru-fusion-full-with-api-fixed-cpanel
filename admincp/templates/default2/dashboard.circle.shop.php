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
$table = ["tbl_order_product"];
$defaultprogress = 3;
$today = date("Y-m-d", time());
$yesterday = date("Y-m-d", time() - 86400);
$month = date("m", time());
$pmonth = date("m", mktime(0, 0, 0, date("m") - 1, date("d"), date("Y")));
$year = date("Y", time());
$pyear = date("Y") - 1;
$startTime = mktime(0, 0, 0, date("m"), 1, date("Y"));
$startYear = mktime(0, 0, 0, 1, 1, date("Y"));
$condition = ["totalorder" => "(1=1) ", "totalnew" => " user_can_c=0", "totalaccepted" => " user_can_c=1", "todaystotal" => "date='" . $today . "'", "todaysnew" => " date='" . $today . "' and user_can_c=0", "todaysaccepted" => " date='" . $today . "' and user_can_c=1", "todaysrejected" => " date='" . $today . "' and user_can_c=3", "todayscompleted" => " reply_date='" . $today . "' and (user_can_c=4)", "verify" => "verified=1 and user_can_c=4 ", "yestotal" => " date='" . $yesterday . "'", "yesaccepted" => " date='" . $yesterday . "' and user_can_c=1", "yescompleted" => " reply_date='" . $yesterday . "' and ( user_can_c=4)", "frommonth" => "time>=" . $startTime, "fromyear" => "time>=" . $startYear];
foreach ($table as $tbl) {
    foreach ($condition as $key => $cnd) {
        $ord = mysqli_fetch_assoc(dquery("select count(*) as total from " . $tbl . " where " . $cnd . " "));
        $order[$tbl][$key] = $ord["total"];
    }
}
echo "         <table style=\"text-align: center !important;\">\n            <tr>                \n                <td> <div class=\"panel-box\" style=\"margin-right: 0;\"> <div class=\"shop order-box\"><a onclick=\"javascript:load_fromsubpage('productorder','Shop Order');\"> SHOP ORDER </a></div> <div class=\"left\" style=\"width: 50% !important; border-right: 1px solid rgb(238, 238, 238); box-sizing: border-box;\">  <a onclick=\"javascript:load_fromsubpage('productorder&laoddefaultpage=productorder.new.php','";
echo $LNG["shop"];
echo " ";
echo $LNG["accepted"];
echo "');\"> <h3>";
echo $order["tbl_order_product"]["totalnew"];
echo "</h3> </a>  <small> New </small>  </div><div class=\"left\" style=\"width: 50% !important;\">  <a onclick=\"javascript:load_fromsubpage('productorder&laoddefaultpage=productorder.replied.php','";
echo $LNG["new"];
echo " ";
echo $LNG["accepted"];
echo "');\"> <h3>";
echo $order["tbl_order_product"]["totalaccepted"];
echo "</h3> </a>  <small> Accepted </small>  </div> <div class=\"clear\"></div>  </div> </td>\n            </tr>\n         </table>\n    \n        ";
$fileverioncheck = "6.1.0";

?>