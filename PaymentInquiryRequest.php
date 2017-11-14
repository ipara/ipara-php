<?php



class PaymentInquiryRequest extends  BaseRequest
{
	// Ödeme sorugulama servisi için gerekli olan servis girdi parametrelerini temsil eder.
    public $orderId;
    
   /*
	* Bu servise sorgulanmak istenen ödemenin mağaza sipariş numarası ve mode değeri iletilerek, ödemenin durumu ve ödemenin tutarı öğrenilebileceği servisi temsil eder.
	* @$request Ödeme sorgulama servisi için gerekli olan girdilerin olduğu sınıfı temsil eder.
	* @$settings Kullanıcıya özel olarak belirlenen ayarları temsil eder.
   */
    public static function execute(PaymentInquiryRequest $request, Settings $settings)
    {
          $settings->transactionDate = Helper::GetTransactionDateString();
          $request->Mode=$settings->Mode;
          $settings->HashString = $settings->PrivateKey . $request->orderId . $request->Mode . $settings->transactionDate;  
          return  restHttpCaller::post($settings->BaseUrl . "/rest/payment/inquiry", Helper::GetHttpHeaders($settings, "application/xml"), $request->toXmlString());
    }

	//İstek sonucunda oluşan çıktının xml olarak gösterilmesini sağlar.
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