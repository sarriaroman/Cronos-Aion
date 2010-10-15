<?php

require_once( dirname(dirname(__FILE__)) . "/engine/start.php" );

function sendHtmlEmail($to, $subject, $message ) {
    $headers = 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
    $headers .= 'From: Cronos {Development} <web@cronosdevelopment.com.ar>' . "\r\n";


    $html = '<html><head></head><body>';
    $html .= '<div style="width: 550px; margin-left: auto; margin-right: auto; border: 1px black solid; padding: 3px;">';
    $html .= '<table border="0" style="width: 543px;"><tr><td>';
    $html .= '<div style="background-color:#F2F4F4;
        height:100px;
        border-right-width:4px;
        border-bottom-width:4px;
        border-left-width:4px;
        border-right-color:#A9ADAE;
        border-bottom-color:#A9ADAE;
        border-left-color:#A9ADAE;
        background-repeat:repeat-x;
        background-position:left top;
        border-style:none none solid;
        padding: 10px;
        padding-left: 15px;">
                <a href="' . base_url . '">
                    <img src="' . admin_base_url . 'images/cronos.png" width="280" height="100" alt="Logo Cronos {Development}" />
                </a>
            </div>';
    $html .= '</td></tr>';
    $html .= '<tr><td>' . $message . '</td></tr></table></div>';
    $html .= '</body></html>';

    mail($to, $subject, $html, $headers);
}
?>
