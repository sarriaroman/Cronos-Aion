<?php

function load_posters() {
    global $dbprefix;

    $con = new Connection();

    $sql = "select uid, COUNT(id) as total from {$dbprefix}podcast group by uid order by total desc limit 0,10";

    $rst = $con->make_request( $sql );

    $i = 0;
    while( $pod = mysql_fetch_array( $rst, MYSQL_ASSOC ) ) {
        $usertop = User::get_user_by_id( $pod['uid'] );
        $podtop = new Podcast( Podcast::last_id( $pod['uid'] ) );

        if( ($i % 2) == 0 ) include( modules_dir . 'most_posters/most_left.html' );
        else include( modules_dir . 'most_posters/most_right.html' );

        $i++;
    }
}

?>
