<?php

	/**
         *
         *	Cronos-Aion
	 *
	*/

	require_once( dirname(__FILE__) . "/engine/start.php" );

        global $CONFIG;
        if( isset ( $_GET['lang'] ) ) $CONFIG->lang = $_GET['lang'];

        if( $_GET['url'] == "sysinfo" ) {
            include_once( dirname(__FILE__) . "/engine/phpinfo.php" );
        } else {
            include_once( dirname(__FILE__) . "/" . template_dir . "/index.php" );
        }

        // Mod & egg at final
	//keyboard_shortcuts();
        
?>