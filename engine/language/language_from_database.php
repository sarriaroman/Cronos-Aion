<?php

function get_message_from_database($string, $replace = "") {
    $language = load_language_from_database($string);

    if ($replace != "" && is_array($replace)) {
        foreach ($replace as $key => $value) {
            $language = str_ireplace("{" . $key . "}", $value, $language);
        }

        return $language;
    }
    return $language;
}

function load_language_from_database($key) {
    global $CONFIG;

    $con = new Connection();

    $rst = $con->make_request("select value from languages where tag = '{$key}' and lang = '{$CONFIG->lang}'");

    $result = mysql_fetch_object($rst);

    return $result->value;
}

?>
