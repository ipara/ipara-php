<?php
ini_set ( 'display_errors', 1 );
error_reporting ( E_ERROR );

include ("settings.php");
include ("helper.php");
include ("base.php");
include ("restHttpCaller.php");
include ("ThreeDPaymentInitRequest.php");
include ("ThreeDPaymentCompleteRequest.php");

$settings = new Settings ();

$settings->PublicKey = ""; // "Public Magaza Anahtarı",
$settings->PrivateKey = ""; // "Private Magaza Anahtarı",
$settings->BaseUrl = "https://www.ipara.com/3dgate";
$settings->Version = "1.0";
$settings->Mode = "T"; // Test -> T / Prod -> P
$settings->HashString = "";

$request = new ThreeDPaymentInitRequest ();
$request->OrderId = Helper::Guid ();
$request->Echo = "Echo";
$request->Mode = $settings->Mode;
$request->Version = $settings->Version;
$request->Amount = "10000"; // 100 tL
$request->CardOwnerName = "Kart Sahibi Ad Soyad";
$request->CardNumber = "5456165456165454";
$request->CardExpireMonth = "12";
$request->CardExpireYear = "24";
$request->Installment = "1";
$request->Cvc = "000";
$request->CardId = "";
$request->UserId = "";

$request->PurchaserName = "Murat";
$request->PurchaserSurname = "Kaya";
$request->PurchaserEmail = "murat@kaya.com";
$request->SuccessUrl = helper::getCurrentUrl() . "/success.php";
$request->FailUrl = helper::getCurrentUrl() . "/fail.php";

$response = ThreeDPaymentInitRequest::execute ( $request, $settings );
print $response;
?>


 
