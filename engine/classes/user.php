<?php
class User {

    var $con;

    var $uid;
    var $name;
    var $username;
    var $password;
    var $address;
    var $email;
    var $telephone;
    var $level;

    static $admin = 0;
    static $common = 1;
    static $mailing = 5;

    function __construct( $email = "" ) {
        global $dbprefix;

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
        if( strpos($email, "@") == true ) {
            $sql = "SELECT password FROM {$dbprefix}profile WHERE email = '{$email}'";
            $req = $conn->make_request( $sql );
        } else {
            $req = $conn->make_request("SELECT email, password FROM {$dbprefix}profile WHERE username = '{$email}'");
        }

        $rst = mysql_fetch_array( $req, MYSQL_ASSOC );

        if( !empty($rst) ) {
            if( $rst['password'] == md5($password) ) {
                $user = new User( (strpos($email, "@")) ? $email : $rst['email'] );
                return $user;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public static function getUser( $email ) {
        global $dbprefix;

        $conn = new Connection();
        if( strpos($email, "@") == true ) {
            $sql = "SELECT email FROM {$dbprefix}profile WHERE email = '{$email}'";
            $req = $conn->make_request( $sql );
        } else {
            $req = $conn->make_request("SELECT email FROM {$dbprefix}profile WHERE username = '{$email}'");
        }

        $rst = mysql_fetch_array( $req, MYSQL_ASSOC );

        return new User( $rst['email'] );
    }

    public static function exist( $email ) {
        global $dbprefix;

        $conn = new Connection();
        if( strpos($email, "@") == true ) {
            $sql = "SELECT email FROM {$dbprefix}profile WHERE email = '{$email}'";
            $req = $conn->make_request( $sql );
        } else {
            return false;
        }

        if( mysql_num_rows( $req ) == 1 ) return true;
        else return false;
    }

    public function complete_all_data( $email ) {
        global $dbprefix;

        $req = $this->connection()->make_request("select * from {$dbprefix}profile where email = '{$email}'");

        $rst = mysql_fetch_array( $req, MYSQL_ASSOC );

        if( !empty( $rst ) ) {
            $this->uid 			= $rst['id'];
            $this->level 			= $rst['level'];
            $this->name 			= $rst['name'];
            $this->password		= $rst['password'];
            $this->username			= $rst['username'];
            $this->email			= $rst['email'];
            $this->telephone		= $rst['phone'];
            $this->address		= $rst['address'];
        }
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

    public function is_level( $lvl ) {
        return ( $this->level == $lvl );
    }

    public function delete( ) {
        global $dbprefix;

        $rst = $this->connection()->delete_data("DELETE FROM {$dbprefix}profile WHERE id = '{$this->uid}'");

        return ( $rst ) ? true : false;
    }

    public function save() {
        global $dbprefix;

        if( $this->uid != "" ) {
            $sql = "UPDATE {$dbprefix}profile SET
                    name = '" 			. $this->name .
                "', level = '" 			. $this->level .
                "', password = '"		. $this->password .
                "', username = '"		. $this->username .
                "', email = '"			. $this->email .
                "', phone = '"                  . $this->telephone .
                "', address = '"		. $this->address .
                "' WHERE id = '" . $this->uid . "'";

            $upd = $this->connection()->update_data( $sql );

            return $upd;
        } else {
            $new = $this->connection()->insert_data("INSERT INTO {$dbprefix}profile (name, username, password, address, email, phone, level) VALUES
														('" . $this->name . 			"',
                                                                                                                 '" . $this->username . 			"',
														 '" . $this->password . 		"',
														 '" . $this->address . 			"',
														 '" . $this->email . 		"',
														 '" . $this->telephone . 			"',
														 '" . $this->level . 		"')
												 ");
            return !empty( $new ) ? true : false;
        }
    }

}
?>