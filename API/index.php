<?
	
	//header('Content-type: text/plain');
	
	require_once(dirname(__FILE__) . "/engine/start.php");

	$function	= $_GET['function'];
	$type 		= $_GET['type'];
	$dkey 		= $_GET['API'];

        define("did", ( isset($dkey) ) ? $dkey : "no set", true);

        if( !isset( $function ) || !isset( $type ) || !isset( $device ) || !isset( $dkey ) ) {
            echo "ERROR CRITICO";
            Log::error("no set", "Intento de ingreso sin parametros.");
            return;
        }

	global $functions, $dtype;

	$cnt = new Connection( $dtype );
	if( ( $dev = $cnt->authenticate( $dkey ) ) ) {
                Log::info(did, "Authentication OK");
		
		if( ( $func = $functions[ $function ] ) ) {
			if( ( $rst = call_function( $func , $parameters ) ) ) {
				$parser = new Parser( $type , $rst );
				$parser->create();
			} else {
				$error = array( "error" => system_message("function:parameters_error") );
				$parser = new Parser( $type , $error );
				$parser->create();
			}
		} else {
			$error = array( "error" => system_message("function:not_exist") );
			$parser = new Parser( $type , $error );
			$parser->create();
		}
	} else {
                Log::error( did , "Authentication ERROR");
		
		$error = array( "error" => system_message("api:api_connection") );
		$parser = new Parser( $type , $error );
		$parser->create();
	}
	
?>