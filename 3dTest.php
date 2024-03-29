<?php
ini_set ( 'display_errors', 1 );
error_reporting ( E_ERROR );

include ("settings.php");
include ("helper.php");
include ("base.php");
include ("restHttpCaller.php");
include ("Api3DPaymentRequest.php");
include ("ThreeDPaymentCompleteRequest.php");

$settings = new Settings ();

$settings->PublicKey = ""; // "Public Magaza Anahtarı",
$settings->PrivateKey = ""; // "Private Magaza Anahtarı",
$settings->BaseUrl = "https://www.ipara.com/rest/payment/threed";
$settings->Version = "1.0";
$settings->Mode = "T"; // Test -> T / Prod -> P
$settings->HashString = "";

$request = new Api3DPaymentRequest ();
$request->OrderId = Helper::Guid ();
$request->Echo = "Echo";
$request->Mode = $settings->Mode;
$request->Version = $settings->Version;
$request->Amount = "10000"; // 100 tL
$request->CardOwnerName = "Kart Sahibi Ad Soyad";
$request->CardNumber = "4662803300111364";
$request->CardExpireMonth = "10";
$request->CardExpireYear = "25";
$request->Installment = "1";
$request->Cvc = "000";
$request->CardId = "";
$request->UserId = "";

$request->PurchaserName = "Murat";
$request->PurchaserSurname = "Kaya";
$request->PurchaserEmail = "murat@kaya.com";
$request->SuccessUrl = helper::getCurrentUrl() . "/success.php";
$request->FailUrl = helper::getCurrentUrl() . "/fail.php";

$response = Api3DPaymentRequest::execute ( $request, $settings );
print $response;
?>


 
