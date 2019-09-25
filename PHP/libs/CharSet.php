<?php
class CharSet{
	const CHAR_ASCII = "ASCII";
	const CHAR_GBK   = "GBK";
	const CHAR_GB2312= "GB2312";
	const CHAR_UTF8  = "UTF-8";
	public static function detectEncoding($str){
		foreach (array('ASCII','UTF-8','GB2312','GBK') as $v) {
			if ($str === iconv($v, $v . '//IGNORE', $str)) {
				return $v;
			}
		}
		return 'UTF-8';
	}
	public static function transEncoding($str,$srcEncoding,$destEncoding){
		return iconv($srcEncoding, $destEncoding, $str);
	}
	public static function transToUTF8(&$str){
		$enc = self::detectEncoding($str);
		if($enc==self::CHAR_GB2312 || $enc==self::CHAR_GBK){
			$str = iconv($enc, "UTF-8", $str);
		}
		return $enc;
	}
}