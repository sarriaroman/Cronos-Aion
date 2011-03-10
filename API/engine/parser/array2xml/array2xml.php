<?php
/****
* @PHPVER4.0
*
* @author	emnu
* @ver	--
* @date	12/08/08
*
* use this class to convert from mutidimensional array to xml.
* see example.php file on howto use this class
*
*/

class arr2xml
{
	var $arr;
	var $xml = "";

	function arr2xml($array)
	{
		$this->arr = $array;
		
		if(is_array($array) && count($array) > 0)
		{
			$this->struct_xml($array);
		}
		else
		{
			$this->xml .= "no data";
		}
	}

	function struct_xml($array)
	{
		foreach($array as $k => $v)
		{
			if(is_array($v))
			{
				$tag = ereg_replace('^[0-9]{1,}','data',$k); // replace numeric key in array to 'data'
				$this->xml .= "<$k>";
				$this->struct_xml($v);
				$this->xml .= "</$k>";
			}
			else
			{
				$tag = ereg_replace('^[0-9]{1,}','data',$k); // replace numeric key in array to 'data'
				$this->xml .= "<$k>$v</$k>";
			}
		}
	}
	
	function get_xml()
	{
		$header = "<?xml version=\"1.0\" encoding=\"iso-8859-1\"?><root>";
		$footer = "</root>";
		
		return $header . $this->xml . $footer;
	}
}
?>