<?php

/**
 * Guarda variables para una sesion, las mismas pueden
 * ser unidimensionales o multidimensionales (array).
 *
 */
function create_session( $vars, $name = 'sessionvars' ) {
    if( session_start() ) {

        if( empty( $vars ) ) return false;
        $_SESSION[$name] = $vars;

        return true;
    } else {
        return false;
    }
}

/**
 * Devuelve la variable guardada en la sesion creada,
 * con la funcion create_session().
 *
 * @return <type>
 */
function check_session( $name = 'sessionvars' ) {
    session_start();

    $vars = $_SESSION[$name];
    if( !empty( $vars ) ) {
        return $vars;
    } else {
        return false;
    }
}

/**
 * Cierra la Sesion actual borrando sus variables.
 *
 * @return <type>
 */
function close_session( $name = 'sessionvars' ) {
    check_session();

    $_SESSION[$name] = "";
    unset( $_SESSION[$name] );

    session_destroy();
    session_write_close();

    return true;
}

/**
 * Permite registrar mas variables a una session abierta en
 * el sitio sobre el que se esta trabajando.
 *
 * @param <type> $vars
 * @param <type> $name
 * @return <type>
 */
function set_sessionvars( $vars, $name = 'sessionvars' ) {
    if( session_start() ) {

        if( empty( $vars ) ) return false;
        $_SESSION[$name] = $vars;

        return true;
    } else {
        return false;
    }
}

/**
 * Hace lo mismo que check_session(), solo se establece
 * para estandarizar el codigo.
 *
 * @param <type> $name
 * @return <type>
 */
function get_sessionvars( $name = 'sessionvars' ) {
    session_start();

    $vars = $_SESSION[$name];
    if( !empty( $vars ) ) {
        return $vars;
    } else {
        return false;
    }
}

/**
 * Solamente destruye las variables asignadas a una session sin,
 * sin destruir la misma, esto permite tener almacenadas varias,
 * variables dentro del mismo sitio en una session.
 *
 * @param <type> $name
 */
function unset_sessionvars( $name = 'sessionvars' ) {
    unset( $_SESSION[$name] );
}

?>
