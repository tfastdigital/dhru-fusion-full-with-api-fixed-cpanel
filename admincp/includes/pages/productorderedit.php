<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

$pageid = 186;
checkPagePermission($pageid);
$orderid = $id;
$Invoice = mysqli_fetch_assoc(dquery("select * from tbl_invoices where id='" . $orderid . "'"));
include_once ROOTDIR . "/includes/clients.fun.inc.php";
include_once ROOTDIR . "/includes/customfield.fun.inc.php";
$_ClientsDetails = getClientsDetails($Invoice["userid"]);
$Order = mysqli_fetch_assoc(dquery("select * from tbl_order_product\nwhere invoiceid='" . $orderid . "'"));
$result = dquery("SELECT * FROM `tbl_shipping_services` WHERE `status`='1'\n         ORDER BY gateway");
$Shippingarr = [];
while ($data = @mysqli_fetch_assoc($result)) {
    $Shippingarr[$data[id]] = $data["value"];
}
if (is_file("../images/avtar/" . $Invoice["userid"] . "_avtar.jpg")) {
    $avatar = "../images/avtar/" . $Invoice["userid"] . "_avtar.jpg";
}
echo "    <style>\n        .forceleft{\n            text-align: left !important;\n        }\n        .highlight{\n            background-color: #fcfcfc ;\n        }\n        .tooltiptext{\n            margin-top: 226px !important;\n        }\n    </style>\n    <script>\n        function multiple(val){\n            if(\$('.current'+val).css('display')!='none'){\n                \$(\".item\"+val).val('3');\n                \$('.mainitem'+val).addClass('highlight');\n            }else{\n                \$(\".item\"+val).val('1');\n                \$('.mainitem'+val).removeClass('highlight');\n            }\n            \$('.current'+val).toggle();\n            \$('.multi'+val).toggle();\n        }\n    </script>\n    <div id=\"notification\"></div>\n\n\n    <div id=\"content\">\n\n        <form method=\"post\" id=\"frmtrakc\">\n            <div id=\"content_padded\">\n                <div>\n\n                    <div  class=\"groupstabes\" >\n                        <div class=\"groupstabescontant\">\n                            <div class=\"\" style=\"float: left; border-right:#ddd solid 1px;padding-right:20px;margin-right: 20px;\">\n                                <h2><span class=\"groupstabesheadertext\">";
echo $LNG["user"];
echo "  ";
echo $LNG["detail"];
echo " </span> </h2>\n\n                                <a href=\"javascript:load_fromsubpage('edituser&id=";
echo $_ClientsDetails["id"];
echo "','";
echo $_ClientsDetails["username"];
echo "');\">\n\n\n                                    ";
if ($avatar) {
    echo "                                        <img src=\"";
    echo $avatar;
    echo "\" height=\"100\" style=\"border-radius: 50%;\"/>\n                                    ";
} else {
    echo "                                        <div style=\"text-transform: uppercase;font-size: 30px;padding:30px 0;background:rgb(63, 81, 181);color:white;border-radius:50%;width:100px;text-align: center;\">\n                                            ";
    echo substr($clientDetails["username"], 0, 2);
    echo "                                        </div>\n                                    ";
}
echo "                                </a>\n                                <div><span class=\"text-muted\"> ";
echo $LNG["name"];
echo " </span>\n                                    :  ";
echo $_ClientsDetails[firstname];
echo " ";
echo $_ClientsDetails[lastname];
echo "                                </div>\n                                <div><span class=\"text-muted\"> ";
echo $LNG["email"];
echo " </span>\n                                    :  ";
echo $_ClientsDetails[email];
echo "                                </div>\n                                <div><span class=\"text-muted\"> ";
echo $LNG["contact"];
echo " </span>\n                                    :  ";
echo $_ClientsDetails[phonenumber];
echo "                                </div>\n\n                            </div>\n                        </div>\n\n\n                        <div  class=\"groupstabes\" >\n                            <div class=\"groupstabescontant\">\n                                <div class=\"\" style=\"float: left; border-right:#ddd solid 1px;padding-right:20px;margin-right: 20px;\">\n                                    <h2><span class=\"groupstabesheadertext\">";
echo $LNG["shipping"];
echo "  ";
echo $LNG["detail"];
echo " </span> </h2>\n\n                                    <div><span class=\"text-muted\"> ";
echo $LNG["name"];
echo " </span>\n                                        :  ";
echo $Order[sh_firstname] ? $Order[sh_firstname] : $_ClientsDetails[firstname];
echo " ";
echo $Order[sh_lastname] ? $Order[sh_lastname] : $_ClientsDetails[lastname];
echo "                                    </div>\n                                    <div><span class=\"text-muted\"> ";
echo $LNG["email"];
echo " </span>\n                                        :  ";
echo $Order[sh_email] ? $Order[sh_email] : $_ClientsDetails[email];
echo "                                    </div>\n                                    <div><span class=\"text-muted\"> ";
echo $LNG["contact"];
echo " </span>\n                                        :  ";
echo $Order[sh_contact] ? $Order[sh_contact] : $_ClientsDetails[phonenumber];
echo "                                    </div>\n                                    <div><span class=\"text-muted\"> ";
echo $LNG["address"];
echo " </span>\n                                        :  ";
echo $Order[sh_address1] ? $Order[sh_address1] : $_ClientsDetails[address];
echo " <br/> ";
echo $Order[sh_address2] ? $Order[sh_address2] : $_ClientsDetails[address2];
echo "                                    </div>\n                                    <div><span class=\"text-muted\"> ";
echo $LNG["city"];
echo " </span>\n                                        :  ";
echo $Order[sh_city] ? $Order[sh_city] : $_ClientsDetails[city];
echo " ";
echo $Order[sh_zip] ? $Order[sh_zip] : $_ClientsDetails[zip];
echo "                                    </div>\n                                    <div><span class=\"text-muted\"> ";
echo $LNG["state"];
echo " </span>\n                                        :  ";
echo $Order[sh_state] ? $Order[sh_state] : $_ClientsDetails[state];
echo "                                    </div>\n                                </div>\n                            </div>\n\n\n                            <div  class=\"groupstabes\" >\n                                <div class=\"groupstabescontant\">\n                                    <div class=\"\" style=\"float: left; border-right:#ddd solid 1px;padding-right:20px;margin-right: 20px;\">\n                                        <h2><span class=\"groupstabesheadertext\">";
echo $LNG["payment"];
echo "  ";
echo $LNG["detail"];
echo " </span> </h2>\n                                        <span>\n        <a href=\"javascript:load_fromsubpage('edituser.editinvoice&id=";
echo $orderid;
echo "','#";
echo $orderid;
echo "');\">Invoice #";
echo $orderid;
echo "</a>\n    </span>\n                                        <div><span class=\"text-muted\"> ";
echo $LNG["status"];
echo " </span>\n                                            :  ";
if ($Invoice["onhold"] == 1) {
    echo "<span class='badge badge-warning'>On Hold</span>";
} else {
    if ($Invoice["status"] == "Unpaid" && 0 < $Invoice["receivedamount"]) {
        echo "<span class='badge info'>Partially Paid</span>";
    } else {
        if ($Invoice["status"] == "Unpaid") {
            echo "<span class='badge badge-danger'>Waiting Payment</span>";
        } else {
            if ($Invoice["status"] == "Cancel") {
                echo "<span class='badge badge-secondary'>" . $Invoice["status"] . "</span>";
            } else {
                echo "<span class='badge success'>" . $Invoice["status"] . "</span>";
            }
        }
    }
}
echo "                                        </div>\n                                        <div><span class=\"text-muted\"> ";
echo $LNG["date"];
echo "</span>\n                                            :  ";
echo $Invoice[date];
echo "                                        </div>\n                                        <div><span class=\"text-muted\"> ";
echo $LNG["paid"];
echo " ";
echo $LNG["amount"];
echo "</span>\n                                            :  ";
echo $Invoice[receivedamount];
echo "                                        </div>\n                                        <div><span class=\"text-muted\"> ";
echo $LNG["total"];
echo " ";
echo $LNG["amount"];
echo "</span>\n                                            :  ";
echo $Invoice[total];
echo "                                        </div>\n\n                                    </div>\n                                </div>\n                                <div  class=\"groupstabes\" >\n                                    <div class=\"groupstabescontant\">\n                                        <button onclick=\"window.open('includes/pages/packingslip.php?id=";
echo $orderid;
echo "',  'windowname1',  'width=700, height=800');   return false;\" class=\"btn btn-inverse\">Print Packaging Slip</button>\n\n                                        <button  onclick=\"window.open('includes/pages/viewproductinv.php?id=";
echo $orderid;
echo "',  'windowname1',  'width=900, height=800');   return false;\" class=\"btn btn-inverse\">Print Invoice</button>\n                                        <br/>\n                                        <div method=\"post\" id=\"frmupdate\"\n                                             style=\"float: left; padding: 10px; max-width:500px !important;\">\n                                            <input type=\"hidden\" name=\"orderid\" value=\"";
echo $orderid;
echo "\" />\n                                            <br/>\n                                            Staff ";
echo $LNG["notes"];
echo " <br />\n                                            <textarea name=\"notes\" cols=\"40\" class=\"textarea large\">";
echo $Invoice["notes"];
echo "</textarea>\n\n                                        </div>\n                                    </div>\n                                </div>\n\n\n                            </div>\n                        </div>\n\n                        <table id=\"main_tbl\" >\n                            <thead>\n                            <th>";
echo $LNG["product"];
echo "</th>\n                            <th>";
echo $LNG["price"];
echo "</th>\n                            <th>";
echo $LNG["weight"];
echo "</th>\n                            <th class=\"forceleft\">Fulfillment Status</th>\n\n                            <th>Shipping/Tracking</th>\n                            <th class=\"forceleft\">User notes</th>\n                            </thead>\n                            <tbody>\n                            ";
$total = 0;
$weights = 0;
$q = dquery("select group_concat(order_id) as ids,mep,(select service_name from tbl_products\nwhere id=service_id) as item,(select sku from tbl_products\nwhere id=service_id) as sku,service_id ,shipped_by,status,note,tracking, credit,(select weight from tbl_products where id=service_id) as weight\nfrom tbl_order_product where invoiceid='" . $orderid . "' group by service_id order by order_id asc");
while ($r = mysqli_fetch_assoc($q)) {
    $qnt = mysqli_num_rows(dquery("select order_id\n                            from tbl_order_product where service_id='" . $r["service_id"] . "'\n                            and invoiceid='" . $orderid . "'"));
    $total += $r["credit"] * $qnt;
    $weights += $r["weight"] * $qnt;
    echo "                                <tr class=\"mainitem";
    echo $r["service_id"];
    echo "\" >\n                                    <td>\n                                        <input type=\"hidden\" name=\"itemtype[";
    echo $r["service_id"];
    echo "]\" value=\"1\" class=\"item";
    echo $r["service_id"];
    echo "\" />\n\n                                        ";
    if (1 < $qnt) {
        echo "                                            <span class=\"tooltip\" style=\"cursor:pointer; font-size: 25px; line-height: 1px;  \"\n                                                  onclick=\"multiple('";
        echo $r["service_id"];
        echo "')\">+ <span class=\"tooltiptext ts\">Process Individual</span></span>\n\n                                            &nbsp;\n                                            ";
    }
    echo "                                        <span  onclick=\"multiple('";
    echo $r["service_id"];
    echo "')\" class=\"badge badge-secondary\">";
    echo $qnt;
    echo " x</span>\n                                        <a class=\"default_dg_a\" href=\"javascript:load_fromsubpage('editproduct&id=";
    echo $r["service_id"];
    echo "','";
    echo $r["item"];
    echo "')\">";
    echo $r["item"];
    if ($r["sku"]) {
        echo "<small> SKU: " . $r["sku"] . "</small>";
    }
    echo "</a>\n\n                                        <small >\n                                            <div style=\"padding-left: 60px; line-height: 5px;\">\n                                                ";
    $Custom = getCustomFields("product", $r["service_id"], $Order["order_id"]);
    if (count($Custom)) {
        echo "<br />&nbsp;";
    }
    foreach ($Custom as $cdetail) {
        $buff .= $cdetail["name"] . ": " . $cdetail["rawvalue"] . " ,";
    }
    echo trim($buff, ",");
    echo "</div></small>\n                                    </td>\n                                    <td ><span class=\"current";
    echo $r["service_id"];
    echo "\">";
    echo round($r["credit"] * $qnt, 2) . " " . $_ClientsDetails["currency"]["code"];
    echo "</span></td>\n                                    <td class=\"td-right\"><span class=\"current";
    echo $r["service_id"];
    echo "\">";
    echo round($r["weight"] * $qnt, 2);
    echo " Kg</span></td>\n\n                                    <td class=\"td-left forceleft\">\n\n                                        <div style=\"float: left;\" class=\"current";
    echo $r["service_id"];
    echo "\">\n                                            <select name=\"orderstatuss[";
    echo $r["service_id"];
    echo "]\">\n                                                <option ";
    if ($r["status"] == "new") {
        echo "selected";
    }
    echo " value=\"new\">New Order</option>\n                                                <option ";
    if ($r["status"] == "accepted") {
        echo "selected";
    }
    echo " value=\"accepted\">";
    echo $LNG["packed"];
    echo "</option>\n                                                <option ";
    if ($r["status"] == "cancelled") {
        echo "selected";
    }
    echo " value=\"cancelled\">Rejected</option>\n                                                <option ";
    if ($r["status"] == "dispatched") {
        echo "selected";
    }
    echo " value=\"dispatched\">Dispatched</option>\n                                                <option ";
    if ($r["status"] == "delivered") {
        echo "selected";
    }
    echo " value=\"delivered\">Delivered</option>\n                                            </select>\n                                        </div>&nbsp;\n                                    </td>\n                                    <td class=\" forceleft\">\n\n                                        <div style=\"float: left;\" class=\"current";
    echo $r["service_id"];
    echo "\">\n\n                                            <select name=\"curriers[";
    echo $r["service_id"];
    echo "]\">\n                                                ";
    foreach ($Shippingarr as $shipingid => $ship) {
        $selected = "";
        if ($r["shipped_by"] == $shipingid) {
            $selected = "selected";
        }
        echo "                                                    <option ";
        echo $selected;
        echo " value=\"";
        echo $shipingid;
        echo "\">";
        echo $ship;
        echo "</option>\n                                                    ";
    }
    echo "                                            </select>\n                                        </div>&nbsp;\n\n\n                                        <div style=\"float: left;\" class=\"current";
    echo $r["service_id"];
    echo "\">\n                                            <input type=\"text\" placeholder=\"Tracking ID\" value=\"";
    echo $r["tracking"];
    echo "\" name=\"trackings[";
    echo $r["service_id"];
    echo "]\" />\n                                        </div>\n                                    </td>\n                                    <td class=\" forceleft\">\n\n                                        <div style=\"float: left;\" class=\"current";
    echo $r["service_id"];
    echo "\">\n                                            <input type=\"text\" name=\"usernotess[";
    echo $r["service_id"];
    echo "]\" value=\"";
    echo $r["note"];
    echo "\" placeholder=\"user notes\" />\n\n                                        </div>\n                                    </td>\n                                </tr>\n\n\n                                ";
    $ids = explode(",", $r["ids"]);
    foreach ($ids as $i) {
        $O = mysqli_fetch_assoc(dquery("select * from tbl_order_product \nwhere order_id='" . $i . "'"));
        echo "                                    <tr style=\"display: none;\" class=\"multi";
        echo $r["service_id"];
        echo "\">\n\n                                        <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class=\"badge badge-secondary\">1 x</span>\n                                            <a class=\"default_dg_a\" href=\"javascript:load_fromsubpage('editproduct&id=";
        echo $r["service_id"];
        echo "','";
        echo $r["item"];
        echo "')\">";
        echo $r["item"];
        echo "</a>\n\n                                        </td>\n                                        <td>";
        echo round($r["credit"], 2) . " " . $_ClientsDetails["currency"]["code"];
        echo "</td>\n                                        <td class=\"td-right\">";
        echo round($r["weight"], 2);
        echo " Kg</td>\n\n                                        <td class=\"forceleft\">\n                                            <select name=\"orderstatus[";
        echo $r["service_id"];
        echo "][";
        echo $i;
        echo "]\">\n                                                <option ";
        if ($O["status"] == "new") {
            echo "selected";
        }
        echo " value=\"new\">New Order</option>\n                                                <option ";
        if ($O["status"] == "accepted") {
            echo "selected";
        }
        echo " value=\"accepted\">";
        echo $LNG["packed"];
        echo "</option>\n                                                <option ";
        if ($O["status"] == "cancelled") {
            echo "selected";
        }
        echo " value=\"cancelled\">Rejected</option>\n                                                <option ";
        if ($O["status"] == "dispatched") {
            echo "selected";
        }
        echo " value=\"dispatched\">Dispatched</option>\n                                                <option ";
        if ($O["status"] == "delivered") {
            echo "selected";
        }
        echo " value=\"delivered\">Delivered</option>\n                                            </select>\n                                        </td>\n                                        <td class=\"forceleft\">\n                                            <select name=\"currier[";
        echo $r["service_id"];
        echo "][";
        echo $i;
        echo "]\">\n                                                ";
        foreach ($Shippingarr as $shipingid => $ship) {
            $selected = "";
            if ($O["shipped_by"] == $shipingid) {
                $selected = "selected";
            }
            echo "                                                    <option ";
            echo $selected;
            echo " value=\"";
            echo $shipingid;
            echo "\">";
            echo $ship;
            echo "</option>\n                                                    ";
        }
        echo "                                            </select>\n\n                                            <input type=\"text\" placeholder=\"Tracking ID\"  value=\"";
        echo $O["tracking"];
        echo "\" name=\"tracking[";
        echo $r["service_id"];
        echo "][";
        echo $i;
        echo "]\" />\n                                        </td>\n                                        <td class=\"forceleft\">\n                                            <input type=\"text\" name=\"usernotes[";
        echo $r["service_id"];
        echo "][";
        echo $i;
        echo "]\" value=\"";
        echo $O["note"];
        echo "\" placeholder=\"user notes\" />\n                                        </td>\n                                    </tr>\n                                    ";
    }
    echo "\n\n                                ";
    if ($r["mep"] == 3) {
        echo "                                        <script>\n                                            multiple('";
        echo $r["service_id"];
        echo "');\n                                        </script>\n                                        ";
    }
}
echo "                            </tbody>\n                            <tfoot>\n                            <tr>\n                                <th></th>\n                                <th>";
echo $total;
echo " ";
echo $_ClientsDetails["currency"]["code"];
echo "</th>\n                                <th>";
echo $weights;
echo " Kg</th>\n                                <th></th>  <th></th>  <th></th>  <th></th>\n                            </tr>\n                            </tfoot>\n                        </table>\n\n\n                        ";
$iq = dquery("select * from tbl_invoiceitems where `type`='IMEI'\nand invoiceid='" . $orderid . "'");
if (mysqli_num_rows($iq)) {
    echo "                            <br />\n                            <table id=\"main_tbl\" >\n                                <thead>\n                                <th>";
    echo $LNG["sub"];
    echo " ";
    echo $LNG["orderid"];
    echo "</th>\n                                <th>";
    echo $LNG["service"];
    echo "</th>\n                                <th>";
    echo $LNG["price"];
    echo "</th>\n                                <th>";
    echo $LNG["status"];
    echo "</th>\n                                <th>";
    echo $LNG["reply"];
    echo "</th>\n                                </thead>\n                                <tbody>\n                                ";
    while ($r = mysqli_fetch_assoc($iq)) {
        $Order = mysqli_fetch_assoc(dquery("select  * from tbl_order_imei\nwhere order_id='" . $r["relid"] . "'"));
        $Status = $LNG["new"];
        if ($Order["user_can_c"] == 1) {
            $Status = $LNG["accepted"];
        } else {
            if ($Order["user_can_c"] == 3) {
                $Status = $LNG["cancelled"];
            } else {
                if ($Order["user_can_c"] == 4) {
                    $Status = $LNG["completed"];
                }
            }
        }
        echo "\n                                    <tr style=\"cursor:pointer;\" onclick=\"javascript:load_fromsubpage('edituser.editimeiorder&id=";
        echo $Order["order_id"];
        echo "','IMEI#";
        echo $Order["order_id"];
        echo "')\">\n                                        <td>";
        echo $r["relid"];
        echo "</td>\n                                        <td>";
        echo $r["description"];
        echo "</td>\n                                        <td>";
        echo $r["amount"];
        echo "</td>\n                                        <td>";
        echo $Status;
        echo "</td>\n                                        <td>";
        echo $r["reply"] ? $r["reply"] : "-";
        echo "</td>\n                                    </tr>\n                                    ";
    }
    echo "                                </tbody>\n                            </table>\n                            ";
}
echo "\n\n                        ";
echo generate_token("form");
echo "\n                        <p  class=\"fixedbtn\">\n                            <input class=\"btn save\" type=\"button\" name=\"save\" value=\"Save\"\n                                   onclick=\"SubmitForm ('#btn','productorderedit','#frmtrakc','#notification','true','#main_loader');\"/>\n\n\n                        </p>\n        </form>\n    </div>\n\n";
$fileverioncheck = "6.1.0";

?>