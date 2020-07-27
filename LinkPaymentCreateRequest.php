<?php

class LinkPaymentCreateRequest extends  BaseRequest
{
    // LinkPayment create servisi body parametreleri
    private $name;
    private $surname;
    private $tcCertificate;
    private $taxNumber;
    private $email;
    private $gsm;
    private $amount;
    private $threeD;
    private $expireDate;
    private $installmentList;
    private $sendEmail;
    private $commissionType;
    private $clientIp;

    public function __construct($requestData)
    {
        $this->name = $requestData['name'];
        $this->surname = $requestData['surname'];
        $this->tcCertificate = $requestData['tcCertificate'];
        $this->taxNumber = $requestData['taxNumber'];
        $this->email = $requestData['email'];
        $this->gsm = $requestData['gsm'];
        $this->amount = $requestData['amount'];
        $this->threeD = $requestData['threeD'];
        $this->expireDate = $requestData['expireDate'];
        $this->installmentList = $requestData['installmentList'];
        $this->sendEmail = $requestData['sendEmail'];
        $this->commissionType = $requestData['commissionType'];
        $this->clientIp = Helper::get_client_ip();
    }

    public function execute(Settings $settings)
    {
          $settings->transactionDate = Helper::GetTransactionDateString();
          $settings->HashString = $settings->PrivateKey . $this->name . $this->surname . $this->email  . $this->amount . $this->clientIp . $settings->transactionDate;

          return  restHttpCaller::post($settings->BaseUrl . "/corporate/merchant/linkpayment/create", Helper::GetHttpHeaders($settings, "application/json"), $this->toJsonString());
    }

    public function toJsonString()
    {
        return json_encode([
            "name" => $this->name,
            "surname" => $this->surname,
            "tcCertificate" => $this->tcCertificate,
            "taxNumber" => $this->taxNumber,
            "email" => $this->email,
            "gsm" => $this->gsm,
            "amount" => $this->amount,
            "threeD" => $this->threeD,
            "expireDate" => $this->expireDate,
            "installmentList" => $this->installmentList,
            "sendEmail" => $this->sendEmail,
            "commissionType" => $this->commissionType,
            "clientIp" => $this->clientIp
        ]);
    }
}