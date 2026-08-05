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
echo "  <div class=\"content\">\n <form action=\"\" id=\"searchclient\" method=\"post\">\n\n <div class=\"panel\">\n            <h2>Search Client</h2>\n            <ol>\n                <li class=\"field\">\n                    <label>Username:\n                        <input type=text id=user name=username>\n                    </label>\n                </li>\n\n\n            </ol>\n\n\n\n            <p><a onclick=\"getClients(document.getElementById('user').value,'#userlist','false','');\"\n            id=\"btnid\" class=\"btn\">Search</a></p>\n\n </div>\n </form>\n\n\n\n\n\n\n      <div  id=\"userlist\" style=\"display: none;\" class=\"panel\">\n\n      </div>\n\n\n\n\n\n\n\n\n\n";

?>