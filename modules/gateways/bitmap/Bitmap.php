<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

class NetworkonlieBitmapPaymentIntegration
{
    public $merchantId = NULL;
    public $merchantKey = NULL;
    public $iv = NULL;
    public $collaboratorId = NULL;
    public $url = NULL;
    public $blockExistenceIndicator = NULL;
    public $transactionDataBlock = true;
    public $billingDataBlock = false;
    public $shippingDataBlock = false;
    public $paymentDataBlock = false;
    public $merchantDataBlock = false;
    public $otherDataBlock = false;
    public $DCCDataBlock = false;
    public $merchantOrderNumber = "";
    public $amount = "";
    public $successUrl = "";
    public $failureUrl = "";
    public $transactionMode = "";
    public $payModeType = "";
    public $transactionType = "";
    public $currency = "SGD";
    public $billToFirstName = "";
    public $billToLastName = "";
    public $billToStreet1 = "";
    public $billToStreet2 = "";
    public $billToCity = "";
    public $billToState = "";
    public $billtoPostalCode = "";
    public $billToCountry = "";
    public $billToEmail = "";
    public $billToMobileNumber = "";
    public $billToPhoneNumber1 = "";
    public $billToPhoneNumber2 = "";
    public $billToPhoneNumber3 = "";
    public $shipToFirstName = "";
    public $shipToLastName = "";
    public $shipToStreet1 = "";
    public $shipToStreet2 = "";
    public $shipToCity = "";
    public $shipToState = "";
    public $shipToPostalCode = "";
    public $shipToCountry = "";
    public $shipToPhoneNumber1 = "";
    public $shipToPhoneNumber2 = "";
    public $shipToPhoneNumber3 = "";
    public $shipToMobileNumber = "";
    public $payModeTypeCard = ["CC", "DC", "DD"];
    public $payModeTypeNetBank = ["NB"];
    public $cardNumber = "";
    public $expMonth = "";
    public $expYear = "";
    public $CVV = "";
    public $cardHolderName = "";
    public $cardType = "";
    public $custMobileNumber = "";
    public $paymentID = "";
    public $OTP = "";
    public $gatewayID = "";
    public $cardToken = "";
    public $UDF1 = "";
    public $UDF2 = "";
    public $UDF3 = "";
    public $UDF4 = "";
    public $UDF5 = "";
    public $UDF6 = "";
    public $UDF7 = "";
    public $UDF8 = "";
    public $UDF9 = "";
    public $UDF10 = "";
    public $custID = "";
    public $transactionSource = "";
    public $productInfo = "";
    public $isUserLoggedIn = "";
    public $itemTotal = "";
    public $itemCategory = "";
    public $ignoreValidationResult = "";
    public $DCCReferenceNumber = "";
    public $foreignAmount = "";
    public $ForeignCurrency = "";
    public function __construct()
    {
        $arguments = func_get_args();
        if (!empty($arguments)) {
            foreach ($arguments as $argumentsArray) {
                if (!empty($argumentsArray["Field_Existence_Indicator_Transaction"])) {
                    $this->transactionArray = array_filter($argumentsArray["Field_Existence_Indicator_Transaction"]);
                }
                if (!empty($argumentsArray["Field_Existence_Indicator_Billing"])) {
                    $this->billingArray = array_filter($argumentsArray["Field_Existence_Indicator_Billing"]);
                }
                if (!empty($argumentsArray["Field_Existence_Indicator_Shipping"])) {
                    $this->shippingArray = array_filter($argumentsArray["Field_Existence_Indicator_Shipping"]);
                }
                if (!empty($argumentsArray["Field_Existence_Indicator_Payment"])) {
                    $this->paymentArray = array_filter($argumentsArray["Field_Existence_Indicator_Payment"]);
                }
                if (!empty($argumentsArray["Field_Existence_Indicator_Merchant"])) {
                    $this->merchantArray = array_filter($argumentsArray["Field_Existence_Indicator_Merchant"]);
                }
                if (!empty($argumentsArray["Field_Existence_Indicator_OtherData"])) {
                    $this->otherDataArray = array_filter($argumentsArray["Field_Existence_Indicator_OtherData"]);
                }
                if (!empty($argumentsArray["Field_Existence_Indicator_DCC"])) {
                    $this->DCCArray = array_filter($argumentsArray["Field_Existence_Indicator_DCC"]);
                }
                foreach ($argumentsArray["Network_Online_setting"] as $key => $property) {
                    if (property_exists($this, $key)) {
                        $this->{$key} = $property;
                    }
                }
                foreach ($argumentsArray["Block_Existence_Indicator"] as $key => $property) {
                    if (property_exists($this, $key)) {
                        $this->{$key} = $property;
                    }
                }
                foreach ($argumentsArray["Field_Existence_Indicator_Transaction"] as $key => $property) {
                    if (property_exists($this, $key)) {
                        $this->{$key} = $property;
                    }
                }
                foreach ($argumentsArray["Field_Existence_Indicator_Billing"] as $key => $property) {
                    if (property_exists($this, $key)) {
                        $this->{$key} = $property;
                    }
                }
                foreach ($argumentsArray["Field_Existence_Indicator_Shipping"] as $key => $property) {
                    if (property_exists($this, $key)) {
                        $this->{$key} = $property;
                    }
                }
                foreach ($argumentsArray["Field_Existence_Indicator_Payment"] as $key => $property) {
                    if (property_exists($this, $key)) {
                        $this->{$key} = $property;
                    }
                }
                foreach ($argumentsArray["Field_Existence_Indicator_Merchant"] as $key => $property) {
                    if (property_exists($this, $key)) {
                        $this->{$key} = $property;
                    }
                }
                foreach ($argumentsArray["Field_Existence_Indicator_OtherData"] as $key => $property) {
                    if (property_exists($this, $key)) {
                        $this->{$key} = $property;
                    }
                }
                foreach ($argumentsArray["Field_Existence_Indicator_DCC"] as $key => $property) {
                    if (property_exists($this, $key)) {
                        $this->{$key} = $property;
                    }
                }
                if (in_array($this->payModeType, $this->payModeTypeCard)) {
                    $this->paymentArray = array_filter($argumentsArray["Field_Existence_Indicator_Payment"]);
                } else {
                    if (in_array($this->payModeType, $this->payModeTypeNetBank)) {
                        $this->paymentArray = ["gatewayID" => $this->gatewayID];
                    } else {
                        $this->paymentArray = ["custMobileNumber" => $this->custMobileNumber, "paymentID" => $this->paymentID, "OTP" => $this->OTP];
                    }
                }
            }
        }
        $this->blockExistenceIndicator = $this->setblockExistenceIndicator();
        $this->TransactionFieldExistenceIndicator = $this->setTransactionFieldExistenceIndicator();
        $this->TransactionData = join("|", $this->transactionArray);
        $this->TransactionDataBlock1 = $this->TransactionFieldExistenceIndicator . "|" . $this->TransactionData;
        $this->BillingFieldExistenceIndicator = $this->setBillingFieldExistenceIndicator();
        if ($this->billingDataBlock) {
            $this->BillingData = join("|", $this->billingArray);
            $this->BillingDataBlock2 = $this->BillingFieldExistenceIndicator . "|" . $this->BillingData;
        } else {
            foreach ($this->billingArray as $key => $val) {
                $emptybillingArray[] = str_replace($val, "", $val);
            }
            $this->BillingData = join("|", array_filter($emptybillingArray));
            $this->BillingDataBlock2 = $this->BillingFieldExistenceIndicator . $this->BillingData;
        }
        $this->ShippingFieldExistenceIndicator = $this->setShippingFieldExistenceIndicator();
        if ($this->shippingDataBlock) {
            $this->ShippingData = join("|", $this->shippingArray);
            $this->ShippingDataBlock3 = $this->ShippingFieldExistenceIndicator . "|" . $this->ShippingData;
        } else {
            foreach ($this->shippingArray as $key => $val) {
                $emptyshippingArray[] = str_replace($val, "", $val);
            }
            $this->ShippingData = join("|", array_filter($emptyshippingArray));
            $this->ShippingDataBlock3 = $this->ShippingFieldExistenceIndicator . $this->ShippingData;
        }
        $this->PaymentFieldExistenceIndicator = $this->setPaymentFieldExistenceIndicator();
        if ($this->paymentDataBlock) {
            $this->PaymentData = join("|", $this->paymentArray);
            $this->PaymentDataBlock4 = $this->PaymentFieldExistenceIndicator . "|" . $this->PaymentData;
        } else {
            foreach ($this->paymentArray as $key => $val) {
                $emptypaymentArray[] = str_replace($val, "", $val);
            }
            $this->PaymentData = join("|", array_filter($emptypaymentArray));
            $this->PaymentDataBlock4 = $this->PaymentFieldExistenceIndicator . $this->PaymentData;
        }
        $this->MerchantFieldExistenceIndicator = $this->setMerchantFieldExistenceIndicator();
        if ($this->merchantDataBlock) {
            $this->MerchantData = join("|", $this->merchantArray);
            $this->MerchantDataBlock5 = $this->MerchantFieldExistenceIndicator . "|" . $this->MerchantData;
        } else {
            foreach ($this->shippingArray as $key => $val) {
                $emptymerchantArray[] = str_replace($val, "", $val);
            }
            $this->MerchantData = join("|", array_filter($emptymerchantArray));
            $this->MerchantDataBlock5 = $this->MerchantFieldExistenceIndicator . $this->MerchantData;
        }
        $this->OtherDetailsFieldExistenceIndicator = $this->setOtherDetailsFieldExistenceIndicator();
        if ($this->otherDataBlock) {
            $this->OtherDetailsData = join("|", $this->otherDataArray);
            $this->OtherDetailsDataBlock6 = $this->OtherDetailsFieldExistenceIndicator . "|" . $this->OtherDetailsData;
        } else {
            foreach ($this->otherDataArray as $key => $val) {
                $emptyotherDataArray[] = str_replace($val, "", $val);
            }
            $this->OtherDetailsData = join("|", array_filter($emptyotherDataArray));
            $this->OtherDetailsDataBlock6 = $this->OtherDetailsFieldExistenceIndicator . $this->OtherDetailsData;
        }
        $this->DCCFieldExistenceIndicator = $this->setDCCFieldExistenceIndicator();
        if ($this->DCCDataBlock) {
            $this->DCCData = join("|", $this->DCCArray);
            $this->DCCDataBlock7 = $this->DCCFieldExistenceIndicator . "|" . $this->DCCData;
        } else {
            foreach ($this->DCCArray as $key => $val) {
                $emptyDCCDataArray[] = str_replace($val, "", $val);
            }
            $this->DCCData = join("|", array_filter($emptyDCCDataArray));
            $this->DCCDataBlock7 = $this->DCCFieldExistenceIndicator . $this->DCCData;
        }
        $this->DataBlocksArray = ["DataBlockBitmap" => $this->blockExistenceIndicator, "DataBlock1" => $this->TransactionDataBlock1, "DataBlock2" => $this->billingDataBlock ? $this->BillingDataBlock2 : "", "DataBlock3" => $this->shippingDataBlock ? $this->ShippingDataBlock3 : "", "DataBlock4" => $this->paymentDataBlock ? $this->PaymentDataBlock4 : "", "DataBlock5" => $this->merchantDataBlock ? $this->MerchantDataBlock5 : "", "DataBlock6" => $this->otherDataBlock ? $this->OtherDetailsDataBlock6 : "", "DataBlock7" => $this->DCCDataBlock ? $this->DCCDataBlock7 : ""];
        $this->beforeEncryptionString = join("||", array_filter($this->DataBlocksArray));
        $this->EncryptedString = $this->encryptData($this->beforeEncryptionString, $this->merchantKey, $this->iv);
        $this->NeoPostData = $this->merchantId . "||" . $this->collaboratorId . "||" . $this->EncryptedString;
        $TestNeoPostData = $this->merchantId . "||" . $this->collaboratorId . "||" . $this->EncryptedString;
        if ($this->url) {
            $requestUrl = "https://NeO.network.ae/direcpay/secure/PaymentTxnServlet";
        } else {
            $requestUrl = "https://uat-NeO.network.ae/direcpay/secure/PaymentTxnServlet";
        }
        $billingDataBlock = $this->billingDataBlock ? $this->BillingDataBlock2 : "NULL";
        $shippingDataBlock = $this->shippingDataBlock ? $this->ShippingDataBlock3 : "NULL";
        $paymentDataBlock = $this->paymentDataBlock ? $this->PaymentDataBlock4 : "NULL";
        $merchantDataBlock = $this->merchantDataBlock ? $this->MerchantDataBlock5 : "NULL";
        $otherDataBlock = $this->otherDataBlock ? $this->OtherDetailsDataBlock6 : "NULL";
        $DCCDataBlock = $this->DCCDataBlock ? $this->DCCDataBlock7 : "NULL";
        $path = "neologs.txt";
        if (file_exists($path)) {
            $fp = fopen($path, "w+");
            ftruncate($fp, 0);
            fclose($fp);
        }
        $this->AddLog("Merchant ID : " . $this->merchantId, "1");
        $this->AddLog("Merchant Key : " . $this->merchantKey, "2");
        $this->AddLog("Collaborator ID : " . $this->collaboratorId, "3");
        $this->AddLog("Neo URL  : " . $requestUrl, "4");
        $this->AddLog("Block Existence Indicator   : " . $this->blockExistenceIndicator, "5");
        $this->AddLog("DataBlock1 : TransactionDataBlock1   : " . $this->TransactionDataBlock1, "6");
        $this->AddLog("DataBlock2 : billingDataBlock   : " . $billingDataBlock, "7");
        $this->AddLog("DataBlock3 : shippingDataBlock   : " . $shippingDataBlock, "8");
        $this->AddLog("DataBlock4 : paymentDataBlock   : " . $paymentDataBlock, "9");
        $this->AddLog("DataBlock5 : merchantDataBlock   : " . $merchantDataBlock, "10");
        $this->AddLog("DataBlock6 : otherDataBlock   : " . $otherDataBlock, "11");
        $this->AddLog("DataBlock7 : DCCDataBlock   : " . $DCCDataBlock, "12");
        $this->AddLog("beforeEncryptionString : " . $this->beforeEncryptionString, "13");
        $this->AddLog("EncryptedString  : " . $this->EncryptedString, "14");
        $this->AddLog("NeoPostData  : " . $this->NeoPostData, "15");
    }
    public static function AddLog($message, $severity = 2)
    {
        $fp = fopen("neologs.txt", "a+");
        $message = strip_tags($message);
        $message = htmlentities((string) $message, ENT_QUOTES, "utf-8");
        fwrite($fp, "\n[" . (int) $severity . "] " . $message);
        fclose($fp);
    }
    public function encryptData($data, $key, $iv)
    {
        $enc_method = "AES-256-CBC";
        $base64_decode_key = base64_decode($key);
        $options = 0;
        $data = openssl_encrypt($data, $enc_method, $base64_decode_key, $options, $iv);
        return $data;
    }
    public function decryptData($data, $key, $iv)
    {
        if ($data) {
            $enc = "AES-256-CBC";
            $iv = "0123456789abcdef";
            list($merchantId, $encryptString) = explode("||", $data);
            $base64_decode_key = base64_decode($key);
            $options = 0;
            $text = openssl_decrypt($encryptString, $enc, $base64_decode_key, $options, $iv);
            $reponseArray = explode("||", $text);
            $blockEI = $reponseArray[0];
            $bitmapString = str_split($blockEI);
            $blockEIArrayKey = ["Transaction_Response", "Transaction_related_information", "Transaction_Status_information", "Merchant_Information", "Fraud_Block", "DCC_Block", "Additional"];
            $bit = 0;
            $blockEIArray = [];
            foreach ($blockEIArrayKey as $blockValues) {
                $blockEIArray[$blockValues] = $bitmapString[$bit];
                $bit++;
            }
            $blockEIArray = array_filter($blockEIArray);
            array_shift($reponseArray);
            $resposeAssignedArray = [];
            $res = 0;
            foreach ($blockEIArray as $key => $value) {
                $resposeAssignedArray[$key] = $reponseArray[$res];
                $res++;
            }
            $TransactionResposeValue["text"] = $merchantId . "||" . $text;
            $TransactionResposeValue["merchantId"] = $merchantId;
            $TransactionResposeValue["DataBlockBitmap"] = $blockEI;
            foreach ($blockEIArrayKey as $key => $value) {
                if (isset($resposeAssignedArray[$value])) {
                    $TransactionResposeValue[$value] = $resposeAssignedArray[$value];
                } else {
                    $TransactionResposeValue[$value] = "NULL";
                }
            }
            return $TransactionResposeValue;
        } else {
            return false;
        }
    }
    public function setblockExistenceIndicator()
    {
        $blockExistenceIndicator = "";
        $blockExistenceIndicator .= $this->transactionDataBlock ? "1" : "0";
        $blockExistenceIndicator .= $this->billingDataBlock ? "1" : "0";
        $blockExistenceIndicator .= $this->shippingDataBlock ? "1" : "0";
        $blockExistenceIndicator .= $this->paymentDataBlock ? "1" : "0";
        $blockExistenceIndicator .= $this->merchantDataBlock ? "1" : "0";
        $blockExistenceIndicator .= $this->otherDataBlock ? "1" : "0";
        $blockExistenceIndicator .= $this->DCCDataBlock ? "1" : "0";
        return $blockExistenceIndicator;
    }
    public function setTransactionFieldExistenceIndicator()
    {
        if ($this->transactionDataBlock) {
            $transactionFieldEI = "";
            $transactionFieldEI .= $this->merchantOrderNumber ? "1" : "0";
            $transactionFieldEI .= $this->amount ? "1" : "0";
            $transactionFieldEI .= $this->successUrl ? "1" : "0";
            $transactionFieldEI .= $this->failureUrl ? "1" : "0";
            $transactionFieldEI .= $this->transactionMode ? "1" : "0";
            $transactionFieldEI .= $this->payModeType ? "1" : "0";
            $transactionFieldEI .= $this->transactionType ? "1" : "0";
            $transactionFieldEI .= $this->currency ? "1" : "0";
            return $transactionFieldEI;
        }
        return "00000000";
    }
    public function setBillingFieldExistenceIndicator()
    {
        if ($this->billingDataBlock) {
            $billingFieldEI = "";
            $billingFieldEI .= $this->billToFirstName ? "1" : "0";
            $billingFieldEI .= $this->billToLastName ? "1" : "0";
            $billingFieldEI .= $this->billToStreet1 ? "1" : "0";
            $billingFieldEI .= $this->billToStreet2 ? "1" : "0";
            $billingFieldEI .= $this->billToCity ? "1" : "0";
            $billingFieldEI .= $this->billToState ? "1" : "0";
            $billingFieldEI .= $this->billtoPostalCode ? "1" : "0";
            $billingFieldEI .= $this->billToCountry ? "1" : "0";
            $billingFieldEI .= $this->billToEmail ? "1" : "0";
            $billingFieldEI .= $this->billToMobileNumber ? "1" : "0";
            $billingFieldEI .= $this->billToPhoneNumber1 ? "1" : "0";
            $billingFieldEI .= $this->billToPhoneNumber2 ? "1" : "0";
            $billingFieldEI .= $this->billToPhoneNumber3 ? "1" : "0";
            return $billingFieldEI;
        }
        return "0000000000000";
    }
    public function setShippingFieldExistenceIndicator()
    {
        if ($this->shippingDataBlock) {
            $shippingFieldEI = "";
            $shippingFieldEI .= $this->shipToFirstName ? "1" : "0";
            $shippingFieldEI .= $this->shipToLastName ? "1" : "0";
            $shippingFieldEI .= $this->shipToStreet1 ? "1" : "0";
            $shippingFieldEI .= $this->shipToStreet2 ? "1" : "0";
            $shippingFieldEI .= $this->shipToCity ? "1" : "0";
            $shippingFieldEI .= $this->shipToState ? "1" : "0";
            $shippingFieldEI .= $this->shipToPostalCode ? "1" : "0";
            $shippingFieldEI .= $this->shipToCountry ? "1" : "0";
            $shippingFieldEI .= $this->shipToPhoneNumber1 ? "1" : "0";
            $shippingFieldEI .= $this->shipToPhoneNumber2 ? "1" : "0";
            $shippingFieldEI .= $this->shipToPhoneNumber3 ? "1" : "0";
            $shippingFieldEI .= $this->shipToMobileNumber ? "1" : "0";
            return $shippingFieldEI;
        }
        return "000000000000";
    }
    public function setPaymentFieldExistenceIndicator()
    {
        if ($this->paymentDataBlock) {
            $creditArray = ["CC", "DC", "DD"];
            if (in_array($this->payModeType, $creditArray)) {
                $paymentFieldEI = "";
                $paymentFieldEI .= $this->cardNumber ? "1" : "0";
                $paymentFieldEI .= $this->expMonth ? "1" : "0";
                $paymentFieldEI .= $this->expYear ? "1" : "0";
                $paymentFieldEI .= $this->CVV ? "1" : "0";
                $paymentFieldEI .= $this->cardHolderName ? "1" : "0";
                $paymentFieldEI .= $this->cardType ? "1" : "0";
                $paymentFieldEI .= $this->custMobileNumber ? "1" : "0";
                $paymentFieldEI .= $this->paymentID ? "1" : "0";
                $paymentFieldEI .= $this->OTP ? "1" : "0";
                $paymentFieldEI .= $this->gatewayID ? "1" : "0";
                $paymentFieldEI .= $this->cardToken ? "1" : "0";
                return $paymentFieldEI;
            }
            if ($this->payModeType == "NB") {
                $paymentFieldEI = "00000000010";
                return $paymentFieldEI;
            }
            $paymentFieldEI = "00000011100";
            return $paymentFieldEI;
        }
        $paymentFieldEI = "00000000000";
        return $paymentFieldEI;
    }
    public function setMerchantFieldExistenceIndicator()
    {
        if ($this->merchantDataBlock) {
            $merchantFieldEI = "";
            $merchantFieldEI .= $this->UDF1 ? "1" : "0";
            $merchantFieldEI .= $this->UDF2 ? "1" : "0";
            $merchantFieldEI .= $this->UDF3 ? "1" : "0";
            $merchantFieldEI .= $this->UDF4 ? "1" : "0";
            $merchantFieldEI .= $this->UDF5 ? "1" : "0";
            $merchantFieldEI .= $this->UDF6 ? "1" : "0";
            $merchantFieldEI .= $this->UDF7 ? "1" : "0";
            $merchantFieldEI .= $this->UDF8 ? "1" : "0";
            $merchantFieldEI .= $this->UDF9 ? "1" : "0";
            $merchantFieldEI .= $this->UDF10 ? "1" : "0";
            return $merchantFieldEI;
        }
        return "0000000000";
    }
    public function setOtherDetailsFieldExistenceIndicator()
    {
        if ($this->otherDataBlock) {
            $otherFieldEI = "";
            $otherFieldEI .= $this->custID ? "1" : "0";
            $otherFieldEI .= $this->transactionSource ? "1" : "0";
            $otherFieldEI .= $this->productInfo ? "1" : "0";
            $otherFieldEI .= $this->isUserLoggedIn ? "1" : "0";
            $otherFieldEI .= $this->itemTotal ? "1" : "0";
            $otherFieldEI .= $this->itemCategory ? "1" : "0";
            $otherFieldEI .= $this->ignoreValidationResult ? "1" : "0";
            return $otherFieldEI;
        }
        return "0000000";
    }
    public function setDCCFieldExistenceIndicator()
    {
        if ($this->DCCDataBlock) {
            $DCCFieldEI = "";
            $DCCFieldEI .= $this->DCCReferenceNumber ? "1" : "0";
            $DCCFieldEI .= $this->foreignAmount ? "1" : "0";
            $DCCFieldEI .= $this->ForeignCurrency ? "1" : "0";
            return $DCCFieldEI;
        }
        return "000";
    }
}

?>