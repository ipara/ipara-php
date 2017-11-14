<?php



class BankCardDeleteRequest extends  BaseRequest
{
	//	Cüzdanda kayıtlı olan kartı silmek için gerekli olan servis girdi parametrelerini temsil eder.
	
    public $userId;
    public $cardId;
    public $clientIp;
    
    
   /*
	*	Mağazanın, kullanıcının bir kartını veya kayıtlı olan tüm kartlarını silmek istediği zaman kullanabileceği servisi temsil eder.
	*	@BankCardDeleteRequest Banka kartı silmek için gerekli olan girdilerin olduğu sınıfı temsil eder.
	*	@Settings Kullanıcıya özel olarak belirlenen ayarları temsil eder.
   */
    public static function execute(BankCardDeleteRequest $request, Settings $settings)
    {
          $settings->transactionDate = Helper::GetTransactionDateString();
          $settings->HashString = $settings->PrivateKey . $request->userId . $request->cardId . $request->clientIp . $settings->transactionDate;  
          return  restHttpCaller::post($settings->BaseUrl . "/bankcard/delete", Helper::GetHttpHeaders($settings, "application/json"), $request->toJsonString());
    }
	/*
		Servis çıktı parametrelerinin json olarak ekranda gösterilmesini sağlar
	*/
    public function toJsonString()
    {
        
        return json_encode(array(
            "userId" => $this->userId,
            "cardId" => $this->cardId,
            "clientIp" => $this->clientIp
      ));


    }

}