<?php



class BankCardCreateRequest extends  BaseRequest
{
    public $userId;
    public $cardOwnerName;
    public $cardNumber;
    public $cardAlias;
    public $cardExpireMonth;
    public $cardExpireYear;
    public $clientIp;
    
   
    public static function execute(BankCardCreateRequest $request, Settings $settings)
    {
          $settings->transactionDate = Helper::GetTransactionDateString();
          $settings->HashString = $settings->PrivateKey . $request->userId . $request->cardOwnerName . $request->cardNumber . $request->cardExpireMonth . $request->cardExpireYear . $request->clientIp . $settings->transactionDate;  
          return  restHttpCaller::post($settings->BaseUrl . "/bankcard/create", Helper::GetHttpHeaders($settings, "application/json"), $request->toJsonString());
    }

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