<?
require_once( dirname(dirname(dirname(dirname(dirname(__FILE__))))) . "/engine/start.php" );

if( isset( $_GET['offset'] ) ) {
    load_podcast( $_GET['offset'] );
}

if( isset( $_GET['top'] ) ) {
    load_more_listen_podcast();
}

function load_podcast( $offset = 0 ) {
    global $dbprefix;

    $con = new Connection();

    $user = check_session();

    $program = new Program( $_GET['id'] ) ;

    $sp = " where uid = " . ( ($program->admin_uid == "") ? $_GET['uid'] : $program->admin_uid ) . " and blog = '1' ";

    $position = $offset * 5;

    $sql = "select id from {$dbprefix}podcast {$sp} order by date LIMIT {$position}, 5";

    $rst = $con->make_request( $sql );

    //echo '<div id="PlayerPodcastsBlog">';

    $i = 0;
    while( $pod = mysql_fetch_array( $rst, MYSQL_ASSOC ) ) {
        $podcast = new Podcast( $pod['id'] );

        $limit = 120;
        if( strlen( $podcast->Description ) > $limit ) {
            $podcast->Description = substr( $podcast->Description, 0, $limit ) . "...";
        }

        if( ($i % 2) == 0 ) include( modules_dir . 'podcast_audioblogs/podcast_impar.html' );
        else include( modules_dir . 'podcast_audioblogs/podcast_par.html' );

        $i++;
    }

    $count = Podcast::podcast_count(-1, $sp);

    if( $count == 0 ) return;

    $total = ceil( $count / 5 );

    echo '<div id="PagListaPod" style="height=25px;">';
    if( $offset > 0 ) {
        echo '<a style="color: white; float: right; cursor: pointer;" onclick="$(\'#podcast-load\').load(\'' . modules_url . "podcast_audioblogs/podcast.php?uid=" . ( ($program->admin_uid == "") ? $_GET['uid'] : $program->admin_uid ) . "&offset=" . ( $offset - 1 ) . '\');"> << </a>';
    }
    if( $offset < ( $total - 1 ) ) {
        echo '<a style="color: white; float: right; cursor: pointer;" onclick="$(\'#podcast-load\').load(\'' . modules_url . "podcast_audioblogs/podcast.php?uid=" . ( ($program->admin_uid == "") ? $_GET['uid'] : $program->admin_uid ) . "&offset=" . ( $offset + 1 ) . '\');"> >> </a>';
    }
    echo '</div>';
}

?>