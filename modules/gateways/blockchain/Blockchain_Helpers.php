<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

if (!class_exists("Blockchain_DB")) {
    require_once __DIR__ . "/Blockchain_DB.php";
}
function _createTable()
{
    $DB = new Blockchain_DB();
    $query = "CREATE TABLE IF NOT EXISTS blockchain_payments (\ninvoice_id int(11) NOT NULL, \namount float(11,8) NOT NULL, \naddress varchar(64) NOT NULL, \nsecret varchar(64) NOT NULL, \nconfirmations int(11) NOT NULL DEFAULT 0, \nstatus enum(\"unpaid\", \"confirming\", \"paid\") NOT NULL DEFAULT \"unpaid\", \nPRIMARY KEY (invoice_id)\n)";
    $rtn = $DB->mysqlQuery($query);
    return $rtn;
}
function _getPaymentDataByInvoiceId($invoiceId = 0)
{
    $DB = new Blockchain_DB();
    $query = "SELECT * FROM blockchain_payments WHERE invoice_id=%s";
    $rtn = $DB->fetch_assoc($DB->mysqlQuery($query, $invoiceId));
    return $rtn;
}
function _getPaymentDataBySecretAndAddress($secret = "", $address = "")
{
    $DB = new Blockchain_DB();
    $query = "SELECT * FROM blockchain_payments WHERE secret=%s AND address=%s";
    $rtn = $DB->fetch_assoc($DB->mysqlQuery($query, $secret, $address));
    return $rtn;
}
function _getWHMCSInvoice($invoiceId = 0)
{
    $DB = new Blockchain_DB();
    $query = "SELECT * FROM tblinvoices WHERE id=%s";
    $rtn = $DB->fetch_assoc($DB->mysqlQuery($query, $invoiceId));
    return $rtn;
}
function _getWHMCSTransId($transid = "")
{
    $DB = new Blockchain_DB();
    $query = "SELECT * FROM tblaccounts WHERE transid=%s";
    $rtn = $DB->fetch_assoc($DB->mysqlQuery($query, $transid));
    $rtn = !empty($rtn["transid"]) ? $rtn["transid"] : NULL;
    return $rtn;
}
function _setPaymentData($invoiceId = 0, $amount = 0, $address = "", $secret = "")
{
    $DB = new Blockchain_DB();
    $query = "INSERT INTO blockchain_payments SET invoice_id=%s,  amount=%s,address=%s,secret=%s";
    $rtn = $DB->mysqlQuery($query, $invoiceId, $amount, $address, $secret);
    return $rtn;
}
function _setConfirmationsAndStatus($invoiceId = 0, $confirmations = 0, $status = "")
{
    $DB = new Blockchain_DB();
    $query = "UPDATE blockchain_payments SET confirmations=%s,status=%s WHERE invoice_id=%s";
    $rtn = $DB->mysqlQuery($query, $confirmations, $status, $invoiceId);
    return $rtn;
}
function _getGap($xpub = "", $key = "")
{
    $url = "https://api.blockchain.info/v2/receive/checkgap?xpub=" . $xpub . "&key=" . $key;
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    if (in_array($status, [200, 301]) && is_string($response)) {
        $response = json_decode($response);
        return $response->gap;
    }
    return false;
}
function _generateSecret($invoiceId = 0, $amount = 0)
{
    $secret = false;
    if (!empty($invoiceId) && is_numeric($invoiceId) && !empty($amount) && is_numeric($amount)) {
        $secret = "I" . preg_replace("/\\D/", "", $invoiceId);
        $secret .= "A" . preg_replace("/\\D/", "", $amount);
        $secret .= "X";
        $characters = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890";
        for ($i = 0; $i < 16; $i++) {
            $secret .= substr($characters, rand(0, strlen($characters) - 1), 1);
        }
    }
    return $secret;
}

?>