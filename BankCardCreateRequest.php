<?php



class BankCardCreateRequest extends  BaseRequest
{
	
	 //Cüzdana kart ekleme servisi içerisinde kullanılacak alanları temsil etmektedir.
	
    public $userId;
    public $cardOwnerName;
    public $cardNumber;
    public $cardAlias;
    public $cardExpireMonth;
    public $cardExpireYear;
    public $clientIp;
    
   /*
	*	Cüzdana kart ekleme istek metodur. Bu metod çeşitli kart bilgilerini ve settings sınıfı içerisinde bize özel olarak oluşan alanları kullanarak
    *   cüzdana bir kartı kaydetmemizi sağlar.
	*	@request Cüzdana kart eklemek için gerekli olan girdilerin olduğu sınıfı temsil eder.
	*	@options Kullanıcıya özel olarak belirlenen ayarları temsil eder.
   */
    public static function execute(BankCardCreateRequest $request, Settings $settings)
    {
          $settings->transactionDate = Helper::GetTransactionDateString();
          $settings->HashString = $settings->PrivateKey . $request->userId . $request->cardOwnerName . $request->cardNumber . $request->cardExpireMonth . $request->cardExpireYear . $request->clientIp . $settings->transactionDate;  
          return  restHttpCaller::post($settings->BaseUrl . "/bankcard/create", Helper::GetHttpHeaders($settings, "application/json"), $request->toJsonString());
    }
	/*
		Servis çıktı parametrelerinin json olarak ekranda gösterilmesini sağlar
	*/
    public function toJsonString()
    {
        return json_encode(array(
            "userId" => $this->userId,
            "cardAlias" => $this->cardAlias,
            "cardOwnerName" => $this->cardOwnerName,
            "cardNumber" => $this->cardNumber,
            "cardExpireMonth" => $this->cardExpireMonth,
            "cardExpireYear" => $this->cardExpireYear,
            "clientIp" => $this->clientIp
        ));


    }

}