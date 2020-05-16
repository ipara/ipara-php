<?php
ini_set('display_errors',1); 
error_reporting(E_ERROR );

include ("settings.php");
include ("helper.php");
include ("base.php");
include ("restHttpCaller.php");
include ("BinNumberInquiryRequest.php");
include ("BankCardInquiryRequest.php");
include ("ApiPaymentRequest.php");
include ("BankCardCreateRequest.php");
include ("BankCardDeleteRequest.php");
include ("PaymentInquiryRequest.php");


$settings = new Settings();

$request = new BinNumberInquiryRequest();
$request->binNumber="492130";
$response=BinNumberInquiryRequest::execute($request,$settings);
print  "Bin Inqury \xA" . $response . "\xA". "\xA";

$request = new PaymentInquiryRequest();
$request->orderId = orderId;
$request->Echo= "Echo";
$request->Mode = settings.Mode;
$response=PaymentInquiryRequest::execute($request,$settings);
print  "PaymentInquiryRequest \xA" . $response . "\xA". "\xA";


$request = new BankCardCreateRequest();
$request->userId = "123456";
$request->cardOwnerName = "Kart Sahibi Ad Soyad";
$request->cardNumber = "5456165456165454";
$request->cardAlias = "Adios";
$request->cardExpireMonth = "12";
$request->cardExpireYear = "24";
$request->clientIp=Helper::get_client_ip();
$response=BankCardCreateRequest::execute($request,$settings);
print "BankCardCreateRequest  \xA" . $response  . "\xA". "\xA";


$request = new BankCardInquiryRequest();
$request->userId = "123456";
$request->cardId = "";
$request->clientIp=Helper::get_client_ip();
$response=BankCardInquiryRequest::execute($request,$settings);
print "BankCardInquiryRequest  \xA" . $response  . "\xA". "\xA";


$request = new BankCardDeleteRequest();
$request->userId = "123456";
$request->cardId = "";
$request->clientIp=Helper::get_client_ip();
$response=BankCardDeleteRequest::execute($request,$settings);
print "BankCardDeleteRequest  \xA" . $response  . "\xA". "\xA";


$request = new ApiPaymentRequest();
$request->OrderId = Helper::Guid();
$request->Echo = "Echo";
$request->Mode = $settings->Mode;
$request->Amount = "10000"; // 100 tL
$request->CardOwnerName = "Kart Sahibi Ad Soyad";
$request->CardNumber = "5456165456165454";
$request->CardExpireMonth = "12";
$request->CardExpireYear = "24";
$request->Installment = "1";
$request->Cvc = "000";
$request->ThreeD = "false";



#region Sipariş veren bilgileri
$request->Purchaser = new Purchaser();
$request->Purchaser->Name = "Murat";
$request->Purchaser->SurName = "Kaya";
$request->Purchaser->BirthDate = "1986-07-11";
$request->Purchaser->Email = "murat@kaya.com";
$request->Purchaser->GsmPhone = "5881231212";
$request->Purchaser->IdentityNumber = "1234567890";
$request->Purchaser->ClientIp = Helper::get_client_ip();
#endregion

#region Fatura bilgileri

$request->Purchaser->InvoiceAddress = new PurchaserAddress();
$request->Purchaser->InvoiceAddress->Name = "Murat";
$request->Purchaser->InvoiceAddress->SurName = "Kaya";
$request->Purchaser->InvoiceAddress->Address = "Mevlüt Pehlivan Mah-> Multinet Plaza Şişli";
$request->Purchaser->InvoiceAddress->ZipCode = "34782";
$request->Purchaser->InvoiceAddress->CityCode = "34";
$request->Purchaser->InvoiceAddress->IdentityNumber = "1234567890";
$request->Purchaser->InvoiceAddress->CountryCode = "TR";
$request->Purchaser->InvoiceAddress->TaxNumber = "123456";
$request->Purchaser->InvoiceAddress->TaxOffice = "Kozyatağı";
$request->Purchaser->InvoiceAddress->CompanyName = "iPara";
$request->Purchaser->InvoiceAddress->PhoneNumber = "2122222222";
#endregion

#region Kargo Adresi bilgileri
$request->Purchaser->ShippingAddress = new PurchaserAddress();
$request->Purchaser->ShippingAddress->Name = "Murat";
$request->Purchaser->ShippingAddress->SurName = "Kaya";
$request->Purchaser->ShippingAddress->Address = "Mevlüt Pehlivan Mah-> Multinet Plaza Şişli";
$request->Purchaser->ShippingAddress->ZipCode = "34782";
$request->Purchaser->ShippingAddress->CityCode = "34";
$request->Purchaser->ShippingAddress->IdentityNumber = "1234567890";
$request->Purchaser->ShippingAddress->CountryCode = "TR";
$request->Purchaser->ShippingAddress->PhoneNumber = "2122222222";
#endregion

#region Ürün bilgileri
$request->Products =  array();
$p = new Product();
$p->Title = "Telefon";
$p->Code = "TLF0001";
$p->Price = "5000";
$p->Quantity = 1;
$request->Products[0]=$p;

$p = new Product();
$p->Title = "Bilgisayar";
$p->Code = "BLG0001";
$p->Price = "5000";
$p->Quantity = 1;
$request->Products[1]=$p;

#endregion


$response=ApiPaymentRequest::execute($request,$settings);   
print "\xA ApiPaymentRequest  \xA" . $response  . "\xA". "\xA";


