<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

echo "<!--\n<ul id=\"tabmenu\"> \n<li><a onclick=\"getContect('#tab','main2.php?page=productorder.new','','','#tabcontent',true,'#main_loader');\" id=\"tab\" >";
echo $LNG["neworder"];
echo "</a>\n</li> \n<li><a ";
if ($loaddefaultpage == "productorder.replied") {
    echo "class='tabmenu_active'";
}
echo " onclick=\"getContect('#tab12','main2.php?page=productorder.replied','','','#tabcontent',true,'#main_loader');\" id=\"tab12\" >";
echo $LNG["inprocess"];
echo " ";
echo $LNG["orders"];
echo "</a></li>\n<li><a ";
if ($loaddefaultpage == "productorder.history") {
    echo "class='tabmenu_active'";
}
echo " onclick=\"getContect('#tab4','main2.php?page=productorder.history','','','#tabcontent',true,'#main_loader');\" id=\"tab4\" >";
echo $LNG["orderhistory"];
echo "</a></li>\n<li><a ";
if ($loaddefaultpage == "productorder.pending") {
    echo "class='tabmenu_active'";
}
echo "  onclick=\"getContect('#tab5','main2.php?page=productorder.pending','','','#tabcontent',true,'#main_loader');\" id=\"tab5\" >";
echo $LNG["pending"];
echo " ";
echo $LNG["order"];
echo "</a></li>\n<li><a ";
if ($loaddefaultpage == "productorder.return") {
    echo "class='tabmenu_active'";
}
echo "  onclick=\"getContect('#tab6','main2.php?page=productorder.return','','','#tabcontent',true,'#main_loader');\" id=\"tab6\" >";
echo $LNG["returns"];
echo "</a></li>\n<div style=\"clear: both;\"></div> \n</ul>\n-->\n<div class=\"clear\"></div>\n\n";
if ($loaddefaultpage == "productorder.new.php") {
    include $loaddefaultpage;
    $loaddefaultpage = NULL;
} else {
    echo "<div id=\"tabcontent\">\n";
    require_once ROOTDIR . "/comm.php";
    require_once ROOTDIR . "/includes/fun.inc.php";
    include_once ROOTDIR . "/includes/clients.fun.inc.php";
    include_once ROOTDIR . "/includes/products.fun.php";
    require_once ROOTDIR . "/includes/shipping.fun.php";
    require_once ROOTDIR . "/includes/invoice.fun.php";
    if (!function_exists(getCustomFields)) {
        require_once "../includes/customfield.fun.inc.php";
    }
    if ($reorder) {
        checkDemoMode(false);
        $idd = md5($id);
        $sql = dquery("select * from tbl_order_product where md5(invoiceid)='" . $idd . "'");
        $_ClientsDetails = getClientsDetails($uid);
        while ($r = mysqli_fetch_assoc($sql)) {
            $qnts = mysqli_num_rows(dquery("select order_id from tbl_order_product\n        where service_id='" . $r["service_id"] . "' and md5(invoiceid)='" . $idd . "'"));
            $serviceDetails = getProducts("", md5($r["service_id"]), "", "", "", "", "", "", "", "", "", "", "", "", "", $qnts);
            $data = NULL;
            if ($serviceDetails["credit"] == 0 && $serviceDetails["zeropriceaction"] == 3) {
                $serviceDetails["credit"] = $r["credit"];
                $amount = $serviceDetails["credit"];
            }
            $data["note"] = $r["note"];
            $data["comments"] = $r["comments"];
            $data["service_id"] = $r["service_id"];
            if ($_SESSION["system_default_currency"]["id"] != $_ClientsDetails["currency_id"]) {
                $serviceDetails["purchase_cost"] = getPurchaseCost($_SESSION["system_default_currency"]["id"], $serviceDetails["id"], "shop");
                if (!$serviceDetails["purchase_cost"]) {
                    $serviceDetails["purchase_cost"] = convertCurrency($serviceDetails["purchase_cost"], $_SESSION["system_default_currency"]["id"], $_ClientsDetails["currency_id"]);
                }
            }
            $data["purchase_cost"] = $serviceDetails["purchase_cost"];
            $data["user_id"] = $_ClientsDetails["id"];
            $data["date"] = date("Y-m-d");
            $data["time"] = time();
            $data["user_can_c"] = 5;
            if ($serviceDetails["subscription"]) {
                $data["subscribe"] = 1;
                dquery("UPDATE tbl_subscribers set used=used+1 WHERE \n    \t\tservice_id='" . $serviceDetails["id"] . "' AND user_id='" . $_ClientsDetails["id"] . "'\n    \t\tAND type='tbl_products'");
            }
            $data["pass_key"] = md5(time() . $_ClientsDetails["id"] . time());
            $data["credit"] = $serviceDetails["credit"];
            $data["discount"] = $serviceDetails["discount"];
            $data["gift"] = $r["gift"];
            $data["gatway"] = $r["gatway"];
            $invitem = mysqli_fetch_assoc(dquery("select shippingtax,qnt,warehouseid,paymentmethod from \ntbl_invoiceitems WHERE md5(invoiceid)='" . $idd . "' AND relid='" . $r["relid"] . "'"));
            $paymentmethod = $invitem["paymentmethod"];
            $data["sh_email"] = $r["sh_email"];
            $data["sh_contact"] = $r["sh_contact"];
            $data["sh_firstname"] = $r["sh_firstname"];
            $data["sh_lastname"] = $r["sh_lastname"];
            $data["sh_address1"] = $r["sh_address1"];
            $data["sh_address2"] = $r["sh_address2"];
            $data["sh_city"] = $r["sh_city"];
            $data["sh_zip"] = $r["sh_zip"];
            $data["sh_state"] = $r["sh_state"];
            $data["sh_country"] = $r["sh_country"];
            if ($serviceDetails["wholesaleprice"]) {
                $data["wholesale"] = 1;
            }
            $date = date("Y-m-d");
            if ($serviceDetails["stock_allow"] && $serviceDetails["stock"] < 1 && $serviceDetails["outofstock"] == 0 || $date < $serviceDetails["availability_date"] && $serviceDetails["outofstock"] == 0) {
                $data["buyadvance"] = 1;
            }
            $data["ip"] = $_SERVER["REMOTE_ADDR"];
            $data["currency_id"] = $_ClientsDetails["currency_id"];
            $oids = "";
            for ($i = 1; $i <= $qnts; $i++) {
                $order = $db->insert("tbl_order_product", $data);
                $ordarr[] = $order;
                $amount = $serviceDetails["credit"] - $serviceDetails["discount"];
                $cust = dquery("select * from tbl_customfieldsvalues where relid='" . $r["order_id"] . "'");
                while ($cstm = mysqli_fetch_assoc($cust)) {
                    $extraprice = getPriceFromCustomField($cstm["fieldid"], $cstm["value"], $_SESSION["currency"]);
                    $amount = $amount + $extraprice;
                    insert_query("tbl_customfieldsvalues", ["fieldid" => $cstm["fieldid"], "relid" => $order, "value" => $cstm["value"]]);
                }
                insert_query("tbl_invoiceitems", ["qnt" => $qnts, "userid" => $uid, "type" => "Product", "relid" => $order, "description" => $serviceDetails["service_name"], "amount" => $amount, "taxed" => $serviceDetails["taxed"], "duedate" => "now()", "paymentmethod" => $paymentmethod, "shippingtax" => $invitem["shippingtax"], "warehouseid" => $invitem["warehouseid"]]);
            }
            unset($data);
        }
        $invoiceid = generateInvoice($uid);
        require_once ROOTDIR . "/includes/mail.fun.php";
        if (is_array($ordarr)) {
            foreach ($ordarr as $o) {
                if ($o) {
                    dquery("UPDATE tbl_order_product set invoiceid='" . $invoiceid . "' where order_id='" . $o . "'");
                    $s = mysqli_fetch_assoc(dquery("select *,(select \n            service_name from tbl_products where id=service_id) as item,\n            (select template_id1  from tbl_products where id=service_id) as successt,\n            \n            (select username from tblUsers where id=user_id) as user,\n            (select email from tblUsers where id=user_id) as email\n            from tbl_order_product where order_id='" . $o . "'"));
                    $itms .= $s["item"] . "<br />";
                    $user = $s["user"] . " [ " . $s["email"] . " ]";
                    $shipper = $s["sh_firstname"] . " " . $s["sh_lastname"] . "<br />";
                    $shipper .= $s["sh_address1"] . "<br />";
                    $shipper .= $s["sh_address2"] . "<br />";
                    $shipper .= $s["sh_city"] . " " . $s["sh_zip"] . "<br />";
                    $shipper .= $s["sh_state"] . "<br />";
                    $shipper .= $s["sh_country"] . "<br />";
                    $shipper .= $s["sh_contact"] . "<br />";
                }
            }
            $email_merge_fields["invoiceid"] = $invoiceid;
            $email_merge_fields["details"] = $itms;
            $email_merge_fields["feedbacklink"] = $config["site_address"] . "feedback.php?u=c&o=" . md5($o);
            sendMail(72, $ClientsDetails["id"], "", $email_merge_fields, true);
        }
        echo "<div id='notification1' class='successbox'>" . $LNG["order"] . " " . $LNG["generated"] . " " . $LNG["invoice"] . " " . $LNG["id"] . " : \n<a target='_blank' href='includes/pages/viewinvoice.php?id=" . $invoiceid . "'>" . $invoiceid . "</a></div>";
    }
    if (isset($save)) {
        checkDemoMode(false);
        if (is_array($track)) {
            foreach ($track as $key => $v) {
                if ($forall) {
                    if ($v == "") {
                        $v = $old;
                    } else {
                        $old = $v;
                    }
                }
                $time = time();
                $date = date("Y-m-d");
                dquery("UPDATE tbl_order_product SET shipped_by='" . $v . "',remove='0',reply_time='" . $time . "',\n          reply_date='" . $date . "',user_can_c='4' WHERE order_id='" . $key . "'");
                $det = mysqli_fetch_assoc(dquery("select service_id from tbl_order_product where order_id='" . $key . "'"));
                $w = mysqli_fetch_assoc(dquery("select mywarehouse from tbl_admin where id='" . $_SESSION["adminid"] . "'"));
                $ins["wid"] = $w["mywarehouse"];
                $ins["pid"] = $det["service_id"];
                $ins["stockout"] = 1;
                $db->insert("tbl_warehousestock", $ins);
                $ins = NULL;
                $ins["qnt"] = 1;
                $ins["date"] = date("Y-m-d");
                $ins["time"] = time();
                $ins["pid"] = $det["service_id"];
                $ins["wid"] = $w["mywarehouse"];
                $ins["aid"] = $_SESSION["adminid"];
                $ins["status"] = "OUT";
                $ins["relid"] = $key;
                $db->insert("tbl_stock_history", $ins);
                $ins = NULL;
                $buf[] = $key;
            }
        }
        include_once ROOTDIR . "/includes/mail.fun.php";
        if (is_array($buf)) {
            foreach ($buf as $b) {
                $key = $b;
                $OrderDtl = mysqli_fetch_assoc(dquery("select *,\n                (select template_id1  from tbl_products where id=service_id) as successt\n                 from tbl_order_product \n                where order_id='" . $key . "'"));
                if ($OrderDtl) {
                    $service = mysqli_fetch_assoc(dquery("select `service_name`,bundle,bysupplier,\n                `template_id1` from `tbl_products` where `id`='" . $OrderDtl["service_id"] . "'"));
                    $email_merge_fields["servicetype"] = "Product";
                    $email_merge_fields["orderid"] = $OrderDtl["order_id"];
                    $email_merge_fields["service"] .= $service["service_name"] . " <br>\r\n";
                    $email_merge_fields["reply"] = $v;
                    $email_merge_fields["trackinid"] = $v;
                    $gatwaydetail = mysqli_fetch_assoc(dquery("select `trackingurl`,`value` from tbl_shipping_services where `id`='" . $OrderDtl["gatway"] . "'"));
                    $email_merge_fields["trackingurl"] = str_replace("[TID]", $v, $gatwaydetail["trackingurl"]);
                    $email_merge_fields["shipping_gatway"] = $gatwaydetail["value"];
                    $email_merge_fields["comments"] = $OrderDtl["comments"];
                    $email_merge_fields["feedbacklink"] = $config["site_address"] . "feedback.php?u=c&o=" . md5($key);
                    if ($service["bysupplier"]) {
                        $email_merge_fields["link"] = $config["site_address"] . "feedback.php?id=" . md5($key);
                    }
                    sendMail(49, $OrderDtl["user_id"], $OrderDtl["order_id"], $email_merge_fields, true);
                    if ($OrderDtl["successt"]) {
                    }
                }
            }
        }
        echo "<div id=notification1 class=successbox>" . $LNG["datasavesuccessfully"] . "</div>";
    }
    $prod = dquery("SELECT *,gift,user_id,\n        (SELECT bundle FROM tbl_products WHERE id=service_id) as bun,\n        (SELECT service_name FROM tbl_products WHERE id=service_id) as service,\n        (SELECT code FROM tbl_currencies where id=(select default_currency from tblUsers where id=user_id)) as code ,\n        (select value from tbl_shipping_services where id=gatway) as gatway\n         from tbl_order_product where invoiceid='" . $id . "' order by order_id");
    $ds = dquery("SELECT user_id\n         from tbl_order_product where invoiceid='" . $id . "' order by order_id");
    echo "\n<h2><span  class=\"groupstabesheadertext\"> ";
    echo $LNG["order"];
    echo " : #";
    echo $id;
    echo " </span></h2>\n \n <div style=\"position: absolute;right:10px;top:60px\">\n <a  href=\"javascript:load_subpage('main2.php?page=edituser.editinvoice&id=";
    echo $id;
    echo "','View Invoice')\">View Invoice</a> | <a  href=\"javascript: void(0)\"  onclick=\"window.open('includes/pages/viewproductinv.php?id=";
    echo $id;
    echo "',  'windowname1',  'width=900, height=800');   return false;\">Print View</a> | <a href=\"javascript: load_subpage('main2.php?page=editproductorder.return&id=";
    echo $id;
    echo "','Return Request');\">Return Request</a> \n</div>\n \n<div id=\"notification1\"></div>\n\n<form method=\"post\">\n";
    $vrs = mysqli_fetch_assoc($ds);
    echo "<input type=\"hidden\" name=\"uid\" value=\"";
    echo $vrs["user_id"];
    echo "\" />\n<input type=\"hidden\" name=\"id\" value=\"";
    echo $id;
    echo "\" />\n<input type=\"hidden\" name=\"loaddefaultpage\"  value=\"";
    echo $loaddefaultpage;
    echo "\" />\n<table id=\"main_tbl\" >\n<thead>\n<th>";
    echo $LNG["product"];
    echo "</th>\n<th>";
    echo $LNG["price"];
    echo "</th>\n<th>";
    echo $LNG["shipping"];
    echo "</th>\n<th>";
    echo $LNG["status"];
    echo "</th>\n<th>";
    echo $LNG["trackingid"];
    echo " <input type=\"checkbox\" id=\"forall\" name=\"forall\" checked=\"checked\" /> <label for=\"forall\">";
    echo $LNG["same"] . " " . $LNG["for"] . " " . $LNG["all"];
    echo "</label> </th>\n<th>";
    echo $LNG["reject"];
    echo "</th>\n<th></th>\n</thead>\n<tbody>\n    ";
    while ($det = mysqli_fetch_assoc($prod)) {
        echo "        <tr class=\"fieldlable\"><td > &#45;&#45;";
        echo $det["service"];
        echo " \n        ";
        if ($det["bun"]) {
            echo " [" . $LNG["bundle"] . "]";
        }
        echo " ";
        if ($det["gift"]) {
            echo " [" . $LNG["gift"] . "]";
        }
        echo " \n        ";
        $cst = getCustomFields("product", $det["service_id"], $det["order_id"]);
        if ($cst) {
            foreach ($cst as $custom) {
                if ($custom["value"]) {
                    echo " <small><i style=\"color: #666 !important;\">";
                    echo $custom["name"];
                    echo " - ";
                    echo $custom["value"];
                    echo "</small></i> \n                    ";
                }
            }
        }
        echo "        </td><td>";
        echo $det["credit"] - $det["discount"];
        echo " ";
        echo $det["code"];
        echo "</td>\n        <td >";
        echo $det["gatway"];
        echo "</td>\n        <td id=\"also";
        echo $det["order_id"];
        echo "\">\n";
        if ($det["remove"]) {
            echo $LNG["rejected"];
        } else {
            echo "        \n <script type=\"text/javascript\">\n\$(function() {\n  \$(\".editable_select";
            echo $det["order_id"];
            echo "\").editable(\"includes/pages/editshipping.php?status=true\", { \n    indicator : '<img src=\"images/indicator.gif\">',\n    data   : \"{'0':'New','1':'In Process','4':'Sent','6':'On Hold','7':'Received','selected':'";
            echo $det["user_can_c"];
            echo "'}\",\n    type   : \"select\",\n    submit : \"OK\",\n    style  : \"inherit\",\n    submitdata : function() {\n      return {id : ";
            echo $det["order_id"];
            echo "};\n    }\n  });\n});\n</script>        \n        <span class=\"editable_select";
            echo $det["order_id"];
            echo "\" id=\"select_";
            echo $det["order_id"];
            echo "\" style=\"display: inline\">";
            if ($det["user_can_c"] == 0) {
                echo $LNG["new"];
            } else {
                if ($det["user_can_c"] == 1) {
                    echo $LNG["inprocess"];
                } else {
                    if ($det["user_can_c"] == 3) {
                        echo $LNG["rejected"];
                    } else {
                        if ($det["user_can_c"] == 4) {
                            echo $LNG["sent"];
                        } else {
                            if ($det["user_can_c"] == 6) {
                                echo $LNG["onhold"];
                            } else {
                                if ($det["user_can_c"] == 7) {
                                    echo $LNG["received"];
                                }
                            }
                        }
                    }
                }
            }
        }
        echo "</span>              \n        </td>\n        <td id=\"";
        echo $det["order_id"];
        echo "\" >\n         ";
        if (!$det["remove"]) {
            echo "        <input type=\"text\" name=\"track[";
            echo $det["order_id"];
            echo "]\" value=\"";
            echo $det["shipped_by"];
            echo "\" /></td>\n        ";
        } else {
            echo "       Refunded       ";
        }
        echo "        <td  id=\"rr";
        echo $det["order_id"];
        echo "\">";
        if (!$det["remove"]) {
            echo "     \n          <input type=\"button\" class=\"button deletedata\" name=\"rem[";
            echo $det["order_id"];
            echo "]\" \n            onclick=\"removes(";
            echo $det["order_id"];
            echo ")\" \n         value=\"X\" title=\"Reject\"/>       ";
        }
        echo "</td>   <td></td>    </tr>\n    ";
    }
    echo "</tbody>\n</table>\n \n<p  class=\"fixedbtn\"><input class=\"btn save\" type=\"submit\" name=\"save\" value=\"Save\" />\n    <form id=\"frmedituser\" name=\"\" method=\"post\" style=\"float:right\">\n";
    echo generate_token("form");
    $prod1 = mysqli_fetch_assoc(dquery("SELECT user_id,order_id from tbl_order_product where invoiceid='" . $id . "'"));
    echo "<input type=\"hidden\" value=\"";
    echo $prod1["order_id"];
    echo "\" id=\"id\" name=\"id\"/>\n<input type=\"hidden\" value=\"";
    echo $md5id;
    echo "\" name=\"md5id\"/>\n<input type=\"hidden\" value=\"";
    echo $prod1["user_id"];
    echo "\" id=\"uid\" name=\"uid\"/>\n\n <select name=\"productordermail\" id=\"emaili\">\n    <option value=\"\">";
    echo $LNG["select"];
    echo "</option>\n        ";
    $d = dquery("select `type` from tbl_emailtemplates where `type`='product' or `type`='other' group by type");
    while ($ss = mysqli_fetch_assoc($d)) {
        echo "        <optgroup style=\"background-color: #DFDFDF;\" label=\"";
        echo $ss["type"];
        echo "\" >  \n ";
        $s = dquery("select id,name,type from tbl_emailtemplates where type='" . $ss["type"] . "'");
        while ($r = mysqli_fetch_assoc($s)) {
            echo "    <option style=\"background-color: #FFF;\" value=\"";
            echo $r["id"];
            echo "\">";
            echo $r["name"];
            echo "</option>\n ";
        }
        echo "      </optgroup>\n";
    }
    echo " </select>\n<input type=\"button\" class=\"addFromgallery\" name=\"resetpin\" value=\"";
    echo $LNG["send"];
    echo " ";
    echo $LNG["email"];
    echo "\" id=\"btnpmail\" onclick=\"sendMailer();\" />\n</form> \n</p>\n</form>\n\n\n\n\n \n<div  class=\"groupstabes\" style=\"float: left;margin-right:60px\">\n  <h2>    \n    <span class=\"groupstabesheadertext\">";
    echo $LNG["order"] . " " . $LNG["detail"];
    echo "</span>\n  </h2>\n  <div class=\"groupstabescontant\">\n  \n  <table id=\"main_tbl\">\n    <tr><td>";
    echo $LNG["product"];
    echo "</td><td class=\"fielarea\" align=\"right\">";
    echo $LNG["total"];
    echo " [";
    echo $total;
    echo " ";
    echo $LNG["kg"];
    echo "]</td></tr>\n";
    $prod = dquery("SELECT (select weight from tbl_products where id=service_id) as weight,\nsh_firstname,sh_lastname,sh_address1,sh_address2,sh_city,sh_zip,sh_state,sh_country,\n(select service_name from tbl_products where id=service_id) as service\n from tbl_order_product where invoiceid='" . $id . "' and remove='0'");
    while ($row = mysqli_fetch_assoc($prod)) {
        if (!$row["weight"]) {
            $row["weight"] = 0;
        }
        $total = $total + $row["weight"];
        echo " <tr>\n<td>";
        echo $row["service"];
        echo "</td><td class=\"fieldarea\" align=\"right\">";
        echo $row["weight"];
        echo " ";
        echo $LNG["kg"];
        echo "</td>\n</tr>\n";
    }
    echo "\n</table>\n</div>  \n</div>\n\n";
    $shdetails = mysqli_fetch_assoc(dquery("SELECT \nsh_firstname,sh_lastname,sh_address1,sh_address2,sh_city,sh_zip,sh_state,sh_country\n from tbl_order_product where invoiceid='" . $id . "' and remove='0'"));
    echo " \n\n\n<script language=\"JavaScript\">\nfunction newWindow(file,window)\n {msgWindow=open(file,window,'scrollbars=yes,resizable=no,width=533,height=533');\n    if (msgWindow.opener == null) msgWindow.opener = self;\n } \n</script>\n\n<div  class=\"groupstabes\" style=\"float: left;margin-right:60px\">\n  <h2>    \n    <span class=\"groupstabesheadertext\">";
    echo $LNG["shipping"] . " " . $LNG["detail"];
    echo "</span>\n  </h2>\n  <div class=\"groupstabescontant\">\n  \n ";
    if ($config["googlelanguageapi"]) {
        echo "\n<a style=\"text-decoration: none;\" href=\"javascript:newWindow('includes/pages/map.php?id=";
        echo $id;
        echo "','Google Map')\"> ";
        echo $LNG["shipping"];
        echo " ";
        echo $LNG["location"];
        echo " \n   Map\n</a>\n <br />\n";
    }
    echo "\n\n\n";
    echo $shdetails["sh_firstname"] . " " . $shdetails["sh_lastname"];
    echo "<br />\n";
    echo $shdetails["sh_address1"];
    echo " <br />\n";
    echo $shdetails["sh_address2"];
    echo " <br />\n";
    echo $shdetails["sh_city"] . " - " . $shdetails["sh_zip"];
    echo "  \n";
    echo $shdetails["sh_state"];
    echo "  <br />\n";
    echo $shdetails["sh_country"];
    echo " \n \n</div>  \n</div>\n \n";
    $prod = mysqli_fetch_assoc(dquery("SELECT user_id,order_id from tbl_order_product where invoiceid='" . $id . "'"));
    $user = mysqli_fetch_assoc(dquery("select * from tblUsers where id='" . $prod["user_id"] . "'"));
    echo "\n\n<div  class=\"groupstabes\" style=\"float: left;margin-right:60px\">\n  <h2>    \n    <span class=\"groupstabesheadertext\">";
    echo $LNG["user"] . " " . $LNG["info"];
    echo "</span>\n  </h2>\n  <div class=\"groupstabescontant\">\n  \n   <table class=\"form\">\n<tr><td class=\"fieldlabel\">";
    echo $LNG["name"];
    echo " </td><td class=\"fieldarea\">";
    echo $user["first_name"] . " " . $user["last_name"];
    echo "</td></tr>\n<tr><td  class=\"fieldlabel\">";
    echo $LNG["email"];
    echo " </td><td class=\"fieldarea\"><a href=\"mailto:";
    echo $user["email"];
    echo "\">";
    echo $user["email"];
    echo "</a></td></tr>\n<tr><td  class=\"fieldlabel\">";
    echo $LNG["contact"];
    echo " </td><td class=\"fieldarea\">";
    echo $user["phonenumber"];
    echo "</td></tr>\n   </table>\n\n</div>  \n</div>\n\n\n\n\n<div  class=\"groupstabes\" style=\"float: left;\" >\n  <h2>    \n    <span class=\"groupstabesheadertext\">";
    echo $LNG["invoice"] . " " . $LNG["detail"];
    echo "</span>\n  </h2>\n  <div class=\"groupstabescontant\">\n  \n  <table class=\"form\">\n";
    $inv = mysqli_fetch_assoc(dquery("SELECT *,\n(SELECT code FROM tbl_currencies where id=(select default_currency from tblUsers where id=userid))\nas code,\n(SELECT promotion_code FROM tbl_invoiceitems where invoiceid='" . $id . "' limit 1) as promocode\nFROM tbl_invoices where id='" . $id . "'"));
    echo " <tr><td class=\"fieldlabel\">";
    echo $LNG["invoice"] . " " . $LNG["date"];
    echo "</td><td class=\"fieldarea\" align=\"left\">";
    echo $inv["date"];
    echo "</td></tr>\n <tr><td  class=\"fieldlabel\">";
    echo $LNG["due"] . " " . $LNG["date"];
    echo "</td><td class=\"fieldarea\" align=\"left\">";
    echo $inv["date"];
    echo "</td></tr>\n <tr><td  class=\"fieldlabel\">";
    echo $LNG["invoicessubtotal"];
    echo "</td><td class=\"fieldarea\" align=\"left\">";
    echo $inv["subtotal"] . " " . $inv["code"];
    echo "</td></tr>\n <tr><td  class=\"fieldlabel\">";
    echo $LNG["shippingcharge"];
    echo "</td><td class=\"fieldarea\" align=\"left\">";
    echo $inv["shippingtax"] . " " . $inv["code"];
    echo "</td></tr>\n <tr> ";
    if ($inv["promotion"]) {
        echo "<td  class=\"fieldlabel\">";
        echo $LNG["promotion"];
        echo "</td><td class=\"fieldarea\" align=\"left\"> ";
        echo $inv["promotion"] . " " . $inv["code"];
        echo "&nbsp;&nbsp;&nbsp; <span style=\"padding: 5px; background: none repeat scroll 0% 0% rgb(102, 102, 102); color: rgb(255, 255, 255);\">";
        echo $inv["promocode"];
        echo "</span></td></tr>";
    }
    echo "<td>";
    echo $LNG["credit"];
    echo "</td><td class=\"fieldarea\" align=\"left\">";
    echo $inv["credit"] . " " . $inv["code"];
    echo "</td></tr>\n <tr><td  class=\"fieldlabel\">";
    echo $LNG["total"];
    echo "</td><td class=\"fieldarea\" align=\"left\">";
    echo $inv["total"] . " " . $inv["code"];
    echo "</td></tr>\n</table>\n  </div>  \n</div>\n\n\n<div class=\"clear\"></div>\n<script>\nfunction removes(val){\n    \n    \n    \n    \$.post(\"includes/pages/editshipping.php?reject=true\", { id: val} );\n    \n    document.getElementById(val).innerHTML='Refunded';\n    document.getElementById(\"rr\"+val).innerHTML='';\n    document.getElementById(\"also\"+val).innerHTML='Rejected';\n}\nfunction sendMailer(){\n    var val=\$('#emaili').val();\n    var ids=\$('#id').val();\n    var uids=\$('#uid').val();\n    var tok=\$('#token').val();\n    \$(\"#main_loader\").show();\n    \$.post(\"includes/pages/productorder.edit.sendmail.php?type=true\", { productordermail: val, id: ids,uid: uids,special: tok},function(data){\n      \n    spl=data.split(\":\");\n    if(spl[0]=='error'){\n        \$(\"#notification1\").addClass(\"errorbox\");\n    }else{\n        \$(\"#notification1\").addClass(\"successbox\");\n    }\n     \$(\"#notification1\").html(spl[1]);\n        \$(\"#main_loader\").hide();    \n   });\n}\n</script>\n";
}
echo "</div>";
$fileverioncheck = "6.1.0";

?>