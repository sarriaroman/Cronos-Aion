<?php

	function system_message( $string ) {	
		$language = load_language();
		
		echo $language[$string];
	}
	
	function get_message( $string, $replace = "" ) {
		$language = load_language();

                if( $replace != "" && is_array($replace) ) {
                    $return = $language[$string];
                    
                    foreach( $replace as $key => $value ) {
                        $return = str_ireplace( "{" . $key . "}", $value, $return);
                    }

                    return $return;
                }

		$replace = str_ireplace(array_keys( $language ), array_values( $language ), $string);
		return $language[$string];
	}


?>