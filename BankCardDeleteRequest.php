<?php



class BankCardDeleteRequest extends  BaseRequest
{
    public $userId;
    public $cardId;
    public $clientIp;
    
    
   
    public static function execute(BankCardDeleteRequest $request, Settings $settings)
    {
          $settings->transactionDate = Helper::GetTransactionDateString();
          $settings->HashString = $settings->PrivateKey . $request->userId . $request->cardId . $request->clientIp . $settings->transactionDate;  
          return  restHttpCaller::post($settings->BaseUrl . "/bankcard/delete", Helper::GetHttpHeaders($settings, "application/json"), $request->toJsonString());
    }

    public function toJsonString()
    {
        
    

        return json_encode(array(
            "userId" => $this->userId,
            "cardId" => $this->cardId,
            "clientIp" => $this->clientIp
      ));


    }

}