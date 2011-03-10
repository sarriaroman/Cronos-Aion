<?php

$action = $_POST['action'];
if (empty($action))
    $action = $_GET['action'];

switch ($action) {
    case "install":
        $file = dirname(__FILE__) . '/mysql.sql';

        $fh = fopen($file, 'r');
        $sql = fread($fh, filesize($file));
        fclose($fh);

        $sqls = explode(';', $sql);

        $host = $_POST['server'];
        $user = $_POST['username'];
        $key = $_POST['password'];

        $db = $_POST['database'];

        $adminemail = $_POST['email'];
        $sitebase = $_POST['site'];

        if (( $connect = mysql_connect($host, $user, $key))) {
            if (mysql_select_db($db, $connect)) {
                $finish = false;
                for ($i = 0; $i < ( count($sqls) - 1 ); $i++) {
                    $query = $sqls[$i] . ';';
                    if (mysql_query($query)) {
                        $finish = true;
                    } else {
                        $finish = false;
                        break;
                    }
                }
                if ($finish) {
                    $config = file_get_contents('settings.model.php');

                    $replace = array("server" => $host, "database" => $db, "user" => $user, "password" => $key, "adminemail" => $adminemail, "sitebase" => $sitebase);

                    $file = get_message($config, $replace);

                    echo json_encode(array("response" => true, "file" => $file));

                    return;
                } else {
                    echo json_encode(array("response" => false, "error" => mysql_error()));
                }
            } else {
                echo json_encode(array("response" => false, "error" => mysql_error($connect)));
            }
        } else {
            echo json_encode(array("response" => false, "error" => mysql_error($connect)));
        }
        return;
        break;
    case "check":
        require_once( dirname(dirname(__FILE__)) . '/engine/settings.php' );

        if (( $connect = mysql_connect($host, $user, $key))) {
            if (mysql_select_db($db, $connect)) {
                echo json_encode(array("response" => true));
            } else {
                echo json_encode(array("response" => false));
            }
        } else {
            echo json_encode(array("response" => false));
        }

        break;
    case "create":
        include( dirname(dirname(__FILE__)) . '/engine/settings.php' );
        include( dirname(dirname(__FILE__)) . '/engine/connection/connection.php' );

        include( dirname(dirname(__FILE__)) . '/engine/superclasses/data.php' );
        include( dirname(dirname(__FILE__)) . '/engine/classes/users.php' );
        
        include( dirname(dirname(__FILE__)) . '/engine/classes/developer.php' );

        $user = new Users();

        $user->username = $_POST['username'];
        $user->email = $_POST['email'];
        $user->password = md5( $_POST['password'] );
        $user->roleid = 0;

        $user->save( );

        $user = $user->getUser( $_POST['email'] );
        $uid = $user->id;

        $message = '<strong>Hi ' . $user->username . '</strong>:<br/>';
        $message .= '<br />Thanks for install Cronos Aion. Here is your data to access to our framework.';
        $message .= '<br />Username: ' . $user->username;
        $message .= '<br />Password: ' . $_POST['password'];
        $message .= '<br/><br/>Thanks.<br/><strong>Speryans Team - Cronos Development Team.</strong>';

        sendHtmlEmail($user->email, "New installation", $message);
        
        if ( $_POST['enableapi'] == 'on' ) {
            $file = dirname(__FILE__) . '/api.sql';

            $fh = fopen($file, 'r');
            $sql = fread($fh, filesize($file));
            fclose($fh);

            $sqls = explode(';', $sql);

            $con = new Connection();

            for ($i = 0; $i < ( count($sqls) - 1 ); $i++) {
                $query = $sqls[$i] . ';';
                if ($con->make_request($query)) {
                    $finish = true;
                } else {
                    $finish = false;
                    break;
                }
            }
            if ($finish) {
                if ( $_POST['enableapiadmin'] == 'on' ) {
                    $dev = new Developer();
                    
                    $dev->uid = $uid;
                    $dev->api_key = sha1($user->username . $user->password);

                    $dev->save();

                    echo json_encode(array("response" => true));
                } else {
                    echo json_encode(array("response" => true));
                }
                return;
            } else {
                echo json_encode(array("response" => false, "error" => mysql_error()));
                return;
            }
        }

        echo json_encode(array("response" => true));

        break;
}

function get_message($string, $replace = "") {
    if ($replace != "" && is_array($replace)) {
        $return = $string;

        foreach ($replace as $key => $value) {
            $return = str_ireplace("{" . $key . "}", $value, $return);
        }

        return $return;
    }
}

function sendHtmlEmail($to, $subject, $message ) {
    include( dirname(dirname(__FILE__)) . '/engine/settings.php' );

    $logo = "http://" . $_SERVER['HTTP_HOST'] . "/" . $base . '/admin/style/img/logo.png';

    $headers = 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
    $headers .= 'From: Cronos Aion <web@speryans.com>' . "\r\n";

    $html = '<html><head></head><body>';
    $html .= '<div style="width: 550px; margin-left: auto; margin-right: auto; border: 1px black solid; padding: 3px;">';
    $html .= '<table border="0" style="width: 543px;"><tr><td>';
    $html .= '<img src="' . $logo . '" /></td></tr>';
    $html .= '<tr><td>' . $message . '</td></tr></table></div>';
    $html .= '</body></html>';

    mail($to, $subject, $html, $headers);
}

?>
