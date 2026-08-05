<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

$pageid = 512;
checkPagePermission($pageid);
$admin_template = $config["admin_template"];
echo "<div id=\"content\">\n\n\n";
if ($delete && $id) {
    dquery("delete from tbl_navigation where id='" . $id . "'");
    dquery("delete from tbl_navigation where groupid='" . $id . "' and locked='0'");
}
echo "\n<style type=\"text/css\">\n\t\t*{margin:0;padding:0}\n\t\t.placeholder{background-color:#cfcfcf;}\n\t\t.ui-nestedSortable-error{background:#fbe3e4;color:#8a1f11;}\n\t\t.default_dg_a2{text-decoration: none;color: #666}\n\n\t\t.ui-sortable li{list-style-type:none;margin-left:20px;}\n\t\t.ui-sortable li div{cursor:move;margin:0;padding:6px 5px;display: block;margin-left:30px}\t\t\t\t\t\n\t\t.ui-sortable li ul{margin:0;padding:0;margin-left:6px;}\n\t\t.ui-sortable li ul,.sortable .last .maincategory ul,.sortable .last .last .maincategory ul{border-left:1px solid #dadada;}\t\t\n\t\t.sortable .last ul,.sortable .last .last ul,.sortable .last .last .last ul{border: none;}\t\t\t\t\t\t\t\n\t\t.ui-sortable li{background: url('images/tree_bg3.png') no-repeat top left;}\n\t\t.ui-sortable .last.nocategory,.ui-sortable .last,.ui-sortable .last.maincategory{background: url('images/tree_bg2.png') no-repeat top left;}\n\n        #search { display :none;\n            z-index:1000 !important;\n            position: fixed;\n            border: 1px solid #ccc;\n            background-color: white;\n            min-width: 200px !important;\n        }\n\n\n</style>\n\n <script src=\"includes/js/jquery.ui.min.js\"></script>\n<script type=\"text/javascript\" src=\"includes/3rdparty/nest/jtest.js\"></script>\n\n<script>\nfunction setLangValue(val,vals){\n    \$(\"#languagevar\").val(val);\n    \$('#finded').html(val);\n    \$(\"#search\").hide();\n    \$(\"#find\").val(vals);\n}\nfunction setDeleted(val){\n    var a=confirm(\"Are you sure want to remove Menu?\");\n    if(a){\n        redirectedit('menumanager&laoddefaultpage=menumaster.php',val+'&delete=true');        \n    }\n}\n\tfunction assignli(){\n\t\t\$('li').removeClass('last');\t\t\n\t\t\$('li:last-child').addClass('last');\n\t\t\$('li').each(function() {\n\t\t\t\$('.ns-row:odd').addClass('odd');\n\t\t\tif(\$(this).find('ul').length>0){\n\t\t\t\t\$(this).addClass('maincategory');\n\t\t\t}\n\t\t\telse{\n\t\t\t\t\$(this).addClass('nocategory');\n\t\t\t}\n\t\t  });\n\t}\n\t\$(document).ready(function(){\n\t   assignli();\n\t\t\$(\"#draggable\").draggable(); \n\t\t\$('ul.sortable').nestedSortable({\n\t\t\tdisableNesting: 'no-nest',\n\t\t\tforcePlaceholderSize: true,\n\t\t\thandle: 'div',\n\t\t\thelper:\t'clone',\n\t\t\titems: 'li',\n\t\t\tmaxLevels: 15,\n\t\t\topacity: .6, \n\t\t\tplaceholder: 'placeholder', \n\t\t\trevert: 250,\n\t\t\ttabSize: 25,\n\t\t\ttolerance: 'pointer',\n\t\t\ttoleranceElement: '> div',\n\t\t\tsubmit: true\n\t\t});\t\t  \t\n\t\t\$('ul.sortable').mouseout(function(){\n\t\t\t\$('li').removeClass('last');\t\t\n\t\t\t\$('li:last-child').addClass('last');\n\t\t\t\$('li').each(function() {\n\t\t\t\t\$('.ns-row:odd').addClass('od`d');\n\t\t\t\tif(\$(this).find('ul').length>0){\n\t\t\t\t\t\$(this).addClass('maincategory');\n\t\t\t\t}\n\t\t\t\telse{\n\t\t\t\t\t\$(this).addClass('nocategory');\n\t\t\t\t}\n\t\t\t  });\n\t\t}); \n\t\t\$('#btn-save-menu').click(function(){\n\t\t\tserialized = \$('ul.sortable').nestedSortable('toHierarchy');\t\t\t\n\t\t});\t\t\t\n\t\t\$(\"#find\").keyup(function(){\n            if(\$(this).val().length>2){\n                \$(\"#search\").show();\n    \t\t    \$.post( \"includes/pages/searchlang.php\",{val: \$(this).val()}, function( data ) {\n                    \$(\"#search\").html( data );\n                });\n            }else{\n                \$(\"#search\").html('');\n                \$(\"#search\").hide();\n            }\n\t\t});\n\t\t\$('#form-menu').submit(function() {\n\t\t\t\$.ajax({\n\t\t\t\ttype: 'POST',\n\t\t\t\turl: 'includes/pages/menugroup.save.php',\n\t\t\t\tdata: {easymm:  serialized},\n\t\t\t\tsuccess: function(data) {\n\t\t\t\t\t \$(\"#notification1\").addClass('successbox');\n\t\t\t\t     \$(\"#notification1\").html(data).show();\n\t\t\t\t}\n\t\t\t});\n\t\t\treturn false;\n\t\t});\n\t\t\n\t});\n\n\tfunction editthis(){\n\t\tserialized = \$('ul.sortable').nestedSortable('toHierarchy');\t\n\t\t\$.ajax({\n\t\t\ttype: 'POST',\n\t\t\turl: 'includes/pages/menugroup.save.php',\n\t\t\tdata: {easymm:  serialized},\n\t\t\tsuccess: function(data) {\n\t\t\t\t \$(\"#notification1\").addClass('successbox');\n\t\t\t     \$(\"#notification1\").html(data).show();\n\t\t\t}\n\t\t});\n\t}\n    \n    function deletethis(){\n    \tdocument.getElementById('form-menu').action='';\n    \tdocument.getElementById('form-menu').submit();\n    }\n    function generatelink(val){\n      if(val){\n            ARR=val.split(\"-\");\n            document.getElementById('link').value=ARR[0];\n      }\n    }\n</script>\n";
echo "\n<link href=\"../includes/icons/menu-icon.css\" rel=\"stylesheet\" />\n\n<div id='notification1' ></div>\n<div id=\"notification\"></div>\n<form id=\"frm\" name=\"\" method=\"post\">\n";
echo generate_token("form");
echo "\n<div  class=\"groupstabes\" >\n  <h2>    \n    <span class=\"groupstabesheadertext\">Add new menu item in Master Navigation</span>\n  </h2>\n  <div class=\"groupstabescontant\">\n  \n<input type=\"hidden\" name=\"id\" value=\"";
echo $id;
echo "\" />\n<input type=\"hidden\" name=\"master\" value=\"1\" />\n<table class=\"form\" border=\"0\" cellpadding=\"3\" cellspacing=\"7\" width=\"100%\">\n<tbody>\n\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["name"];
echo "</td>\n    <td class=\"fieldarea\"><input name=\"name\" id=\"find\" value=\"\" type=\"text\"/>&nbsp;&nbsp;&nbsp;&nbsp;<span id=\"finded\"></span>\n    <input name=\"languagevar\" id=\"languagevar\"  value=\"\" type=\"hidden\"/> \n    <div id=\"search\"></div>\n    <!--\n        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
echo $LNG["or"];
echo " \n        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  ";
echo $LNG["languagevar"];
echo " \n        <input name=\"languagevar\"  value=\"\" type=\"text\"/> \n    -->\n    </td>\n</tr>\n\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["listedin"];
echo " </td>\n    <td class=\"fieldarea\">\n    <select name=\"groupid\">\n    <option value=\"0\">Main Menu</option>\n    ";
if ($OnlyEcommerce) {
    $gr = dquery("SELECT id,name FROM tbl_navigation WHERE groupid='0' \n        and master='1' and name!='IMEI Service' and name!='File Services'\n        and name!='Server Services' and name!='Server Service'");
    while ($row = mysqli_fetch_assoc($gr)) {
    }
    echo "    </select>    </td>\n</tr>\n\n<tr>\n    <td class=\"fieldlabel\">";
    echo $LNG["link"];
    echo "</td>\n    <td class=\"fieldarea\">\n        <input type=\"radio\" name=\"lk\" checked=\"\" onclick=\"\$('#lk').show();\$('#default').hide();\" value=\"link\"/> <label>New Page</label>\n        <input type=\"radio\" name=\"lk\" onclick=\"\$('#lk').hide();\$('#default').show();\"  value=\"default\"/> <label>Existing page</label>\n    </td>\n</tr>\n\n<tr>\n    <td class=\"fieldlabel\"> Page Link </td>\n    <td class=\"fieldarea\">\n    <div id=\"lk\">\n    <input name=\"link\" id=\"link\"  value=\"\" type=\"text\"/>\n    </div>\n    <div id=\"default\" style=\"display: none;\">\n<select name=\"url\" onChange=\"generatelink(this.value)\">\n    <option value=\"\">Select</option>\n    ";
    $sql = dquery("SELECT `id`,`urlname` FROM tbl_cms_pages");
    while ($row = mysqli_fetch_assoc($sql)) {
        echo "    <option value=\"";
        echo $row["urlname"];
        echo "\">";
        echo $row["urlname"];
        echo "</option>\n    ";
    }
    echo "</select>  &nbsp; <a href=\"#\" data-target=\"viewpage\" data-target-header=\"";
    echo $LNG["add"];
    echo " ";
    echo $LNG["new"];
    echo " ";
    echo $LNG["page"];
    echo "\" onclick=\"AddnewInpopup(this);\">";
    echo $LNG["add"];
    echo " ";
    echo $LNG["new"];
    echo " ";
    echo $LNG["page"];
    echo "</a>  \n    </div>\n    </td>\n</tr>\n\n\n<tr>\n    <td class=\"fieldlabel\">";
    echo $LNG["display"];
    echo " </td>\n    <td colspan=\"2\" class=\"fieldarea\">\n    <input type=\"radio\" name=\"display\" id=\"edi\" value=\"1\" checked=\"checked\" /><label for=\"edi\">&nbsp;";
    echo $LNG["yes"];
    echo "</label>\n   &nbsp;&nbsp; <input type=\"radio\" name=\"display\" id=\"ddi\" value=\"0\"  /><label for=\"ddi\">&nbsp;";
    echo $LNG["no"];
    echo "</label>    </td>\n</tr>\n<tr>\n    <td class=\"fieldlabel\">";
    echo $LNG["login"];
    echo " ";
    echo $LNG["required"];
    echo "</td>\n    <td class=\"fieldarea\" colspan=\"2\">\n    <input type=\"radio\" name=\"req_login\" id=\"rdi\" value=\"1\"  /><label for=\"rdi\">&nbsp;";
    echo $LNG["yes"];
    echo "</label>\n   &nbsp;&nbsp; <input type=\"radio\" name=\"req_login\" id=\"rdb\" value=\"0\"  checked=\"\" /><label for=\"rdb\">&nbsp;";
    echo $LNG["no"];
    echo "</label>    </td>\n</tr>\n<!--\n<tr>\n    <td class=\"fieldlabel\">";
    echo $LNG["icon"];
    echo " ";
    echo $LNG["link"];
    echo "</td>\n    <td class=\"fieldarea\" colspan=\"2\">\n    <i class=\"icon\" id=\"view-icon\" style=\"vertical-align:middle;height:60px;width:60px;\"></i>\n    <input type=\"hidden\" name=\"icon\" id=\"icon\" value=\"\" />\n      <a style=\"text-decoration: none;\" class=\"default_dg_a2\" href=\"javascript: void(0)\" \n       onclick=\"window.open('includes/pages/iconlink.php', \n\t  'windowname1','scrollbars=yes,width=500, height=400'); \n\t   return false;\">";
    echo $LNG["pickfromicongallery"];
    echo "</a>\n    </td>\n </tr>\n -->\n<tr>\n    <td class=\"fieldlabel\"></td>\n    <td class=\"fieldarea\"><input type=\"checkbox\" name=\"external\" value=\"1\" id=\"line\" /> <label for=\"line\">";
    echo $LNG["linkexternal"];
    echo "</label>\n        <input type=\"checkbox\" name=\"openinnew\" value=\"1\" id=\"open\" /> <label for=\"open\">";
    echo $LNG["openinnew"];
    echo "</label> \n        <input type=\"checkbox\" name=\"afterloginshow\"  id=\"addi\" value=\"1\"  /> \n        <label for=\"addi\">";
    echo $LNG["dontshowifloged"];
    echo "</label>\n    </td>\n</tr>\n<tr>\n    <td></td>\n    <td class=\"fieldarea\">\n        <input value=\"";
    echo $LNG["add"];
    echo "\" id=\"btnoverview\" class=\"button btn-primary\" type=\"button\"  \nonclick=\"SubmitForm ('#btnoverview','addmenu','#frm','#notification','true','#main_loader');\"/>\n    </td>\n</tr>\n</tbody>\n</table>\n<p class=\"fixedbtn\"></p> \n</div> \n</form>\n \n <br /><br />\n \n<div class=\"groupstabes\">\n<h2>\n    <span class=\"groupstabesheadertext\">Master Navigation Menu Items List</span>\n</h2>\n\n<div>\n";
    $menu = view_tree();
    echo "<form method=\"post\" id=\"form-menu\" action=\"includes/pages/menugroup.save.php\" ><input type='hidden' name='defaultloadpage' value='menumanagermain.php' />";
    echo "<section id=\"demo\">" . $menu["menu_ul"] . "</section>";
    echo "</form></div> \n <fieldset style=\"float:left;margin:10px\">\n    <legend style=\"font: bold; color: #020031; font-size: medium;\">Color</legend>\n    <table>\n    <tr><td><div style=\"background-color:#FF0000; width:10px; height:10px ;\"></div></td><td>Login required</td></tr>\n    </table>\n </fieldset>\n </div>\n</div> \n<br /><br /><br /><br />";
    $fileverioncheck = "6.1.0";
} else {
    $gr = dquery("SELECT id,name FROM tbl_navigation WHERE groupid='0' \n        and master='1'");
}
echo "     <option value=\"";
echo $row["id"];
echo "\" >";
echo $row["name"];
echo "</option>\n    ";
class Tree
{
    public $data = NULL;
    public function add_row($id, $parent, $li_attr, $label)
    {
        $this->data[$parent][] = ["id" => $id, "li_attr" => $li_attr, "label" => $label];
    }
    public function generate_list($ul_attr = "")
    {
        return $this->ul(0, $ul_attr);
    }
    public function ul($parent = 0, $attr = "")
    {
        $indent = str_repeat("\t\t", $i);
        if (isset($this->data[$parent])) {
            if ($attr) {
                $attr = " " . $attr;
            }
            $html = "\n" . $indent;
            $html .= "<ul" . $attr . ">";
            $i++;
            foreach ($this->data[$parent] as $row) {
                $child = $this->ul($row["id"]);
                $html .= "\n\t" . $indent;
                $html .= "<li" . $row["li_attr"] . ">";
                $html .= $row["label"];
                if ($child) {
                    $i--;
                    $html .= $child;
                    $html .= "\n\t" . $indent;
                }
                $html .= "</li>";
            }
            $html .= "\n" . $indent . "</ul>";
            return $html;
        } else {
            return false;
        }
    }
    public function clear()
    {
        $this->data = [];
    }
}
function view_tree()
{
    $tbl_name = "tbl_navigation";
    $menu = get_menu($tbl_name);
    $data["menu_ul"] = "<ul class=\"sortable\" id=\"easymm\"></ul>";
    if ($menu) {
        $tree = new Tree();
        foreach ($menu as $row) {
            $tree->add_row($row["id"], $row["groupid"], " id=\"menu-" . $row["id"] . "\" class=\"sortabled\" ", get_label($row));
        }
        $data["menu_ul"] = $tree->generate_list("class=\"sortable\" id=\"easymm\" ");
    }
    return $data;
}
function get_menu($tbl_name)
{
    global $OnlyEcommerce;
    if ($OnlyEcommerce) {
        $result = dquery("SELECT * FROM tbl_navigation WHERE master='1'\n         and name!='IMEI Service' and name!='File services'  and name!='File service'\n        and name!='Server Services' and name!='Server Service'");
        while ($row = mysqli_fetch_assoc($result)) {
        }
        return $data;
    }
    $result = dquery("SELECT * FROM `tbl_navigation` WHERE master='1'\n        ORDER BY groupid , `order`");
    $data[] = $row;
}
function get_label($row)
{
    if ($row["req_login"]) {
        $flag = "textred";
    } else {
        $flag = "";
    }
    if ($row["locked"] == 1) {
        $label = "<div class=\"ns-row spc " . $flag . "\"  title=\"Default menu level cant change\">" . $row["name"] . "<span style=\"float: right;\">";
        $label .= "<a class='default_dg_a2 editdata' \n    onclick=\"load_subpage('main2.php?page=editmenu&id=" . $row["id"] . "','Edit Menu');\">Edit</a>";
    } else {
        $label = "<div class=\"ns-row " . $flag . "\">" . $row["name"] . "<span style=\"float: right;\">";
        $label .= "        \n\t <a class='default_dg_a2 deletedata'\n     href=\"javascript: setDeleted(" . $row["id"] . ");\">Delete</a> |";
        $label .= "<a class='default_dg_a2 editdata' \n    onclick=\"load_subpage('main2.php?page=editmenu&id=" . $row["id"] . "','Edit Menu');\"> Edit</a>";
    }
    $label .= "</span></div>";
    return $label;
}

?>