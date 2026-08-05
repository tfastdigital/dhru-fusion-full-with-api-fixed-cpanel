<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

require_once "../lib/nusoap.php";
$method = isset($_POST["method"]) ? $_POST["method"] : "";
$null = isset($_POST["null"]) ? $_POST["null"] : "";
$empty = isset($_POST["empty"]) ? $_POST["empty"] : "";
$proxyhost = isset($_POST["proxyhost"]) ? $_POST["proxyhost"] : "";
$proxyport = isset($_POST["proxyport"]) ? $_POST["proxyport"] : "";
$proxyusername = isset($_POST["proxyusername"]) ? $_POST["proxyusername"] : "";
$proxypassword = isset($_POST["proxypassword"]) ? $_POST["proxypassword"] : "";
if ($method == "") {
    echo "<form name=\"MethodForm\" method=\"POST\">";
    echo "<input type=\"hidden\" name=\"proxyhost\" value=\"" . $proxyhost . "\">";
    echo "<input type=\"hidden\" name=\"proxyport\" value=\"" . $proxyport . "\">";
    echo "<input type=\"hidden\" name=\"proxyusername\" value=\"" . $proxyusername . "\">";
    echo "<input type=\"hidden\" name=\"proxypassword\" value=\"" . $proxypassword . "\">";
    echo "Method: <select name=\"method\"><option>echoString</option><option>echoStringArray</option><option>echoInteger</option><option>echoIntegerArray</option><option>echoFloat</option><option>echoFloatArray</option><option>echoStruct</option><option>echoStructArray</option><option>echoVoid</option><option>echoBoolean</option><option>echoBase64</option></select><br><br>Null parameter? <input type=\"checkbox\" name=\"null\" value=\"1\"><br>Empty array? <input type=\"checkbox\" name=\"empty\" value=\"1\"><br><br><input type=\"submit\" value=\"&#160;Execute&#160;\"></form>";
    exit;
}
if ($method == "echoString") {
    if ($null != "1") {
        $params = ["inputString" => "If you cannot echo a string, you probably cannot do much"];
    } else {
        $params = ["inputString" => NULL];
    }
} else {
    if ($method == "echoStringArray") {
        if ($null != "1") {
            if ($empty != "1") {
                $params = ["inputStringArray" => ["String 1", "String 2", "String Three"]];
            } else {
                $params = ["inputStringArray" => []];
            }
        } else {
            $params = ["inputStringArray" => NULL];
        }
    } else {
        if ($method == "echoInteger") {
            if ($null != "1") {
                $params = ["inputInteger" => 329];
            } else {
                $params = ["inputInteger" => NULL];
            }
        } else {
            if ($method == "echoIntegerArray") {
                if ($null != "1") {
                    if ($empty != "1") {
                        $params = ["inputIntegerArray" => [451, 43, -392220011, 1, 1, 2, 3, 5, 8, 13, 21]];
                    } else {
                        $params = ["inputIntegerArray" => []];
                    }
                } else {
                    $params = ["inputIntegerArray" => NULL];
                }
            } else {
                if ($method == "echoFloat") {
                    if ($null != "1") {
                        $params = ["inputFloat" => 3.14159265];
                    } else {
                        $params = ["inputFloat" => NULL];
                    }
                } else {
                    if ($method == "echoFloatArray") {
                        if ($null != "1") {
                            if ($empty != "1") {
                                $params = ["inputFloatArray" => [1.1, 2.2, 3.3, 0.25, -0.11111111111111]];
                            } else {
                                $params = ["inputFloatArray" => []];
                            }
                        } else {
                            $params = ["inputFloatArray" => NULL];
                        }
                    } else {
                        if ($method == "echoStruct") {
                            if ($null != "1") {
                                $struct = ["varString" => "who", "varInt" => 2, "varFloat" => 3.14159];
                                $params = ["inputStruct" => $struct];
                            } else {
                                $params = ["inputStruct" => NULL];
                            }
                        } else {
                            if ($method == "echoStructArray") {
                                if ($null != "1") {
                                    if ($empty != "1") {
                                        $structs[] = ["varString" => "who", "varInt" => 2, "varFloat" => 3.14159];
                                        $structs[] = ["varString" => "when", "varInt" => 4, "varFloat" => 99.9876];
                                        $params = ["inputStructArray" => $structs];
                                    } else {
                                        $params = ["inputStructArray" => []];
                                    }
                                } else {
                                    $params = ["inputStructArray" => NULL];
                                }
                            } else {
                                if ($method == "echoVoid") {
                                    $params = [];
                                } else {
                                    if ($method == "echoBoolean") {
                                        if ($null != "1") {
                                            $params = ["inputBoolean" => false];
                                        } else {
                                            $params = ["inputBoolean" => NULL];
                                        }
                                    } else {
                                        if ($method == "echoBase64") {
                                            if ($null != "1") {
                                                $params = ["inputBase64" => base64_encode("You must encode the data you send; NuSOAP will automatically decode the data it receives")];
                                            } else {
                                                $params = ["inputBase64" => NULL];
                                            }
                                        } else {
                                            echo "Sorry, I do not know about method " . $method;
                                            exit;
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    }
}
$client = new soapclient("http://www.scottnichol.com/samples/round2_base_server.php?wsdl&debug=1", true, $proxyhost, $proxyport, $proxyusername, $proxypassword);
$err = $client->getError();
if ($err) {
    echo "<h2>Constructor error</h2><pre>" . $err . "</pre>";
}
$client->useHTTPPersistentConnection();
echo "<h2>Execute " . $method . "</h2>";
$result = $client->call($method, $params);
if ($client->fault) {
    echo "<h2>Fault</h2><pre>";
    print_r($result);
    echo "</pre>";
} else {
    $err = $client->getError();
    if ($err) {
        echo "<h2>Error</h2><pre>" . $err . "</pre>";
    } else {
        echo "<h2>Result</h2><pre>";
        print_r(!is_bool($result) ? $result : ($result ? "true" : "false"));
        echo "</pre>";
        echo "<h2>Execute " . $method . " again to test persistent connection (see debug)</h2>";
        $client->debug("*** execute again to test persistent connection ***");
        $result = $client->call($method, $params);
        $client->debug("*** execute again ... ***");
        $result = $client->call($method, $params);
    }
}
echo "<h2>Request</h2><pre>" . htmlspecialchars($client->request, ENT_QUOTES) . "</pre>";
echo "<h2>Response</h2><pre>" . htmlspecialchars($client->response, ENT_QUOTES) . "</pre>";
echo "<h2>Debug</h2><pre>" . htmlspecialchars($client->debug_str, ENT_QUOTES) . "</pre>";

?>