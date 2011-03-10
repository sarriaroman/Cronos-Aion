<?php

/**
 * 	Gestor dinánimo de funciones
 *
 * 	Román A. Sarria
 *
 */
register_function("dump", "dump_functions", array());

function dump_functions() {
    global $functions;

    echo "<pre>";
    var_dump($functions);
    echo "</pre>";

    return null;
}

?>