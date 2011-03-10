<?php
	
	/**
	*	Gestor dinánimo de funciones
	*
	*	Román A. Sarria
	*
	*/
	
	register_function( "functions" , "get_functions" , array() );
					  
	function get_functions( ) {
		global $functions;
		
		return $functions;
	}
?>