<?php
/**
 *  Clase de conexion en PHP
 *
 *  Román A. Sarria
 */

class Connection {
    var $connect;

    function __construct( ) {
        if( $this->connect = mysql_connect( db_host , db_user , db_key ) ) {
            mysql_select_db( db_base, $this->connect ) or die( system_message("connect:db_error") );
        }
    }

    function make_request( $sql ) {
    //echo $sql . "<br />";
        if( $rst = mysql_query( $sql, $this->connect ) or die( system_message("connect:query_error") ) ) {
            return $rst;
        } else {
            die( system_message("connect:data_error") );
        }
    }

    function insert_data( $sql ) {
        $rst = mysql_query( $sql, $this->connect ) or die( system_message("connect:insert_error") . "\nProducido por: " . $sql ); //system_message("connect:insert_error")
    }

    function update_data( $sql ) {
        $rst = mysql_query( $sql, $this->connect ) or die( system_message("connect:update_error") );
    }

    function delete_data( $sql ) {
        $rst = mysql_query( $sql, $this->connect ) or die( system_message("connect:delete_error") );
    }

    function authenticate( $API_Key ) {
        if( $rst = $this->make_request( "select id from developers where api_key='$API_Key'" ) ) {
            $r = mysql_fetch_array( $rst, MYSQL_ASSOC );

            return $r['id'];
        } else {
            return false;
        }
    }

}

?>