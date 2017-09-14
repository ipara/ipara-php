<?php 

ini_set('display_errors',1); 
error_reporting(E_ERROR );

include ("settings.php");
include ("helper.php");
include ("base.php");
include ("restHttpCaller.php");
include ("ThreeDPaymentInitRequest.php");
include ("ThreeDPaymentCompleteRequest.php");


$settings = new Settings();

$settings->PublicKey = "SVD40N0BEHZVY4D"; //"Public Magaza Anahtarı",
$settings->PrivateKey = "SVD40N0BEHZVY4D8L9GMQXMDU"; //"Private Magaza Anahtarı",
$settings->BaseUrl = "https://entegrasyon.ipara.com/3dgate";
$settings->Version = "1.0";
$settings->Mode = "T"; // Test -> T / Prod -> P
$settings->HashString = "";


$request = new ThreeDPaymentInitRequest();
$request->OrderId = Helper::Guid();
$request->Echo = "Echo";
$request->Mode = $settings->Mode;
$request->Version = $settings->Version;
$request->Amount = "10000"; // 100 tL
$request->CardOwnerName = "Fatih Coşkun";
$request->CardNumber = "4282209027132016";
$request->CardExpireMonth = "05";
$request->CardExpireYear = "18";
$request->Installment = "1";
$request->Cvc = "000";
$request->CardId = "";
$request->UserId = "";

$request->PurchaserName = "Murat";
$request->PurchaserSurname = "Kaya";
$request->PurchaserEmail = "murat@kaya.com";
$request->SuccessUrl = "http://localhost:5000/success.php";
$request->FailUrl = "http://localhost:5000/fail.php";




 $response=ThreeDPaymentInitRequest::execute($request,$settings);   
 print  $response;



 