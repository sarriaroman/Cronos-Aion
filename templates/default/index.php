<?
    $permalinks = explode("/",$_GET['url']);

    if( !$permalinks[0] ) {
        load_module("home");
    } else load_section( $permalinks );
?>