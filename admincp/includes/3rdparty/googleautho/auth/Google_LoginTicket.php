<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

/**
 * Class to hold information about an authenticated login.
 *
 * @author Brian Eaton <beaton@google.com>
 */
class Google_LoginTicket
{
    private $envelope = NULL;
    private $payload = NULL;
    const USER_ATTR = "id";
    public function __construct($envelope, $payload)
    {
        $this->envelope = $envelope;
        $this->payload = $payload;
    }
    public function getUserId()
    {
        if (array_key_exists("id", $this->payload)) {
            return $this->payload["id"];
        }
        throw new Google_AuthException("No user_id in token");
    }
    public function getAttributes()
    {
        return ["envelope" => $this->envelope, "payload" => $this->payload];
    }
}

?>