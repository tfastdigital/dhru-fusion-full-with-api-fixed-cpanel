<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

if ($id) {
    $row = mysqli_fetch_assoc(dquery("select * from tblPaymentAggregator where  aggregatorid='" . $id . "'"));
    $Gateway = json_decode($row["gateway"], true);
}
echo "<script>\n    function removeGateway(gat){\n        \$(\".gat\"+gat).remove();\n    }\n</script>\n    <div id=\"notification\"></div>\n    <div id=\"content\">\n        <div id=\"content_padded\" class=\"groupstabescontant\">\n\n                <form id=\"frm\" name=\"\" method=\"post\">\n                    <input type=\"hidden\" name=\"edit\" value=\"true\" />\n                    ";
echo generate_token("form");
echo "                    <input type=\"hidden\"  name=\"aggregatorid\" value=\"";
echo $id;
echo "\"/>\n                    <table class=\"form\" border=\"0\" cellpadding=\"3\" cellspacing=\"2\" width=\"100%\" style=\"width: 100%;\">\n                        <tbody>\n                        <tr>\n                            <td class=\"fieldlabel\">";
echo $LNG["aggregator"];
echo " ";
echo $LNG["name"];
echo "</td>\n                            <td class=\"fieldarea\">\n\n         <input name=\"aggregatorname\"  id=\"page\" value=\"";
echo $row["aggregatorname"];
echo "\" type=\"text\"  class=\"txt medium\"/>\n\n                            </td>\n                        </tr>\n                        <tr>\n                            <td class=\"fieldlabel\">UIID</td>\n                            <td class=\"fieldarea\"><strong>";
echo $row["apikey"];
echo "</strong></td>\n                        </tr>\n                        <tr>\n                            <td class=\"fieldlabel\">Allowed IP from</td>\n                            <td class=\"fieldarea\">\n                                <textarea name=\"ip\" cols=\"30\" rows=\"5\" >";
echo $row["ip"];
echo "</textarea>\n                                <small>Allowed IP Range</small>\n\n                            </td>\n                        </tr>\n\n                        </tbody>\n                    </table>\n<table id=\"main_tbl\" >\n<thead>\n<tr>\n<th>Gateway</th>\n<th>Monthly Limit (";
echo $_SESSION["system_default_currency"]["code"];
echo ")</th>\n<th>Used Amount (";
echo $_SESSION["system_default_currency"]["code"];
echo ")</th>\n    <th>Default</th>\n    <th>Action</th>\n</tr>\n</thead>\n    <tr>\n        <td>\n            <select name=\"gatewayname\" >\n                <option value=\"\">Gateway</option>\n                ";
$q = dquery("select value,gateway from tbl_paymentgateways where setting='name' group by gateway");
while ($r = mysqli_fetch_assoc($q)) {
    echo "                    <option value=\"";
    echo $r["gateway"];
    echo "\">";
    echo $r["value"];
    echo "</option>\n                ";
}
echo "            </select>\n        </td>\n        <td><input type=\"text\" name=\"limit\" /></td>\n        <td></td>\n        <td><input type=\"radio\" name=\"default\" value=\"1\" checked=\"checked\" /></td>\n        <td><button type=\"button\"\n onclick=\"SubmitForm ('.btn','editaddaggregator','#frm','#notification','true','#main_loader');\"\n                    name=\"addgatea\" value=\"Add\" class=\"btn\" >Add</button> </td>\n    </tr>\n<tbody>\n";
foreach ($Gateway as $gat) {
    $gatewayname = mysqli_fetch_assoc(dquery("select value from tbl_paymentgateways where\n            gateway='" . $gat["gateway"] . "' and setting='name'"));
    echo "        <tr class=\"gat";
    echo $gat["gateway"];
    echo "\">\n            <td style=\"text-align: left\">";
    echo $gatewayname["value"];
    echo "</td>\n            <td style=\"text-align: left\"><input type=\"text\" size=\"10\" name=\"gateway[";
    echo $gat["gateway"];
    echo "]\" value=\"";
    echo $gat["limit"];
    echo "\" /></td>\n            <td style=\"text-align: left\"><input type=\"text\" size=\"10\" name=\"used[";
    echo $gat["gateway"];
    echo "]\" value=\"";
    echo $gat["used"];
    echo "\" /></td>\n            <td style=\"text-align: left\">\n                <input type=\"radio\" name=\"default\"\n                       ";
    if ($gat["default"]) {
        echo "checked";
    }
    echo "                       value=\"";
    echo $gat["gateway"];
    echo "\" />\n            </td>\n            <td>  <a onclick=\"return confirm('Are you sure want to remove Gateway?');\"  href=\"javascript:removeGateway('";
    echo $gat["gateway"];
    echo "')\" class=\"deletedata\">";
    echo $LNG["delete"];
    echo "</a></td>\n            </td>\n        </tr>\n        ";
}
echo "</tbody>\n</table>\n                    <div class=\"fixedbtn\">\n                        <input value=\"";
echo $LNG["save"];
echo "\" id=\"btnoverview\"\n                               onclick=\"SubmitForm ('#btnoverview','editpaymentaggregator','#frm','#notification','true','#main_loader');\"\n                               class=\"btn save\" type=\"button\"   />\n                    </div>\n\n\n\n                </form>\n\n        </div></div>\n    </div> </div>\n\n";
$fileverioncheck = "6.1.0";

?>