<?php

class TimeUtility
{	
	public static function get_time_readable($time=NULL)
	{
		if(!$time) {
			$time = time();
		}
		return date("Y-m-d H:i:s",$time);
	}
	
	public static function get_duration_readable($timestamp)
	{
		$h = $timestamp / 3600;
		$m = $timestamp % 3600 / 60;
		$s = $timestamp % 60;
		return sprintf("%02d:%02d:%02d",$h,$m,$s);
	}
	
	//获取一个简单的日期字符串
	public static function getDateStr($to="d",$splitor=""){
		$str = "";
		if($to=='y'){
			$str = date("Y");
		}else if($to=='m'){
			$str = date("Y-m");
		}else{
			$str = date("Y-m-d");
		}
		return str_replace("-", $splitor, $str);
	}
	
	/**
	 * 将 00:01:02.2类型的时间转换成时长
	 */
	public static function str2duration($str){
		$arr = explode(":", $str);
		if(count($arr)<3){
			return 0;
		}
		return intval($arr[0])*3600 + intval($arr[1])*60 +  intval($arr[2]);
	}
}