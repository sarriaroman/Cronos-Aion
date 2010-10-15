<?php
if( ($email = check_session("admin")) ) {
    $user = new User( $email );
    if( $user->is_level( User::$admin ) ) {
        if( isset( $_GET['section'] ) ) {
            admin_section( $_GET['section'] );
        } else {
            admin_section("home");
        }
    } else {
        if( $_GET['section'] == 'restore' )
            admin_section('restore');
        else
            admin_section("login");
    }
} else {
    if( $_GET['section'] == 'restore' )
        admin_section('restore');
    else
        admin_section("login");
}

?>
