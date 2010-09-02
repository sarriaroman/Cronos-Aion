<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Program {
    var $con;

    var $id;
    var $name;
    var $description;
    var $time;
    var $image;
    var $banner;
    var $admin_uid;
    var $blogpost_count;
    var $created;

    function __construct( $bid = -1 ) {
        if( $bid != -1 )
            $this->complete_all_data( $bid );
    }


    function connection() {
        if( $this->con == null )
            $this->con = new Connection();

        return $this->con;
    }

    function complete_all_data( $id ) {
        global $dbprefix;

        $req = $this->connection()->make_request("select * from {$dbprefix}programs 
                                                  where id = '{$id}'");

        $rst = mysql_fetch_array( $req, MYSQL_ASSOC );

        if( !empty( $rst ) ) {
            $this->id = $rst['id'];
            $this->name = $rst['name'];
            $this->description = $rst['description'];
            $this->time = $rst['time'];
            $this->image = $rst['image'];
            $this->banner = $rst['banner'];
            $this->admin_uid = $rst['admin_uid'];
            $this->created = $rst['created'];
        }

        if( $this->admin_uid == -1 || empty($this->id) ) {
            $this->blogpost_count = 0;
        } else {
            global $dbprefix;

            $sql = "select count(id) from {$dbprefix}blogpost where bid = " . $this->id . "";

            $c = mysql_fetch_array( $this->connection()->make_request( $sql ), MYSQL_NUM );

            $this->blogpost_count = $c[0];
        }
    }

    static function get_first_pid( $uid ) {
        global $dbprefix;

        $con = new Connection();

        $sql = "select id from {$dbprefix}programs where admin_uid = '{$uid}' limit 1";

        $rst = mysql_fetch_array( $con->make_request( $sql ), MYSQL_ASSOC );

        return $rst['id'];
    }

    function delete( ) {
        global $dbprefix;

        $rst = $this->connection()->delete_data("DELETE * FROM {$dbprefix}programs WHERE id = {$this->id}");

        return ( $rst ) ? true : false;
    }

    function save() {
        global $dbprefix;

        if( $this->id != "" ) {
            $upd = $this->connection()->update_data("UPDATE {$dbprefix}programs SET
                      name = '" 	. $this->name .
                    "', description = '"	. $this->description .
                    "', time = '" . $this->time .
                    "', image = '" . $this->image .
                    "', banner = '" . $this->banner .
                    "', admin_uid = '" . $this->admin_uid .
                    "' WHERE id = '" . $this->Id . "'");
            return ( $upd ) ? true : false;
        } else {
            $new = $this->connection()->insert_data("INSERT INTO {$dbprefix}blogs (name, description, time, image, banner, admin_uid, created) VALUES
										  ('" . $this->name . "',
										   '" . $this->description . "',
                                                                                   '" . $this->time . "',
                                                                                   '" . $this->image . "',
                                                                                   '" . $this->banner . "',
                                                                                   '" . $this->admin_uid . "',
										   '" . $this->created . "')");
            return ( $new ) ? true : false;
        }
    }

}

?>
