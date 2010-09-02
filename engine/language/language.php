<?php

	function system_message( $string ) {	
		$language = load_language();
		
		echo $language[$string];
	}
	
	function get_message( $string ) {	
		$language = load_language();
		
		return $language[$string];
	}
?>