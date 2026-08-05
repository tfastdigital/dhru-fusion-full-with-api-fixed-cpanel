<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

unset($_SESSION["SALES"]);
unset($_SESSION["unique"]);
unset($_SESSION["AMOUNT"]);
unset($_SESSION["CUSTOMER"]);
unset($_SESSION["NOTES"]);
unset($_SESSION["STYPE"]);
unset($_SESSION["SHIP"]);
unset($_SESSION["WAREHOUSE"]);
unset($_SESSION["LAST"]);
unset($_SESSION["FIRST"]);
unset($_SESSION["EMAIL"]);
unset($_SESSION["PHONE"]);
dquery("ALTER TABLE `tbl_serial_list`  \n    ADD `date` VARCHAR(50) NOT NULL  AFTER `refund`,  \n    ADD `aid` INT(5) NOT NULL  AFTER `date`");
dquery("ALTER TABLE `tbl_stock_history` \n    ADD `remove` INT(1) NOT NULL  AFTER `status`");
if (!mysqli_num_rows(dquery("select * from tbl_admin_access\n where id=524"))) {
    dquery("INSERT INTO `fusion_fusion`.`tbl_admin_access` (\n    `id` ,`page_name` ,`page_description` ,`groupname` ,`shop`)\n    VALUES (NULL , 'stock.php', 'Remove Stock', 'pos', '')");
}
if (!mysqli_num_rows(dquery("select * from tbl_admin_access\n where id=525"))) {
    dquery("INSERT INTO `fusion_fusion`.`tbl_admin_access` (\n    `id` ,`page_name` ,`page_description` ,`groupname` ,`shop`)\n    VALUES (NULL , 'pos.sales.php', 'Can Change Warehouse', 'pos', '')");
}
$pos = mysqli_fetch_assoc(dquery("select * from tbl_pos_setting"));
$w = mysqli_fetch_assoc(dquery("select mywarehouse,group_id \nfrom tbl_admin where id='" . $_SESSION["adminid"] . "'"));
$acc = mysqli_fetch_assoc(dquery("select access from tbl_admin_access_group\nwhere id=(select group_id from tbl_admin where id='" . $_SESSION["adminid"] . "')"));
$perms = explode(",", $acc["access"]);
echo "<script>\nfunction generate()\n{\n    var reply=confirm(\"Do you want to complete sale\");\n    if(reply){\n        var a=\$('#pay').val();\n        var n=\$('#note').html();\n        var s=\$('#stype').val();\n        var wr=\$('#wid').val();\n        var fn=\$('#firstname').val();\n        var ln=\$('#lastname').val();\n        var em=\$('#email').val();\n        var ph=\$('#phone').val();\n        var gt=\$('#gateway').val();\n        var ship=\$('#ship').val();\n        var i=\$('#printi:checked').val();\n    \n        \$.post(\"includes/pages/pos.sales.add.php?generate2=true\", \n        { amount: a,note :n,stype :s,ship:ship,wr:wr,fn:fn,gt:gt,ln:ln,em:em,ph:ph},function(data) {\n          \n         obj = JSON.parse(data);\n         if(s==2){\n            if(obj['STATUS']=='error'){\n              alert(obj['MSG']);\n            }else{\n              alert(obj['MSG']);\n            }\n         }else{\n           if(obj['STATUS']=='error'){\n              alert(obj['MSG']);\n           }else{\n            \nnewwindow=window.open('includes/pages/printsale.php?action=";
echo $pos["template"];
echo "&print='+i+'&invoiceid='+obj['MSG'],'name','scrollbars=yes,resizeable=yes,menubar=no,height=650,width=650');\nif (window.focus) {newwindow.focus()}\n            \n           }\n          }\n        });\n       \n    }\n}\n\nfunction setVLL1(vals){\n    if(vals!=undefined){\n        document.getElementById('cid').value=vals;\n        \$('#client').hide();\n        \$.post(\"includes/pages/pos.sales.add.php?customer=true\", { val: vals},function(data) {\n              \$('#customer').html(data);                  \n        });\n    }else{\n        document.getElementById('cid').value='';\n    }\n}\nfunction detach(){\n     \$.post(\"includes/pages/pos.sales.add.php?detach=true\", function(data) {              \n              \$('#customer').html(data);              \n    });\n}\nfunction updateTotal()\n{\n     try{\n         var subtotal= 0;\n         var price=\$('.price');\n         var disc=\$('.disc');\n         \n         \$('.qnts').each(function(key, object){\n         \n            try{\n                 \$.post(\"includes/pages/pos.get.php?action=update\",{id:(key+1),qnt:object.value,price:price[key].value,discount: disc[key].value},function(data) {\n                     var cto=parseInt(object.value)*parseFloat(price[key].value);\n                     var disco=(( parseFloat(cto)*parseFloat(disc[key].value) )/100).toFixed(2);\n                     subtotal+=parseFloat(cto)-parseFloat(disco);\n                     \$(\".tot_\"+(key+10)).html( parseFloat(cto)-parseFloat(disco) );\n                 });\n            }catch(e){\n               // alert(e);\n            }\n         });\n     setTimeout(function(){\n    var tax=0;\n    subtotal=parseFloat(subtotal);\n         \n    \$.post(\"includes/pages/pos.get.php?action=tax\",function(data) {\n           \n        obj = JSON.parse(data);\n        for (i = 0; i < obj.length; i++) {\n          \n            if(obj[i]['name']){\n                \$(\".\"+obj[i]['name']).show();\n                var ttax=(subtotal*parseFloat(obj[i]['taxrate'])/100).toFixed(2);\n                \$(\".tax_\"+obj[i]['id']).html(ttax);\n                tax+=ttax;\n                \$(\"#total\").html((subtotal+parseFloat(tax)+parseFloat(\$('#ship').val() )).toFixed(2) ) ;\n            }\n        }\n    });\n        \n     \$(\"#subtotal\").html(subtotal);\n        }, 450);\n     }catch(es){\n      //  alert(es);\n     }         \n}\nfunction Remove(id){\n    \n   \$.post(\"includes/pages/pos.get.php?action=remove\", { rid: id},function(data) {\n       \$(\"#row\"+id).remove();\n       updateTotal();\n   });  \n}\n\$(document).ready(function() {\n     \$(this).focus();\n    \n    \$('#cid').keyup(function(e) {\n          var vls=\$(this).val();\n          if((e.which>=65 && e.which<=90) || (e.which>=48 && e.which<=57)  || (e.which>=96 && e.which<=105)){ \n            \$.post(\"includes/pages/pos.sales.product.php?client=true\", { val: vls},function(data) {\n                 \$('#client').show();\n                 \$('#client').html(data);\n            });\n          }\n        \n    });    \n    \n    \n     \$('#serial').keyup(function(e){\n              if(e.which == 13){\n                    if(\$(this).val()!='')\n                    {\n                             \n        \$.post(\"includes/pages/pos.get.php?action=add\", \n        {serial:\$(this).val(),wid: document.getElementById('wid').value},\n        function(data) {\n          \n            var sales=\$('#sales');\n            obj = JSON.parse(data);\n            \n            if(obj['status']=='success')\n            {\n               \n                if(obj['data']['qnt']>1){\n                    \$(\"#row\"+obj['data']['id']).remove();\n                }\n                \n                var trow=\"<tr id='row\"+obj['data']['id']+\"'><td><input type='hidden' name='sid[\"+obj['data']['id']+\"]' value='\"+obj['data']['id']+\"' />\"+\n                \" \"+obj['data']['item']+\" [\"+obj['data']['serial']\n                +\"] <br /> <small ><a href='#' class='textred' onclick='Remove(\"+obj['data']['id']+\")'>Remove</a></small></td><td><input type='text'  onkeyup='updateTotal()' name='price[\"+obj['data']['id']\n                +\"]' value='\"+obj['data']['price']+\"' class='price' /></td><td><input type='text' name='qnt[\"\n                +obj['data']['id']+\"]' class='qnts' onkeyup='updateTotal()' value='\"+obj['data']['qnt']+\n                \"' /></td><td><input type='text' class='disc' onkeyup='updateTotal()' name='discount[\"+obj['data']['id']+\n                \"]' value='\"+obj['data']['discount']+\"' /></td><td class='total tot_\"+obj['data']['id']+\"'>\"\n                +(parseInt(obj['data']['qnt'])*parseFloat(obj['data']['price']) )+\"</td></tr>\";\n                \n                sales.append(trow);\n                \n                updateTotal();\n                \n            }else if(obj['status']=='error'){                \n                for (i = 0; i < obj['data'].length; i++) {\n                   alert(obj['data'][i]);\n                }\n            } \n            \n            \$(\"#serial\").val(\"\");\n            \n        });\n                    }\n              }\n     });\n});\n</script>\n<style>\n.form {\n\tmargin-bottom: 4px !important;\n}\n#product, #client {\n\tbackground: none repeat scroll 0 0 #222222;\n\tposition: absolute;\n}\n#product li, #client li {\n\tborder-bottom: 1px solid #666666;\n\tcolor: #ffffff !important;\n\tlist-style: outside none none;\n\tpadding: 5px;\n}\n#product li a, #client li a {\n\tcolor:white\n}\n.selected, .selectedc {\n\tbackground-color: orange;\n}\n.fieldlabel {\n\tfont-size:14px\n}\ninput[type=\"text\"], select, textarea {\n\tbackground: white;\n    margin:2px 0\n}\n#totals td, #tax td, #gross td{\n\tfont-size: 20px;\n\ttext-align: right;\n    border:none;\n    width:50%\n}\n#totals td{\n\tbackground: #222;\n\tcolor:white\n}\n#tax td{\n\tbackground: #222;\n    color:white;\n}\n#gross td{\n\tbackground: #779500;\n\tcolor:white\n}\n#disc td{\n\tbackground: #EBAC9A;\n\tcolor:white\n}\n.textred {\n\tfont-size:10px\n}\nfieldset {\n\tbackground:#f5f5f4;\n}\nfieldset legend {\n\tbackground: #eaeaea;\n\tpadding:5px 10px;\n\tfont-size: 14px;\n\tmargin-left: 0 !important;\n}\n#main_tbl td {\n\tborder-right:#ddd solid 1px\n}\n#customer .fieldlabel {\n\tfont-weight: normal;\n\ttext-transform: capitalize;\n}\n#main_tbl td#totals, #main_tbl td#gross, #main_tbl td#tax, #main_tbl #ships td {\n\tfont-size:20px;\n\ttext-align:right;\n}\n.qnts,.price,.disc{width:50px;text-align: right;}\n.price{width:100px;}\n.total{text-align: right;}\n</style>\n<input type=\"text\" style=\"background: #fbf8d2;width:300px\" name=\"serial\" id=\"serial\" placeholder=\"Enter Serial Number\" />\n";
if (!in_array(525, $perms)) {
    $wars = mysqli_fetch_assoc(dquery("select name from tbl_warehouse\n    where id='" . $w["mywarehouse"] . "'"));
    echo "Warehouse: " . $wars["name"];
    echo "<input type=\"hidden\" name=\"wid\" id=\"wid\" value=\"";
    echo $w["mywarehouse"];
    echo "\" />\n";
} else {
    echo "<select style=\"width: 100px;\" id=\"wid\" name=\"wid\"  >\n  ";
    $s = dquery("select * from tbl_warehouse");
    while ($r = mysqli_fetch_assoc($s)) {
        echo "  <option value=\"";
        echo $r["id"];
        echo "\"\n   ";
        if ($r["id"] == $w["mywarehouse"]) {
            echo "selected";
        }
        echo ">\n  ";
        echo $r["name"];
        echo "  </option>\n  ";
    }
    echo "</select>\n";
}
echo "<select name=\"stype\" id=\"stype\">\n  <option value=\"1\">Sale</option>\n  <option value=\"2\">Return</option>\n</select>\n<br />\n<br />\n<div style=\"width:67%;float:left;min-height:365px;\">\n  <table id=\"main_tbl\">\n    <thead>\n    <th>Item</th>\n      <th>Price</th>\n      <th>Qnt</th>\n      <th>Discount %</th>\n      <th>Total</th>\n      </thead>\n    <tbody id=\"sales\">\n    </tbody>\n  </table>\n</div>\n<div style=\"float: right; width: 31%;\">\n  <div>\n    <table style=\"display: table;margin-bottom:0\" id=\"main_tbl\">\n      <tbody>\n        <tr class=\"even\" id=\"totals\">\n          <td style=\"text-align: left;\">Subtotal : </td><td><span id=\"subtotal\">0</span></td>\n        </tr>\n        ";
if ($config["taxtype"] != "Inclusive") {
    $tx = dquery("select * from tbl_tax");
    while ($rt = mysqli_fetch_assoc($tx)) {
        echo "                    <tr style=\"display: none;\" class=\"";
        echo $rt["name"];
        echo "\"  id=\"tax\">\n                      <td style=\"text-align: left;\">";
        echo $rt["name"];
        echo "  ";
        echo $rt["taxrate"];
        echo "% : </td><td><span class=\"tax_";
        echo $rt["id"];
        echo "\">0</span> </td>\n                    </tr>\n                    ";
    }
}
echo "        <tr  id=\"gross\">\n          <td style=\"text-align: left;\">Total : </td><td><span id=\"total\">0</span> </td>\n        </tr>\n        \n      </tbody>\n    </table>\n  </div>\n  <div style=\"background: #f4f4f4;padding:10px; border: 1px solid rgb(204, 204, 204);border-top:none\">\n    <div id=\"payout\">\n      <table cellspacing=\"10\">\n        <tbody>\n          <tr>\n            <td colspan=\"2\">\n                <div id=\"customer\">\n                  <input type=\"text\" name=\"customer\" id=\"cid\"   value=\"\" placeholder=\"Username\" />\n                  <a onclick=\"javascript: \$('.clients').toggle();\" href=\"#\">+";
echo $LNG["add"];
echo " ";
echo $LNG["client"];
echo " </a>\n                  <div id=\"client\" style=\"display: none;\"></div>\n                  <div style=\"display: none;\" class=\"clients\" >\n                    <input type=\"text\" name=\"firstname\" id=\"firstname\" value=\"\" placeholder=\"First Name\" />\n                    <br />\n                    <input type=\"text\" name=\"lastname\" id=\"lastname\" value=\"\" placeholder=\"Last Name\" />\n                    <br />\n                    <input type=\"text\" name=\"email\" id=\"email\" value=\"\" placeholder=\"Email\" />\n                    <br />\n                    <input type=\"text\" name=\"phone\" id=\"phone\" value=\"\" placeholder=\"Phone\" />\n                    <br />\n                  </div>\n                </div>\n            </td>\n          </tr>\n          <tr>\n            <td colspan=\"2\" class=\"fieldarea\">\n            <select name=\"gateway\" onChange=\"setTax();\"  id=\"gateway\">\n                ";
$q = dquery("select value,gateway from tbl_paymentgateways where setting='POS (Point of sales)' and value = '1'");
while ($row = mysqli_fetch_assoc($q)) {
    $cc = mysqli_fetch_assoc(dquery("select value from tbl_paymentgateways\n                    where setting='name' and gateway='" . $row["gateway"] . "'"));
    echo "                <option value=\"";
    echo $row["gateway"];
    echo "\">\n                ";
    echo $cc["value"];
    echo "                </option>\n                ";
}
echo "              </select>\n              <small style=\"float: right;\">(\n              ";
echo $LNG["payment"];
echo "              ";
echo $LNG["type"];
echo "              )</small> </td>\n          </tr>\n          <tr>\n            <td class=\"fieldarea\" colspan=\"2\">\n            <input type=\"text\" style=\"width: 50px;\"\n             name=\"shipping\" id=\"ship\" onkeyup=\"javascript:updateTotal();\" value=\"0\" />\n              <span class=\"preforms\">\n              ";
echo $config["base_currency"];
echo "              </span> <small style=\"float: right;\">(\n              ";
echo $LNG["shipping"];
echo "              ";
echo $LNG["cost"];
echo "              )</small> </td>\n          </tr>\n          <tr>\n            <td class=\"fieldarea\" colspan=\"2\"><input type=\"text\" \n            style=\"width: 50px;\" name=\"amount\" id=\"pay\" value=\"0\" />\n              <span class=\"preforms\">\n              ";
echo $config["base_currency"];
echo "              </span> <small style=\"float: right;\">(\n              ";
echo $LNG["payment"];
echo "              )</small> </td>\n          </tr>\n          <tr>\n            <td class=\"fieldarea\" colspan=\"2\"><textarea cols=\"15\" style=\"width: 290px;\" name=\"note\" id=\"note\" rows=\"5\" placeholder=\"";
echo $LNG["extra"];
echo " ";
echo $LNG["notes"];
echo "\"></textarea>\n            </td>\n          </tr>\n          <tr>\n            <td colspan=\"2\"><input type=\"checkbox\" name=\"print\" id=\"printi\" value=\"1\" checked=\"checked\" />\n              <label for=\"printi\">Print</label>\n            </td>\n          </tr>\n          <tr>\n            <td>&nbsp;</td>\n          </tr>\n          <tr>\n            <td class=\"fieldarea\" colspan=\"2\"><input type=\"button\" name=\"generate\" value=\"Generate\" onclick=\"generate();\" />\n            </td>\n          </tr>\n        </tbody>\n      </table>\n    </div>\n  </div>\n</div>\n\n";
$fileverioncheck = "6.1.0";

?>