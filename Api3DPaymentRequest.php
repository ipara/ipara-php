<?php

class Api3DPaymentRequest extends ApiPaymentRequest
{
    public $SuccessUrl;
    public $FailUrl;
    public $transactionDate;
    private $deviceUUID;
    public $Token;
    public $Language = "tr-TR";

    //3D Secure İle Ödeme Servis çağrısını temsil eder.
    public function execute3D(Settings $settings)
    {

        /*$settings->BaseUrl = "https://www.ipara.com/3dgate"; // 3D işleminin ilk adımında post adresi diğer tüm işlemlerin aksine değişkenlik gösterir.
        $settings->HashString = $settings->PrivateKey . $request->OrderId . $request->Amount . $request->Mode . $request->CardOwnerName . $request->CardNumber . $request->CardExpireMonth . $request->CardExpireYear . $request->Cvc . $request->UserId . $request->CardId . $request->PurchaserName . $request->PurchaserSurname . $request->PurchaserEmail . $settings->transactionDate;
        $request->Token = Helper::CreateToken ( $settings->PublicKey, $settings->HashString );
        return $request->toHtmlString ( $request, $settings );*/

        $settings->transactionDate = Helper::GetTransactionDateString();
        $settings->HashString = $settings->PrivateKey . $this->OrderId . $this->Amount . $this->Mode . $this->CardOwnerName . $this->CardNumber . $this->CardExpireMonth . $this->CardExpireYear . $this->Cvc . $this->UserId . $this->CardId. $this->Purchaser->Name . $this->Purchaser->SurName . $this->Purchaser->Email . $settings->transactionDate;
        $this->Token = Helper::CreateToken($settings->PublicKey, $settings->HashString);
        $parameters = $this->toJsonString($settings);
        $url = $settings->BaseUrl . 'rest/payment/threed'; // 'threed.php';

        return $this->toHtmlString($parameters, $url);
/*
 * object(Settings)#1 (7) { ["PublicKey"]=> string(15) "WY48CP014UFLQ4A"
 * ["PrivateKey"]=> string(25) "WY48CP014UFLQ4A0VSW12US00"
 * ["BaseUrl"]=> string(22) "https://api.ipara.com/"
 * ["Mode"]=> string(1) "T"
 * ["Version"]=> string(3) "1.0"
 * ["HashString"]=> string(152) "WY48CP014UFLQ4A0VSW12US004EF9B379-BF23-4EE3-B2DD-9D4115E4DA9C10000TKart Sahibi Ad Soyad54561654561654541224000MuratKayamurat@kaya.com2020-05-17 12:45:07"
 * ["transactionDate"]=> string(19) "2020-05-17 12:45:07" }
  */
//          return  restHttpCaller::post($settings->BaseUrl . "rest/payment/auth", Helper::GetHttpHeaders($settings, "application/xml"), $request->toXmlString());
    }


    public function toJsonString(Settings $settings)
    {


        $purchaser = [
            "name" => $this->Purchaser->Name,
            "surname" => $this->Purchaser->SurName,
            "email" => $this->Purchaser->Email,
            "clientIp" => $this->Purchaser->ClientIp,
            "birthDate" => $this->Purchaser->BirthDate,
            "gsmNumber" => $this->Purchaser->GsmPhone,
            "tcCertificate" => $this->Purchaser->IdentityNumber,
            "invoiceAddress" => [
                "name" => $this->Purchaser->InvoiceAddress->Name,
                "surname" => $this->Purchaser->InvoiceAddress->SurName,
                "address" => $this->Purchaser->InvoiceAddress->Address,
                "zipcode" => $this->Purchaser->InvoiceAddress->ZipCode,
                "city" => $this->Purchaser->InvoiceAddress->CityCode,
                "country" => $this->Purchaser->InvoiceAddress->CountryCode,
                "tcCertificate" => $this->Purchaser->InvoiceAddress->IdentityNumber,
                "taxNumber" => $this->Purchaser->InvoiceAddress->TaxNumber,
                "taxOffice" => $this->Purchaser->InvoiceAddress->TaxOffice,
                "companyName" => $this->Purchaser->InvoiceAddress->CompanyName,
                "phoneNumber" => $this->Purchaser->InvoiceAddress->PhoneNumber
            ],
            "shippingAddress" => [
                "name" => $this->Purchaser->ShippingAddress->Name,
                "surname" => $this->Purchaser->ShippingAddress->SurName,
                "address" => $this->Purchaser->ShippingAddress->Address,
                "zipcode" => $this->Purchaser->ShippingAddress->ZipCode,
                "city" => $this->Purchaser->ShippingAddress->CityCode,
                "country" => $this->Purchaser->ShippingAddress->CountryCode,
                "tcCertificate" => $this->Purchaser->ShippingAddress->IdentityNumber,
                "phoneNumber" => $this->Purchaser->ShippingAddress->PhoneNumber
            ]
        ];

        $products = [];
        foreach($this->Products as $product) {
            $tmp['productCode'] = $product->Code;
            $tmp['productName'] = $product->Title;
            $tmp['quantity'] = $product->Quantity;
            $tmp['price'] = $product->Price;
            $products[] = $tmp;
        }

        $paymentRequest = [
            "mode" => $settings->Mode,
            "orderId" => $this->OrderId,
            "cardOwnerName" => $this->CardOwnerName,
            "cardNumber" => $this->CardNumber,
            "cardExpireMonth" => $this->CardExpireMonth,
            "cardExpireYear" => $this->CardExpireYear,
            "cardCvc" => $this->Cvc,
            "userId" => $this->UserId,
            "cardId" => $this->CardId,
            "installment" => $this->Installment,
            "amount" => $this->Amount,
            "echo" => $this->Echo,
            "successUrl" => $this->SuccessUrl,
            "failureUrl" => $this->FailUrl,
            "transactionDate" => $settings->transactionDate,
            "version" => $settings->Version,
            "token" => $this->Token,
            "language" => $this->Language,
            "purchaser" => $purchaser,
            "products" => $products
        ];

//        var_dump($paymentRequest);
        return json_encode($paymentRequest);
    }


    public function toHtmlString($parameters, $url) {
        $builder = "";

        $builder .= "<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.0 Transitional//EN\">";
        $builder .= "<html>";
        $builder .= "<body>";
        $builder .= "<form action=\"" . $url . "\" method=\"post\" id=\"three_d_form\" >";
        $builder .= "<input type=\"hidden\" name=\"parameters\" value=\"" . htmlspecialchars($parameters) . "\"/>";
        $builder .= "<input type=\"submit\" value=\"Öde\" style=\"display:none;\"/>";
        $builder .= "<noscript>";
        $builder .= "<br/>";
        $builder .= "<br/>";
        $builder .= "<center>";
        $builder .= "<h1>3D Secure Yönlendirme İşlemi</h1>";
        $builder .= "<h2>Javascript internet tarayıcınızda kapatılmış veya desteklenmiyor.<br/></h2>";
        $builder .= "<h3>Lütfen banka 3D Secure sayfasına yönlenmek için tıklayınız.</h3>";
        $builder .= "<input type=\"submit\" value=\"3D Secure Sayfasına Yönlen\">";
        $builder .= "</center>";
        $builder .= "</noscript>";
        $builder .= "</form>";
        $builder .= "</body>";
        $builder .= "<script>document.getElementById(\"three_d_form\").submit();</script>";
        $builder .= "</html>";
        return $builder;
    }

}