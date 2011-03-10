<?php

/**
 * El framework esta preparado para leer una tabla de configuraciones
 * en las bases de datos donde funciona. Para el uso de esta tabla se
 * puede invocar a esta funcion y devuelve la etiqueta pedida.
 *
 * Etiqueta:
 *  seccion:nombre
 *
 * @global <type> $dbprefix
 * @param <type> $key
 * @return <type>
 */
function get_config( $key ) {
    global $dbprefix;

    $con = new Connection();

    $sql = "select config_value from {$dbprefix}config where config_key = '{$key}'";

    $req = $con->make_request($sql);

    $rst = mysql_fetch_array( $req , MYSQL_ASSOC );

    return $rst['config_value'];
}

/**
 * El framework esta preparado para escribis una tabla de configuraciones
 * en las bases de datos donde funciona. Para el uso de esta tabla se
 * puede invocar a esta funcion y escribir en la etiqueta indicada en
 * la tabla de configuraciones.
 *
 * Etiqueta:
 *  seccion:nombre
 *
 * @global <type> $dbprefix
 * @param <type> $key
 * @param <type> $value
 * @return <type>
 */
function set_config( $key, $value ) {
    global $dbprefix;

    $con = new Connection();

    $sql = "update {$dbprefix}config set config_value = '{$value}' where config_key = '{$key}'";

    if( $con->make_request($sql) ) {
        return true;
    } else return false;
}

?>
