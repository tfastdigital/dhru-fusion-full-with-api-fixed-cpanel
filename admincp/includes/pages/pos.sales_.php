<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

echo "<ul id=\"tabmenu\">\n    <li><a class=\"tabmenu_active\" href=\"#\">Sales</a></li>\n</ul>\n";
error_reporting(0);
licince\reqaddon("POS");
$pageid = 487;
checkPagePermission($pageid);
unset($_SESSION["SALES"]);
unset($_SESSION["SERIAL"]);
unset($_SESSION["WAREHOUSE"]);
unset($_SESSION["CUSTOMER"]);
unset($_SESSION["DISCOUNTED"]);
unset($_SESSION["DESIRED"]);
unset($_SESSION["STYPE"]);
unset($_SESSION["AMOUNT"]);
unset($_SESSION["NOTES"]);
unset($_SESSION["GATEWAYS"]);
$_SESSION["DTYPE"] = 1;
$_SESSION["TOTALS"] = 0;
$w = mysqli_fetch_assoc(dquery("select mywarehouse from tbl_admin where id='" . $_SESSION["adminid"] . "'"));
if ($w["mywarehouse"]) {
    $_SESSION["WAREHOUSE"] = $w["mywarehouse"];
} else {
    $w = mysqli_fetch_assoc(dquery("select id from tbl_warehouse limit 1"));
    $_SESSION["WAREHOUSE"] = $w["id"];
}
$pos = mysqli_fetch_assoc(dquery("select * from tbl_pos_setting"));
echo "<script>\nfunction openInvoice(){\n    var reply=confirm(\"Do you want to complete sale\");\n    if(reply){\n        var a=\$('#amount').val();\n        var n=\$('#note').html();\n        var s=\$('#stype').val();\n        var i=\$('#printi:checked').val();\n        \$.post(\"includes/pages/pos.sales.add.php?generate=true\", { amount: a,note :n,stype :s},function(data) {\nnewwindow=window.open('includes/pages/printinvoice.php?action=";
echo $pos["template"];
echo "&print='+i,'name','scrollbars=yes,resizeable=yes,menubar=no,height=650,width=650');\n            if (window.focus) {newwindow.focus()}\n        });\n    }\n}\n//////////////////////////////////////////\n \nfunction gener(e){\n     var fieldParent = \$('#pid').parents('#product');\n             var fieldChild  = \$('#pid').find('#product');\n       \n             switch (e.which)\n             {\n                 case 40: { keyEvent(\$('#product'),'next');break; }\n                 case 38: { keyEvent(\$('#product'),'prev');break; }\n                 case 13:\n                 {\n                      \$('#pid').val(\$(\"li[class='selected'] a\").attr('class'));\n                      \$('#product').hide();\n                      \$(\"li[class='selected'] a\").removeAttr('class'); \n                        return false;\n                        break;\n                 }\n                 case 9:\n                 {\n                        offFocus('#pid'); \$(\"li\").removeClass(\"selected\");\n                        break;\n                 }\n             }\n}\nfunction gener2(e){\n     var fieldParent = \$('#cid').parents('#customer');\n             var fieldChild  = \$('#cid').find('#customer');\n       \n             switch (e.which)\n             {\n                 case 40: { keyEvent2(\$('#customer'),'next');break; }\n                 case 38: { keyEvent2(\$('#customer'),'prev');break; }\n                 case 13:\n                 {\n                      setVLL1(\$(\"li[class='selectedc'] a\").attr('class'));\n                      if(\$(\"#cid\").val()!=\"\"){\n                      \$('#gateway').focus();\n                      }\n                      return false;\n                      break;\n                 }\n                 case 9:\n                 {\n                        offFocus('#pid'); \$(\"li\").removeClass(\"selected\");\n                        break;\n                 }\n             }\n}\nfunction keyEvent2 (fieldChild,action)\n{\n            yx = 0;\n            fieldChild.find(\"li\").each(function(){\n                if(\$(this).attr(\"class\") == \"selectedc\")\n                yx = 1;\n            });\n            if(yx == 1)\n            {\n              \n                var sel = fieldChild.find(\"li[class='selectedc']\");\n                (action=='next') ? sel.next().addClass(\"selectedc\") : sel.prev().addClass(\"selectedc\");\n                sel.removeClass(\"selectedc\");\n            }\n            else{\n                (action=='next') ? fieldChild.find(\"li:first\").addClass(\"selectedc\") : fieldChild.find(\"li:last\").addClass(\"selectedc\");\n            }\n} \nfunction keyEvent (fieldChild,action)\n{\n            yx = 0;\n            fieldChild.find(\"li\").each(function(){\n                if(\$(this).attr(\"class\") == \"selected\")\n                yx = 1;\n            });\n            if(yx == 1)\n            {\n              \n                var sel = fieldChild.find(\"li[class='selected']\");\n                (action=='next') ? sel.next().addClass(\"selected\") : sel.prev().addClass(\"selected\");\n                sel.removeClass(\"selected\");\n            }\n            else{\n                (action=='next') ? fieldChild.find(\"li:first\").addClass(\"selected\") : fieldChild.find(\"li:last\").addClass(\"selected\");\n            }\n} \nfunction offFocus(fieldChild)\n{\n    var fieldParent =  \$(fieldChild).parents('div.' + config.className);\n    fieldParent.children('div#product').delay(config.fadeTime).fadeOut();\n}           \n   \n///////////////////////////////////////\n \$(document).ready(function() {\n    \$(\"#pid\").val('');\n    \$(\"#pid\").focus();\n////////////////////////////\njQuery.fn.enter2tab = function()\n{\n    this.keyup(function(e){\n        var key = e.charCode ? e.charCode : e.keyCode ? e.keyCode : 0;\n        if(key==46){\n           Remove(\$(this).parent().parent().attr('id'));\n           jQuery.stop(e);\n           return false;\n        }else if(key==13){ \n            var inputs = \$(this).closest('form').find(':input');\n            inputs.eq( inputs.index(this)+ 1 ).focus();\n            if(\$(this).hasClass('discs')){\n                 if(\$('.discs:last').attr('id')==\$(this).attr('id')){\n                    \$('#cid').val('');\n                    \$('#cid').focus();\n                 }\n            }\n        }else{\n            updateData(\$(this).parent().parent().attr('id'));\n        }\n      \n    });\n   return this;\n}\n///////////////////////////\n    \$('#pid').keypress(function(e){\n        \n          if(e.which == 13){\n               var ids=\$(this).val();\n               if(ids!='' && !isNaN(ids)){               \n                \$('#pid').val('');\n                addItem(ids);\n             }else{\n                 if(\$('#pid').val()==''){\n                              \$(\".prices:first\").focus();\n                }\n             }\n           }\n    });\n      \n    \$('#gateway').keypress(function(e){\n          if(e.which == 13){\n                \$('#amount').focus();\n          }\n    });\n    \$('#amount').keypress(function(e){\n          if(e.which == 13){\n                \$('#note').focus();\n          }\n    });\n    \$('#note').keypress(function(e){\n          if(e.which == 13){\n                \$('#geninv').focus();\n          }\n    });   \n    \$('#frm').submit(function() {\n          return false;\n    });\n    \n    \n      \n    \$('#pid').keyup(function(e) {\n        var vls=\$(this).val();\n        if((e.which>=65 && e.which<=90) || (e.which>=48 && e.which<=57) || (e.which>=96 && e.which<=105)){\n            \$.post(\"includes/pages/pos.sales.product.php\", { val: vls},function(data) {\n                 \$('#product').show();\n                 \$('#product').html(data);\n                 \n            });\n        }else if(e.which==40 || e.which==38 || e.which==13){\n              gener(e);\n        }    \n       \n    });\n    \$('#cid').keyup(function(e) {\n          var vls=\$(this).val();\n          if((e.which>=65 && e.which<=90) || (e.which>=48 && e.which<=57)  || (e.which>=96 && e.which<=105)){ \n            \$.post(\"includes/pages/pos.sales.product.php?client=true\", { val: vls},function(data) {\n                 \$('#client').show();\n                 \$('#client').html(data);\n            });\n          }else if(e.which==40 || e.which==38 || e.which==13){\n                  gener2(e);\n          }  \n        \n    });    \n});\nfunction addItem(ids){\n    if(ids!='' && !isNaN(ids)){\n        \$('#pid').val('');\n        \$.post(\"includes/pages/pos.sales.add.php\", { val: ids},function(data) {\n            \n               data=data.explode('---');\n              \n               if(data[1]==\"NOT\"){\n                    alert(\"Desired Quantity is Insufficient in this warehouse.\");\n               }\n               if(data[1]==\"ABS\"){\n                    alert(\"Desired Quantity is Insufficient in this warehouse.\");\n               }else{\n                 \$('#tbody').append(data[0]);\n                 setTotal();\n               }\n                            \n        });\n    }\n}\nfunction setDiscount(val){\n  \$.post(\"includes/pages/pos.sales.add.php?discount=\"+val, function(data) {\n       \$('#gross').html('Total: '+data+' ";
echo $config["base_currency"];
echo "')        \n       \$('#amount').val(data);\n  });\n}\nfunction setTotal(){    \n      \$.post(\"includes/pages/pos.sales.add.php?total=true\", function(data) {\n            \$('#totals').html(data);\n      });\n      setTax();\n}\nfunction setTax(){\n      ids=\$('#gateway').val();\n      \$.post(\"includes/pages/pos.sales.add.php?tax=true\",{ gateway: ids}, function(data) {\n            \$('#net').html(data);\n            var newv=\$('#gross').html().replace('Total:','');\n            var newv=newv.replace(' ','');\n            var newv=newv.replace('";
echo $config["base_currency"];
echo "','');\n            \$('#amount').val(newv);\n      });\n}\nfunction setWarehouse(){\n      ids=\$('#wid').val();\n      \$.post(\"includes/pages/pos.sales.add.php?warehouse=true\",{ idw: ids}, function(data) {\n      });\n}\nfunction Remove(ids){\n    if(confirm(\"Are you sure want to remove ?\")){\n    \$.post(\"includes/pages/pos.sales.add.php?remove=true\", { val: ids},function(data) {\n        \$(\"#\"+ids).remove();\n        setTotal();\n    });\n    }\n    return false;\n}\nfunction setWet(val){\n    if(val==''){\n        document.getElementById('pid').value='Name / Barcode / Serial No';\n    }\n}\nfunction setClk(val){\n    if(val=='Name / Barcode / Serial No'){\n        document.getElementById('pid').value='';\n    }\n}\nfunction setWet1(val){\n    if(val==''){\n        document.getElementById('cid').value='Client ID / Username / Mob No.';\n    }\n}\nfunction setClk1(val){\n    if(val=='Client ID / Username / Mob No.'){\n        document.getElementById('cid').value='';\n    }\n}\nfunction setVLL(vals){\n    document.getElementById('pid').value=vals;\n    \$('#product').hide();\n}\nfunction setVLL1(vals){\n    if(vals!=undefined){\n        document.getElementById('cid').value=vals;\n        \$('#client').hide();\n        \$.post(\"includes/pages/pos.sales.add.php?customer=true\", { val: vals},function(data) {\n                  \$('#customer').html(data);                  \n        });\n    }else{\n        document.getElementById('cid').value='';\n    }\n}\nfunction detach(){\n     \$.post(\"includes/pages/pos.sales.add.php?detach=true\", function(data) {              \n              \$('#customer').html(data);              \n    });\n}\nfunction setTo(ob){\n        ob.enter2tab();\n}\nfunction suspend(){\n    \$.post(\"includes/pages/pos.sales.add.php?suspend=true\",function(data) {\n        if(data=='NOT'){\n                alert(\"No item in sale to suspend\");\n        }else{\n            window.location.reload(true);\n        }\n   }); \n}\nfunction updateData(ids){\n    qnt=document.getElementById('qnt['+ids+']').value;\n    price=document.getElementById('price['+ids+']').value;\n    disc=document.getElementById('disc['+ids+']').value;\n\n    \$.post(\"includes/pages/pos.sales.add.php?update=true\", { val: ids,q: qnt,p: price,d: disc},function(data) {\n        var check=data.explode(\"---\");\n        if(check[0]=='NOT'){\n            data=check[1];\n            alert(\"Desired Quantity is Insufficient in this warehouse. You can still process the sale, but check your inventory \");\n        }\n        if(check[0]=='ABS'){\n               alert(\"Desired Quantity is Insufficient in this warehouse. You can still process the sale, but check your inventory \");\n        }else{\n            \$('#tot_'+ids).html(data);\n            setTotal();\n        }\n        \n    });    \n}\nfunction setSuspended(val){\n    \$.post(\"includes/pages/pos.sales.add.php?setsuspended=true\", { id: val},function(data) {\n        if(data){\n                setVLL1(data);\n         \$.post(\"includes/pages/pos.sales.add.php?setsuspended=true&step=next\", { id: val},function(data)\n          {\n            \n                data=data.explode('--');\n               \$('#tbody').html(data[0]);\n                setTotal();\n                if(data[1]!='1'){\n                    document.getElementById('type').checked=false;\n                }  \n         });\n        }\n    });   \n}\nfunction setType(ob){\n    if(ob.checked){\n        ids=1;\n    }else{\n        ids=0;\n    }\n    \n    \$.post(\"includes/pages/pos.sales.add.php?type=true\", { val: ids},function(data) {\n        setTotal();\n    }); \n  \n \n     \$('#tbody tr').each(function(){\n        ids= \$(this).attr('id');\n         updateData(ids); \n    });\n}\n\n</script>\n<style>    \n.form{margin-bottom: 4px !important;}\n#product,#client{position: absolute;background: white;min-width:200px;border:#dddddd solid 1px;}\n#product li,#client li{border-bottom: #f5f5f5 solid 1px;padding:5px;list-style: none;}\n.selected,.selectedc{background-color: #e6e5e5;}\n.fieldlabel{font-size:14px}\ninput[type=\"text\"],select,textarea{background: white;}\n#totals,#tax,#gross{font-size: 14px;text-align: right;}\n#totals{background: #53637D;color:white}\n#tax{background: white;}\n#gross{background: #779500;color:white}\n#disc{background: #EBAC9A;color:white}\n.textred{font-size:10px}\nfieldset{background:#f5f5f4;}\nfieldset legend{background: #eaeaea;padding:5px 10px;font-size: 14px;margin-left: 0 !important;}\n#main_tbl thead th{background-image: none !important;background-color: #53637D !important;color:white !important;padding:8px 5px}\n#main_tbl td,#main_tbl th{border-right: #cccccc solid 1px;}\n#customer .fieldlabel{font-weight: normal;text-transform: capitalize;}\n</style> \n\n\n<div id=\"content\">\n<div id=\"notification\"></div>\n<div id=\"content_padded\">\n\n";
echo generate_token("form");
echo "\n<div style=\"background: #f4f4f4;padding:10px\">\n <form id=\"frm\" name=\"\" method=\"post\">\n        <table>\n            <tr>\n                <td align=\"left\">\n                    <input type=\"text\" name=\"pid\" id=\"pid\" onclick=\"setClk(this.value)\" onblur=\"setWet(this.value)\" autocomplete=\"off\"  value=\"Name / Barcode / Serial No\" style=\"width:180px\"/>\n                    <input type=\"button\" class=\"addFromgallery\" onclick=\"addItem(document.getElementById('pid').value)\" name=\"additem\" value=\"";
echo $LNG["add"];
echo " ";
echo $LNG["item"];
echo "\" />                          \n                    <div style=\"display: none;z-index:999\" id=\"product\"></div>\n                </td>\n                <td align=\"center\">\n                    ";
echo $LNG["sales"];
echo " ";
echo $LNG["type"];
echo " : <select id=\"stype\" name=\"stype\"><option value=\"1\">Sale</option> <option value=\"2\">Return</option></select>\n                </td>\n                <td align=\"center\">\n                    ";
$w = mysqli_fetch_assoc(dquery("select mywarehouse from tbl_admin where id='" . $_SESSION["adminid"] . "'"));
echo "                    ";
echo $LNG["warehouse"];
echo " : <select style=\"width: 100px;\" id=\"wid\" name=\"wid\"  onchange=\"setWarehouse();\">  ";
$s = dquery("select * from tbl_warehouse");
while ($r = mysqli_fetch_assoc($s)) {
    echo " <option value=\"";
    echo $r["id"];
    echo "\" ";
    if ($r["id"] == $w["mywarehouse"]) {
        echo "selected";
    }
    echo ">";
    echo $r["name"];
    echo "</option>     ";
}
echo "</select>  \n                </td>\n                <td align=\"right\">\n                    <input type=\"button\" class=\"btn\"\n    onclick=\"window.open ('includes/pages/pos.suspened.php', 'newwindow', config='height=500,width=600,toolbar=no, menubar=no, scrollbars=no, resizable=no,location=no, directories=no, status=no')\" name=\"suspendedSales\" value=\"";
echo $LNG["suspended"];
echo " ";
echo $LNG["sales"];
echo "\" />\n                </td>\n            </tr>\n        </table>            \n </form> \n</div>\n  \n         \n <div style=\"position: relative;min-height:200px;background:#f4f4f4\">\n    <div style=\"float: left;width:100%;\">                        \n         <form id=\"frm\" name=\"\" method=\"post\">\n            <table id=\"main_tbl\" style=\"display: table;border: #53637D solid 5px;\">\n                <thead>\n                    <tr>\n                    <th style=\"width:10%;\">";
echo $LNG["item"];
echo "#</th>\n                    <th style=\"width:30%;\">";
echo $LNG["item"];
echo " ";
echo $LNG["name"];
echo "</th>\n                    <th style=\"width:15%;text-align: center;\">";
echo $LNG["price"];
echo " [";
echo $config["base_currency"];
echo "]</th>\n                    <th style=\"width:10%;text-align: center;\">";
echo $LNG["qnt"];
echo "</th>\n                    <th style=\"width:20%; text-align: center;\"><input type=\"checkbox\" onclick=\"setType(this)\" checked=\"checked\" name=\"type\" id=\"type\" value=\"1\" /> ";
echo $LNG["discount"];
echo " (In %)</th>\n                    <th style=\"width:15%;text-align: right;\">";
echo $LNG["total"];
echo " [";
echo $config["base_currency"];
echo "]</th>\n                    </tr>\n                </thead>\n                <tbody id=\"tbody\"></tbody>\n            </table>\n        </form>\n                \n    </div>         \n    \n    <div style=\"float: right;width:150px;text-align: right;\">            \n                \n        <table id=\"main_tbl\" style=\"display: table;\">        \n            <tr>                \n                <td style=\"width:100%;\"  id=\"totals\">Subtotal: 0 ";
echo $config["base_currency"];
echo "</td>\n            </tr>\n            <tbody id=\"net\"></tbody>\n        </table> \n    </div>\n    \n    <div style=\"float: left;width:30%\">      \n        <div id=\"customer\" style=\"padding: 10px;\">           \n            <table  border=\"0\" cellpadding=\"0\" cellspacing=\"0\" class=\"form\">\n                <tbody>                \n                    <tr>\n                        <td>\n                            <input type=\"text\" name=\"customer\" id=\"cid\" style=\"width: 200px;\" onclick=\"setClk1(this.value)\" onblur=\"setWet1(this.value)\" value=\"Client ID / Username / Mob No.\" />\n                            <div id=\"client\" style=\"display: none;\"></div>\n                            <br /><br />OR <br /><br /><a onclick=\"load_subpage('main2.php?page=addnewclient','";
echo $LNG["addnewclient"];
echo "');\">+Add New Client</a>                            \n                        </td>                                        \n                    </tr>                                \n                </tbody>\n            </table>\n        </div>\n    </div>\n    \n    <div style=\"float: left;padding:10px;width:45%\">      \n        <div id=\"payout\">\n            <table  border=\"0\"  style=\"float: left;\" cellpadding=\"10\" cellspacing=\"10\">\n                <tbody>                \n                <tr>\n                    <td style=\"text-align: left;\">";
echo $LNG["payment"];
echo " ";
echo $LNG["type"];
echo "</td>\n                    <td class=\"fieldarea\">\n                 <select name=\"gateway\" onchange=\"setTax();\"  style=\"width: 100px;\" id=\"gateway\">\n                 ";
$q = dquery("select value,gateway from tbl_paymentgateways where setting='POS (Point of sales)' and value = '1'");
while ($row = mysqli_fetch_assoc($q)) {
    $cc = mysqli_fetch_assoc(dquery("select value from tbl_paymentgateways\n                    where setting='name' and gateway='" . $row["gateway"] . "'"));
    echo "                <option value=\"";
    echo $row["gateway"];
    echo "\">";
    echo $cc["value"];
    echo "</option>\n                ";
}
echo "                 </select>\n                    </td>\n                </tr>\n                \n                <tr>\n                    <td style=\"text-align: left;\">";
echo $LNG["payment"];
echo "</td>\n                    <td class=\"fieldarea\">\n                    <input type=\"text\" style=\"width: 100px;\" name=\"amount\" id=\"amount\" value=\"0\" /> ";
echo $config["base_currency"];
echo "                    </td>\n                </tr>\n                <tr>\n                    <td style=\"text-align: left;\">";
echo $LNG["extra"];
echo " ";
echo $LNG["notes"];
echo "</td>\n                    <td class=\"fieldarea\">\n                <textarea cols=\"15\" style=\"width: 150px;\" name=\"note\" id=\"note\" rows=\"3\"> </textarea>\n                    </td>\n                </tr>\n                <tr>\n                    <td></td>\n                    <td><input type=\"checkbox\" name=\"print\" id=\"printi\" value=\"1\" checked=\"checked\" /><label for=\"printi\">Print</label>   </td>\n                </tr>\n                <tr>\n                    <td></td>\n                    <td class=\"fieldarea\">\n                    <input type=\"button\" class=\"btn save\" onclick=\"openInvoice();\" id=\"geninv\" name=\"generate\" value=\"";
echo $LNG["generate"];
echo " ";
echo $LNG["invoice"];
echo "\" />\n                    <input type=\"button\" class=\"button_remove\" onclick=\"suspend();\" name=\"suspend\" value=\"";
echo $LNG["suspend"];
echo " ";
echo $LNG["sale"];
echo "\" />                                  \n                    </td>\n                </tr>\n                </tbody>\n            </table>\n        </div>\n    </div>\n    \n    <div style=\"clear: both;\"></div>            \n</div> \n";
$fileverioncheck = "6.1.0";

?>