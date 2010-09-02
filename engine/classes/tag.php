<?php
/* 
 * Clase para manejo de Etiquetas (Tag)
 *
 * Román A. Sarria
 */

class Tag {

    var $con;

    var $id;
    var $pid;
    var $tag;
    
    function  __construct( $id = -1 ) {
        if( $id != -1 ) complete_all_data( $id );
    }

    function connection() {
	if( $this->con == null )
            $this->con = new Connection();

        return $this->con;
    }

    function complete_all_data( $id ) {
        global $dbprefix;

	$req = $this->connection()->make_request("select * from {$dbprefix}tags where id = '{$id}'");

	$rst = mysql_fetch_array( $req, MYSQL_ASSOC );

        if( !empty( $rst ) ) {
            $this->id = $rst['id'];
            $this->pid = $rst['pid'];
            $this->tag = $rst['tag'];
        }
    }

    static function insert_tags( $pid, $tags ) {
        Tag::delete_all($pid);

        if( empty( $tags ) ) return true;

        $array = explode(",", $tags);

        global $dbprefix;

        $con = new Connection();

        foreach( $array as $key => $value )  {
            $sql = "insert into {$dbprefix}tags (pid, tag) values ($pid,'$value')";

            $con->insert_data($sql);
        }

        return true;
    }

    static function delete_all( $pid ) {
        global $dbprefix;

        $con = new Connection();

        $sql = "delete from {$dbprefix}tags where pid = $pid";

        $rst = $con->delete_data( $sql );
    }

    static function get_tags( $pid ) {
        global $dbprefix;

        $con = new Connection();

        $sql = "select tag from {$dbprefix}tags where pid = $pid";

        $req = $con->make_request($sql);

        $tags = "";

        $tags .= implode(", ", array_values( mysql_fetch_array($req) ) );

//        $i = 0;
//        while( $rst = mysql_fetch_array( $req, MYSQL_ASSOC ) ) {
//            $tags .= $rst['tag'];
//            if( $i != ( count( $rst ) - 1 ) ) {
//                $tags .= ", ";
//                $i++;
//            }
//        }

        return $tags;
    }

    static function get_formed_tags( $pid ) {
        global $dbprefix;

        $con = new Connection();

        $sql = "select tag from {$dbprefix}tags where pid = $pid";

        $req = $con->make_request($sql);

        $rst = mysql_fetch_array( $req, MYSQL_NUM );

        $tags = "";

        foreach( $rst as $key => $value ) {
        }

        return $tags;
    }

}

?>
