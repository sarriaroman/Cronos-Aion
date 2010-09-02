<?php
class User {

    var $con;

    var $uid;
    var $ulevel;
    var $name;
    var $password;
    var $image;
    var $company;
    var $position;
    var $email;
    var $description;
    var $telephone;
    var $website;
    var $banned;

    var $quota;

    var $extras = array();

    static $admin = 0;
    static $partner = 1;
    static $common = 2;

    function __construct( $email = "" ) {
        global $dbprefix;

        $ext = $this->connection()->make_request("select name from {$dbprefix}extra_fields where enabled = '1'");

        $extra = mysql_fetch_array( $ext, MYSQL_ASSOC );

        while( $extra ) {
            array_merge( $this->extras, array( $extra['name'] => "" ) );
        }

        if( $email != "" )
            $this->complete_all_data( $email );
    }

    function connection() {
        if( $this->con == null )
            $this->con = new Connection();

        return $this->con;
    }

    public static function validate( $email, $password ) {
        global $dbprefix;

        $conn = new Connection();
        $req = $conn->make_request("SELECT password FROM {$dbprefix}profile WHERE email = '{$email}'");

        $rst = mysql_fetch_array( $req, MYSQL_ASSOC );

        if( !empty($rst) ) {
            if( $rst['password'] == md5($password) ) {
                $user = new User( $email );
                return $user;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function complete_all_data( $email ) {
        global $dbprefix;

        $req = $this->connection()->make_request("select * from {$dbprefix}profile where email = '{$email}'");

        $rst = mysql_fetch_array( $req, MYSQL_ASSOC );

        if( !empty( $rst ) ) {
            $this->uid 			= $rst['id'];
            $this->ulevel 			= $rst['level'];
            $this->name 			= $rst['name'];
            $this->password		= $rst['password'];
            $this->image			= $rst['image'];
            $this->company		= $rst['company'];
            $this->position		= $rst['position'];
            $this->email			= $rst['email'];
            $this->description	= $rst['description'];
            $this->telephone		= $rst['telephone'];
            $this->website		= $rst['website'];
            $this->banned			= $rst['banned'];

            $this->quota = User::get_quota( $this->uid );

            if( count( $ext = $this->connection()->make_request("select name from {$dbprefix}extra_fields where enabled = '1'") ) > 0 ) {
                while( $extra = mysql_fetch_array( $ext, MYSQL_ASSOC ) ) {
                    $value = $this->connection()->make_request("select data from {$dbprefix}fields_data where uid = '{$this->uid}' and name = '{$extra['name']}'");
                    array_merge( $this->extras, array( $extra['name'] => $value['data'] ) );
                }
            }
        }
    }

    public static function get_quota( $uid ) {
        global $dbprefix;

        $con = new Connection();

        $sql = "select sec_to_time(sum(time_to_sec(duration))) from {$dbprefix}podcast where uid = {$uid}";

        $req = $con->make_request($sql);

        $rst = mysql_fetch_array( $req, MYSQL_NUM );

        return $rst[0];
    }

    public static function get_user_by_id( $id ) {
        global $dbprefix;

        $conn = new Connection();
        $req = $conn->make_request("select email from {$dbprefix}profile where id = '{$id}'");
        $rst = mysql_fetch_array( $req, MYSQL_ASSOC );
        if( !empty( $rst ) ) {
            $user = new User( $rst['email'] );
            return $user;
        }
    }

    public static function is_blog_admin( $id ) {
        global $dbprefix;

        $conn = new Connection();
        $req = $conn->make_request("select id from {$dbprefix}programs where admin_uid = '{$id}'");
        $rst = mysql_fetch_array( $req, MYSQL_ASSOC );
        if( !empty( $rst ) ) {
            return true;
        } else {
            return false;
        }
    }

    public function is_level( $lvl ) {
        return ( $this->ulevel == $lvl );
    }

    public function ban( $uid ) {
        global $dbprefix;

        $rst = $this->connection()->update_data("UPDATE {$dbprefix}profile SET banned = 1 WHERE id = '{$uid}'");
        return !empty( $rst ) ? true : false;
    }

    public function delete( ) {
        global $dbprefix;

        $rst = $this->connection()->delete_data("DELETE FROM {$dbprefix}profile WHERE id = '{$this->uid}'");
        if( $rst ) {
            $ext = $this->connection()->delete_data("delete from {$dbprefix}fields_data where uid = '{$this->uid}'");
        }

        return ( $ext ) ? true : false;
    }

    public function save() {
        global $dbprefix;

        if( $this->uid != "" ) {
            $sql = "UPDATE {$dbprefix}profile SET
                  name = '" 			. $this->name .
                "', level = '" 			. $this->ulevel .
                "', password = '"		. $this->password .
                "', image = '"			. $this->image .
                "', company = '"		. $this->company .
                "', email = '"			. $this->email .
                "', description = '"	. $this->description .
                "', telephone = '"		. $this->telephone .
                "', website = '"		. $this->website .
                "' WHERE id = '" . $this->uid . "'";

            $upd = $this->connection()->update_data( $sql );
            
            if( count( $extra = $this->connection()->make_request("select name from {$dbprefix}extra_fields where enabled = '1'") ) > 0 ) {
                foreach( $this->extras as $key => $value ) {
                    $ext = $this->connection()->update_data("update {$dbprefix}fields_data set data = '{$value}'
														 		where uid = '{$this->uid}' 
																and name = {$key}"
                    );
                }
            }
            return $upd;
        } else {
            $new = $this->connection()->insert_data("INSERT INTO {$dbprefix}profile (name, level, password, image, company, email, description, telephone, website) VALUES
														('" . $this->name . 			"',
                                                                                                                 '" . $this->ulevel . 			"',
														 '" . $this->password . 		"',
														 '" . $this->image . 			"',
														 '" . $this->company . 		"',
														 '" . $this->email . 			"',
														 '" . $this->description . 	"',
														 '" . $this->telephone . 		"',
														 '" . $this->website . 		"')
												 ");
            if( count( $extra = $this->connection()->make_request("select name from {$dbprefix}extra_fields where enabled = '1'") ) > 0 ) {
                foreach( $this->extras as $key => $value ) {
                    $next = $this->connection()->insert_data("insert into {$dbprefix}fields_data (uid, name, data) VALUES
																('" . $this->uid . "',
																 '" . $key . 					 "',
																 '" . $value . 					 "'
														   )");
                }
            }
            return !empty( $new ) ? true : false;
        }
    }

}
?>