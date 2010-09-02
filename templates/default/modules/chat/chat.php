<?php
require_once( dirname(dirname(dirname(dirname(dirname(__FILE__))))) . "/engine/start.php" );

$action = ( isset ($_GET['action'] ) ) ? $_GET['action'] : $_POST['action'] ;

switch ( $action ) {

    case "add":
        global $dbprefix;

        $con = new Connection();

        $name = strip_tags( addSlashes( $_POST['name'] ), "<a>");

        $name = bbcode_format( $name );
        /*$name = preg_replace("/<.*?>/", "", $name );*/

        $post = strip_tags( addSlashes( $_POST['message'] ) );
        /*$post = preg_replace("/<.*?>/", "", $post );*/

        $post = parseString( $post );

        $sql = "INSERT INTO {$dbprefix}chat (name, image, message, created) VALUES
                    (\"" . $name . "\",
                     '" . $_POST['image'] . "',
                     \"" .  $post . "\",
        	    NOW())";

        $response = $con->insert_data( $sql );

        if( !$response ) {
            echo "true";
        }
        break;

    case "load":
        global $dbprefix;

        $con = new Connection();

        $limit = get_config("chat:limit");

        $row_count = mysql_num_rows( $con->make_request( "SELECT id FROM {$dbprefix}chat" ) ) - $limit;

        if( $row_count < 0 ) $row_count = 0;

        $sql = "select id, name, image, message, created, UNIX_TIMESTAMP(created) AS fecha from {$dbprefix}chat order by id ASC limit " . $row_count . ", " . $limit;

        $response = $con->make_request( $sql );

        $text = "";
        $lastId = -1;
        while( $message = mysql_fetch_array( $response, MYSQL_ASSOC ) ) {
            if( $message['id'] % 2 == 0 ) $paridad = "msgpar";
            else $paridad = "msgimpar";
            $text .= '<div id="post" class="' . $paridad . '">
                    <div id="photo"><img width="46" height="46" src="' . $message['image'] . '" /></div>
                    <div id="msg">
			<div id="post-name">' . $message['name'] . '</div>
			<div id="post-message">' . $message['message'] . '</div>
                    </div>
                    <div class="timeid-' . $message['id'] . '" style="float:right; right: 2px; bottom: 1px; font-size: 10px; color: gray; display: block;">creado: ' . $message['created'] . '</div>
                  </div>';

            $lastId = $message['id'];
        }

//        <script type="text/javascript">
//                        $(function(){
//                            setInterval(function(){
//                                var estampa = getElapsed(' . $message['fecha'] . ');
//
//                                $(".timeid-' . $message['id'] . '").text( "hace " + estampa );
//                            }, 60000 );
//                        });
//                    </script>

        header('Content-type: application/json');

        echo json_encode( array( "text" => $text, "last" => $lastId ) );

        break;

    case "reload":
        global $dbprefix;

        $con = new Connection();

        $sql = "select id, name, image, message, created, UNIX_TIMESTAMP(created) AS fecha from {$dbprefix}chat where id > " . $_POST['last'] . " order by id ASC";

        $response = $con->make_request( $sql );

        $text = "";
        $lastId = -1;
        while( $message = mysql_fetch_array( $response, MYSQL_ASSOC ) ) {
            if( $message['id'] % 2 == 0 ) $paridad = "msgpar";
            else $paridad = "msgimpar";
            $text .= '<div id="post" class="' . $paridad . '">
                    <div id="photo"><img width="46" height="46" src="' . $message['image'] . '" /></div>
                    <div id="msg">
			<div id="post-name">' . $message['name'] . '</div>
			<div id="post-message">' . $message['message'] . '</div>
                    </div>
                    <div class="timeid-' . $message['id'] . '" style="float:right; right: 2px; bottom: 1px; font-size: 10px; color: gray; display: block;">creado: ' . $message['created'] . '</div>
                  </div>';

            $lastId = $message['id'];
        }

//                            <script type="text/javascript">
//                        $(function(){
//                            setInterval(function(){
//                                var estampa = getElapsed(' . $message['fecha'] . ');
//
//                                $(".timeid-' . $message['id'] . '").text( "hace " + estampa );
//                            }, 60000 );
//                        });
//                    </script>

        header('Content-type: application/json');

        echo json_encode( array( "text" => $text, "last" => $lastId ) );

        break;

    case "time":
        global $dbprefix;

        $con = new Connection();

        $sql = "select created, UNIX_TIMESTAMP(created) AS fecha from {$dbprefix}chat where id = '" . $_GET['id'] . "'";

        $response = $con->make_request( $sql );

        $time = mysql_fetch_array( $response, MYSQL_ASSOC );

        echo 'hace ' . hace( $message['fecha'] );

        break;

}

