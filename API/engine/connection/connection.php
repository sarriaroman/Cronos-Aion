<?php

/**
 *
 * Clase de conexion en PHP
 *  
 */
class Connection {

    var $connect;
    var $dType;

    const mysql = "mysql";

    function __construct($type = Connection::mysql) {
        global $host, $user, $key, $db;
        $this->dType = $type;

        if (( $this->connect = mysql_connect($host, $user, $key))) {
            mysql_select_db($db, $this->connect) or die(system_message("connect:db_error"));
        }
    }

    function make_request($sql) {
        //Log::info(did, $sql);
        
        if( ( $rst = mysql_query($sql, $this->connect) ) ) {
            return $rst;
        } else {
            //Log::error(did, system_message("connect:data_error"));
            return array( "error" => system_message("connect:data_error") );
        }
    }

    function insert_data($sql) {
        //Log::info( did, $sql);

        if( ($rst = mysql_query($sql, $this->connect) ) ) {
            return $rst;
        } else {
            //Log::error(did, system_message("connect:data_error"));
            return array( "error" => system_message("connect:data_error") );
        }
    }

    /**
     * Get the last ID inserted on a table.
     */
    function get_last_ID() {
        return mysql_insert_id( $this->connect );
    }

    function authenticate($API_Key) {
        if( ($rst = $this->make_request("select id from api_users where api_key='$API_Key'")) ) {
            $r = mysql_fetch_array($rst, MYSQL_ASSOC);
            return $r['id'];
        } else {
            return false;
        }
    }

}

?>