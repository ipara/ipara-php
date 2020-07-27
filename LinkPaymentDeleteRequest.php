<?php

class LinkPaymentDeleteRequest extends  BaseRequest
{
    // LinkPaymentDelete servisi body parametreleri
    private $linkId;
    private $clientIp;

    public function __construct($linkId)
    {
        $this->linkId = $linkId;
        $this->clientIp = Helper::get_client_ip();
    }

    public function execute(Settings $settings)
    {
          $settings->transactionDate = Helper::GetTransactionDateString();
          $settings->HashString = $settings->PrivateKey . $this->clientIp . $settings->transactionDate;

          return  restHttpCaller::post($settings->BaseUrl . "/corporate/merchant/linkpayment/delete", Helper::GetHttpHeaders($settings, "application/json"), $this->toJsonString());
    }

    public function toJsonString()
    {
        return json_encode([
            "linkId" => $this->linkId,
            "clientIp" => $this->clientIp
        ]);
    }
}