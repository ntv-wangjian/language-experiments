<?php
class HttpClient{
	public static function curlGetContents($url,$maxContent=1024){
		return self::curl_file_get_contents($url);
	}
	
	public static function getContents($url,$maxContent=1024){
		$ctx = stream_context_create(array(
				'http' => array(
						'method'=>"GET",
						'timeout' => 2)
		));
		return @file_get_contents($url, false, $ctx, 0, $maxContent);
	}
	
	public static function postData($arr,$url){
		$data_string = json_encode($arr);
	
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
		curl_setopt($ch, CURLOPT_POSTFIELDS,$data_string);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
				'Content-Type: application/json',
				'Content-Length: ' . strlen($data_string))
				);
	
		$result = curl_exec($ch);
		return $result;
	}
	
	private static function curl_file_get_contents($url){
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_TIMEOUT, 3);
		//	curl_setopt($ch, CURLOPT_USERAGENT, _USERAGENT_);
		//	curl_setopt($ch, CURLOPT_REFERER,_REFERER_);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$r = curl_exec($ch);
		curl_close($ch);
		return $r;
	}
	
	public static function getLocalHostUrl($appendSomething=NULL){
		$url = "";
		if (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') {
			$url = "https://127.0.0.1";
		}else{
			$url = "http://127.0.0.1";
		}
		if(is_numeric($_SERVER['SERVER_PORT'])){
			$url .= ":" . $_SERVER['SERVER_PORT'];
		}
		
		if($appendSomething){
			$url .= "/" . ltrim($appendSomething,"/");
		}
		
		return $url;
	}
	
	/**
	 * 将url和参数组合成一个新的url地址
	 * @param unknown $url
	 * @param unknown $paras
	 */
	public static function packUrl($url,$paras){
		if(strpos($url,'?')>0){
			$url .= "&";
		}else{
			$url .= "?";
		}
		if(is_array($paras)){
			$url .= http_build_query($paras);
		}else if($paras){
			$url .= $paras;
		}
		return $url;
	}
}