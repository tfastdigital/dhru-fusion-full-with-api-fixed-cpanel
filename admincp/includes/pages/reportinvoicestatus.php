<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

$pageid = 350;
checkPagePermission($pageid);
echo "\n    <div id=\"content\">\n    <div id=\"content_padded\">\n<form method=\"post\">\n    <fieldset class=\"search-form mb-1\">\n        <legend>Filter by Date</legend>\n        <div class=\"row\" style=\"width: 450px;\">\n        <input type=\"text\"  class=\"txt col mr-1 datepicker\"   autocomplete=\"off\"  name=\"fromdate\" value=\"\" placeholder=\"yyyy-mm-dd\" id=\"from\" />\n\n        <input type=\"text\"  class=\"txt col  mr-1 datepicker\"  autocomplete=\"off\" name=\"todate\" value=\"\" placeholder=\"yyyy-mm-dd\" id=\"to\" />\n\n        <input type=\"submit\" class=\"btn btn-primary\" name=\"finder\" value=\"";
echo $LNG["search"];
echo "\" />\n        </div>\n    </fieldset>\n</form>\n    </div>\n    </div>\n\n<div id=\"tabcontent\">\n\n    ";
$Hold = [];
$Collection = [];
$Completed = [];
$WHERE = "";
if ($finder) {
    $WHERE = " and (date between '" . $fromdate . "' and '" . $todate . "')";
}
$q = dquery("select * from tbl_currencies");
while ($r = mysqli_fetch_assoc($q)) {
    $curt = mysqli_fetch_assoc(dquery("select sum(total) as tot from \n    tbl_invoices  where status='Unpaid' and adminid!='' and onhold=0\n    and userid in (select id from tblUsers where default_currency='" . $r["id"] . "') " . $WHERE));
    if ($curt["tot"]) {
        $Collection[$r["id"]] = [$curt["tot"], $r["code"]];
    }
    $curt = mysqli_fetch_assoc(dquery("select sum(total) as tot from \n    tbl_invoices  where (status='Paid' or (status='Unpaid' and onhold=1) )\n    and userid in (select id from tblUsers where default_currency='" . $r["id"] . "') " . $WHERE));
    if ($curt["tot"]) {
        $Completed[$r["id"]] = [$curt["tot"], $r["code"]];
    }
}
echo "    <script>\n        function filterby(currencyid)\n        {\n            location.href='main2.php?page=unpaidinvoice&_ff_onSUBMIT_FILTER=Search&_ff_tblUsers_default_currency='+currencyid;\n        }\n        function filterby1(currencyid)\n        {\n            location.href='main2.php?page=invoicereport&currency='+currencyid+'&paidonly=1';\n        }\n    </script>\n    <div class=\"mt-4\">\n        <h3>Pending Collections Unpaid Invoices</h3>\n        ";
$i = 1;
foreach ($Collection as $id => $detail) {
    if (count($Collection) == $i) {
        echo "<span onclick='filterby(" . $id . ")' style='font-size:30px; cursor:pointer;margin-right:30px;color:#ad0808'>" . $detail[0] . " <small style='color:gray'> " . $detail[1] . " </small> </span>   ";
    } else {
        echo "<span onclick='filterby(" . $id . ")' style='font-size:30px; cursor:pointer;margin-right:30px;color:#ad0808'> " . $detail[0] . " <small style='color:gray'> " . $detail[1] . " </small>   </span>  ";
    }
    $i++;
}
echo "    </div>\n<br /><br />\n    <div>\n        <h3>Paid Invoices</h3>\n        ";
$i = 1;
foreach ($Completed as $id => $detail) {
    if (count($Completed) == $i) {
        echo "<span onclick='filterby1(" . $id . ")' style='font-size:30px; cursor:pointer;margin-right:30px;color:#0B7500'>" . $detail[0] . " <small style='color:gray'> " . $detail[1] . " </small> </span>   ";
    } else {
        echo "<span onclick='filterby1(" . $id . ")' style='font-size:30px; cursor:pointer;margin-right:30px;color:#0B7500'> " . $detail[0] . " <small style='color:gray'> " . $detail[1] . " </small>   </span>  ";
    }
    $i++;
}
echo "    </div>\n\n\n</div>\n";
$fileverioncheck = "6.1.0";

?>