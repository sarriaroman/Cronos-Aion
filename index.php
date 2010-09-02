<?php

	/**
	*	Index for CVC La voz
	*
	*	Capsule mode ON xD
	*/

	require_once( dirname(__FILE__) . "/engine/start.php" );
        
        if( $_GET['url'] == "sysinfo" ) {
            include_once( dirname(__FILE__) . "/engine/phpinfo.php" );
        } else if( $_GET['url'] == "internalaccounts" ) {
            include_once( dirname(__FILE__) . "/backend/accounts.php" );
        } else {
            include_once( dirname(__FILE__) . "/" . template_dir . "/index.php" );
        }
	
	// Mod & egg at final
	keyboard_shortcuts();
	
?>