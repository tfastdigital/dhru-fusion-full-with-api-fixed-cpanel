<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

namespace Dhru\Endpoint\checkdbconnection;

class post extends Checkdbconnection
{
    public function __construct($Base)
    {
        parent::__construct($Base);
        
        $_host = "localhost";
        $_databsename = "appunbsx_test5";
        $_databseusername = "appunbsx_test5";
        $_databsepassword = "appunbsx_test5";
        try {
            $conn = new \PDO("mysql:host=" . $_host . ";dbname=" . $_databsename, $_databseusername, $_databsepassword);
        } catch (PDOException $e) {
            print_r($e);
            exit;
        }
        throw new \SuccessOut("Database connection successful");
    }
    public static function config()
    {
        $RETURN["name"] = "Check Database Connection";
        $BODY["host"]["type"] = "string";
        $BODY["host"]["isrequired"] = true;
        $BODY["host"]["example"] = "localhost";
        $BODY["databasename"]["type"] = "string";
        $BODY["databasename"]["isrequired"] = true;
        $BODY["databasename"]["example"] = "DBNAME";
        $BODY["databaseusername"]["type"] = "string";
        $BODY["databaseusername"]["isrequired"] = true;
        $BODY["databaseusername"]["example"] = "DB_USERNAME";
        $BODY["databasepassword"]["type"] = "string";
        $BODY["databasepassword"]["isrequired"] = true;
        $BODY["databasepassword"]["example"] = "DB_PASSWORD";
        $RETURN["body"] = $BODY;
        return $RETURN;
    }
}

?>