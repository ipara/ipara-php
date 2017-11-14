<?php
class BinNumberInquiryRequest extends  BaseRequest
{
	//Bin Sorgulama servisleri içerisinde kullanılacak olan bin numarasını temsil eder.
    public $binNumber;
   
   // Türkiye genelinde tanımlı olan tüm yerli kartlara ait BIN numaraları için sorgulama yapılmasına izin veren servisi temsil eder. 
    public static function execute(BinNumberInquiryRequest $request, Settings $settings)
    {
        $settings->transactionDate = Helper::GetTransactionDateString();
          $settings->HashString = $settings->PrivateKey . $request->binNumber . $settings->transactionDate;  
          return restHttpCaller::post($settings->BaseUrl . "rest/payment/bin/lookup", Helper::GetHttpHeaders($settings, "application/json"), $request->toJsonString());

        }

	/*
	*	Servis çıktı parametrelerinin json olarak ekranda gösterilmesini sağlar
	*/
    public function toJsonString()
    {
        
        return json_encode(array("binNumber"=>$this->binNumber));
    }

}