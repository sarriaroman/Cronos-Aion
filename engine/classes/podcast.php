<?php

class Podcast {

    var $con;

    var $Id;
    var $Uid;
    var $Tittle;
    var $Date;
    var $Duration;
    var $Description;
    var $Url;
    var $Filename;
    var $Home;
    var $Internal;
    var $Blog;
    var $Tags;
    var $Listen_count;
    var $Upload_date;

    function __construct( $pid = -1 ) {
        if( $pid != -1 )
            $this->complete_all_data( $pid );
    }


    function connection() {
        if( $this->con == null )
            $this->con = new Connection();

        return $this->con;
    }

    function complete_all_data( $id ) {
        global $dbprefix;

        $req = $this->connection()->make_request("select * from {$dbprefix}podcast where id = '{$id}'");

        $rst = mysql_fetch_array( $req, MYSQL_ASSOC );

        if( !empty( $rst ) ) {
            $this->Id 			= $rst['id'];
            $this->Uid 			= $rst['uid'];
            $this->Tittle 		= $rst['tittle'];
            $this->Date			= $rst['date'];
            $this->Duration		= $rst['duration'];
            $this->Description	= $rst['description'];
            $this->Url			= $rst['url'];
            $this->Home 		= $rst['home'];
            $this->Internal		= $rst['internal'];
            $this->Blog		= $rst['blog'];
            $this->Listen_count	= $rst['listen_count'];
            $this->Upload_date	= $rst['upload_date'];
        }

        $temp = explode("/", $this->Url);

        $this->Filename = $temp[ ( count($temp) - 1 ) ];
    }

    static function podcast_count( $uid = -1, $where = "" ) {
        global $dbprefix;

        $con = new Connection();

        if( $uid != -1 ) {
            $q = $con->make_request( "select COUNT(id) from {$dbprefix}podcast where uid={$uid}" );
        } else {
            $q = $con->make_request( "select COUNT(id) from {$dbprefix}podcast " . $where );
        }

        $rst = mysql_fetch_array( $q, MYSQL_NUM );

        return ( $rst[0] ) ? $rst[0] : 0;
    }

    static function last_id( $uid ) {
        global $dbprefix;

        $con = new Connection();

        $q = $con->make_request( "select id from {$dbprefix}podcast where uid={$uid} order by id DESC ");

        $rst = mysql_fetch_array( $q, MYSQL_NUM );

        return $rst[0];
    }

    function delete( $id ) {
        global $dbprefix;

        $rst = $this->connection()->delete_data("DELETE * FROM {$dbprefix}podcast WHERE id = {$id}");

        return ( $rst ) ? true : false;
    }

    function save() {
        global $dbprefix;

        if( $this->Id != "" ) {
            $upd = $this->connection()->update_data("UPDATE {$dbprefix}podcast SET
                      uid = '" 			. $this->Uid .
                    "', tittle = '"		. $this->Tittle .
                    "', date = '"			. $this->Date .
                    "', duration = '"		. $this->Duration .
                    "', description = '"	. $this->Description .
                    "', url = '"			. $this->Url .
                    "', home = '"		. $this->Home .
                    "', internal = '"		. $this->Internal .
                    "', blog = '"		. $this->Blog .
                    "', listen_count = '"	. $this->Listen_count .
                    "' WHERE id = '" . $this->Id . "'");
            return ( $upd ) ? true : false;
        } else {
            $new = $this->connection()->insert_data("INSERT INTO {$dbprefix}podcast (uid, tittle, date, duration, description, url, home, internal, blog, listen_count, upload_date) VALUES
														(" . $this->Uid . 			", 
														 '" . $this->Tittle . 		"',
														 '" . $this->Date . 			"',
														 '" . $this->Duration . 		"',
														 '" . $this->Description . 	"',
														 '" . $this->Url . 			"',
														 " . $this->Home . 		",
                                                                                                                 " . $this->Internal . 		",
                                                                                                                 " . $this->Blog . 		",
														 " . $this->Listen_count . 	",
														 NOW())
												 ");
            return ( $new ) ? true : false;
        }
    }

}
?>