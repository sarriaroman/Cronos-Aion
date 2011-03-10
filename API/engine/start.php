<?php

/**
 *
 *  Cargar las librerias necesarias para hacer funcionar el API
 *
 */
global $functions;
$functions = array();

// Clase de configuraciones
if (!include_once( dirname(dirname(dirname(__FILE__))) . "/engine/settings.php" )) {
    echo "Error cargando las librerias<br />";
}

// Clase de carga de las funciones
if (!include_once( dirname(__FILE__) . "/functions/engine.php" )) {
    echo "Error cargando las librerias<br />";
}

// Libreria principal con funciones
if (!include_once( dirname(__FILE__) . "/libraries/library.php" )) {
    echo "Error cargando las librerias<br />";
}

// Libreria de gestion de sesiones
if (!include_once( dirname(__FILE__) . "/libraries/sessions.php" )) {
    echo "Error cargando la libreria de sesiones<br />";
}

// Libreria de gestion de sesiones
if (!include_once( dirname(__FILE__) . "/libraries/engine.php" )) {
    echo "Error cargando la libreria de Configuracion<br />";
}

$files = get_files_in_directory(dirname(__FILE__) . "/functions/dev_functions/");
foreach ($files as $class_filename) {
    if( end(explode(".", $class_filename) ) != "php" ) continue;
    if (!include_once( dirname(__FILE__) . "/functions/dev_functions/" . $class_filename )) {
        echo "Error cargando las librerias<br />";
    }
}

// Clase de conexion
if (!include_once( dirname(__FILE__) . "/connection/connection.php" )) {
    echo "Error cargando las librerias<br />";
    exit;
}

// Clase de conexion
if (!include_once( dirname(__FILE__) . "/connection/MySQLiConnection.php" )) {
    echo "Error cargando las librerias de conexion<br />";
    exit;
}

// Clase de gestion de logueo
if (!include_once( dirname(__FILE__) . "/log/log.php" )) {
    echo "Error cargando las librerias<br />";
    exit;
}

// Clase de manejo XML
if (!include_once( dirname(__FILE__) . "/parser/parser.php" )) {
    echo "Error cargando las librerias<br />";
    exit;
}

// Clase de gestion de idiomas
if (!include_once( dirname(__FILE__) . "/language/language.php" )) {
    echo "Error cargando las librerias<br />";
    exit;
}

// Load all super classes
// Carga las clases de gestión de datos
$files = get_files_in_directory(dirname(__FILE__) . "/superclasses/");
foreach ($files as $class_filename) {
    if( end(explode(".", $class_filename) ) != "php" ) continue;
    if (!include_once( dirname(__FILE__) . "/superclasses/" . $class_filename )) {
        echo "Error cargando una clase<br />";
    }
}

// Carga las clases de gestión de datos
$files = get_files_in_directory(dirname(__FILE__) . "/classes/");
foreach ($files as $class_filename) {
    if( end(explode(".", $class_filename) ) != "php" ) continue;
    if (!include_once( dirname(__FILE__) . "/classes/" . $class_filename )) {
        echo "Error cargando una clase<br />";
    }
}

// Archivo de idioma
if (!include_once( dirname(__FILE__) . "/language/" . $lng_file . ".php" )) {
    echo "Error cargando las librerias";
    exit;
}
?>