<?php

// Se definen las variables para su uso, se evita el global.

global $dbprefix;

define("db_host"  , $host,		 false );
define("db_base"  , $db,		 false );
define("db_user"  , $user,		 false );
define("db_key"   , $key,		 false );
define("language" , $lng_file,  	 false );
define("db_type"  , $dtype,		 false );

$dir = ( $base == "" ) ? "" : "{$base}/";

// Main Enviroment
define("base_url", "http://" . $_SERVER['HTTP_HOST'] . "/" . $dir ,   false );
define("base_dir", $_SERVER['DOCUMENT_ROOT'] . "/" . $dir         ,   false );

// Admin Enviroment
define("admin_base_url", base_url . "admin/" , false );
define("admin_base_dir", base_dir . "admin/" , false );

// Admin folders path
define("admin_modules_dir", admin_base_dir . "modules/" , false );
define("admin_modules_url", admin_base_url . "modules/" , false );
define("admin_section_dir", admin_base_dir . "sections/" , false );
define("admin_section_url", admin_base_url . "sections/" , false );

// Enviroment
define("TEMPLATE" , 	$theme,                                                     false );
define("template_dir", 	"templates/" . TEMPLATE,                                    false );
define("template_url", 	base_url . template_dir . "/" ,                             false );

// Modules
define("modules_dir", 	$_SERVER['DOCUMENT_ROOT'] . "/{$base}/"
                        . template_dir . "/modules/" ,                              false );
define("modules_url", 	base_url . template_dir . "/modules/" ,                     false );

// Plugins
define("plugins_dir", 	$_SERVER['DOCUMENT_ROOT'] . "/{$base}/" . "plugins/" ,      false );
define("plugis_url", 	base_url . "plugins/" ,                     false );

// Sections
define("section_dir", 	$_SERVER['DOCUMENT_ROOT'] . "/{$base}/"
                        . template_dir . "/sections/" ,                             false );
define("section_url", 	base_url . template_dir . "/sections/" ,                    false );

// Anothers
define("javascript_url", base_url . "javascript/",                                  false );
define("actions_url", base_url . "actions/",                                        false );

/**
 * Error Handling Values
 */
define('DEBUGGING', $debugging );
define('ADMIN_ERROR_MAIL', $aemail );
define('SEND_ERROR_MAIL', $erroremail );
define('SEND_ERROR_FROM', 'errors@admin.com');
define('IS_WARNING_FATAL', TRUE);
define('ERROR_LOGGING', $errorfile );
define('ERROR_LOGGING_FILE', base_dir );
define('SITE_GENERIC_ERROR_MSG', '<h1>Portal Error!</h1>');

?>