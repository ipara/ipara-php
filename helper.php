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
	
	/**
	 * Generates the current URL path.
	 * This can be used to automatically generate redirection URL's for local environments.
	 * Beware while using in production environments since the method can create faulty URL paths
	 *
	 * @method "request scheme" + "://" + "server name" + "server port"
	 * @return string
	 */
	public static function getCurrentUrl() {
		return $_SERVER ['REQUEST_SCHEME'] . '://' . $_SERVER ['SERVER_NAME'] . ":" . $_SERVER ['SERVER_PORT'];
	}
	
	/**
	 * Formats the xml input to a pretty printed version
	 *
	 * @param unknown $input_xml Unformatted XML text
	 * @return string Pretty printed XML Text
	 */
	public static function formattoXMLOutput($input_xml) {
		$doc = new DOMDocument ();
		$doc->loadXML ( $input_xml );
		$doc->preserveWhiteSpace = false;
		$doc->formatOutput = true;
		$output = $doc->saveXML ();
		return $output;
	}
	
	/**
	 * Note: Borrowed code
	 * <br>
	 * Indents a flat JSON string to make it more human-readable.
	 *
	 * @param string $input_json
	 *        	The original JSON string to process.
	 * @return string Indented version of the original JSON string.
	 * @link https://www.daveperrett.com/articles/2008/03/11/format-json-with-php/
	 */
	public static function formattoJSONOutput($input_json) {
		$result = '';
		$pos = 0;
		$strLen = strlen ( $input_json );
		$indentStr = "\t";
		$newLine = "\n";
		
		for($i = 0; $i < $strLen; $i ++) {
			// Grab the next character in the string.
			$char = $input_json [$i];
			
			// Are we inside a quoted string?
			if ($char == '"') {
				// search for the end of the string (keeping in mind of the escape sequences)
				if (! preg_match ( '`"(\\\\\\\\|\\\\"|.)*?"`s', $input_json, $m, null, $i ))
					return $input_json;
				
				// add extracted string to the result and move ahead
				$result .= $m [0];
				$i += strLen ( $m [0] ) - 1;
				continue;
			} else if ($char == '}' || $char == ']') {
				$result .= $newLine;
				$pos --;
				$result .= str_repeat ( $indentStr, $pos );
			}
			
			// Add the character to the result string.
			$result .= $char;
			
			// If the last character was the beginning of an element,
			// output a new line and indent the next line.
			if ($char == ',' || $char == '{' || $char == '[') {
				$result .= $newLine;
				if ($char == '{' || $char == '[') {
					$pos ++;
				}
				
				$result .= str_repeat ( $indentStr, $pos );
			}
		}
		return $result;
	}
}

?>
