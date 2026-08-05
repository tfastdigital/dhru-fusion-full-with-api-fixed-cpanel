<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

licince\chkLitePlus();
licince\chklite();
$pageid = 207;
checkPagePermission($pageid);
include_once ROOTDIR . "/includes/clients.fun.inc.php";
$clientDetails = getSupplierDetails($id);
$cur = dquery("SELECT *\nFROM tbl_currencies\nORDER BY `default` DESC ");
while ($rc = mysqli_fetch_assoc($cur)) {
    $imeicnt = mysqli_fetch_assoc(dquery("SELECT count(order_id) as cnt,\n    sum(purchase_cost) as tot from tbl_order_imei where reply_by_sup='" . $id . "'\n     AND user_can_c='4' and currency_id='" . $rc["id"] . "'"));
    $filecnt = mysqli_fetch_assoc(dquery("SELECT count(order_id) as cnt,\n    sum(purchase_cost) as tot from tbl_order_file where reply_by_sup='" . $id . "'\n     AND user_can_c='4' and currency_id='" . $rc["id"] . "'"));
    $sercnt = mysqli_fetch_assoc(dquery("SELECT count(order_id) as cnt,\n    sum(purchase_cost) as tot from tbl_order_server where reply_by_sup='" . $id . "'\n     AND user_can_c='4' and currency_id='" . $rc["id"] . "'"));
    $shopcnt = mysqli_fetch_assoc(dquery("SELECT count(order_id) as cnt,\n    sum(purchase_cost) as tot from tbl_order_product where reply_by_sup='" . $id . "'\n     AND user_can_c='4' and currency_id='" . $rc["id"] . "'"));
    if ($_SESSION["currency"]["id"] != $rc["id"]) {
        $imeicnt["tot"] = convertCurrency($imeicnt["tot"], $rc["id"], $_SESSION["currency"]["id"]);
        $filecnt["tot"] = convertCurrency($filecnt["tot"], $rc["id"], $_SESSION["currency"]["id"]);
        $sercnt["tot"] = convertCurrency($sercnt["tot"], $rc["id"], $_SESSION["currency"]["id"]);
        $shopcnt["tot"] = convertCurrency($shopcnt["tot"], $rc["id"], $_SESSION["currency"]["id"]);
    }
    $oi += $imeicnt["cnt"];
    $of += $filecnt["cnt"];
    $os += $sercnt["cnt"];
    $oh += $shopcnt["cnt"];
    $imeitot += $imeicnt["tot"];
    $filetot += $filecnt["tot"];
    $servertot += $sercnt["tot"];
    $shoptot += $shopcnt["tot"];
}
$paid = mysqli_fetch_assoc(dquery("SELECT sum(amount) as tot \nfrom tbl_statement_supplier where supplier_id='" . $id . "'"));
echo "<div id=\"notification\" class=\"info\">";
$ded = $paid["tot"] - ($imeitot + $filetot + $servertot + $shoptot);
if ($ded < 0) {
    echo "You own " . $ded . " credit to :" . $clientDetails["username"];
} else {
    echo $clientDetails["username"] . " own " . $ded . " credit to You";
}
echo "</div><div id=\"content\"><div id=\"content_padded\">\n\n<div  class=\"groupstabes\" >\n  <h2>    \n    <span class=\"groupstabesheadertext\">Supplier Account Information</span>\n  </h2>\n  <div class=\"groupstabescontant\">\n  \n<table class=\"form\" border=\"0\" cellpadding=\"2\" cellspacing=\"2\" width=\"100%\">\n<tbody>\n  <tr>\n    <td class=\"fieldlabel\" >";
echo $LNG["totorderplaced"];
echo " :\n     ";
echo $oi + $of + $os + $oh;
echo " </td><td  \n     class=\"fieldarea\">";
echo round($imeitot + $filetot + $servertot + $shoptot, $precision);
echo " ";
echo $config["base_currency"];
echo "</td>\n  </tr> \n  <tr>\n    <td class=\"fieldlabel\" >";
echo $LNG["youpaidto"];
echo " : \n    ";
echo $clientDetails["username"];
echo "</td><td  class=\"fieldarea\">";
echo round($paid["tot"], $precision);
echo "  ";
echo $config["base_currency"];
echo "</td>\n  </tr>   \n  <tr>\n    <td class=\"fieldlabel\" >\n    ";
if (0 <= $ded) {
    echo "<div style='color:green'>Credit Balance: ";
} else {
    echo "<div style='color:red'>Pending Payout: ";
}
echo "</div> </td><td width=\"85%\"  class=\"fieldarea\">";
if (0 <= $ded) {
    echo "<div style='color:green'>";
} else {
    echo "<div style='color:red'>";
}
echo " ";
echo round($paid["tot"], $precision);
echo " - ";
echo round($imeitot + $filetot + $servertot + $shoptot, $precision);
echo " = ";
echo round($ded, $precision);
echo "  ";
echo $config["base_currency"];
echo "</div>\n    </td>\n  </tr>    \n</tbody>\n</table>\n\n<br />\n<script>\nfunction setPayout(ob){\n  if(ob.value=='addtocredit'){\n    document.getElementById('uid').style.display='';\n  }else{\n    document.getElementById('uid').style.display='none';\n  }\n}\n</script>\n<form id=\"frmeditsupplier\" name=\"\" method=\"post\">\n";
echo generate_token("form");
echo "<input type=\"hidden\" name=\"id\" value=\"";
echo $id;
echo "\"/>\n<table class=\"form\">\n<tbody>\n  <tr>\n    <td class=\"fieldlabel\">";
echo $LNG["amount"];
echo "</td>\n    <td class=\"fieldarea\"> \n      <input name=\"credit\" id=\"credit\" value=\"\" type=\"text\" class=\"small_txt\"/>\n       ";
echo $config["base_currency"];
echo "      <small>Pay/Rebate supplier to track suppliers total order replied cost</small> &nbsp;&nbsp;&nbsp;\n      <small> ";
echo $LNG["rebateinfo"];
echo " </small>\n    </td>\n  </tr>\n  <tr>\n    <td class=\"fieldlabel\">";
echo $LNG["payout"];
echo " ";
echo $LNG["type"];
echo "</td>\n    <td class=\"fieldarea\">\n<select name=\"ptype\" onchange=\"setPayout(this);\">\n<option value=\"other\">Other</option>     \n<option value=\"paypal\">Paypal</option>\n<option value=\"addtocredit\">Add to Credit</option>\n</select>\n    <span id=\"uid\" style=\"display: none;\">User ID:<input type=\"text\" name=\"uid\" style=\"width: 50px;\" /></span>\n    </td>\n  </tr> \n  <tr>\n    <td class=\"fieldlabel\">";
echo $LNG["notes"];
echo "</td>\n    <td class=\"fieldarea\">\n    <textarea name=\"note\" cols=\"45\" rows=\"3\"></textarea>\n       </td>\n  </tr> \n    <tr>\n    <td class=\"fieldlabel\">";
echo $LNG["invoicestransid"];
echo "</td>\n    <td class=\"fieldarea\">\n    <input type=\"text\" name=\"tid\"/>\n       </td>\n  </tr>   \n      \n</tbody>\n\n</table> \n\n<div class=\"fixedbtn\">\n    <input value=\"";
echo $LNG["payout"];
echo "\" id=\"btnedituser\"  class=\"btn save\" type=\"button\"\n onclick=\"SubmitForm ('#btnedituser','editsupplier.account','#frmeditsupplier','#notification','true','#main_loader');\"/>\n</div>\n\n</form>\n</div></div>\n\n\n</div> <script>\nfunction setunlimited(ids)\n{\n    document.getElementById(ids).value='-1';\n}</script>";
$fileverioncheck = "6.1.0";

?>