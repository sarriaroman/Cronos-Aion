<?php

require_once( dirname(dirname(dirname(dirname(dirname(__FILE__))))) . "/engine/start.php" );

$action = $_GET['action'];
if( $action == "reload" ) {
    actualProgram();
}


function actualProgram() {
    date_default_timezone_set( get_config("date:timezone") );

    $time = date('H:i:s');
    $day = strtolower( date('l') );

    global $dbprefix;
    $con = new Connection();

    $sql = "select progid from {$dbprefix}schedule where day = '{$day}' and '{$time}' between fromTime and toTime";

    if( $req = $con->make_request( $sql ) ) {

        $rst = mysql_fetch_array($req, MYSQL_ASSOC);

        if( empty( $rst['progid'] ) ) return false;

        $program = new Program( $rst['progid'] );

        include( "program.html" );
    }
}

?>
