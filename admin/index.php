<?php
if( ($email = check_session("admin")) ) {
    $user = new Users( $email );
    //if( $user->is_level( Users::$admin ) ) {
        if( isset( $_GET['section'] ) ) {
            admin_section( $_GET['section'], $_GET['plugin'] );
        } else {
            admin_section("home");
        }
    /*} else {
        if( $_GET['section'] == 'restore' )
            admin_section('restore');
        else
            admin_section("login");
    }*/
} else {
    if( $_GET['section'] == 'restore' )
        admin_section('restore');
    else
        admin_section("login");
}

?>
