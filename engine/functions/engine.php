<?php

function load_module( $function, $filename = "" ) {
    include( modules_dir . $function . "/" . ( ($filename == "") ? "main.html" : $filename ) );
}

function load_module_with_param( $function, $param ) {
    put_vars( $param );

    include( modules_dir . $function);

}

function put_vars( $v ) {
    $_GET['vars'] = $v;
}

function get_vars() {
    return $_GET['vars'];
}

function put_var( $key, $value ) {
    remap_globals();
    unset($_GET);
    $_GET[$key] = $value;
}

function remap_globals() {

    global $GET_VARS, $POST_VARS, $COOKIE_VARS, $SESSION_VARS, $SERVER_VARS, $ENV_VARS;

    $parser_version = phpversion();

    if ($parser_version <= "4.1.0") {
        $GET = &$GET_VARS;
    }
    if ($parser_version >= "4.1.0") {
        $GET = &$_GET;
    }
}

function get_var( $key ) {
    return $_GET[$key];
}

function get_config( $key ) {
    global $dbprefix;

    $con = new Connection();

    $sql = "select config_value from {$dbprefix}config where config_key = '{$key}'";

    $req = $con->make_request($sql);

    $rst = mysql_fetch_array( $req , MYSQL_ASSOC );

    return $rst['config_value'];
}

function set_config( $key, $value ) {
    global $dbprefix;

    $con = new Connection();

    $sql = "update {$dbprefix}config set config_value = '{$value}' where config_key = '{$key}'";

    if( $con->make_request($sql) ) {
        return true;
    } else return false;
}

?>