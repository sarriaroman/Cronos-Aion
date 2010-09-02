<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Blog {
    var $con;

    var $id;
    var $progid;
    var $admin_uid;
    var $admin_name;
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

        $req = $this->connection()->make_request("select b.*, p.name from {$dbprefix}blogs as b
                                                  inner join {$dbprefix}profile as p
                                                  where b.admin_uid = p.id
                                                  and b.id = '{$id}'");

        $rst = mysql_fetch_array( $req, MYSQL_ASSOC );

        if( !empty( $rst ) ) {
            $this->id = $rst['id'];
            $this->progid = $rst['progid'];
            $this->admin_uid = $rst['admin_uid'];
            $this->admin_name = $rst['name'];
            $this->created = $rst['created'];
        }
    }

    function delete( $bid ) {
        global $dbprefix;

        $rst = $this->connection()->delete_data("DELETE * FROM {$dbprefix}blogs WHERE id = {$bid}");

        return ( $rst ) ? true : false;
    }

    function save() {
        global $dbprefix;

        if( $this->id != "" ) {
            $upd = $this->connection()->update_data("UPDATE {$dbprefix}blogs SET
                      progid = '" 	. $this->progid .
                    "', admin_uid = '"	. $this->admin_uid .
                    "' WHERE id = '" . $this->Id . "'");
            return ( $upd ) ? true : false;
        } else {
            $new = $this->connection()->insert_data("INSERT INTO {$dbprefix}blogs (progid, admin_uid, created) VALUES
										  ('" . $this->progid . "',
										   '" . $this->admin_uid . "',
										    NOW())");
            return ( $new ) ? true : false;
        }
    }

}

?>
