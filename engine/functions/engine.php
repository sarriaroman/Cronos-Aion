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
function load_module( $name, $plugin = 'main', $filename = "" ) {
    if( $plugin == "" || !isset ($plugin) ) $plugin = 'main';

    if( file_exists(get_module_dir($name, $plugin) . "/main.php" ) ) {
        include( get_module_dir($name, $plugin) . "/main.php" );
    }
    if(file_exists( ( $mainfile = get_module_dir($name, $plugin) . "/" . ( ($filename == "") ? "main.html" : $filename ) ) ) ) {
        include( $mainfile );
    }
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
function load_section( $url, $plugin = 'main' ) {
    if( $plugin == "" || !isset ($plugin) ) $plugin = 'main';
    include( ( ( is_array( $url ) ) ? get_section_dir($url[1], $url[0]) : get_section_dir($url, $plugin) ) . "/main.php" );
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
function admin_module( $function, $plugin = 'main', $filename = "" ) {
    if( $plugin == "" || !isset ($plugin) ) $plugin = 'main';
    if( file_exists(get_admin_module_dir($function, $plugin) . "/main.php" ) ) {
        include( get_admin_module_dir($function, $plugin) . "/main.php" );
    }
    if( file_exists(get_admin_module_dir($function, $plugin) . "/" . ( ($filename == "") ? "main.html" : $filename ) ) ) {
        include( get_admin_module_dir($function, $plugin) . "/" . ( ($filename == "") ? "main.html" : $filename ) );
    }
}

/**
 * Carga una seccion del panel de administracion.
 *
 * @param <type> $url
 */
function admin_section( $url, $plugin = 'main' ) {
    if( $plugin == "" || !isset ($plugin) ) $plugin = 'main';
    include( ( ( is_array( $url ) ) ? get_admin_section_dir($url[0], $plugin) : get_admin_section_dir($url, $plugin) ) . "/main.php" );
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