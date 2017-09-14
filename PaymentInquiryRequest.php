<?php



class PaymentInquiryRequest extends  BaseRequest
{
    public $orderId;
    
   
    public static function execute(PaymentInquiryRequest $request, Settings $settings)
    {
          $settings->transactionDate = Helper::GetTransactionDateString();
          $request->Mode=$settings->Mode;
          $settings->HashString = $settings->PrivateKey . $request->orderId . $request->Mode . $settings->transactionDate;  
          return  restHttpCaller::post($settings->BaseUrl . "/rest/payment/inquiry", Helper::GetHttpHeaders($settings, "application/xml"), $request->toXmlString());
    }

    public function toXmlString()
    {
        $xml_data = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n" .
        "<inquiry>\n" .
        "    <orderId>" . $this->orderId . "</orderId>\n" .
        "    <mode>" . $this->Mode . "</mode>\n" .
        "</inquiry>";
         return $xml_data;
    

       

    }

}