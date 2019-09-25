<?php

class FileUtility
{	
	
	public static function delete_file($filename)
	{
		if(!file_exists($filename)){
			return TRUE;
		}
		return @unlink($filename);
	}
	
	public static function create_directory($path)
	{
		return mkdir($path,0755,TRUE);
	}
	
	public static function delete_directory($path)
	{
		return rmdir($path);
	}
	
	public static function write_file($filename,$data){
		return @file_put_contents($filename, $data);
	}
	
	public static function read_file($filename){
		if(is_file($filename)){
			return file_get_contents($filename);
		}else{
			return NULL;
		}
	}
	
	public static function rename($oldname,$newname){
		return @rename($oldname, $newname);
	}
	/*
	 * 下面两个函数
	 * 读取和写入key=value类型的文件到数组
	 */
	public static function loadParaFile($filename,$splitor="=")
	{
		if(!file_exists($filename))
		{
			return FALSE;
		}
		$lines = file($filename);
		if($lines===FALSE)
		{
			return FALSE;
		}
		$para_array = array();
		foreach ($lines as $line_num => $line) {
			if(strstr($line,$splitor)==FALSE)
			{
				continue;
			}
			$line  = trim($line,"\r\n");
			$key   = strstr($line,$splitor,true);
			$value = strstr($line,$splitor);
			$value = substr($value,strlen($splitor));
			$para_array[$key] = $value;
		}
		return $para_array;
	}
	
	public static function saveParaFile($filename,&$arr_auth,$splitor="=")
	{
		$text      = "";
		foreach($arr_auth as $key=>$value)
		{
			if($value=="" || $key=="") continue;
			$text  .= "$key" . $splitor . "$value" . "\n";
		}
		return file_put_contents($filename,$text);
	}
	
	/*
	 * -ctime    -n +n  #按文件创建时间来查找文件，-n指n天以内，+n指n天以前
	 * -cmin     分钟数做单位，同上
	 * 查询$start天以内，$end天以前的视频
	 * $unit min表示分钟单位， day表示日单位
	 */
	public static function scanFile($path,$type="f",$maxDepth=1,$start=0,$end=0,$max=5000,$unit="min"){
	
		$cmd =  "find " . $path . " -maxdepth $maxDepth";
	
		if($type!=""){
			$cmd .= " -type $type";
		}
	
		if($end > $start){
			$end = 0;
		}
		if($start>0){
			if($unit=="min"){
				$cmd .= " -cmin -". $start;
			}else{
				$cmd .= " -ctime -". $start;
			}
		}
		if($end>0){
			if($unit=="min"){
				$cmd .= " -cmin +" . $end;
			}else{
				$cmd .= " -ctime +" . $end;
			}
		}
	
		if($type=="f"){
			// -r参数是关键 :)  暂时不支持对目录使用该参数，没找到如何禁止扫描目录的方法。
			$cmd .= " | xargs -r ls -lta";
		}
	
		$cmd .= " | head -n " . $max;
		//echo $cmd;
		$arr    = array();
		$count  = 0;
		$handle = popen($cmd,"r");
		while (($file = fgets($handle)) !== false) {
			if($type=="f"){
				$file       = strrchr($file," ");
				if($file===FALSE){
					continue;
				}
			}
			$file  = trim($file," \t\r\n");
			$arr[] = $file;
	
			$count++;
			if($max>0 && $count>=$max){
				break;
			}
		}
		pclose($handle);
	
		return $arr;
	}
	
	public static function simpleScan($path,$type="",$max=5000){
	
		$cmd    =  "ls " . $path . " -ltArF 2>/dev/null";
		if($type=="f"){
			$cmd .= " | grep \"^-\"";
		}else if($type=="d"){
			$cmd .= " | grep \"/$\"";
		}
		
		$arr    = array();
		$count  = 0;
		$handle = popen($cmd,"r");
		while (($file = fgets($handle)) !== false) {
			$file       = strrchr($file," ");
			if($file===FALSE){
				continue;
			}
			$file  = trim($file," \t\r\n");
			$arr[] = $file;
	
			$count++;
			if($max>0 && $count>=$max){
				break;
			}
		}
		pclose($handle);
	
		return $arr;
	}
	
	/*
	 * 将扫描结果传递给回调函数,默认是扫描文件，一级目录
	 * $callback 必须是包含两个元素的数组，第一个元素定义回调函数，第二个元素定义参数列表数组（必须存在,无参数时须提供一个空数组）
	 * 		参见例子：call_user_func_array(array('A','show2'),array('argument1','argument2'));  
	 */
	public static function simpleScanCallback($path,$callback,$type=""){
		if(!is_dir($path)){
			return 0;
		}
		
		$cmd    =  "ls " . $path . " -ltAF 2>/dev/null";
		if($type=="f"){
			$cmd .= " | grep \"^-\"";
		}else if($type=="d"){
			$cmd .= " | grep \"/$\"";
		}
		
		$func   = $callback[0];
		$paras  = $callback[1];
		$index  = count($paras);
		
		$count  = 0;
		$handle = popen($cmd,"r");
		while (($file = fgets($handle)) !== false) {
			$file = strrchr($file," ");
			if($file===FALSE){
				continue;
			}
			$file  = trim($file," \t\r\n");
			$paras[$index] = $file;
			call_user_func_array($func,$paras);
			$count++;
		}
		pclose($handle);
	
		return $count;
	}
	
	public static function appendFile($text,$filename)
	{
		if (!$handle = fopen($filename, 'a')) {
			return FALSE;
		}
		if(!fwrite($handle, $text)){
			fclose($handle);
			return FALSE;
		}else{
			fclose($handle);
			return TRUE;
		}
		
	}

	//时间函数，入口出要有：
	//date_default_timezone_set("Asia/Hong_Kong");
	/*
	 * 输入“yyyy-mm-dd”
	 * 返回某天与今天的天数差  例如： 0表示今天，1表示昨天
	 * 今天会返回 0
	 */
	public static function getTimeDay($datestr){
		/*
		$arr = explode("-",$datestr);
		if(count($arr)!=3){
			return 0;
		}
		$y = intval($arr[0]);
		$m = intval($arr[1]);
		$d = intval($arr[2]);
		if($y<2000 || $y>2050 || $m<1 || $m>12 || $d<1 || $d>31){
			return 0;
		}
		*/
		$now  = strtotime(date("y-m-d 00:00:00"));
		$time = strtotime(date($datestr));
		$day  = ceil(($now-$time)/86400);
	
		return $day;
	}
	
	/*
	 * 输入“yyyy-mm-dd"
	 * 返回某天0点与现在的分钟差
	 */
	public static function getDateMin($datestr){
		
		$now  = time();
		$time = strtotime(date($datestr));
		$min  = ceil(($now-$time)/60);
	
		return $min;
	}
	
	/*
	 * 输入“yyyy-mm-dd"
	 * 返回某天24点与现在的分钟差，可能为负
	 */
	public static function getDateEndMin($datestr){
	
		$now  = time();
		$time = strtotime(date($datestr));
		$min  = ceil(($now-$time)/60) - 24*60;
	
		return $min;
	}
}