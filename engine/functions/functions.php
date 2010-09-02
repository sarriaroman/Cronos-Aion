<?php

	function create_session( $email ) {
		if( session_start() ) {
			
			if( empty( $email ) ) return false;
			$_SESSION['email'] = $email;
			
			return true;
		} else {
			return false;
		}
	}
	
	function check_session() {
		session_start();
		
		$email = $_SESSION['email'];
		if( !empty( $email ) ) {
			$user = new User( $email );
                        if( empty( $user->uid ) ) {
                            close_session();
                        }
			return $user;
		} else {
                    //close_session();
                    return false;
		}
	}
	
	function close_session() {
		check_session();
		
		session_destroy();
		session_write_close();
		
		header( "Location: " . base_url );
	}

        function encode_string( $string ) {
            $arr = array(
                "á" => "&aacute;",
                "Á" => "&Aacute;",
                "é" => "&eacute;",
                "É" => "&Eacute;",
                "í" => "&iacute;",
                "Í" => "&Iacute;",
                "ó" => "&oacute;",
                "Ó" => "&Oacute;",
                "ú" => "&uacute;",
                "Ú" => "&Uacute;",
                "ñ" => "&ntilde;",
                "Ñ" => "&Ntilde;",
                "°" => "&deg;",
                "\"" => "&quot;"
            );

            return str_ireplace(array_keys($arr), array_values($arr), $string);
        }

?>