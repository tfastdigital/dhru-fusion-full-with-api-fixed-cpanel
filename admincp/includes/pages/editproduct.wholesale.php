<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

require_once "includes/fun.inc.php";
include_once ROOTDIR . "/includes/products.fun.php";
if (!$_SESSION["adminid"]) {
    exit("error:invalid token");
}
echo " \n";
$md5id = md5($id);
$product = getProducts("", $md5id);
if (isset($save) && $qnt != "") {
    checkDemoMode(false);
    $def = mysqli_fetch_assoc(dquery("select code from tbl_currencies where `default`='1'"));
    if (${$def["code"]} != "") {
        $data["qnt"] = $qnt;
        $data["pid"] = $id;
        $alrd = mysqli_num_rows(dquery("select * from tbl_wholesaleprice where qnt='" . $qnt . "' and pid='" . $id . "'"));
        if (!$alrd) {
            $sql = dquery("select * from tbl_currencies");
            while ($row = mysqli_fetch_assoc($sql)) {
                if (${$row["code"]} != "") {
                    $data["currency_id"] = $row["id"];
                    $data["credit"] = ${$row["code"]};
                    $db->insert("tbl_wholesaleprice", $data);
                }
            }
            echo "<div id='notification1' class='successbox'>" . $LNG["datasavesuccessfully"] . "</div>";
        } else {
            echo "<div id='notification1' class='errorbox'>" . $LNG["quantity"] . " " . $LNG["already"] . " " . $LNG["exists"] . "</div>";
        }
    } else {
        echo "<div id='notification1' class='errorbox'>" . $LNG["defaultcurnotblank"] . "</div>";
    }
} else {
    if (isset($save)) {
        echo "<div id='notification1' class='errorbox'>" . $LNG["fieldblank"] . "</div>";
    }
}
if ($delete) {
    checkDemoMode(false);
    foreach ($delete as $rem => $v) {
        dquery("delete from tbl_wholesaleprice where pid='" . $id . "' and qnt='" . $rem . "'");
        echo "<div id='notification1' class='successbox'>Quantity removed successfully</div>";
    }
}
if (isset($update) && isset($group)) {
    checkDemoMode(false);
    $def = mysqli_fetch_assoc(dquery("select code from tbl_currencies where `default`='1'"));
    foreach ($group as $q => $a) {
        if (${$def["code"]}[$q]) {
            $data["qnt"] = $_POST["qnt"][$q];
            $sql = dquery("select * from tbl_currencies");
            while ($row = mysqli_fetch_assoc($sql)) {
                $data["credit"] = ${$row["code"]}[$q];
                $check = mysqli_num_rows(dquery("select * from tbl_wholesaleprice where qnt='" . $data["qnt"] . "' and pid='" . $id . "' and currency_id='" . $row["id"] . "'"));
                if ($check) {
                    $db->update("tbl_wholesaleprice", $data, "qnt='" . $data["qnt"] . "' and pid='" . $id . "' and currency_id='" . $row["id"] . "'");
                } else {
                    $data["currency_id"] = $row["id"];
                    $data["pid"] = $id;
                    $db->insert("tbl_wholesaleprice", $data);
                    $data["pid"] = NULL;
                    $data["currency_id"] = NULL;
                    unset($data["pid"]);
                    unset($data["currency_id"]);
                }
            }
            $data = NULL;
        }
    }
    echo "<div id='notification1' class='successbox'>" . $LNG["datasavesuccessfully"] . "</div>";
}
echo "\n \n<div id=\"notification\"></div>\n<div id=\"content\">\n<div id=\"content_padded\">\n\n\n<table id=\"main_tbl\">\n<thead><tr>\n<th>";
echo $LNG["quantity"];
echo "</th>\n";
$sql = dquery("select * from tbl_currencies");
while ($row = mysqli_fetch_assoc($sql)) {
    echo "<th>";
    echo $row["code"];
    echo "</th>\n";
}
echo "<th>";
echo $LNG["action"];
echo "</th>\n</thead>\n<tbody>\n\n<form id=\"frm\" name=\"\" method=\"post\">\n<input type=\"hidden\" value=\"";
echo $id;
echo "\" name=\"id\"/>\n<input type=\"hidden\" name=\"defaultloadpage\" value=\"editproduct.wholesale.php\" />\n";
echo generate_token("form");
echo "\n<tr>\n<td align=\"left\"><input type=\"text\"  class=\"txt small\" name=\"qnt\" value=\"\" /></td>\n";
$sql = dquery("select * from tbl_currencies");
while ($row = mysqli_fetch_assoc($sql)) {
    echo "<td    align=\"left\"><input type=\"text\"  class=\"txt small\" name=\"";
    echo $row["code"];
    echo "\" /></td>\n";
}
echo "<td><input value=\"+ ";
echo $LNG["add"];
echo "\" id=\"btnsubscribe\" type=\"submit\" name=\"save\" class=\"btn add\"/></td>\n</tr>\n\n</form>\n\n<form method=\"post\"><input type=\"hidden\" name=\"defaultloadpage\" value=\"editproduct.wholesale.php\" />\n";
$result = dquery("select * from tbl_wholesaleprice where pid='" . $id . "' group by qnt");
while ($row = mysqli_fetch_assoc($result)) {
    echo "<input type=\"hidden\" name=\"group[]\" />\n<tr>\n<td><input type=\"hidden\" name=\"qnt[]\" value=\"";
    echo $row["qnt"];
    echo "\" />\n<strong>";
    echo $row["qnt"];
    echo "</strong></td>\n    ";
    $sql = dquery("select * from tbl_currencies");
    while ($cur = mysqli_fetch_assoc($sql)) {
        $d = mysqli_fetch_assoc(dquery("select credit from tbl_wholesaleprice where qnt='" . $row["qnt"] . "' and pid='" . $id . "' and currency_id='" . $cur["id"] . "'"));
        echo "        <td><input type=\"text\"  class=\"txt small\" name=\"";
        echo $cur["code"];
        echo "[]\" value=\"";
        echo $d["credit"];
        echo "\" /></td>\n    ";
    }
    echo "<td><input type=\"submit\" class=\"button deletedata\" onclick=\"return confirm('Are you sure want to remove wholesale pirce ?');\" name=\"delete[";
    echo $row["qnt"];
    echo "]\" value=\"Delete\" /></td></tr>\n";
}
echo "<tr><td style=\"text-align: left;\"><input value=\"";
echo $LNG["update"];
echo "\" id=\"btnsubscribe\" class=\"btn\" type=\"submit\" name=\"update\" /></td> <td></td></tr>\n</form>\n</tbody>\n</table>\n\n</div></div>\n<div id=\"page_info\" class=\"page_info\">\n\t<li>Set wholesale price for product e.g. for Single qnt price is 100/unit and 5 qnt price is 85/unit</li>\n</div> \n ";
$fileverioncheck = "6.1.0";

?>