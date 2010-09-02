<?php

function loadhearpost( ) {
    global $dbprefix;
    $con = new Connection();

    $section = "-2";

    $sql = "select * from {$dbprefix}blogpost where bid = {$section} order by created desc";

    $req = $con->make_request($sql);

    echo "<div id=\"ContPost\">";
    while( $post = mysql_fetch_array( $req, MYSQL_ASSOC ) ) {

        echo '<h3 class="ui-widget-header ui-corner-all">(' . $post['created'] . ') ' . $post['tittle'];

        echo '<a onclick="deleteHearPost(' . $post['id'] . ', \'' . $post['tittle'] . '\');" title="Borrar post" style="font-size: 10px; cursor: pointer; float: right; margin-right: 5px;"><img src="' . base_url . 'backend/imgs/cross.png" /></a>';

        echo '<a style="font-size: 10px; cursor: pointer; float: right; margin-right: 5px;" title="Ver post" onclick="if( $(\'#postdiv-' . $post['id'] . '\').css(\'display\') != \'none\'){
                                                    $(\'#postdiv-' . $post['id'] . '\').hide();
                                                }else{
                                                    $(\'#postdiv-' . $post['id'] . '\').show();
                                                }"><img src="' . base_url . 'backend/imgs/eye.png" /></a>';
        echo '</h3>';

        //href="' . actions_url . 'admin.php?action=deletepost&id=' . $post['id'] . '"

        echo "<div id=\"postdiv-" . $post['id'] . "\" style=\"display: none;\">"; //
        echo '<div id="TextoPost">' . $post['post'] . '</div>';

        if( $post['bid'] != -1 && $post['bid'] != -2 ) {
            echo '<div id="SocialPost">
                        <p>' . system_message("post:createdby") . $post['created'] . '</p>
                    </div>';
        }

        echo '<div id="ComentPost">
                            <h4><a style="font-size: 10px; cursor: pointer;" onclick="if( $(\'#commentdiv-' . $post['id'] . '\').css(\'display\') != \'none\'){
                                                    $(\'#commentdiv-' . $post['id'] . '\').hide();
                                                }else{
                                                    $(\'#commentdiv-' . $post['id'] . '\').show();
                                                }">Ver/Ocultar Comentarios</a></h4>
                        </div>';

        echo "<div id=\"commentdiv-" . $post['id'] . "\" style=\"display: none;\">"; //

        $sql = "select * from {$dbprefix}blogcomments where postid = {$post['id']}";

        $creq = $con->make_request($sql);

        while( $comment = mysql_fetch_array( $creq, MYSQL_ASSOC ) ) {
            echo '<a style="font-size: 10px; cursor: pointer; float: right; margin-right: 5px;" onclick="deleteComment(' . $comment['id'] . ',' . $section . ',\'' . $comment['name'] . '\');"><img src="' . base_url . 'backend/imgs/cross.png" /></a>';
            echo '<div id="Coment">
                        <h5><a href="mailto:' . $comment['email'] . '">' . $comment['name'] . '</a> ' . $comment['created'] . '</h5>
                        <p>' . $comment['post'] . '</p>
                      </div>';
        }

        //include( modules_dir . "/blogpost/postcomment.html");

        echo "</div>";

        echo "</div>";
    }
    echo "</div>";

}

?>
