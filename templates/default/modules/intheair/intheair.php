<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
*/

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

        return $program;
    } else {
        return false;
    }
}

?>
