<?php
class BinNumberInquiryRequest extends  BaseRequest
{
    public $binNumber;
   
    public static function execute(BinNumberInquiryRequest $request, Settings $settings)
    {
        $settings->transactionDate = Helper::GetTransactionDateString();
          $settings->HashString = $settings->PrivateKey . $request->binNumber . $settings->transactionDate;  
          return restHttpCaller::post($settings->BaseUrl . "rest/payment/bin/lookup", Helper::GetHttpHeaders($settings, "application/json"), $request->toJsonString());

        }

    public function toJsonString()
    {
        
        return json_encode(array("binNumber"=>$this->binNumber));
    }

}