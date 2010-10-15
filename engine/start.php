<?php

	/**
	* Cargar las librerias necesarias
	*
	* Román A. Sarria
	*/

	// Clase de configuraciones
	if ( !include_once( dirname(__FILE__) . "/settings.php" ) ) {
		echo "Error cargando las configuraciones<br />";
	}

        // Gestor de excepciones
        if ( !include_once( dirname(__FILE__) . "/exceptions/class.ErrorLogging.php" ) ) {
		echo "Error cargando el gestor de excepciones<br />";
	} else new ErrorLogging();

        // Clase de gestion de idiomas
	if ( !include_once( dirname(__FILE__) . "/language/language.php" ) ) {
		echo "Error cargando la libreria de idioma<br />";
		exit;
	}

	// Archivo de idioma
	if ( !include_once( dirname( dirname(__FILE__) ) . "/language/" . language . ".php" ) ) {
		echo "Error cargando los archivos de idioma para: " . language . "<br />";
		exit;
	}

	// Librerias escenciales
	if ( !include_once( dirname(__FILE__) . "/libraries/libraries.php" ) ) {
		echo "Error cargando las librerias escenciales<br />";
	}

	// Clase de carga de las funciones
	if ( !include_once( dirname(__FILE__) . "/functions/engine.php" ) ) {
		echo "Error cargando las librerias del motor<br />";
	}

        if ( !include_once( dirname(__FILE__) . "/functions/functions.php" ) ) {
		echo "Error cargando las funciones<br />";
	}

        // Clase que habilita la funcionalidad de Sesiones del Framework
        if ( !include_once( dirname(__FILE__) . "/functions/sessions.php" ) ) {
		echo "Error cargando las funciones de Sesion<br />";
	}

        if ( !include_once( dirname(__FILE__) . "/functions/Browser.php" ) ) {
		echo "Error cargando la libreria Browser<br />";
	}

        if ( !include_once( dirname(__FILE__) . "/functions/Mail.php" ) ) {
		echo "Error cargando la libreria SMTPEmail<br />";
	}

        if ( !include_once( dirname(__FILE__) . "/functions/io.php" ) ) {
		echo "Error cargando la libreria IO<br />";
	}
        
        if ( !include_once( dirname(__FILE__) . "/log/log.php" ) ) {
		echo "Error cargando la libreria LOG<br />";
	}

        // Verifico que el motor de la plataforma este inicializado
        //if( !verify_initilization() ) header( "Location:" . base_url );

	// Clase de conexion
	if ( !include_once( dirname(__FILE__) . "/connection/connection.php" ) ) {
		echo "Error cargando la libreria de conexion<br />";
		exit;
	}

	// Carga las funciones de visualización
//	$files = get_files_in_directory( dirname(__FILE__) . "/functions/mod_functions/" );
//	foreach( $files as $class_filename) {
//    	if ( !include_once( dirname(__FILE__) . "/functions/mod_functions/" . $class_filename ) ) {
//			echo "Error cargando las librerias<br />";
//		}
//	}

	// Carga las librerias adicionales
	$files = get_files_in_directory( dirname(__FILE__) . "/libraries/" );
	foreach( $files as $class_filename) {
    	if ( !include_once( dirname(__FILE__) . "/libraries/" . $class_filename ) ) {
			echo "Error cargando la libreria: $class_filename<br />";
		}
	}

        // Load all super classes
        // Carga las clases de gestión de datos
	$files = get_files_in_directory( dirname(__FILE__) . "/superclasses/" );
	foreach( $files as $class_filename) {
    	if ( !include_once( dirname(__FILE__) . "/superclasses/" . $class_filename ) ) {
			echo "Error cargando una clase<br />";
		}
	}

	// Carga las clases de gestión de datos
	$files = get_files_in_directory( dirname(__FILE__) . "/classes/" );
	foreach( $files as $class_filename) {
    	if ( !include_once( dirname(__FILE__) . "/classes/" . $class_filename ) ) {
			echo "Error cargando una clase<br />";
		}
	}

?>