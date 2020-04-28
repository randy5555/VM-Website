<?php
class common {
	public function __construct() {
	}

	function dateDisplay($timein) {
		$time = strtotime($timein);
		$dt = new DateTime();
		$dt->setTimeStamp($time);
		$dt->setTimezone(new DateTimeZone($_SESSION["tz"]));
		$timeout = $dt->format("Y-m-d H:i:sP");
		return $timeout;
	}

	function getHash($string) {
		return hash('sha256', $string.SALT);
	}
	
	static function numberDisplay($input,$precision=0) {
		$abbreviations = array(12 => 't', 9 => 'b', 6 => 'm', 3 => 'k', 0 => '');
		foreach($abbreviations as $exp=>$abbrv) {
			if($input >= pow(10,$exp+2))
				return number_format($input/pow(10,$exp),$precision).$abbrv;
		}
		return $input;
	}

	function getURL($url, $proxy = false,$opt = 0) {
		try {
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; PHP client; '.php_uname('s').'; PHP/'.phpversion().')');
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
			curl_setopt($ch, CURLOPT_HEADER, 0);
			curl_setopt($ch, CURLOPT_ENCODING, "");
			curl_setopt($ch, CURLOPT_VERBOSE,0);
			curl_setopt($ch, CURLOPT_TIMEOUT, 15);
			curl_setopt($ch, CURLOPT_CONNECTTIMEOUT ,3); 
			if($opt==4) {
				curl_setopt($ch, CURL_IPRESOLVE_V4 ,true); 
			}
			
			$output = curl_exec($ch);
			curl_close($ch);
			return $output;
		} catch (Exception $e) {
			return 0;
		}
	}

	function postURL($url,$proxy = false,$opt=0,$parms=array()) {
		try {
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; PHP client; '.php_uname('s').'; PHP/'.phpversion().')');
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
			curl_setopt($ch, CURLOPT_HEADER, 0);
			curl_setopt($ch, CURLOPT_ENCODING, "");
			curl_setopt($ch, CURLOPT_VERBOSE,0);
			curl_setopt($ch, CURLOPT_TIMEOUT, 15);
			curl_setopt($ch, CURLOPT_CONNECTTIMEOUT ,3); 
			if($opt==4) {
				curl_setopt($ch, CURL_IPRESOLVE_V4 ,true); 
			}
			
			if(!empty($parms)) {
				$parms = json_encode($parms);
				curl_setopt($ch, CURLOPT_POST, true);
				curl_setopt($ch, CURLOPT_POSTFIELDS, $parms);
			}
			$output = curl_exec($ch);
			curl_close($ch);
			return $output;
		} catch (Exception $e) {
			return 0;
		}
	}
	
	function htmlPurify($input,$extraconf=array()) {
		require_once "php/lib/htmlpurifier/HTMLPurifier.standalone.php";
		$config = HTMLPurifier_Config::createDefault();
		$config->set('HTML.Allowed', 'p,b,strong,a[href],u,em,i,strike,br,h1,h2,h3,h4,ul,li,ol,div,pre,span,code');
		$purifier = new HTMLPurifier($config);
		return $purifier->purify($input);
	}
	
	function timeDiff($start,$end,$granularity="i") {
		$stime = new DateTime($start);
		$etime = new DateTime($end);
		$diff = $stime->diff($etime);
		$granularity = strtolower($granularity);
		if($granularity == "y")
			return $diff->y;
		if($granularity == "m")
			return ($diff->y*12)+$diff->m;
		if($granularity == "d")
			return $diff->days;
		if($granularity == "h")
			return ($diff->days*24)+$diff->h;
		if($granularity == "i")
			return ($diff->days*24*60)+($diff->h*60)+$diff->i;
		if($granularity == "s")
			return ($diff->days*24*60*60)+($diff->h*60*60)+($diff->i*60)+$diff->s;
		return false;
	}
	
	public static function makeJavaScriptArray($JS_VarName, $array) {
		$js_array = json_encode($array);
		return "var $JS_VarName = ". $js_array . ";\n";
	}
	public static function getCSRF() {
		return rand(100,32733) * 51331;
	}
	
	public static function validateCSRF($tok) {
		if(is_numeric($tok) && ($tok % 51331) == 0) {
			return true;
		}
		return false;
	}
	
	public static function sendraw($host, $port, $message) {
		$socket = socket_create(AF_INET, SOCK_STREAM, 0);
		$result = socket_connect($socket, $host, $port);
		socket_write($socket, $message, strlen($message));
		$result = socket_read ($socket, 1024);
		socket_close($socket);
		return $result;
	}
	
}
