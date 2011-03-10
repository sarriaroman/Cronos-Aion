<?php

/**
 * 	Motor del gestor dinánimo de funciones
 *
 */
function call_function($function, $p) {
    global $symbol;

    $name = $function["call"];
    $param = $function[0];
    //$parameters = explode($symbol, $p);
    $send = array();

    foreach ($param as $f) {
        if (get_config("developer:enabled")) {
            $val = $_POST[$f['parameter']];
            if( !$val ) $val = $_GET[$f['parameter']];

            if ( $val ) {
                array_push($send, $val);
            } else {
                if ($f["required"]) {
                    return array("error" => system_message("function:parameter_required", array("field" => $f['parameter'])));
                } else {
                    array_push($send, "");
                }
            }
        } else {
            if (( $val = ( ( $f['post'] ) ? $_POST[$f['parameter']] : $_GET[$f['parameter']] ))) {
                array_push($send, $val);
            } else {
                if ($f["required"]) {
                    return array("error" => system_message("function:parameter_required", array("field" => $f['parameter'])));
                } else {
                    array_push($send, "");
                }
            }
        }
    }

    if (count($send) == count($param)) {
        return call_user_func_array($name, $send);
    } else {
        return false;
    }
}

function register_function($name, $call_name, $arr_vars) {
    global $functions;

    $functions = array_merge($functions, array($name => array("call" => $call_name, $arr_vars)));
}

?>