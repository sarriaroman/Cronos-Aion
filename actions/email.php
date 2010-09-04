<?php

require_once( dirname(dirname(__FILE__)) . "/engine/start.php" );

function sendHtmlEmail($to, $subject, $message ) {
    $headers = 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
    $headers .= 'From: [Cronos Aion] Framework <web@cronosdevelopment.com>' . "\r\n";

    $html = '<html><head></head><body>';
    $html .= '<div style="width: 550px; margin-left: auto; margin-right: auto; border: 1px black solid; padding: 3px;">';
    $html .= '<table border="0" style="width: 543px;"><tr><td>';
    $html .= '<img src="' . admin_base_url . 'images/cronos.png" /></td></tr>';
    $html .= '<tr><td>' . $message . '</td></tr></table></div>';
    $html .= '</body></html>';

    mail($to, $subject, $html, $headers);
}
?>
