<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

class Tree
{
    /**
     * variable to store temporary data to be processed later
     *
     * @var array
     */
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
    $data["menu_ul"] = "<ul id=\"easymm\"></ul>";
    if ($menu) {
        $tree = new Tree();
        foreach ($menu as $row) {
            $tree->add_row($row["id"], $row["mid"], " id=\"menu-" . $row["id"] . "\" class=\"sortable\"", get_label($row));
        }
        $data["menu_ul"] = $tree->generate_list("id=\"easymm\"");
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
    $label = "<div class=\"ns-row\"><div class=\"ns-title\">" . $row["group_name"] . "</div>" . "<div class=\"ns-actions\"> <a href=\"javascript: load_subpage('main2.php?page=editproductgroup&id=" . $row["id"] . "','Edit')\">Edit</a> <a href=\"javascript:redirectedit('product.listgroup2','" . $row["id"] . "')\">Delete</a>" . "</div>" . "</div>";
    return $label;
}

?>