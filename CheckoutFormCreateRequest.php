<?php




	//Müşteri bilgilerinin bulunduğı sınıfı temsil eder.

class Purchaser{
    public $Name;
    public $Surname;
    public $BirthDate;
    public $Email;
    public $GsmPhone;
    public $IdentityNumber;
    public $ClientIp;  
    public $InvoiceAddress;
    public $ShippingAddress;

  }
	//Müşteri adresi bilgilerinin bulunduğı sınıfı temsil eder.

    class PurchaserAddress{
        
        public $Name;
        public $Surname;
        public $Address;
        public $ZipCode;
        public $CityCode;
        public $IdentityNumber;
        public $CountryCode;  
        public $TaxNumber;
        public $TaxOffice;
        public $CompanyName;
        public $PhoneNumber;
    }

	
	//Ürün bilgilerinin bulunduğu sınıfı temsil eder.

    class Product{
                public $Code; 
        
                public $Title; 
        
                public $Quantity; 
        
                public $Price;
    }

        

class CheckoutFormCreateRequest extends  BaseRequest
{
    public $Threed;
    public $OrderId;
    public $Amount;
    public $AllowedInstallments;
    public $VendorId;
    public $Products;
    public $Purchaser;
    public $CallbackUrl;
                      
    public static function execute(CheckoutFormCreateRequest $request, Settings $settings)
    {
          $settings->transactionDate = Helper::GetTransactionDateString();
          $settings->HashString = $settings->PrivateKey . $request->Mode . $request->Purchaser->Name . $request->Purchaser->SurName . $request->Purchaser->Email . $settings->transactionDate;
          return  restHttpCaller::post($settings->BaseUrl . "rest/checkoutForm/create", Helper::GetHttpHeaders($settings, "application/json"), $this->toJsonString());
    }
	
    public function toJsonString()
    {
        return json_encode([
            "script" => $this->script,
            "iframeUrl" => $this->iframeUrl,           
        ]);
    }

}