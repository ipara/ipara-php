<?php



class CreatePaymentRefundRequest extends  BaseRequest
{
	
	
    public $orderId;
    public $amount;
    public $clientIp;
    public $refundHash;

    public static function execute(CreatePaymentRefundRequest $request, Settings $settings)
    {
          $settings->transactionDate = Helper::GetTransactionDateString();
          $settings->HashString = $settings->PrivateKey . $request->orderId . $request->clientIp . $settings->transactionDate;  
          return  restHttpCaller::post($settings->BaseUrl . "/corporate/payment/refund", Helper::GetHttpHeaders($settings, "application/json"), $request->toJsonString());
    }
	/*
		Servis çıktı parametrelerinin json olarak ekranda gösterilmesini sağlar
	*/
    public function toJsonString()
    {
        return json_encode(array(
            "orderId" => $this->orderId,
            "amount" => $this->amount,
            "clientIp" => $this->clientIp,
            "refundHash"=> $this->refundHash
        ));


    }

}