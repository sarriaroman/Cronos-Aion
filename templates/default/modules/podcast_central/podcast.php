<?
require_once( dirname(dirname(dirname(dirname(dirname(__FILE__))))) . "/engine/start.php" );

if( isset( $_GET['action'] ) ) {
    if( $_GET['action'] == "paginator" ) {
        if( isset( $_GET['offset'] ) ) {
            load_podcast( $_GET['offset'], $_GET['place'] );
        }
    } else if( $_GET['action'] == "delete" ) {
        deletePodcast( $_GET['pid'] );
    } else if( $_GET['action'] == "top" ) {
        load_more_listen_podcast();
    }

}

function load_podcast( $offset = 0, $place = "mine" ) {
    global $dbprefix;

    $con = new Connection();

    $user = check_session();

    $sp = ( $place == "mine" ) ? " where uid = " . $user->uid . " " : " where internal = '1' ";

    $position = $offset * 10;

    $sql = "select id from {$dbprefix}podcast $sp order by date LIMIT {$position}, 10";

    $rst = $con->make_request( $sql );

    echo "<div id=\"PodcastOut\">";

    $i = 0;
    while( $pod = mysql_fetch_array( $rst, MYSQL_ASSOC ) ) {
        $podcast = new Podcast( $pod['id'] );

        $limit = 120;
        if( strlen( $podcast->Description ) > $limit ) {
            $podcast->Description = substr( $podcast->Description, 0, $limit ) . "...";
        }

        if( ($i % 2) == 0 ) include( modules_dir . 'podcast_central/podcast_impar.html' );
        else include( modules_dir . 'podcast_central/podcast_par.html' );

        $i++;
    }

    echo "</div>";

    paginator( ($place == "mine") ? $user->uid : -1 , ($place == "mine") ? $place : "others" );
}

function load_more_listen_podcast( ) {
    global $dbprefix;

    $con = new Connection();

    $user = check_session();

    $sql = "select id from {$dbprefix}podcast where home = '1' or internal = '1' order by listen_count desc LIMIT 0, 10";

    $rst = $con->make_request( $sql );

    echo "<div id=\"PodcastOut\">";

    $i = 0;
    while( $pod = mysql_fetch_array( $rst, MYSQL_ASSOC ) ) {
        $podcast = new Podcast( $pod['id'] );

        $listen_count = $podcast->Listen_count;

        $limit = 120;
        if( strlen( $podcast->Description ) > $limit ) {
            $podcast->Description = substr( $podcast->Description, 0, $limit ) . "...";
        }

        if( ($i % 2) == 0 ) include( modules_dir . 'podcast_central/podcast_impar.html' );
        else include( modules_dir . 'podcast_central/podcast_par.html' );

        $i++;
    }

    echo "</div>";
}

function paginator( $uid = -1, $place = "mine" ) {
    if( $uid == -1 ) $where = "where internal = '1'";
    $count = Podcast::podcast_count($uid, $where);

    if( $count == 0 ) return;

    $cant = ceil( $count / 10 );

    echo "<div id=\"PagListaPod\">";
    echo "<p><strong>P&aacute;gina</strong>: ";
    for( $i = 1 ; $i <= $cant ; $i++ ) {
        $n = ($i -1);
        echo "<a style=\"cursor: pointer;\" onclick=\"$('#podcast-load').load('" . modules_url . "podcast_central/podcast.php?action=paginator&offset=$n&place=$place');\">$i</a>";
    }
    echo "</div>";
}

function deletePodcast( $pid ) {
    global $dbprefix;

    $con = new Connection();

    $sql = "delete from {$dbprefix}podcast where id = '{$pid}'";

    // Programar borrado de archivo desde el servidor
    // Usar codigo que se usa para borrar la foto del usuario ;)

    if( $con->delete_data($sql) ) {
        load_podcast();
    } else {
        load_podcast();
    }
}

?>