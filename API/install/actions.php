<?php

$action = $_POST['action'];
if (empty($action))
    $action = $_GET['action'];

switch ($action) {
    case "install":
        $sql = file_get_contents('mysql.sql');

        $host = $_POST['server'];
        $user = $_POST['username'];
        $key = $_POST['password'];

        $db = $_POST['database'];

        if (( $connect = mysql_connect($host, $user, $key))) {
            if (mysql_select_db($db, $connect)) {
                if (mysql_query($sql, $connect)) {
                    $config = file_get_contents('settings.model.php');

                    $replace = array( "server" => $host, "database" => $db, "user" => $user, "password" => $key );

                    $file = get_message($config, $replace, false);

                    echo json_encode( array( "response" => true, "file" => $file ) );

                    return;
                } else {
                    echo json_encode( array( "response" => false ) );
                }
            } else {
                echo json_encode( array( "response" => false ) );
            }
        } else {
            echo json_encode( array( "response" => false ) );
        }
        return;
        break;
}

function get_message($string, $replace = "", $lang = true) {
    $language = load_language();

    if ($replace != "" && is_array($replace)) {
        $return = ( $lang ) ? $language[$string] : $string;

        foreach ($replace as $key => $value) {
            $return = str_ireplace("{" . $key . "}", $value, $return);
        }

        return $return;
    }

    $replace = str_ireplace(array_keys($language), array_values($language), $string);
    return $language[$string];
}

?>
