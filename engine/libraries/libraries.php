<?php

	function get_files_in_directory( $directory ) {
		$the_array = Array(); 
		$handle = opendir( $directory ); 
		while (false !== ($file = readdir($handle))) { 
   			if ($file != "." && $file != "..") { 
   				$the_array[] = $file; 
	   		} 
		} 
		closedir($handle); 
		sort ($the_array);
		
		return $the_array;
	}

        function get_directories_in_directory( $directory ) {
		$the_array = Array();
		$handle = opendir( $directory );
		while (false !== ($file = readdir($handle))) {
   			if ($file != "." && $file != ".." && is_dir( $directory . $file )) {
   				$the_array[] = $file;
	   		}
		}
		closedir($handle);
		sort ($the_array);

		return $the_array;
	}
	
	function getIP() {
    	if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
    	  $ip=$_SERVER['HTTP_CLIENT_IP'];
	    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
    	  $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
	    } else {
    	  $ip=$_SERVER['REMOTE_ADDR'];
	    }
		
    	return $ip;
	}
	
	function keyboard_shortcuts() {
		?><script>
			var isCtrl = false;
			document.onkeyup=function(e) {
				if(e.which == 17) isCtrl=false;
			}
			document.onkeydown=function(e){
				if(e.which == 17) isCtrl=true;
				if(e.which == 90 && isCtrl == true) {
					alert('<? system_message("egg:z") ?>');
					return false;
				}
			}
            </script><?
	}
	
?>