<?php

/**
 *
 * Clase de conexion en PHP
 *
 * Libreria MySQLi
 *  
 */
class MySQLiConnection {

    var $connect;

    function __construct() {
        global $host, $user, $key, $db;

        if (( $this->connect = new mysqli($host, $user, $key))) {
            $this->connect->select_db($db) or die(system_message("connect:db_error"));
        }
    }

    function make_request($sql) {
        //Log::info(did, $sql);
        
        if( ( $rst = $this->connect->query( $sql ) ) ) {
            return $rst;
        } else {
            //Log::error(did, system_message("connect:data_error"));
            return array( "error" => system_message("connect:data_error") );
        }
    }

    function insert_data($sql) {
        if( ($rst = $this->connect->query( $sql ) ) ) {
            return $rst;
        } else {
            //Log::error(did, system_message("connect:data_error"));
            return array( "error" => system_message("connect:data_error") );
        }
    }

    function authenticate($API_Key) {
        if( ($rst = $this->make_request("select id from api_users where api_key='$API_Key'")) ) {
            $r = mysqli_fetch_assoc($rst);
            return $r['id'];
        } else {
            return false;
        }
    }

}

?>