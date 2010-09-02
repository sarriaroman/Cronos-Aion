<?php

	/**
	*	Clase de manejo de excepciones
	*
	*	Román A. Sarria
	*/

	/*** a default Exception handler ***/
	function engine_exception_handler($exception){
		echo '<p style="color: red;">' . "Uncaught exception: " . $exception->getMessage() . '</p>';
	}

	/*** set the default to handler to my_default_handler ***/
	set_exception_handler('engine_exception_handler');
	
?>