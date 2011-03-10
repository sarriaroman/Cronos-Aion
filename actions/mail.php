<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
*/

require_once( dirname(dirname(__FILE__)) . "/engine/start.php" );

$to = $_POST['to'];
$from = $_POST['from'];
$subject = $_POST['subject'];
$message = nl2br( $_POST['msg'] );

//if( get_config("smtp:enabled") == "true" ) {
    $mail = new SmtpMail($to, $message, $subject, $from);
    if( $mail->send() ) {
        if( ( $firstbackup = get_config("email:firstbackup") ) != "" ) {
            $bkp = new SmtpMail($firstbackup, $message, $subject, $from);
            $bkp->send();
        }
        if( ( $secondbackup = get_config("email:secondbackup") ) != "" ) {
            $bkp = new SmtpMail($secondbackup, $message, $subject, $from);
            $bkp->send();
        }
        echo "El mensaje ha sido enviado correctamente";
    } else {
        echo "Se ha producido un error, intentelo de nuevo mas tarde";
    }
/*} else {

    $extra = "Content-type: text/html; charset=utf-8\r\n";
    if( get_config("email:fromclientenabled") == 1 ) {
        $extra .= "From: " . $from . "\r\n";
    } else {
        $extra .= "From: " . $to . "\r\n";
    }
    $extra .= "Reply-To: " . $from . "\r\n";

    if( mail($to, $subject, $message, $extra ) ) {

        if( ( $firstbackup = get_config("email:firstbackup") ) != "" ) {
            mail($firstbackup, $subject, $message, $extra);
        }
        if( ( $secondbackup = get_config("email:secondbackup") ) != "" ) {
            mail($secondbackup, $subject, $message, $extra);
        }
        echo "El mensaje ha sido enviado correctamente";
    } else {
        echo "Se ha producido un error, intentelo de nuevo mas tarde";
    }
}*/

?>
