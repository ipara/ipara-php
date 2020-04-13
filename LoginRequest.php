<?php

class LoginRequest extends  BaseRequest
{
    // Login servisi body parametreleri
    private $corporateNumber;
    private $username;
    private $password;
    private $clientIp;

    public function __construct($corporateNumber, $username, $password)
    {
        $this->corporateNumber = $corporateNumber;
        $this->username = $username;
        $this->password = $password;
        $this->clientIp = Helper::get_client_ip();
    }

    public function execute(Settings $settings)
    {
          $settings->transactionDate = Helper::GetTransactionDateString();
          $settings->HashString = $settings->PrivateKey . $this->corporateNumber . $this->username . $this->password . $this->clientIp . $settings->transactionDate;
          return  restHttpCaller::post($settings->BaseUrl . "/corporate/member/login", Helper::GetHttpHeaders($settings, "application/json"), $this->toJsonString());
    }

    public function toJsonString()
    {
        return json_encode(array(
            "corporateNumber" => $this->corporateNumber,
            "username" => $this->username,
            "password" => $this->password,
            "clientIp" => $this->clientIp
        ));
    }
}