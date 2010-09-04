<?php

/**
 * Carga un modulo, para ello apunta a la carpeta que posee
 * el mismo nombre que el modulo que se quiere cargar e incluye
 * el archivo main.html y si existe su archivo main.php
 *
 * main.html -> HTML
 * main.php -> Funciones en php necesarias
 *
 * @param <String> $name Nombre del modulo
 * @param <String> $filename Si el archivo html del modulo no se llama main.html
 * @param <String> $parameters Envio de parametros al php. Se usa la logica de php: main.php?[nombre=variable]
 */
function load_module( $name, $filename = "", $parameters = "" ) {
    if( file_exists( modules_dir . $name . "/main.php" ) ) {
        if( $parameters != "" ) {
           include( modules_url . $name . "/main.php" . $parameters );
        } else {
            include( modules_dir . $name . "/main.php" );
        }
    }
    include( modules_dir . $name . "/" . ( ($filename == "") ? "main.html" : $filename ) );
}

/**
 * Carga dinamicamente una seccion y esta pensado para ser
 * usado con el modulo de reescritrura integrado. Si se le
 * envia el array de parametros obtenido, carga el primer
 * nombre que posee la url despues del indicador de
 * reescritura ( Por default: f ). Sino carga el nombre
 * que se le da.
 *
 * @param <type> $url String o Array con la seccion deseada.
 */
function load_section( $url ) {
    include( section_dir . ( ( is_array( $url ) ) ? $url[0] : $url ) . "/main.php" );
}

/**
 * Carga un modulo dentro del panel de administracion
 * siguiendo la logica planteada en el framework.
 *
 * main.html -> HTML
 * main.php -> Funciones a usar
 *
 * @param <type> $function Nombre de la carpeta que lo contiene
 * @param <type> $filename Si el archivo main.html se llama distinto.
 */
function admin_module( $function, $filename = "" ) {
    if( file_exists( admin_modules_dir . $function . "/main.php" ) ) {
        include( admin_modules_dir . $function . "/main.php" );
    }
    include( admin_modules_dir . $function . "/" . ( ($filename == "") ? "main.html" : $filename ) );
}

/**
 * Carga una seccion del panel de administracion.
 *
 * @param <type> $url
 */
function admin_section( $url ) {
    include( admin_section_dir . ( ( is_array( $url ) ) ? $url[0] : $url ) . "/main.php" );
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