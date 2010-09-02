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
	$db = "cvc_cvclavoz";
	
	// Usuario
	$user = "cvclavoz";
	
	// Clave
	$key = "CVCLaVoz";
	
	// Lenguaje
	$lng_file = "es_ar";
	
	// Prefijo
	$dbprefix = "cvc_";
	
	// Base del sitio
	$base = "";
	
	// Template schema
	$theme = "default";
	
	// Tipo de base de datos
	/**
	*	MySQL: mysql
	*	MSSQL: mssql
	*/
	$dtype = "mysql";
	/**********************/

	require( "enviroment.php" );
	
?>