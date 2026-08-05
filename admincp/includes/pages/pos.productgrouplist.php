<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

if (!isset($_SESSION[adminid])) {
    exit;
}
echo "<head>\n<style type=\"text/css\">\n\t\t*{margin:0;padding:0}\n        ul{padding:5px 0px 5px 20px}\n        ul li{padding:5px 0}\n\t\t.placeholder{background-color:#cfcfcf;}\n\t\t.ui-nestedSortable-error{background:#fbe3e4;color:#8a1f11;}\n\t\t.default_dg_a2{text-decoration: none;color: #666}\n\t\t.ns-row:hover{background-color:#FDFDE7 !important;}\n\t\t.ns-row{border-bottom:#f1f1f1 solid 1px;}\n\t\t.ui-sortable li{list-style-type:none;margin-left:20px;font-size:12px}\n\t\t.ui-sortable li div{cursor:move;margin:0;padding:8px 5px;display: block;margin-left:30px}\t\t\t\t\t\n\t\t.ui-sortable li ul{margin:0;padding:0;margin-left:6px;}\n\t\t.ui-sortable li ul,.sortable .last .maincategory ul,.sortable .last .last .maincategory ul{border-left:1px solid #dadada;}\t\t\n\t\t.sortable .last > ul{border: none;}\t\t\t\t\t\t\t\n\t\t.ui-sortable li{background: url('images/tree_bg3.png') no-repeat top left;}\n\t\t.ui-sortable .last.nocategory,.ui-sortable .last,.ui-sortable .last.maincategory{background: url('images/tree_bg2.png') no-repeat top left;}\n\t\t.sortable .odd{background-color:#fbfbfb;}\n        .ui-sortable li:hover{color:black;font-weight: bold;font-size:12px}\t                                 \n</style>\n\n\n<script type=\"text/javascript\" src=\"includes/3rdparty/nest/jquery.ui.nestedSortable.js\"></script>\n\n<script>\n       \n    var obj=\$('ul.sortable');     \n   \n\tfunction assignli(){\t\t                 \n        \$('li',obj).removeClass('last');\t\t\n\t\t\$('li:last-child',obj).addClass('last');\n\t\t\$('li',obj).each(function() {\n\t\t\t\$('.ns-row:odd',obj).addClass('odd');\n\t\t\tif(\$(obj).find('ul').length>0){\n\t\t\t\t\$(obj).addClass('maincategory');\n\t\t\t}\n\t\t\telse{\n\t\t\t\t\$(obj).addClass('nocategory');\n\t\t\t}\n\t\t  });\n\t}\n\t\$(document).ready(function(){\n\t   \n\t   assignli();\n\t\t//\$(\"#draggable\").draggable(); \n\t\t\$(obj).nestedSortable({\n\t\t\tdisableNesting: 'no-nest',\n\t\t\tforcePlaceholderSize: true,\n\t\t\thandle: 'div',\n\t\t\thelper:\t'clone',\n\t\t\titems: 'li',\n\t\t\tmaxLevels: 15,\n\t\t\topacity: .6, \n\t\t\tplaceholder: 'placeholder', \n\t\t\trevert: 250,\n\t\t\ttabSize: 25,\n\t\t\ttolerance: 'pointer',\n\t\t\ttoleranceElement: '> div',\n\t\t\tsubmit: true\n\t\t});\t\n        \n        \n        \n/*         \t  \t\n\t\t\$('ul.sortable').mouseout(function(){\t\t   \n\t\t\t\$('li').removeClass('last');\t\t\n\t\t\t\$('li:last-child').addClass('last');\n\t\t\t\$('li').each(function() {\n\t\t\t\t\$('.ns-row:odd').addClass('odd');\n\t\t\t\tif(\$(this).find('ul').length>0){\n\t\t\t\t\t\$(this).addClass('maincategory');\n\t\t\t\t}\n\t\t\t\telse{\n\t\t\t\t\t\$(this).addClass('nocategory');\n\t\t\t\t}\n\t\t\t  });\n\t\t});\n        \n        \n        \n        \n\t\t\$('#btn-save-menu').click(function(){\n\t\t\tserialized = \$('ul.sortable').nestedSortable('toHierarchy');\t\t\t\n\t\t});\t\t\t\n\t\t\n \t\t\$('#form-menu').submit(function() {\t\t      \n \t\t\t\$.ajax({\n \t\t\t\ttype: 'POST',\n \t\t\t\turl: 'includes/pages/product.listgroup2.save.php',\n \t\t\t\tdata: {easymm:  serialized},\n \t\t\t\tsuccess: function(data) {\n \t\t\t\t\t \$(\"#notification1\").addClass('successbox');\n \t\t\t\t     \$(\"#notification1\").html(data).show();\n \t\t\t\t}\n \t\t\t});\n \t\t\treturn false;\n \t\t});\n */\n\t\t\n\t});\n\n\tfunction editthis(){\t      \n\t\tserialized = \$(obj).nestedSortable('toHierarchy');\n                \t\n\t\t\$.ajax({\n\t\t\ttype: 'POST',\n\t\t\turl: 'includes/pages/product.listgroup2.save.php',\n\t\t\tdata: {easymm:  serialized},\n\t\t\tsuccess: function(data) {\n\t\t\t\t \$(\"#notification1\").addClass('successbox');\n\t\t\t     \$(\"#notification1\").html(data).show();\n                 assignli();                                   \n\t\t\t}\n\t\t});\n\t}\n    \n    function deletethis(){\n        if(confirm('Are you sure want to remove Group ?')){\n    \t   document.getElementById('form-menu').action='';\n    \t   document.getElementById('form-menu').submit();\n        }\n    }\n</script>\n\n\n\n</head>\n";
if ($id) {
    $flag = true;
    if (mysqli_num_rows(dquery("select id from tbl_products where group_id='" . $id . "'"))) {
        echo "<div id='notification1' class='errorbox'>Group has products so please remove it first to proceed.</div>";
    } else {
        dquery("delete from tbl_product_group where id='" . $id . "'");
        echo "<div id='notification1' class='successbox'>Group removed successfully</div>";
    }
}
if ($ids) {
    $flag = true;
    if (count($ids)) {
        foreach ($ids as $v => $k) {
            dquery("update tbl_products set active=0 where group_id='" . $v . "'");
            dquery("delete from tbl_product_group where id='" . $v . "'");
        }
        if (!$flag) {
            echo "<div id='notification1' class='errorbox'>Group has products so please remove it first to proceed.</div>";
        } else {
            echo "<div id='notification1' class='successbox'>Group removed successfully</div>";
        }
    } else {
        echo "<div id='notification1' class='errorbox'>Please select any group</div>";
    }
}
echo "<div id='notification1' ></div>\n\n\n";
$menu = view_tree();
echo "<form method=\"post\" id=\"form-menu\" action=\"includes/pages/product.listgroup2.save.php\" ><input type='hidden' name='defaultloadpage' value='product.listgroup3.php' />";
echo "<section id=\"demo\">" . $menu["menu_ul"] . "</section>";
echo "<br /><div align='right'><input type='button' name='delete' class=button_remove value='Delete Selected' onclick='deletethis();' /></div> </form> \n  ";
$fileverioncheck = "6.1.0";
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
    $tbl_name = "tbl_product_group";
    $menu = get_menu($tbl_name);
    $data["menu_ul"] = "<ul class=\"sortable\" id=\"easymm\"></ul>";
    if ($menu) {
        $tree = new Tree();
        foreach ($menu as $row) {
            $tree->add_row($row["id"], $row["mid"], " id=\"menu-" . $row["id"] . "\" class=\"sortabled\" ", get_label($row));
        }
        $data["menu_ul"] = $tree->generate_list("class=\"sortable\" id=\"easymm\" ");
    }
    return $data;
}
function get_menu($tbl_name)
{
    $result = dquery("SELECT * FROM `tbl_product_group` ORDER BY mid , display_order");
    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
    }
    return $data;
}
function get_label($row)
{
    $label = "<div class=\"ns-row\"><span class=\"searchme\">" . html_entity_decode($row["group_name"]) . "</span><span style=\"float: right;\">" . "<a class='default_dg_a2 editdata' onclick=\"load_subpage('main2.php?page=editproductgroup&id=" . $row["id"] . "','Edit Product Group');\">Edit</a>" . "  &nbsp;&nbsp; <input type='checkbox' id='i_" . $row["id"] . "' name='ids[" . $row["id"] . "]' /><label for='i_" . $row["id"] . "'></label> " . "</span></div>";
    return $label;
}

?>