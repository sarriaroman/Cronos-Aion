<?php
class Template
{
  var $page;
  var $tpl;

  function  __construct( $template = "template.html" ) {
    if (file_exists($template))
      $this->page = join("", file($template));
    else
      die("Template file $template not found.");
  }
  
  /*
  * reads the given template file and set data in variable
  
  function Template() {
	  
    
  }
   * */
  
  /*
  * buffers the content of file if it's given instead of a value
  */
  function parse($file) {
    ob_start();
    include($file);
    $buffer = ob_get_contents();
    ob_end_clean();
    return $buffer;
  }

  /*
  * replace the tags in the template. 
  *
  * Recursive is used for looping when tabular data is given in array form like:
  * $arr = array(
				 'name' => array('john','mary','susy','bob')
				 , 'age' => array('22','45','67','89')
				 );
  *
  */
  function replace_tags($tags = array(), $recursive = FALSE) {
	  
    /*
    * if recursive set the content of the var $this->page to the var $this->tpl
    */
	if($recursive == 'loop') {
		$this->tpl = $this->page; $this->page = '';
	}
	
    if (sizeof($tags) > 0)
	
      foreach ($tags as $tag => $data) {
		  
        $data = (!is_array($data) && file_exists($data)) ? $this->parse($data) : $data;
		
    	/*
    	* if not recursive set replaces the tags one time in the template
    	*/		
        if($recursive == FALSE) {
			$this->page = preg_replace('/{' . $tag . '}/', $data, $this->page);
		}
		
		else {

			/*
			* if recursive goes through the array data
			*/
			foreach ($data as $tagx => $datax) {
				
				/*
				* the 1st time append the template data to himself
				*/
				if($count == 0) {
					$this->page .= preg_replace('/{' . $tag . '}/', $datax, $this->tpl) . chr(10);
				}
				
				/*
				* for the 2nd time or greater replaces the 1st tag in the template (note the 1 as third parameter)
				*/
				else {
					$this->page = preg_replace('/{' . $tag . '}/', $datax, $this->page, 1) . chr(10);
				}
				
			}
			
		}
		
		$count++;
		
        }
		
    else
      die("No tags designated for replacement.");
    }

  /**
  * Output the data to browser
  * if $output not TRUE returns the data
  */
  function output($charset='UTF-8', $output = true) { //ISO-8859-15
	if($output == true) {
            header('Content-type: text/html; charset='.$charset.'');
            echo $this->page;
	}
	else {
            return $this->page;
	}
  }

  /**
  * Output the data to browser
  * if $output not TRUE returns the data
  */
  function simpleOutput( $output = true ) { //ISO-8859-15
	if($output == true) {
            echo $this->page;
	} else {
            return $this->page;
	}
  }
  
}
?>