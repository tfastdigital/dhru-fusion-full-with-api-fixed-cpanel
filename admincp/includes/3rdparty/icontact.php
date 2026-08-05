<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

function IContactLogin($account_id, $key, $user, $pass, &$client_folder_id)
{
    $headers = ["Accept: text/xml", "Content-Type: text/xml", "Api-Version: 2.0", "Api-AppId: " . $key, "Api-Username: " . $user, "Api-Password: " . $pass];
    $ch = curl_init("https://app.icontact.com/icp/a/" . $account_id . "/c/");
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    $buf = curl_exec($ch);
    curl_close($ch);
    $client_folder_id = "";
    if (($pos = strpos($buf, "<clientFolderId>")) !== false) {
        $client_folder_id = substr($buf, strlen("<clientFolderId>") + $pos);
        if (($pos = strpos($client_folder_id, "<")) !== false) {
            $client_folder_id = substr($client_folder_id, 0, $pos);
        }
    }
    $result = 0 < $client_folder_id + 0;
    return $result;
}
function IContactSubscribe($account_id, $key, $user, $pass, $email, $list_id, &$result_str)
{
    if (!icontactlogin($account_id, $key, $user, $pass, $client_folder_id)) {
        $result_str = "Failed retrieving client_folder_id for '" . $user . "'";
        return $result_str;
    }
    $headers = ["Accept: text/xml", "Content-Type: text/xml", "Api-Version: 2.0", "Api-AppId: " . $key, "Api-Username: " . $user, "Api-Password: " . $pass];
    $ch = curl_init("https://app.icontact.com/icp/a/" . $account_id . "/c/" . $client_folder_id . "/contacts/?email=" . URLEncode($email));
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    $buf = curl_exec($ch);
    curl_close($ch);
    $contact_id = "";
    if (($pos = strpos($buf, "<contactId>")) !== false) {
        $contact_id = substr($buf, $pos + strlen("<contactId>"));
        if (($pos = strpos($contact_id, "<")) !== false) {
            $contact_id = substr($contact_id, 0, $pos);
        }
    }
    if (empty($contact_id)) {
        $result_str = "Failed finding a contact with the email address of '" . $email . "'";
        return $result_str;
    }
    $data = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\r\n<subscriptions>\r\n";
    $data .= "<subscription>\r\n";
    $data .= "<contactId>" . $contact_id . "</contactId>\r\n";
    $data .= "<listId>" . $list_id . "</listId>\r\n";
    $data .= "<status>normal</status>\r\n";
    $data .= "</subscription>\r\n</subscriptions>";
    $ch = curl_init("https://app.icontact.com/icp/a/" . $account_id . "/c/" . $client_folder_id . "/subscriptions/");
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    $buf = curl_exec($ch);
    curl_close($ch);
    $subscription_id = "";
    if (($pos = strpos($buf, "<subscriptionId>")) !== false) {
        $subscription_id = substr($buf, $pos + strlen("<subscriptionId>"));
        if (($pos = strpos($subscription_id, "<")) !== false) {
            $subscription_id = substr($subscription_id, 0, $pos);
        }
    }
    $result = !empty($subscription_id) || strpos($buf, "could not be updated") !== false;
    $result_str = $result ? "Updated subscription " . $subscription_id : $buf;
    return $result;
}
function IContactAddContact($account_id, $key, $user, $pass, $email, $firstname, $lastname, $folder_id = "", &$result_str)
{
    if (!$folder_id) {
        if (!icontactlogin($account_id, $key, $user, $pass, $client_folder_id)) {
            $result_str = "Failed retrieving client_folder_id for '" . $user . "'";
            return $result_str;
        }
    } else {
        $client_folder_id = $folder_id;
    }
    $headers = ["Accept: text/xml", "Content-Type: text/xml", "Api-Version: 2.0", "Api-AppId: " . $key, "Api-Username: " . $user, "Api-Password: " . $pass];
    $data = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\r\n<contacts>\r\n";
    $data .= "<contact>\r\n";
    $data .= "<email>" . $email . "</email>\r\n";
    $data .= "<firstName>" . $firstname . "</firstName>\r\n";
    $data .= "<lastName>" . $lastname . "</lastName>\r\n";
    $data .= "<status>normal</status>\r\n";
    $data .= "</contact>\r\n</contacts>";
    $ch = curl_init("https://app.icontact.com/icp/a/" . $account_id . "/c/" . $client_folder_id . "/contacts/?email=" . URLEncode($email));
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    $buf = curl_exec($ch);
    curl_close($ch);
    $contact_id = "";
    if (($pos = strpos($buf, "<contactId>")) !== false) {
        $contact_id = substr($buf, $pos + strlen("<contactId>"));
        if (($pos = strpos($contact_id, "<")) !== false) {
            $contact_id = substr($contact_id, 0, $pos);
        }
    }
    if (!empty($contact_id)) {
        $result_str = "Contact already exist";
        return $result_str;
    }
    $ch = curl_init("https://app.icontact.com/icp/a/" . $account_id . "/c/" . $client_folder_id . "/contacts/");
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    $buf = curl_exec($ch);
    curl_close($ch);
    $contact_id = "";
    if (($pos = strpos($buf, "<contactId>")) !== false) {
        $contact_id = substr($buf, $pos + strlen("<contactId>"));
        if (($pos = strpos($contact_id, "<")) !== false) {
            $contact_id = substr($contact_id, 0, $pos);
        }
    }
    $result = !empty($contact_id);
    $result_str = $result ? "Added new contact " . $contact_id : $buf;
    return $result;
}
function IContactUnsubscribe($account_id, $key, $user, $pass, $email, $list_id, &$result_str)
{
    if (!icontactlogin($account_id, $key, $user, $pass, $client_folder_id)) {
        $result_str = "Failed retrieving client_folder_id for '" . $user . "'";
        return $result_str;
    }
    $headers = ["Accept: text/xml", "Content-Type: text/xml", "Api-Version: 2.0", "Api-AppId: " . $key, "Api-Username: " . $user, "Api-Password: " . $pass];
    $ch = curl_init("https://app.icontact.com/icp/a/" . $account_id . "/c/" . $client_folder_id . "/contacts/?email=" . URLEncode($email));
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    $buf = curl_exec($ch);
    curl_close($ch);
    $contact_id = "";
    if (($pos = strpos($buf, "<contactId>")) !== false) {
        $contact_id = substr($buf, $pos + strlen("<contactId>"));
        if (($pos = strpos($contact_id, "<")) !== false) {
            $contact_id = substr($contact_id, 0, $pos);
        }
    }
    if (empty($contact_id)) {
        $result_str = "Failed finding a contact with the email address of '" . $email . "'";
        return $result_str;
    }
    $data = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\r\n<subscriptions>\r\n";
    $data .= "<subscription>\r\n";
    $data .= "<contactId>" . $contact_id . "</contactId>\r\n";
    $data .= "<listId>" . $list_id . "</listId>\r\n";
    $data .= "<status>unsubscribed</status>\r\n";
    $data .= "</subscription>\r\n</subscriptions>";
    $ch = curl_init("https://app.icontact.com/icp/a/" . $account_id . "/c/" . $client_folder_id . "/subscriptions/");
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    $buf = curl_exec($ch);
    curl_close($ch);
    $subscription_id = "";
    if (($pos = strpos($buf, "<subscriptionId>")) !== false) {
        $subscription_id = substr($buf, $pos + strlen("<subscriptionId>"));
        if (($pos = strpos($subscription_id, "<")) !== false) {
            $subscription_id = substr($subscription_id, 0, $pos);
        }
    }
    $result = !empty($subscription_id) || strpos($buf, "could not be updated") !== false;
    $result_str = $result ? "Updated subscription " . $subscription_id : $buf;
    return $result;
}

?>