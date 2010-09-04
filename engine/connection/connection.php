<?php

/**
 * Objeto encargado de hacer la transaccion de datos<br/>
 * mediante las funciones de PHP. Por el momento funciona<br/>
 * con MySQL pero tiene que ser facilmente modificable<br/>
 * por su desarrollo basado en la simplicidad<br /><br />
 *
 *
 * @name Connection
 * @version 1.0.0
 * @copyright Cronos Development (R)
 * @author Román A. Sarria
 */

class Connection {
    var $connect;

    /**
     * Make the connection with the Config Vars.
     */
    function __construct( ) {
        if( ($this->connect = mysql_connect( db_host , db_user , db_key )) ) {
            mysql_select_db( db_base, $this->connect ) or die( system_message("connect:db_error") );
        }
    }

    /**
     * Make a Data request to DataBase
     *
     * @param <String> $sql SQL Statement.
     * @return <Array>
     */
    function make_request( $sql ) {
        if( $rst = mysql_query( $sql, $this->connect ) or die( system_message("connect:query_error") . " ( " . $sql . " )" ) ) {
            return $rst;
        } else {
            die( system_message("connect:data_error") . " ( " . $sql . " )" );
        }
    }

    /**
     * Make an insert into in DataBase<br/>
     * Must do a check of statemet before write it.
     *
     * @param <type> $sql SQL Statement.
     */
    function insert_data( $sql ) {
        $rst = mysql_query( $sql, $this->connect ) or die( system_message("connect:insert_error") . "\nProducido por: " . $sql ); //system_message("connect:insert_error")
    }

    /**
     * Make an update in Database
     *
     * @param <type> $sql SQL Statement.
     */
    function update_data( $sql ) {
        $rst = mysql_query( $sql, $this->connect ) or die( system_message("connect:update_error") . " ( " . $sql . " )" );
    }

    /**
     * Make a delete of amount of Data in DataBase
     *
     * @param <type> $sql SQL Statement.
     */
    function delete_data( $sql ) {
        $rst = mysql_query( $sql, $this->connect ) or die( system_message("connect:delete_error") . " ( " . $sql . " )" );
    }

}

?>