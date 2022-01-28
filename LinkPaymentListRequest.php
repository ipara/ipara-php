<?php

class LinkPaymentListRequest extends  BaseRequest
{
    // LinkPayment servisi body parametreleri
    private $email;
    private $gsm;
    private $linkState;
    private $startDate;
    private $endDate;
    private $pageSize;
    private $pageIndex;
    private $clientIp;
    private $linkId;


    public function __construct($requestData)
    {
        $this->email = $requestData['email'];
        $this->gsm = $requestData['gsm'];
        $this->linkState = $requestData['linkState'];
        $this->startDate = $requestData['startDate'];
        $this->endDate = $requestData['endDate'];
        $this->linkId = $requestData['linkId'];
        $this->pageSize = $requestData['pageSize'];
        $this->pageIndex = $requestData['pageIndex'];
        $this->clientIp = Helper::get_client_ip();

    }

    public function execute(Settings $settings)
    {
          $settings->transactionDate = Helper::GetTransactionDateString();
          $settings->HashString = $settings->PrivateKey . $this->clientIp . $settings->transactionDate;

          return  restHttpCaller::post($settings->BaseUrl . "/corporate/merchant/linkpayment/list", Helper::GetHttpHeaders($settings, "application/json"), $this->toJsonString());
    }

    public function toJsonString()
    {
        return json_encode([
            "email" => $this->email,
            "gsm" => $this->gsm,
            "linkState" => $this->linkState,
            "startDate" => $this->startDate,
            "endDate" => $this->endDate,
            "linkId" => $this->linkId,
            "pageSize" => $this->pageSize,
            "pageIndex" => $this->pageIndex,
            "clientIp" => $this->clientIp
        ]);
    }
}