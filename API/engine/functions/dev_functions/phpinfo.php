<?php
	
	/**
	*	Gestor dinánimo de funciones
	*
	*	Román A. Sarria
	*
	*/
	
	register_function( "phpinfo" , "showPHPInfo" , array() );
					  
	function showPHPInfo( ) {
            phpinfo();
	}
?>