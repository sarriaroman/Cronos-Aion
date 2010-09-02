<?php
require_once( dirname(dirname(dirname(dirname(dirname(__FILE__))))) . "/engine/start.php" );

$action = ( isset ($_GET['action'] ) ) ? $_GET['action'] : $_POST['action'] ;

switch ( $action ) {

    case "add":
        global $dbprefix;

        $con = new Connection();

        $name = strip_tags( addSlashes( $_POST['name'] ), "<a>");
        /*$name = preg_replace("/<.*?>/", "", $name );*/

        $post = strip_tags( addSlashes( $_POST['message'] ) );
        $post = preg_replace("/<.*?>/", "", $post );

        //$post = str_ireplace("\n", "", $post);

        $post = bbcode_format( $post );

        $sql = "INSERT INTO {$dbprefix}chat (name, image, message, created) VALUES
                    ('" . $name . "',
                     '" . $_POST['image'] . "',
                     \"" .  $post . "\",
        	    NOW())";

        $response = $con->insert_data( $sql );

        if( !$response ) {
//            echo '<div id="post">
//                    <div id="photo"><img src="' . $_POST['image'] . '" /></div>
//                    <div id="msg">
//			<div id="post-name">' . $_POST['name'] . '</div>
//			<div id="post-message">' . $post . '</div>
//                    </div>
//                  </div>';
            echo "true";
        }
        break;

    case "load":
        global $dbprefix;

        $con = new Connection();

        $limit = get_config("chat:limit");

        $row_count = mysql_num_rows( $con->make_request( "SELECT id FROM {$dbprefix}chat" ) ) - $limit;

        if( $row_count < 0 ) $row_count = 0;

        $sql = "select id, name, image, message from {$dbprefix}chat order by id ASC limit " . $row_count . ", " . $limit;

        $response = $con->make_request( $sql );

        $text = "";
        $lastId = -1;
        while( $message = mysql_fetch_array( $response, MYSQL_ASSOC ) ) {
            $text .= '<li class="store" style="height: auto;" id="' . $message['id'] . '">
                    <img alt="list" src="' . $message['image'] . '" style="float:left; margin-right: 6px;" />
                    
                    <span class="comment" style="margin-left: 10px;">' . strip_tags( $message['name'] ) . '</span>
                    <span style="margin-top: 20px; margin-bottom: 4px; margin-left: 5px; margin-right: 5px; display:block;">' . $message['message'] . '</span>
                    </li>';

            //<span class="image" style="background-image: url(\'' . $message['image'] . '\');"  ></span>
            $lastId = $message['id'];
        }

        header('Content-type: application/json');

        echo json_encode( array( "text" => $text, "last" => $lastId ) );

        break;

    case "reload":
        global $dbprefix;

        $con = new Connection();

        $sql = "select id, name, image, message from {$dbprefix}chat where id > " . $_POST['last'] . " order by id ASC";

        $response = $con->make_request( $sql );

        $text = "";
        $lastId = -1;
        while( $message = mysql_fetch_array( $response, MYSQL_ASSOC ) ) {
            $text .= '<li class="store" style="height: auto;" id="' . $message['id'] . '">
                    <img alt="list" src="' . $message['image'] . '" style="float:left; margin-right: 6px;" />

                    <span class="comment" style="margin-left: 10px;">' . strip_tags( $message['name'] ) . '</span>
                    <span style="margin-top: 20px; margin-bottom: 4px; margin-left: 5px; margin-right: 5px; display:block;">' . $message['message'] . '</span>
                    </li>';

            $lastId = $message['id'];
        }

        header('Content-type: application/json');

        echo json_encode( array( "text" => $text, "last" => $lastId ) );

        break;

}
?>