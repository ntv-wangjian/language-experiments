<?php
class HttpClient{
	public static function curlGetContents($url,$paras=NULL){
		if($paras){
			$url = self::packUrl($url,$paras);
		}
		return self::curl_file_get_contents($url);
	}
	
	public static function getJosnArray($url,$paras=NULL){
		$data = self::curlGetContents($url,$paras);
		if($data){
			return json_decode($data,TRUE);
		}else{
			return NULL;
		}
	}
	
	public static function itemProp(&$data,$prop){
		if(is_array($data) && isset($data[$prop])){
			return $data[$prop];
		}else{
			return NULL;
		}
	}
	public static function dataItem(&$data){
		$data = self::itemProp($data,"data");
		if(!$data) return NULL;
		$items= self::itemProp($data,"items");
		if($items && count($items)>0){
			return $items[0];
		}
		return NULL;
	}
	
	public static function getContents($url,$maxContent=1024){
		$ctx = stream_context_create(array(
				'http' => array(
						'method'=>"GET",
						'timeout' => 2)
		));
		return @file_get_contents($url, false, $ctx, 0, $maxContent);
	}
	
	/**
	 * 
	 * @param $json_data 是否将post数据以json格式发送。
	 */
	public static function postData($arr,$url,$json_data=TRUE){
		$data_string = "";
		if($json_data){
			$data_string = json_encode($arr);
		}else{
			$data_string = http_build_query($arr);
		}
	
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
		curl_setopt($ch, CURLOPT_POSTFIELDS,$data_string);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
		if($json_data){
			curl_setopt($ch, CURLOPT_HTTPHEADER, array(
					'Content-Type: application/json',
					'Content-Length: ' . strlen($data_string))
					);
		}else{
			curl_setopt($ch, CURLOPT_HTTPHEADER, array(
					'Content-Length: ' . strlen($data_string))
					);
		}
	
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
	
	public static function getServerHostUrl($appendSomething=NULL){
		$url  = "";
		$host =$_SERVER['HTTP_HOST'];
		if (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') {
			$url = "https://" . $host;
		}else{
			$url = "http://"  . $host;
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
	
	/**
	 * 获取指定参数&name=wang&sex=1 
	 */
	public static function getQueryPara($paraname,$haystack){
		if(!$haystack) return NULL;
		$str = strstr($haystack,$paraname."=");
		if(!$str){
			return NULL;
		}
		$str2 = strstr($str,"&",TRUE);
		if($str2){
			$str = $str2;
		}
	
		$arr = explode("=",$str);
		return $arr[1];
	}
	
	public static function getSession($key,$default=NULL){
		if(!isset($_SESSION[$key])){
			return $default;
		}
		return $_SESSION[$key];
	}
	public static function regSession($key,$val){
		$_SESSION[$key] = $val;
	}
	
	//给个默认值
	public static function getPara($key,$default=NULL,$number=FALSE){
		if(!isset($_REQUEST[$key])){
			return $default;
		}
		$value = $_REQUEST[$key];
		if($number){
			return intval($value);
		}else{
			return $value;
		}
	}
	
	public static function gotoUrl($url,$paras=NULL){
		if($paras){
			$url = self::packUrl($url, $paras);
		}
		header('location:' . $url);
		exit();
	}
	
	public static function randomkeys($length)
	{
		$key    = "";
		$pattern='1234567890abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLOMNOPQRSTUVWXYZ';
		for($i=0;$i<$length;$i++)
		{
			$key .= $pattern{mt_rand(0,35)};
		}
		return $key;
	}
}