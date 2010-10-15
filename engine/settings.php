<?php
	/**
	 * Clase de configuraci�n del motor de plataforma
	 *
	 * Engine class *
	 *
	 * Rom�n A. Sarria
	 */
	//global $host, $db, $user, $key, $dtype, $lng_file, $symbol;

	// Host
	$host = "localhost";

	// Base de datos
	$db = "localdb";

	// Usuario
	$user = "localuser";

	// Clave
	$key = "password";

        // Admin email

        $aemail = "agustin478@gmail.com";

        // Error logging

        $debugging = true;
        $erroremail = false;
        $errorfile = true;

	// Lenguaje
	$lng_file = "es_ar";

	// Prefijo
	$dbprefix = "";

	// Base del sitio
	$base = "base";

        // Base de soporte de reescritura
        $friendly = "f";

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