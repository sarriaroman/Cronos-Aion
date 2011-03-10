<?php

global $host, $db, $user, $key, $dtype, $lng_file, $symbol;

global $CONFIG;

if (is_null($CONFIG))
    $CONFIG = new stdClass ();

// Host
$host = "{server}";

// Base de datos
$db = "{database}";

// Usuario
$user = "{user}";

// Clave
$key = "{password}";

// Admin email

$aemail = "{adminemail}";

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
$base = "{sitebase}";

// Base de soporte de reescritura
$friendly = "";

// Template schema
$theme = "default";

// Tipo de base de datos
/**
 * 	MySQL: mysql
 */
$dtype = "mysql";
/* * ******************* */

require( "enviroment.php" );
?>