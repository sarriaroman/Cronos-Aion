<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
*/

require_once( dirname(dirname(dirname(dirname(dirname(__FILE__))))) . "/engine/start.php" );

if( isset( $_GET['pid'] ) ) {
    loadPosts( $_GET['pid'] );
}

function loadPosts( $pid = -1 ) {
    global $dbprefix;
    $con = new Connection();

    if( !isset( $user ) ) $user = check_session();

    if( $pid == -1 ) {
        if( ( $tmp = Program::get_first_pid( $user->uid ) ) ) {
            $pid = $tmp;
        } else {
            return;
        }
    }

    echo '<div id="blogid" style="display: none;">' . $pid . '</div>';

    $program = new Program( $pid );

    $sql = "select * from {$dbprefix}blogpost where bid = " . $program->id . " order by created desc limit 10";

    $req = $con->make_request($sql);

    while( $post = mysql_fetch_array( $req, MYSQL_ASSOC ) ) {
        echo "<div id=\"ContPost\">";
        echo '<div id="FechaPost">
                    <a onclick="$(\'#loadblogpost\').load(\'' . modules_url . 'admin_blogpost/actions.php?action=deletepost&pid=' . $pid . '&id=' . $post['id'] . '\');" style="font-size: 10px; cursor: pointer; float: right; margin-right: 5px;"><img src="' . base_url . 'backend/imgs/cross.png" /></a>
                    <h5>' . $post['created'] . '</h5>
                  </div>
                  <div id="TitlePost">
                    <h3>' . $post['tittle'] . '</h3>
                  </div>
                  <div id="TextoPost">' . $post['post'] . '</div>';

        if( $post['bid'] != -1 && $post['bid'] != -2 ) {
            echo '<div id="SocialPost">
                        <p>' . system_message("post:createdby") . $post['created'] . ' (' . $program->name . ') ' . '</p>
                    </div>';
        }

        echo '<div id="ComentPost">
                            <h4><a style="cursor: pointer;" onclick="if( $(\'#commentdiv-' . $post['id'] . '\').css(\'display\') != \'none\'){
                                                    $(\'#commentdiv-' . $post['id'] . '\').hide();
                                                }else{
                                                    $(\'#commentdiv-' . $post['id'] . '\').show();
                                                }">Ver/Ocultar Comentarios</a></h4>
                        </div>';

        echo "<div id=\"commentdiv-" . $post['id'] . "\" style=\"display: none;\">"; //

        $sql = "select * from {$dbprefix}blogcomments where postid = {$post['id']} order by id asc";

        $creq = $con->make_request($sql);

        echo "<div id=\"comments-" . $post['id'] . "\" >"; //

        while( $comment = mysql_fetch_array( $creq, MYSQL_ASSOC ) ) {
            echo '<div id="Coment">
                        <h5><a href="mailto:' . $comment['email'] . '">' . $comment['name'] . '</a> ' . $comment['created'] . '</h5>
                        <p>' . $comment['post'] . '</p>
                      </div>';
        }

        echo "</div>";

        echo "</div>";
        echo "</div>";
    }
}

function load_blogs() {
    global $dbprefix;
    $con = new Connection();

    if( !isset( $user ) ) $user = check_session();

    $sql = "select id, name from {$dbprefix}programs where admin_uid = '{$user->uid}'";

    $req = $con->make_request( $sql );

    echo '<script type="text/javascript">
            $(function(){
                $("#cbblogs").change( function(){
                    $("#loadblogpost").load("' . modules_url . 'admin_blogpost/blog.php?pid=" + $("#cbblogs").val() );
                });
            });
          </script>';

    echo "Seleccione el blog que desea editar:<br/>";

    echo '<select id="cbblogs" style="width: 250px;" >';

    while( $prog = mysql_fetch_array( $req, MYSQL_ASSOC ) ) {
        echo '<option value="' . $prog['id'] . '">' . $prog['name'] . '</option>';
    }

    echo '</select>';
}

?>
