<?php
	/**
	 * Clase de configuraci�n del motor de plataforma
	 *
	 * Engine class *
	 *
	 * Rom�n A. Sarria
	 */
	global $host, $db, $user, $key, $dtype, $lng_file, $symbol;
        
        global $CONFIG;

        if( is_null( $CONFIG ) )
            $CONFIG = new stdClass ();

	// Host
	$host = "localhost";

	// Base de datos
	$db = "test";

	// Usuario
	$user = "test";

	// Clave
	$key = "FTesting";

        // Admin email

        $aemail = "agustin478@gmail.com";

        // Error logging

        $debugging = true;
        $erroremail = false;
        $errorfile = true;

	// Lenguage
	$lng_file = "es_ar";
        $CONFIG->lang = "en";

	// Prefijo
	$dbprefix = "";

	// Base del sitio
	$base = "framework";

	// Template schema
	$theme = "default";

	// Tipo de base de datos
	/**
	*	MySQL: mysql
	*/
	$dtype = "mysql";
	/**********************/

	require( "enviroment.php" );

?>