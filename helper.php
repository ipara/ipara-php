<?php

class Helper {
	public static function GetTransactionDateString() {
		return date ( "Y-m-d H:i:s" ); // "2017-03-21 16:26:54
	}
	public static function CreateToken($publicKey, $hashString) {
		return $publicKey . ":" . base64_encode ( sha1 ( $hashString, true ) );
	}
	public static function Validate3DReturn(ThreeDPaymentInitResponse $paymentResponse, Settings $settings) {
		if (! isset ( $paymentResponse->Hash ) || trim ( $paymentResponse->Hash ) === '') {
			$error = "Ödeme cevabı hash bilgisi boş. [result : " . $paymentResponse->Result . ",error_code : " . $paymentResponse->ErrorCode . ",error_message : " . $paymentResponse->ErrorMessage . "]";
			throw new Exception ( $error );
			return false;
		}
		$hashText = $paymentResponse->OrderId . $paymentResponse->Result . $paymentResponse->Amount . $paymentResponse->Mode . $paymentResponse->ErrorCode . $paymentResponse->ErrorMessage . $paymentResponse->TransactionDate . $settings->PublicKey . $settings->PrivateKey;
		$hashedText = base64_encode ( sha1 ( $hashText, true ) );
		if ($hashedText != $paymentResponse->Hash) {
			$error = "Ödeme cevabı hash doğrulaması hatalı. [result : " . $paymentResponse->Result . ",error_code : " . $paymentResponse->ErrorCode . ",error_message : " . $paymentResponse->ErrorMessage . "]";
			throw new Exception ( $error );
			return false;
		}
		return true;
	}
	public static function GetHttpHeaders(Settings $settings, $acceptType) {
		$header = array (
				"Accept:" . $acceptType,
				"Content-type:" . $acceptType,
				"version:" . $settings->Version,
				"token:" . Helper::CreateToken ( $settings->PublicKey, $settings->HashString ),
				"transactionDate:" . $settings->transactionDate 
		);
		
		return $header;
	}
	public static function GUID() {
		if (function_exists ( 'com_create_guid' ) === true) {
			return trim ( com_create_guid (), '{}' );
		}
		
		return sprintf ( '%04X%04X-%04X-%04X-%04X-%04X%04X%04X', mt_rand ( 0, 65535 ), mt_rand ( 0, 65535 ), mt_rand ( 0, 65535 ), mt_rand ( 16384, 20479 ), mt_rand ( 32768, 49151 ), mt_rand ( 0, 65535 ), mt_rand ( 0, 65535 ), mt_rand ( 0, 65535 ) );
	}
	public static function get_client_ip() {
		if (getenv ( 'HTTP_CLIENT_IP' ))
			$ipaddress = getenv ( 'HTTP_CLIENT_IP' );
		else if (getenv ( 'HTTP_X_FORWARDED_FOR' ))
			$ipaddress = getenv ( 'HTTP_X_FORWARDED_FOR' );
		else if (getenv ( 'HTTP_X_FORWARDED' ))
			$ipaddress = getenv ( 'HTTP_X_FORWARDED' );
		else if (getenv ( 'HTTP_FORWARDED_FOR' ))
			$ipaddress = getenv ( 'HTTP_FORWARDED_FOR' );
		else if (getenv ( 'HTTP_FORWARDED' ))
			$ipaddress = getenv ( 'HTTP_FORWARDED' );
		else if (getenv ( 'REMOTE_ADDR' ))
			$ipaddress = getenv ( 'REMOTE_ADDR' );
		else
			$ipaddress = '127.0.0.1';
		
		return $ipaddress;
	}
	public static function getCurrentUrl() {
		return $_SERVER ['REQUEST_SCHEME'] . '://' . $_SERVER ['SERVER_NAME'] . ":" . $_SERVER ['SERVER_PORT'];
	}
}

?>
