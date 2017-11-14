<?php



class BankCardInquiryRequest extends  BaseRequest
{
	//Cüzdanda bulunan kartları getirmek için gerekli olan servis girdi parametrelerini temsil eder.
    public $userId;
    public $cardId;
    public $clientIp;
    
   
   /*
          *  Mağazanın, kullanıcının bir kartını veya kayıtlı olan tüm kartlarını getirmek istediği zaman kullanabileceği servisi temsil eder.
		  * @request Cüzdanda bulunan kartları getirmek için gerekli olan girdilerin olduğu sınıfı temsil eder.
		  * @options  Kullanıcıya özel olarak belirlenen ayarları temsil eder.

   */
    public static function execute(BankCardInquiryRequest $request, Settings $settings)
    {
          $settings->transactionDate = Helper::GetTransactionDateString();
          $settings->HashString = $settings->PrivateKey . $request->userId . $request->cardId . $request->clientIp . $settings->transactionDate;  
          return  restHttpCaller::post($settings->BaseUrl . "/bankcard/inquiry", Helper::GetHttpHeaders($settings, "application/json"), $request->toJsonString());
    }
	//Servis çıktı parametrelerinin json olarak ekranda gösterilmesini sağlar
    public function toJsonString()
    {
        
        return json_encode(array(
            "userId" => $this->userId,
            "cardId" => $this->cardId,
            "clientIp" => $this->clientIp
        ));


    }

}