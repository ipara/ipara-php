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
        $settings->transactionDate = Helper::GetTransactionDateString();
        $settings->HashString = $settings->PrivateKey . $this->OrderId . $this->Amount . $this->Mode . $this->CardOwnerName . $this->CardNumber . $this->CardExpireMonth . $this->CardExpireYear . $this->Cvc . $this->UserId . $this->CardId. $this->Purchaser->Name . $this->Purchaser->SurName . $this->Purchaser->Email . $settings->transactionDate;
        $this->Token = Helper::CreateToken($settings->PublicKey, $settings->HashString);
        $parameters = $this->toJsonString($settings);
        $url = $settings->BaseUrl . 'rest/payment/threed';

        return $this->toHtmlString($parameters, $url);
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
            "vendorId" => $this->VendorId,
            "successUrl" => $this->SuccessUrl,
            "failureUrl" => $this->FailUrl,
            "transactionDate" => $settings->transactionDate,
            "version" => $settings->Version,
            "token" => $this->Token,
            "language" => $this->Language,
            "purchaser" => $purchaser,
            "products" => $products
        ];

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
