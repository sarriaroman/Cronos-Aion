<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

require_once( dirname(dirname(__FILE__)) . "/engine/start.php" );

$action = $_POST['action'];
if (empty($action))
    $action = $_GET['action'];

switch ($action) {
    case "time":
        // Set TimeZone
        date_default_timezone_set(get_config("date:timezone"));

        echo date('H:i:s');
        break;

    case "actualtime":
        // Set TimeZone
        date_default_timezone_set(get_config("date:timezone"));

        echo "Hora actual: " . date('H:i:s');
        break;

    case "day":
        date_default_timezone_set(get_config("date:timezone"));

        echo strtolower(date('l'));
        break;

    case "formatdaytime":
        date_default_timezone_set(get_config("date:timezone"));

        echo get_message("week:" . strtolower(date('l'))) . " - " . date('H:i:s e');
        break;

    case "config":
        set_config($_POST['key'], $_POST['value']);
        echo "Saved";
        break;

    case "addrevenue":
        $type = new Revenue();

        $type->name = $_POST['name'];
        $type->code = $_POST['code'];
        $type->revenue = $_POST['revenue'];
        $type->percentage = ( $_POST['percentage'] == "checked" ) ? true : false;


        if ($type->save()) {
            echo json_encode(array("error" => "-1"));
        } else {
            echo json_encode(array("error" => "Se produjo un error al guardar la Operación"));
        }

        break;

    case "deleterevenue":
        $type = new Revenue($_GET['id']);

        $type->delete();
        break;

    case "addtype":
        $type = new OpTypes();

        $revenuea = $_POST['revenuesa'];
        $condition = $_POST['condition'];
        $revenueb = $_POST['revenuesb'];
        $emitterpercentage = $_POST['emitterpercentage'];
        $receiverpercentage = $_POST['receiverpercentage'];

        /*
        if (is_array($revenuea)) {

            for ($i = 0; $i < count($revenuea); $i++) {

                if( $revenuea[$i] == "-1" ) {
                    echo json_encode( array("error" => "Debe seleccionar al menos un tipo de ganancia") );
                    return;
                }
                $emitterpercentage[$i];
                $receiverpercentage[$i];
            }
        } else {

            $revenuea;
            $condition;
            $revenueb;
            $emitterpercentage;
            $receiverpercentage;
        }
         */

        $type->name = $_POST['name'];
        $type->emitterdebit = ( $_POST['emitterdebit'] == "checked" ) ? true : false;
        $type->receiverdebit = ( $_POST['receiverdebit'] == "checked" ) ? true : false;
        $type->code = $_POST['code'];

        if ($type->save()) {

            $con = new Connection();

            $opt = mysql_fetch_object($con->make_request("select id from OpTypes where code = '{$_POST['code']}'"));

            if (is_array($revenuea)) {

                for ($i = 0; $i < count($revenuea); $i++) {
                    $cond = new OperationsConditions();

                    $cond->optid = $opt->id;
                    $cond->revenueA = $revenuea[$i];
                    $cond->cond = $condition[$i];
                    $cond->revenueB = $revenueb[$i];
                    $cond->emitterpercentage = $emitterpercentage[$i];
                    $cond->receiverpercentage = $receiverpercentage[$i];

                    $cond->save();
                }
            } else {
                $cond = new OperationsConditions();

                $cond->optid = $opt->id;
                $cond->revenueA = $revenuea;
                $cond->cond = $condition;
                $cond->revenueB = $revenueb;
                $cond->emitterpercentage = $emitterpercentage;
                $cond->receiverpercentage = $receiverpercentage;

                $cond->save();
            }
            echo json_encode(array("error" => "-1"));
        } else {
            echo json_encode(array("error" => "Se produjo un error al guardar la Operación"));
        }

        break;

    case "deletetype":
        $type = new OpTypes($_GET['id']);

        $type->delete();
        break;

    case "adduser":
        $user = new Users( );

        $user->username = $_POST['username'];
        $user->password = md5($_POST['password']);
        $user->name = $_POST['name'];
        $user->lastname = $_POST['lastname'];
        $user->email = $_POST['email'];

        if ($user->save()) {
            echo json_encode(array("error" => "-1"));
        } else {
            echo json_encode(array("error" => "Se produjo un error al guardar la Operación"));
        }

        break;
    case "deleteuser":
        $user = new Users($_GET['id']);

        $user->delete();

        break;

    case "adddeveloper":
        $uid = $_GET['id'];

        $user = new Users($uid);

        $api_key = sha1($user->username . $user->password);

        $dev = new Developer();

        $dev->uid = $uid;
        $dev->api_key = $api_key;

        $dev->save();

        break;

    case "deletedeveloper":
        $dev = new Developer($_GET['id']);

        $dev->delete();

        break;

    case "restorekey":
        require_once('restoreemail.php');

        $email = $_POST['email'];

        if (( $user = Users::getUser($email))) {
            $clave = dechex(rand());

            $user->password = md5($clave);

            $user->save();

            $message = '<strong>' . $user->name . '</strong>:<br/>';
            $message .= '<br />Su clave ha sido recuperada exitosamente. Ingrese a su panel de administraci&oacute;n con la clave provista a continuaci&oacute;n.<br /><br/>Su nueva clave es: ' . $clave;
            $message .= '<br/><br/>Gracias por confiar en nosotros.<br/><strong>Cronos Development</strong>';

            sendHtmlEmail($user->email, "Nuevo password", $message);

            echo "<p class='msg done'>Su clave ha sido restaurada existosamente, revise su e-mail.<br/>Regrese al login para ingresar nuevamente</p>";

            return;
        }
        echo "<p class='msg error'>El e-mail no existe!</p>";

        break;

    case "changekey":
        require_once('restoreemail.php');

        $key = $_POST['actualpass'];
        $newkey = $_POST['newpass'];

        if (( $user = new User(check_session()))) {
            if ($user->password != md5($key)) {
                echo "<p class='msg error'>La contraseña ingresada no coincide con su contraseña actual.</p>";
                return;
            }

            $user->password = md5($newkey);

            $user->save();

            $message = '<br/><strong>' . $user->name . '</strong>:<br/>';
            $message .= '<br />Su clave ha sido cambiada exitosamente. Ingrese a su panel de administraci&oacute;n con la clave provista a continuaci&oacute;n.<br /><br/>Su nueva clave es: ' . $newkey;
            $message .= '<br/><br/>Gracias por confiar en nosotros.<br/><strong>Cronos Development</strong>';

            sendHtmlEmail($user->email, "Cambio de password", $message);

            echo "<p class='msg done'>Su clave ha sido cambiada existosamente, se le ha enviado un e-mail con su nueva clave.</p>";

            return;
        }
        echo "<p class='msg error'>El e-mail no existe!</p>";

        break;

    case "login":
        $email = $_POST['email'];
        $psw = $_POST['psw'];

        if (($user = Users::validate($email, $psw))) {
            if ($user->roleid == "0") {
                if (create_session($user->email, "admin")) {
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
        close_session("admin");
        header("Location: " . base_url . "admin.php");

        break;

    case "edittaglanguje":
        $ERROR = array();

        $ERROR = array_merge($ERROR, array("error" => "error"));
        $ERROR = array_merge($ERROR, array("message" => $_POST['content'].$_POST['tagid']));
        echo json_encode($ERROR);
        return;

        break;

    case "savtag":
        $ERROR = array();

        $lang = new Languages($_POST['id']);
        $lang->value = $_POST['cont'];
        if($lang->save()) {
            $ERROR = array_merge($ERROR, array("result" => "ok"));
            $ERROR = array_merge($ERROR, array("message" => $_POST['cont']));
        }
        else {
            $ERROR = array_merge($ERROR, array("result" => "error"));
            $ERROR = array_merge($ERROR, array("message" => 'Ocurrio un error al guardar los datos, intente mas tarde'));
        }

        echo json_encode($ERROR);
        return;

        break;

    case "savpost":
        $ERROR = array();

        if($_POST['id'] != '-1')
            $post = new Post($_POST['id']);
        else {
            $post = new Post();
        }

        $post->title = $_POST['tit'];
        $post->content = $_POST['cont'];

        if($post->save()) {
            $ERROR = array_merge($ERROR, array("result" => "ok"));
            $ERROR = array_merge($ERROR, array("tit" => strftime('%Y-%B-%d %H:%M', strtotime($post->created)). ' '.$post->title));
            $ERROR = array_merge($ERROR, array("cont" => $post->content));
        }
        else {
            $ERROR = array_merge($ERROR, array("result" => "error"));
            $ERROR = array_merge($ERROR, array("message" => 'Ocurrio un error al guardar los datos, intente mas tarde'));
        }

        echo json_encode($ERROR);
        return;

        break;
}
?>