/*
 
 */

function parseString( $post ) {
    $tam = "16";

    $smiley_url = template_url . "imgs/";

    $smileys = array(
            ":(|)" => "<img src='" . $smiley_url . "smileys/monkey.png' width='$tam' height='$tam' />",
            "=D" => "<img src='" . $smiley_url . "smileys/smile-big.png' width='$tam' height='$tam' />",
            "=)" => "<img src='" . $smiley_url . "smileys/smile.png' width='$tam' height='$tam' />",
            ":)" => "<img src='" . $smiley_url . "smileys/smile.png' width='$tam' height='$tam' />",
            ";)" => "<img src='" . $smiley_url . "smileys/wink.png' width='$tam' height='$tam' />",
            ":(" => "<img src='" . $smiley_url . "smileys/sad.png' width='$tam' height='$tam' />",
            ":D" => "<img src='" . $smiley_url . "smileys/laugh.png' width='$tam' height='$tam' />",
            "x-(" => "<img src='" . $smiley_url . "smileys/angry.png' width='$tam' height='$tam' />",
            ":@" => "<img src='" . $smiley_url . "smileys/angry.png' width='$tam' height='$tam' />",
            "B-)" => "<img src='" . $smiley_url . "smileys/cool.png' width='$tam' height='$tam' />",
            ":'(" => "<img src='" . $smiley_url . "smileys/crying.png' width='$tam' height='$tam' />",
            "\m/" => "<img src='" . $smiley_url . "smileys/desire.png' width='$tam' height='$tam' />",
            ":-o" => "<img src='" . $smiley_url . "smileys/shock.png' width='$tam' height='$tam' />",
            ":-S" => "<img src='" . $smiley_url . "smileys/confused.png' width='$tam' height='$tam' />",
            ":S" => "<img src='" . $smiley_url . "smileys/confused.png' width='$tam' height='$tam' />",
            ":-|" => "<img src='" . $smiley_url . "smileys/dazed.png' width='$tam' height='$tam' />",
            ":P" => "<img src='" . $smiley_url . "smileys/tongue.png' width='$tam' height='$tam' />",
            ":-D" => "<img src='" . $smiley_url . "smileys/laugh.png' width='$tam' height='$tam' />",
            ";-)" => "<img src='" . $smiley_url . "smileys/wink.png' width='$tam' height='$tam' />",
            ";^)" => "<img src='" . $smiley_url . "smileys/sarcastic.png' width='$tam' height='$tam' />",
            "(l)" => "<img src='" . $smiley_url . "smileys/love.png' width='$tam' height='$tam' />",
            "(u)" => "<img src='" . $smiley_url . "smileys/love-over.png' width='$tam' height='$tam' />"

    );

    $post = str_ireplace(array_keys($smileys), array_values($smileys), $post);

    //$post = str_ireplace("\n", "", $post);

    $post = bbcode_format( $post );

    //$post = htmlentities( $post );
    $post = str_replace("&lt;","<",$post);
    $post = str_replace("&gt;",">",$post);
    $post = str_replace("&quot;",'"',$post);
    $post = str_replace("&amp;",'&',$post);

    $ent = array(
            'ě' => '&#283;',
            'Ě' => '&#282;',
            'š' => '&#353;',
            'Š' => '&#352;',
            'č' => '&#269;',
            'Č' => '&#268;',
            'ř' => '&#345;',
            'Ř' => '&#344;',
            'ž' => '&#382;',
            'Ž' => '&#381;',
            'ý' => '&#253;',
            'Ý' => '&#221;',
            'á' => '&#225;',
            'Á' => '&#193;',
            'í' => '&#237;',
            'Í' => '&#205;',
            'é' => '&#233;',
            'É' => '&#201;',
            'ú' => '&#250;',
            'ů' => '&#367;',
            'Ů' => '&#366;',
            'ď' => '&#271;',
            'Ď' => '&#270;',
            'ť' => '&#357;',
            'Ť' => '&#356;',
            'ň' => '&#328;',
            'Ň' => '&#327;',
            'Ã' => 'ñ',
            'ñ' => '&ntilde;',
            'Ñ' => '&Ntilde;'
    );

    //$post = strtr($post, $ent);

    //$post = str_ireplace("&lt;", "<", $post);
    //$post = str_ireplace("&gt;", ">", $post);

    return $post;
}

?>