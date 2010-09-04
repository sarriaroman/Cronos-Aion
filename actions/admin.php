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

    case "restorekey":
        require_once('restoreemail.php');

        $email = $_POST['email'];

        if( ( $user = User::getUser($email) ) ) {
            $clave = dechex( rand() );

            $user->password = md5($clave);

            $user->save();

            $message = '<strong>' . $user->name . '</strong>:<br/>';
            $message .= '<br />Su clave ha sido recuperada exitosamente. Ingrese a su panel de administraci&oacute;n con la clave provista a continuaci&oacute;n.<br /><br/>Su nueva clave es: ' . $clave;
            $message .= '<br/><br/>Gracias por confiar en nosotros.<br/><strong>Cronos Development</strong>';

            sendHtmlEmail( $user->email , "Nuevo password", $message);

            echo "<p class='msg done'>Su clave ha sido restaurada existosamente, revise su e-mail.<br/>Regrese al login para ingresar nuevamente</p>";

            return;
        }
        echo "<p class='msg error'>El e-mail no existe!</p>";

        break;

    case "changekey":
        require_once('restoreemail.php');

        $key = $_POST['actualpass'];
        $newkey = $_POST['newpass'];

        if( ( $user = new User( check_session() ) ) ) {
            if( $user->password != md5( $key ) ) {
                echo "<p class='msg error'>La contraseña ingresada no coincide con su contraseña actual.</p>";
                return;
            }

            $user->password = md5( $newkey );

            $user->save();

            $message = '<br/><strong>' . $user->name . '</strong>:<br/>';
            $message .= '<br />Su clave ha sido cambiada exitosamente. Ingrese a su panel de administraci&oacute;n con la clave provista a continuaci&oacute;n.<br /><br/>Su nueva clave es: ' . $newkey;
            $message .= '<br/><br/>Gracias por confiar en nosotros.<br/><strong>Cronos Development</strong>';

            sendHtmlEmail( $user->email , "Cambio de password", $message);

            echo "<p class='msg done'>Su clave ha sido cambiada existosamente, se le ha enviado un e-mail con su nueva clave.</p>";

            return;
        }
        echo "<p class='msg error'>El e-mail no existe!</p>";

        break;

    case "login":
        $email = $_POST['email'];
        $psw = $_POST['psw'];

        if (($user = User::validate($email, $psw))) {
            if ($user->is_level(User::$admin)) {
                if (create_session($user->email)) {
                    echo "<login: ok>";
                } else {
                    echo "<p class='msg warning'>Hubo un error al crear la sesión</p>";
                }
            } else {
                echo "<p class='msg error'>No tiene autorización para acceder a esta seccion</p>";
            }
        } else {
            echo "<p class='msg error'>Clave o e-mail incorrecto</p>";
        }
        break;

    case "logout":
        close_session();
        echo "<logout: ok>";

        header("Location: " . base_url . "admin.php");

        break;
}

?>
