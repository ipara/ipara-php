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

        

class ApiPaymentRequest extends  BaseRequest
{
    public $ThreeD;
    public $OrderId;
    public $Amount;
    public $CardOwnerName;
    public $CardNumber;
    public $CardExpireMonth;
    public $CardExpireYear;  
    public $Installment;
    public $Cvc;
    public $VendorId;
    public $UserId;
    public $CardId;
    public $ThreeDSecureCode;
    public $Products;
    public $Purchaser;
    

   //3D Secure Olmadan Ödeme Servis çağrısını temsil eder.
  
    public static function execute(ApiPaymentRequest $request, Settings $settings)
    {
          $settings->transactionDate = Helper::GetTransactionDateString();
          $settings->HashString = $settings->PrivateKey . $request->OrderId . $request->Amount . $request->Mode . $request->CardOwnerName . $request->CardNumber . $request->CardExpireMonth . $request->CardExpireYear . $request->Cvc . $request->UserId . $request->CardId. $request->Purchaser->Name . $request->Purchaser->SurName . $request->Purchaser->Email . $settings->transactionDate;
           return  restHttpCaller::post($settings->BaseUrl . "rest/payment/auth", Helper::GetHttpHeaders($settings, "application/xml"), $request->toXmlString());
    }
	//3D olmadan ödeme sonucunun xml olarak ekrana yazdırılmasını sağlar.
	
    public function toXmlString()
    {
        $xml_data_product_part = "";
        foreach ($this->Products as $Product) {
            
            $xml_data_product_part .= "<product>\n" .
                "	<productCode>" . urlencode($Product->Code) . "</productCode>\n" .
                "	<productName>" . urlencode($Product->Title) . "</productName>\n" .
                "	<quantity>" . $Product->Quantity . "</quantity>\n" .
                "	<price>" . $Product->Price . "</price>\n" .
                "</product>\n";
        }
        
        $three_d_secure_code_part = "";
        if ($this->ThreeD == "true") {
            $three_d_secure_code_part = "    <threeDSecureCode>" . $this->ThreeDSecureCode . "</threeDSecureCode>\n";
        }

        $vendor_id_part = "";
        if ($this->VendorId != NULL) {
            $vendor_id_part .= "    <vendorId>" . $this->VendorId . "</vendorId>\n";
        }

        $xml_data = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n" .
            "<auth>\n" .
            "    <threeD>" . $this->ThreeD . "</threeD>\n" .
            "    <orderId>" . $this->OrderId . "</orderId>\n" .
            "    <amount>" . $this->Amount . "</amount>\n" .
            "    <cardOwnerName>" . urlencode($this->CardOwnerName) . "</cardOwnerName>\n" .
            "    <cardNumber>" . $this->CardNumber . "</cardNumber>\n" .
            "    <cardExpireMonth>" . $this->CardExpireMonth . "</cardExpireMonth>\n" .
            "    <cardExpireYear>" . $this->CardExpireYear . "</cardExpireYear>\n" .
            "    <installment>" . $this->Installment . "</installment>\n" .
            "    <cardCvc>" . $this->Cvc . "</cardCvc>\n" .
            "    <userId>" . $this->UserId . "</userId>\n" .
            "    <cardId>" . $this->CardId . "</cardId>\n" .
            "    <mode>" . $this->Mode . "</mode>\n" .
            $three_d_secure_code_part .
            $vendor_id_part .
            "    <products>\n" .
            $xml_data_product_part .
            "    </products>\n" .
            "    <purchaser>\n" .
            "        <name>" . urlencode($this->Purchaser->Name) . "</name>\n" .
            "        <surname>" . urlencode($this->Purchaser->SurName) . "</surname>\n" .
            "        <birthDate>" . $this->Purchaser->BirthDate . "</birthDate>\n" .
            "        <email>" . $this->Purchaser->Email . "</email>\n" .
            "        <gsmNumber>" . urlencode($this->Purchaser->GsmPhone) . "</gsmNumber>\n" .
            "        <tcCertificate>" . urlencode($this->Purchaser->IdentityNumber) . "</tcCertificate>\n" .
            "        <clientIp>" . $this->Purchaser->ClientIp . "</clientIp>\n" .
            "        <invoiceAddress>\n" .
            "            <name>" . urlencode($this->Purchaser->InvoiceAddress->Name) . "</name>\n" .
            "            <surname>" . urlencode($this->Purchaser->InvoiceAddress->SurName) . "</surname>\n" .
            "            <address>" . urlencode($this->Purchaser->InvoiceAddress->Address) . "</address>\n" .
            "            <zipcode>" . urlencode($this->Purchaser->InvoiceAddress->ZipCode ) . "</zipcode>\n" .
            "            <city>" . urlencode($this->Purchaser->InvoiceAddress->CityCode) . "</city>\n" .
            "            <tcCertificate>" . urlencode($this->Purchaser->InvoiceAddress->IdentityNumber) . "</tcCertificate>\n" .
            "            <country>" . urlencode($this->Purchaser->InvoiceAddress->CountryCode) . "</country>\n" .
            "            <taxNumber>" . urlencode($this->Purchaser->InvoiceAddress->TaxNumber) . "</taxNumber>\n" .
            "            <taxOffice>" . urlencode($this->Purchaser->InvoiceAddress->TaxOffice) . "</taxOffice>\n" .
            "            <companyName>" . urlencode($this->Purchaser->InvoiceAddress->CompanyName) . "</companyName>\n" .
            "            <phoneNumber>" . urlencode($this->Purchaser->InvoiceAddress->PhoneNumber) . "</phoneNumber>\n" .
            "        </invoiceAddress>\n" .
            "        <shippingAddress>\n" .
            "            <name>" . urlencode($this->Purchaser->ShippingAddress->Name) . "</name>\n" .
            "            <surname>" . urlencode($this->Purchaser->ShippingAddress->SurName) . "</surname>\n" .
            "            <address>" . urlencode($this->Purchaser->ShippingAddress->Address) . "</address>\n" .
            "            <zipcode>" . urlencode($this->Purchaser->ShippingAddress->ZipCode) . "</zipcode>\n" .
            "            <city>" . urlencode($this->Purchaser->ShippingAddress->CityCode ) . "</city>\n" .
            "            <country>" . urlencode($this->Purchaser->ShippingAddress->CountryCode) . "</country>\n" .
            "            <phoneNumber>" . urlencode($this->Purchaser->ShippingAddress->PhoneNumber) . "</phoneNumber>\n" .
            "        </shippingAddress>\n" .
            "    </purchaser>\n" .
            "</auth>";
        return $xml_data;
        print $xml_data;
    }

}