<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
*/

require_once( dirname(dirname(__FILE__)) . "/engine/start.php" );

$action = $_POST['action'];
if( empty( $action ) ) $action = $_GET['action'];

switch ( $action ) {
    case "time":
        // Set TimeZone
        date_default_timezone_set( get_config("date:timezone") );
    
        echo date('H:i:s');
        break;

    case "actualtime":
        // Set TimeZone
        date_default_timezone_set( get_config("date:timezone") );
    
        echo "Hora actual: " . date('H:i:s');
        break;

    case "day":
        date_default_timezone_set( get_config("date:timezone") );

        echo strtolower( date('l') );
        break;

    case "formatdaytime":
        date_default_timezone_set( get_config("date:timezone") );

        echo get_message( "week:" . strtolower( date('l') ) ) . " - " . date('H:i:s e');
        break;

    case "config":
        set_config( $_POST['key'] , $_POST['value'] );
        echo "Saved";
        break;

    case "login":
        $email = $_POST['email'];
        $psw = $_POST['psw'];

        if( ($user = User::validate($email, $psw)) ) {
            if( $user->is_level( User::$admin ) && !$user->banned ) {
                if( create_session( $user->email ) ) {
                    echo "<login: ok>";
                } else {
                    echo "Hubo un error al crear la sesión";
                }
            } else {
                echo "No tiene autorización para acceder a esta seccion";
            }
        } else {
            echo "Clave o e-mail incorrecto";
        }
        break;

    case "logout":
        close_session();
        echo "<logout: ok>";
        break;
}

?>
