<?php

	/*
	*
	* Rom�n A. Sarria is licensed under a Creative Commons Reconocimiento 2.5 Argentina License
	* License link: http://creativecommons.org/licenses/by/2.5/ar/
	* Project name: aion-api
	* Project homepage: http://code.google.com/p/aion-api/
	*/
	
	function system_message( $string, $replace = "" ) {
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

        function get_message( $string, $replace = "", $lang = true ) {
		$language = load_language();

                if( $replace != "" && is_array($replace) ) {
                    $return = ( $lang ) ? $language[$string] : $string;

                    foreach( $replace as $key => $value ) {
                        $return = str_ireplace( "{" . $key . "}", $value, $return);
                    }

                    return $return;
                }

		$replace = str_ireplace(array_keys( $language ), array_values( $language ), $string);
		return $language[$string];
	}
	
?>