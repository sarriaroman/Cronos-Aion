<?php

    // Friendly url explode
    $permalinks = explode("/",$_GET['url']);

    if( ( $email = check_session() ) ) {
        // On Session
    } else {
        load_module( $permalinks[0] );
    }

?>
