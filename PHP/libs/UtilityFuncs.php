<?php
class UtilityFuncs{

	public static function get_duration_readable($timestamp)
	{
		$h = intval($timestamp / 3600);
		$m = $timestamp % 3600 / 60;
		$s = $timestamp % 60;
		if($h>0){
			return sprintf("%02d:%02d:%02d",$h,$m,$s);
		}else{
			return sprintf("%02d:%02d",$m,$s);
		}
	}
	
	public static function get_filesize_readable($size)
	{
		$g = $size / (1024*1024*1024);
		$m = $size / (1024*1024);
		$k = $size / 1024;
		if($g>1){
			return sprintf("%.2f GB",$g);
		}
		else if($m>1)
		{
			return sprintf("%.2f MB",$m);
		}
		else
		{
			return sprintf("%d KB",$k);
		}
	}
	
	public static function get_bitrate_readable($bitrate)
	{
		$m = $bitrate / (1024*1024);
		$k = $bitrate / 1024;
		if($m>1)
		{
			return sprintf("%.2fMbps",$m);
		}
		else
		{
			return sprintf("%dKbps",$k);
		}
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
	
	public static function genkey($str,$len=8){
		$mstr = md5($str);
		if($len<32){
			return substr($mstr,0,$len);
		}else{
			return $mstr;
		}
	}

	public static function spaceStr($len,$chr=" "){
		$str = "";
		for($i=0;$i<$len;$i++){
			$str .= $chr;
		}
		return $str;
	}
	
	public static function DateValidate($date){
		if(date("Y-m-d H:i:s",strtotime($date))==$date){
			return TRUE;
		}else{
			return FALSE;
		}
	}
	
	public static function countProcess($cmd)
	{
		$cmd = popen("ps -ef | grep \"" . $cmd ."\" | grep -v grep | wc -l", "r");
		$line = fread($cmd, 512);
		pclose($cmd);
		return $line;
	}
}