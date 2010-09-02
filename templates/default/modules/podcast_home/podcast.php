<?

if( isset( $_GET['offset'] ) ) {
    load_podcast( $_GET['offset'] );
}

function load_podcast( $offset = 0 ) {
    global $dbprefix;

    $con = new Connection();

    $position = $offset * 5;

    $sql = "select id from {$dbprefix}podcast where home = '1' order by upload_date DESC LIMIT {$position}, 5";

    if( $rst = $con->make_request( $sql ) ) {

        while( $pod = mysql_fetch_array( $rst, MYSQL_ASSOC ) ) {
            $podcast = new Podcast( $pod['id'] );

            include( modules_dir . 'podcast_home/podcast.html' );
            //echo file_get_contents( modules_dir . 'podcast_home/podcast.html' );
        }
    }

    /*$count = Podcast::podcast_count(-1, "where home = '1'");

    if( $count == 0 ) return;

    $total = ceil( $count / 10 );

    echo '<div id="ModuloPodcastHome">';
    if( $offset > 0 ) {
        echo '<a style="cursor: pointer;" onclick="$(\'#podcast-home\').load(\'' . modules_url . "podcast_home/podcast.php?offset=" . ( $offset - 1 ) . '\');"> << </a>';
        echo ' | ';
    }
    if( $offset < ( $total - 1 ) ) {
        echo '<a style="cursor: pointer;" onclick="$(\'#podcast-home\').load(\'' . modules_url . "podcast_home/podcast.php?offset=" . ( $offset + 1 ) . '\');"> >> </a>';
    }
    echo '</div>';*/
}

?>