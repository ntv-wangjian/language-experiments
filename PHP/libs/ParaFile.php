<?php
/**
 * 处理 key=value类型的文件结构。
 */
class ParaFile
{	
	private $paras = NULL;
	
	/**
	 * 可以直接指定一个参数数组
	 * @param array $paras  传入的数组
	 */
	public function setParaArray($paras){
		$this->paras = $paras;
	}
	
	/**
	 * 下面两个函数
	 * 读取和写入key=value类型的文件到数组
	 */
	public function load($filename,$splitor="=")
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

		$this->paras = array();
		foreach ($lines as $line_num => $line) {
			if(strstr($line,$splitor)==FALSE)
			{
				continue;
			}
			$line  = trim($line,"\r\n");
			$key   = strstr($line,$splitor,true);
			$value = strstr($line,$splitor);
			$value = substr($value,strlen($splitor));
			$this->paras[$key] = $value;
		}
		return $this->paras;
	}
	
	public function saveParaFile($filename,$splitor="=")
	{
		if(!$this->paras){
			return FALSE;
		}
		
		$text = "";
		foreach($this->paras as $key=>$value)
		{
			if($value=="" || $key=="") continue;
			$text  .= "$key" . $splitor . "$value" . "\n";
		}
		return file_put_contents($filename,$text);
	}
	
	public function get($key,$default=NULL,$number=FALSE){
		if(!$this->paras){
			return $default;
		}
		
		if(isset($this->paras[$key])){
			$value = $this->paras[$key];
			if($number){
				if(!is_numeric($value)){
					return $default;
				}else{
					return $value;
				}
			}else{
				return $value;
			}
		}else{
			return $default;
		}
	}
	
	public function set($key,$value){
		if(!$this->paras){
			$this->paras = array();
		}
		
		$this->paras[$key] = $value;
	}
	
	public function getSafe($key){
		$value = $this->get($key);
		if($value){
			$value = escapeshellcmd($value);
		}
		return $value;
	}
	/**
	 * 转换成安全的命令行参数
	 * @param unknown $val
	 */
	public static function safeCmdVal($val){
		return  escapeshellcmd($val);
	}
	
}