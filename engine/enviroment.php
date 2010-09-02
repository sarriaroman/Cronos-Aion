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
// Enviroment
define("TEMPLATE" , 	$theme,                                                     false );
define("template_dir", 	"templates/" . TEMPLATE,                                    false );
define("template_url", 	base_url . template_dir . "/" ,                             false );
define("modules_dir", 	$_SERVER['DOCUMENT_ROOT'] . "/{$base}/" 
                        . template_dir . "/modules/" ,                              false );
define("modules_url", 	base_url . template_dir . "/modules/" ,                     false );
define("javascript_url", base_url . "javascript/",                                  false );
define("actions_url", base_url . "actions/",                                        false );

?>