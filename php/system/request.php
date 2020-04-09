<?php
class Request {
	public static function get($name,$wysiwyg=false,$var="request") {
		$data = null;
		
		if($var == "request")
			$data = isset($_REQUEST[$name]) ? $_REQUEST[$name] : null;
		elseif($var == "get")
			$data = isset($_GET[$name]) ? $_GET[$name] : null;
		elseif($var == "post")
			$data = isset($_POST[$name]) ? $_POST[$name] : null;
		
		if(empty($data))
			return $data;
		
		if($wysiwyg) {
			$data = self::purifyHtml($data);
		} else {
			$data = htmlspecialchars(strip_tags($data));
		}
		return $data;
	}
	
	public static function issetRequest($n) {
		return isset($_REQUEST[$n]) ? true : false;
	}
	
	public static function issetPost($n) {
		return isset($_POST[$n]) ? true : false;
	}
	public static function issetGet($n) {
		return isset($_GET[$n]) ? true : false;
	}
	
	public static function purifyHtml($input,$parent = 'div') {
		require_once "php/lib/htmlpurifier/HTMLPurifier.standalone.php";
		$config = HTMLPurifier_Config::createDefault();
		$config->set('HTML.Allowed', 'p,b,strong,a[href],u,em,i,strike,br,h1,h2,h3,h4,ul,li,ol,div,pre,span,code');
		$config->set('AutoFormat.RemoveEmpty', true);
		if($parent != "div") {
			$config->set('HTML.Parent', $parent);
		}
		$purifier = new HTMLPurifier($config);
		return $purifier->purify($input);
	}
}