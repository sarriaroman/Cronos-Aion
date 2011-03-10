<?php

class Users extends DataObject {

    function __construct($id = "") {
        global $dbprefix;

        parent::__construct("{$dbprefix}users", $id);
    }

    public static function validate($email, $password) {
        global $dbprefix;

        $conn = new Connection();
        if (strpos($email, "@") == true) {
            $req = $conn->make_request("SELECT id, password FROM {$dbprefix}users WHERE email = '{$email}'");
        } else {
            $req = $conn->make_request("SELECT id, email, password FROM {$dbprefix}users WHERE username = '{$email}'");
        }

        $rst = mysql_fetch_array($req, MYSQL_ASSOC);

        if (!empty($rst)) {
            if ($rst['password'] == md5($password)) {
                return new Users( $rst['id'] );
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public static function getUser($email) {
        global $dbprefix;

        $conn = new Connection();
        if (strpos($email, "@") == true) {
            $req = $conn->make_request("SELECT id FROM {$dbprefix}users WHERE email = '{$email}'");
        } else {
            $req = $conn->make_request("SELECT id FROM {$dbprefix}users WHERE username = '{$email}'");
        }

        $rst = mysql_fetch_array($req, MYSQL_ASSOC);

        return new Users($rst['id']);
    }

    public static function exist($email) {
        global $dbprefix;

        $conn = new Connection();
        if (strpos($email, "@") == true) {
            $req = $conn->make_request("SELECT id FROM {$dbprefix}users WHERE email = '{$email}'");
        } else {
            $req = $conn->make_request("SELECT id FROM {$dbprefix}users WHERE username = '{$email}'");
        }

        if (mysql_num_rows($req) == 1)
            return true;
        else
            return false;
    }
}

?>
