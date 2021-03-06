<?php

require_once( dirname(__FILE__) . "/PHPMailer/class.phpmailer.php");

class SmtpMail {

    var $address;
    var $body;
    var $subject;
    var $from;

    var $host;
    var $port;
    var $username;
    var $password;

    public function __construct( $address, $body, $subject, $from ) {
        $this->address = $address;
        $this->from = $from;
        $this->body = $body;
        $this->subject = $subject;

        $this->host = get_config("smtp:host");
        $this->port = intval( get_config("smtp:port") );
        $this->username = get_config("smtp:username");
        $this->password = get_config("smtp:password");
    }

    public function send() {
        if( get_config("smtp:enabled") == "false" ) {
            return $this->sendTypicalMail();

        }

        $mail             = new PHPMailer();

        $mail->IsSMTP(); // telling the class to use SMTP
        $mail->Host       = $this->host; // SMTP server
        $mail->SMTPDebug  = 1;                     // enables SMTP debug information (for testing)
        // 1 = errors and messages
        // 2 = messages only
        $mail->SMTPAuth   = true;                  // enable SMTP authentication
        $mail->Host       = $this->host; // sets the SMTP server
        $mail->Port       = $this->port;                    // set the SMTP port for the GMAIL server
        $mail->Username   = $this->username; // SMTP account username
        $mail->Password   = $this->password;        // SMTP account password

        if( get_config("email:fromclientenabled") == 1 ) {
            $mail->SetFrom( $this->from );
        } else {
            $mail->SetFrom( get_config("email:sender") );
        }

        $mail->AddReplyTo( $this->from );

        $mail->Subject    = $this->subject;

        $mail->AltBody    = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test

        $mail->IsHTML();
        $mail->MsgHTML( $this->body );

        // Dirección a la que se envia
        $mail->AddAddress( $this->address );

        if(!$mail->Send()) {
            return false;
            //$mail->ErrorInfo;
        } else {
            return true;
        }
    }

    private function sendTypicalMail() {
        $extra = "Content-type: text/html; charset=utf-8\r\n";

        if( get_config("email:fromclientenabled") == 1 ) {
            $extra .= "From: " . $this->from . "\r\n";
        } else {
            $extra .= "From: " . get_config("email:sender") . "\r\n";
        }
        $extra .= "Reply-To: " . $this->from . "\r\n";

        if( mail( $this->address , $this->subject, $this->body, $extra ) ) {
            return true;
        } else {
            return false;
        }
    }
}
?>
