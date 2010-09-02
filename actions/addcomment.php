<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
*/

require_once( dirname(dirname(__FILE__)) . "/engine/start.php" );

global $dbprefix;
$con = new Connection();
$req = $con->insert_data("INSERT INTO {$dbprefix}blogcomments (postid, name, email, post, created) VALUES
                                                          ('" . $_POST['pid'] . "',
        						   '" . $_POST['name'] . "',
                                                           '" . $_POST['email'] . "',
                                                           '" . $_POST['post'] . "',
        						    NOW())");

if( !$req ) {
    $date = date("Y-m-d H:i:s");

    if( $_POST['bid'] == -1 || $_POST['bid'] == -2 ) {
        $sql = "select tittle from {$dbprefix}blogpost where id = " . $_POST['pid'] . " and bid = " . $_POST['bid'];
    } else {
        $sql = "select b.tittle, b.bid, p.admin_uid from {$dbprefix}blogpost as b inner join {$dbprefix}programs as p where b.bid = p.id and b.id = " . $_POST['pid'] . " and b.bid = " . $_POST['bid'];
    }

    $data = mysql_fetch_array( $con->make_request($sql), MYSQL_ASSOC );

    $to = "";
    if( $_POST['bid'] != -1 && $_POST['bid'] != -2 ) {
        $admin = User::get_user_by_id( $data['admin_uid'] );

        $to = $admin->email;
    } else {
        $to = get_config("email:comments");
    }

    $from = $_POST['email'];

    $subject = "Nuevo comentario";

    $message = "Nuevo comentario en el topico:<br/>";

    if( $_POST['bid'] == -1 ) {
        $message .= $data['tittle'] . " ( Te Ayudamos )<br/><br/>";
    } else if( $_POST['bid'] == -2 ) {
        $message .= $data['tittle'] . " ( Te Escuchamos )<br/><br/>";
    } else {
        $message .= $data['tittle'] . "<br/><br/>";
    }
    $message .= "De: " . $_POST['name'] . " ( " . $_POST['email'] . " )<br/><br/>";
    $message .= "Comentario:<br/>" . $_POST['post'];

    $message = nl2br( $message );

    $mail = new SmtpMail($to, $message, $subject, $from);
    if( $mail->send() ) {

        $subject = "Nuevo comentario para " . $to;
        if( ( $firstbackup = get_config("email:firstbackup") ) != "" ) {
            $bkp = new SmtpMail($firstbackup, $message, $subject, $from);
            $bkp->send();
        }
        if( ( $secondbackup = get_config("email:secondbackup") ) != "" ) {
            $bkp = new SmtpMail($secondbackup, $message, $subject, $from);
            $bkp->send();
        }
        
        echo '<div id="Coment">
            <h5>' . $_POST['name'] . '</a> ' . $date . '</h5>
                <p>' . $_POST['post'] . '</p>
          </div>';
    } else {
        echo "Se ha producido un error, intentelo de nuevo mas tarde";
    }

} else {
    echo "Error";
}

?>
