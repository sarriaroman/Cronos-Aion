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

    case "addpost":
        global $dbprefix;
        $con = new Connection();

        $post = addSlashes( $_POST['post'] );

        $rst = $con->insert_data("INSERT INTO {$dbprefix}blogpost (bid, tittle, post, created) VALUES
        									  ('" . $_POST['bid'] . "',
        									   '" . encode_string( $_POST['tittle'] ) . "',
                                                                                   \"" .  $post . "\",
        									    NOW())");

        if( !$rst ) {
            if( $_POST['bid'] == "-1" ) {
                include( base_dir . "backend/functions/helpyou.php");
                loadhelppost();
                //header("Location: " . base_url . "/admin.php#tabs-3");
            } else {
                include( base_dir . "backend/functions/hearyou.php");
                loadhearpost();
            }
        } else {
            echo "Error";
        }
        break;

    case "deletepost":
        global $dbprefix;
        $con = new Connection();

        $sql = "DELETE FROM {$dbprefix}blogpost WHERE id = '" . $_GET['id'] . "'";

        $rst = $con->delete_data( $sql );
        $rst = $con->delete_data("DELETE FROM {$dbprefix}blogcomments WHERE postid = {$_GET['id']}");

        if( $_GET['section'] == "-1" ) {
            include( base_dir . "backend/functions/helpyou.php");
            loadhelppost();
        } else {
            include( base_dir . "backend/functions/hearyou.php");
            loadhearpost();
        }

        break;

    case "deletecomment":
        global $dbprefix;
        $con = new Connection();

        $sql = "DELETE FROM {$dbprefix}blogcomments WHERE id = '" . $_GET['id'] . "'";

        $rst = $con->delete_data( $sql );

        if( $_GET['section'] == "-1" ) {
            include( base_dir . "backend/functions/helpyou.php");
            loadhelppost();
        } else {
            include( base_dir . "backend/functions/hearyou.php");
            loadhearpost();
        }

        break;

    case "addprogram":
        global $dbprefix;
        $con = new Connection();
        $rst = $con->insert_data("INSERT INTO {$dbprefix}programs (name, description, image, banner, admin_uid, created) VALUES
								  ('" . $_POST['name'] . "',
								   '" . $_POST['description'] . "',
                                                                   '" . $_POST['image'] . "',
                                                                   '" . $_POST['banner'] . "',
                                                                   '" . $_POST['auid'] . "',
								   NOW() )");
        if( !$rst ) {
            include( base_dir . "backend/functions/programs.php");
            loadPrograms();
        } else {
            echo "Error";
        }
        break;

    case "updateprogram":
        global $dbprefix;
        $con = new Connection();
        $rst = $con->update_data("update {$dbprefix}programs set name = '" . $_POST['name'] . "',
                                                                 description = '" . $_POST['description'] . "',
                                                                 image = '" . $_POST['image'] . "',
                                                                 banner = '" . $_POST['banner'] . "',
                                                                 admin_uid = '" . $_POST['auid'] . "'
                                                                 where id = " . $_POST['pid'] );
        
        if( !$rst ) {
            include( base_dir . "backend/functions/programs.php");
            loadPrograms();
        } else {
            echo "Error";
        }
        break;

    case "getprogram":
        $program = new Program( $_POST['pid'] );

        header('Content-type: application/json');

        echo json_encode( array( "name" => $program->name,
                                 "description" => $program->description,
                                 "image" => $program->image,
                                 "banner" => $program->banner,
                                 "adminuid" => $program->admin_uid ) );

        break;

    case "deleteprogram":
        global $dbprefix;
        $con = new Connection();

        $sql = "DELETE FROM {$dbprefix}programs WHERE id = '" . $_GET['id'] . "'";

        $rst = $con->delete_data( $sql );

        if( !$rst ) {
            include( base_dir . "backend/functions/programs.php");
            loadPrograms();
        } else {
            echo "Error";
        }
        break;

    case "addprofile":

        $temp = new User( $_POST['email'] );

        if( $temp->name != "" ) {
            echo "Error: ya existe un usuario que posee el mismo e-mail";

            break;
        }

        $user = new User();

        $user->name = $_POST['name'];
        $user->email = $_POST['email'];
        $user->ulevel = $_POST['level'];
        $user->password = md5( $_POST['pass'] );

        if( !$user->save() ) {
            include( base_dir . "backend/functions/profiles.php");
            loadProfiles();
        } else {
            echo "Error";
        }
        break;

    case "deleteprofile":
        global $dbprefix;
        $con = new Connection();

        $sql = "DELETE FROM {$dbprefix}profile WHERE id = '" . $_GET['id'] . "'";

        $rst = $con->delete_data( $sql );

        if( !$rst ) {
            include( base_dir . "backend/functions/profiles.php");
            loadProfiles();
        } else {
            echo "Error";
        }
        break;

    case "addschedule":
        global $dbprefix;
        $con = new Connection();
        $rst = $con->insert_data("INSERT INTO {$dbprefix}schedule (progid, fromTime, toTime, day) VALUES
								  ('" . $_POST['pid'] . "',
								   '" . $_POST['from'] . "',
                                                                   '" . $_POST['to'] . "',
								   '" . $_POST['day'] . "')");
        if( !$rst ) {
            include( base_dir . "backend/functions/schedule.php");
            loadSchedule();
        } else {
            echo "Error";
        }
        break;

    case "editschedule":
        global $dbprefix;
        $con = new Connection();

        $sql = "update {$dbprefix}schedule set progid = " . $_POST['pid'] . ",
                                               fromTime = '" . $_POST['from'] . "',
                                               toTime = '" . $_POST['to'] . "',
                                               day = '" . $_POST['day'] . "'
                                               where id = '" . $_POST['sid'] . "'";

        $rst = $con->update_data($sql);

        if( rst ) {
            echo $_POST['name'] . ": " . get_message( "week:" . strtolower( $_POST['day'] ) ) . " (" . $_POST['from'] . " - " . $_POST['to'] . ')';
        } else {
            echo "Se produjo un error";
        }
        break;

    case "deleteschedule":
        global $dbprefix;
        $con = new Connection();

        $sql = "DELETE FROM {$dbprefix}schedule WHERE id = '" . $_GET['id'] . "'";

        $rst = $con->delete_data( $sql );

        if( !$rst ) {
            include( base_dir . "backend/functions/schedule.php");
            loadSchedule();
        } else {
            echo "Error";
        }

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
