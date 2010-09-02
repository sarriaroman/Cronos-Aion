<?php
/* 
 * The BackEnd For Engine
 *
 * The cool things arrive late... but arrive!
 *
 * Román A. Sarria
 */


    if( $user = check_session() ) {
        if( $user->is_level( User::$admin ) ) {
            include("index.html");
        } else {
            header("Location:" . base_url . "index.php?url=red" );
        }
    } else {
        include("login.html");
    }

?>
