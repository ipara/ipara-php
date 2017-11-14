<?php

// include ("base.php");
// include ("restHttpCaller.php");
class ThreeDPaymentInitRequest extends BaseRequest {
	//3D Ödeme Formu başlatmak için gerekli olan servis girdi parametrelerini temsil eder.
	public $OrderId;
	public $Amount;
	public $UserId;
	public $CardId;
	public $CardOwnerName;
	public $CardNumber;
	public $CardExpireMonth;
	public $CardExpireYear;
	public $Installment;
	public $Cvc;
	public $PurchaserName;
	public $PurchaserSurname;
	public $PurchaserEmail;
	public $SuccessUrl;
	public $FailUrl;
	public $Version;
	public $TransactionDate;
	public $Token;
	
	/*
	 *	Diğer fonksiyonların aksine 3D Sınıfı bir formun post edilmesi ile başlar 
	 *  bu sebeble bu fonksiyon ilgili HTML formu oluşturur ve geri döndürür.
	 *  Bu formu mevcut formun üzerine yazmak ilgili formun Javascript ile post edilmesini sağlar. 
	*/
	public static function execute(ThreeDPaymentInitRequest $request, Settings $settings) {
		$settings->transactionDate = Helper::GetTransactionDateString ();
		$request->TransactionDate = $settings->transactionDate;
		$settings->HashString = $settings->PrivateKey . $request->OrderId . $request->Amount . $request->Mode . $request->CardOwnerName . $request->CardNumber . $request->CardExpireMonth . $request->CardExpireYear . $request->Cvc . $request->UserId . $request->CardId . $request->PurchaserName . $request->PurchaserSurname . $request->PurchaserEmail . $settings->transactionDate;
		$request->Token = Helper::CreateToken ( $settings->PublicKey, $settings->HashString );
		return $request->toHtmlString ( $request, $settings );
	}
	public function toHtmlString(ThreeDPaymentInitRequest $request, Settings $settings) {
		$builder = "";
		
		$builder .= "<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.0 Transitional//EN\">";
		$builder .= "<html>";
		$builder .= "<body>";
		$builder .= "<form action=\"" . $settings->BaseUrl . "\" method=\"post\" id=\"three_d_form\" >";
		$builder .= "<input type=\"hidden\" name=\"orderId\" value=\"" . $request->OrderId . "\"/>";
		$builder .= "<input type=\"hidden\" name=\"amount\" value=\"" . $request->Amount . "\"/>";
		$builder .= "<input type=\"hidden\" name=\"cardOwnerName\" value=\"" . $request->CardOwnerName . "\"/>";
		$builder .= "<input type=\"hidden\" name=\"cardNumber\" value=\"" . $request->CardNumber . "\"/>";
		$builder .= "<input type=\"hidden\" name=\"userId\" value=\"" . $request->UserId . "\"/>";
		$builder .= "<input type=\"hidden\" name=\"cardId\" value=\"" . $request->CardId . "\"/>";
		$builder .= "<input type=\"hidden\" name=\"cardExpireMonth\" value=\"" . $request->CardExpireMonth . "\"/>";
		$builder .= "<input type=\"hidden\" name=\"cardExpireYear\" value=\"" . $request->CardExpireYear . "\"/>";
		$builder .= "<input type=\"hidden\" name=\"installment\" value=\"" . $request->Installment . "\"/>";
		$builder .= "<input type=\"hidden\" name=\"cardCvc\" value=\"" . $request->Cvc . "\"/>";
		$builder .= "<input type=\"hidden\" name=\"mode\" value=\"" . $request->Mode . "\"/>";
		$builder .= "<input type=\"hidden\" name=\"purchaserName\" value=\"" . $request->PurchaserName . "\"/>";
		$builder .= "<input type=\"hidden\" name=\"purchaserSurname\" value=\"" . $request->PurchaserSurname . "\"/>";
		$builder .= "<input type=\"hidden\" name=\"purchaserEmail\" value=\"" . $request->PurchaserEmail . "\"/>";
		$builder .= "<input type=\"hidden\" name=\"successUrl\" value=\"" . $request->SuccessUrl . "\"/>";
		$builder .= "<input type=\"hidden\" name=\"failureUrl\" value=\"" . $request->FailUrl . "\"/>";
		$builder .= "<input type=\"hidden\" name=\"echo\" value=\"" . $request->Echo . "\"/>";
		$builder .= "<input type=\"hidden\" name=\"version\" value=\"" . $request->Version . "\"/>";
		$builder .= "<input type=\"hidden\" name=\"transactionDate\" value=\"" . $request->TransactionDate . "\"/>";
		$builder .= "<input type=\"hidden\" name=\"token\" value=\"" . $request->Token . "\"/>";
		$builder .= "<input type=\"submit\" value=\"Öde\" style=\"display:none;\"/>";
		$builder .= "<noscript>";
		$builder .= "<br/>";
		$builder .= "<br/>";
		$builder .= "<center>";
		$builder .= "<h1>3D Secure Yönlendirme İşlemi</h1>";
		$builder .= "<h2>Javascript internet tarayıcınızda kapatılmış veya desteklenmiyor.<br/></h2>";
		$builder .= "<h3>Lütfen banka 3D Secure sayfasına yönlenmek için tıklayınız.</h3>";
		$builder .= "<input type=\"submit\" value=\"3D Secure Sayfasına Yönlen\">";
		$builder .= "</center>";
		$builder .= "</noscript>";
		$builder .= "</form>";
		$builder .= "</body>";
		$builder .= "<script>document.getElementById(\"three_d_form\").submit();</script>";
		$builder .= "</html>";
		return $builder;
	}
}