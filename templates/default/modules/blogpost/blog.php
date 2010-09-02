<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
*/

require_once( dirname(dirname(dirname(dirname(dirname(__FILE__))))) . "/engine/start.php" );

function loadPosts() {
    global $dbprefix;
    $con = new Connection();

    $url = $_GET['url'];

    if( $url == "helpyou" ) {
        $code = "-1";
    } else if( $url == "hearyou" ) {
        $code = "-2";
    } else if( $url == "blog" ) {
        $code = $_GET['id'];

        $program = new Program( $code );
    }

    if( isset( $_GET['post'] ) ) {
        $sql = "select * from {$dbprefix}blogpost where bid = " . $code . " and id = " . $_GET['post'] . " order by created DESC";
    } else {
        $sql = "select * from {$dbprefix}blogpost where bid = " . $code . " order by created DESC";
    }

    $req = $con->make_request($sql);

    while( $post = mysql_fetch_array( $req, MYSQL_ASSOC ) ) {

        $dlink = base_url . "index.php?url=" . $url . ( ( $code != "-1" && $code != "-2" ) ? "&id=" . $code : "" ) . "&post=" . $post['id'];

        if( isset( $_GET['post'] ) ) {
            echo '<script type="text/javascript">';
            echo "document.title = '" . $post['tittle'] . " - CVC La Voz';";
            echo '</script>';
        }

        echo "<div id=\"ContPost-" . $post['id'] . "\" class=\"" . $post['id'] . "\">";
        echo '<div id="FechaPost">
                    <h5>' . $post['created'] . '</h5>
                  </div>
                  <div id="TitlePost">
                    <h3><a href="' . $dlink . '" id="directlink">' . $post['tittle'] . '</a></h3>
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

        $sql = "select * from {$dbprefix}blogcomments where postid = {$post['id']}";

        $creq = $con->make_request($sql);

        echo "<div id=\"comments-" . $post['id'] . "\" >"; //

        while( $comment = mysql_fetch_array( $creq, MYSQL_ASSOC ) ) {
            echo '<div id="Coment">
                        <h5>' . $comment['name'] . ' ' . $comment['created'] . '</h5>
                        <p>' . $comment['post'] . '</p>
                      </div>';
        }

        //<a href="mailto:' . $comment['email'] . '">  . '</a> '

        echo "</div>";

        echo '<script type="text/javascript">
    $(function(){

        $("#sendcomment-' . $post['id'] . '").click( function(){

            var url_send = "' . actions_url . 'addcomment.php";

            var name = $("input#name-' . $post['id'] . '").val();
            var email = $("input#email-' . $post['id'] . '").val();
            var comment = $("textarea#txtcomment-' . $post['id'] . '").val();

            if( name == "" || email == "" || comment == "" ) {
                $("#resp-' . $post['id'] . '").fadeIn("slow");
                $("#resp-' . $post['id'] . '").text("Faltan completar campos");

                setTimeout(function() {
                    $("#resp-' . $post['id'] . '").fadeOut("slow");
                }, 2000);

                return false;
            }

            if( email.indexOf("@") == -1 ) {
                $("#resp-' . $post['id'] . '").fadeIn("slow");
                $("#resp-' . $post['id'] . '").text("El correo electronico no es valido");

                setTimeout(function() {
                    $("#resp-' . $post['id'] . '").fadeOut("slow");
                }, 2000);

                return false;
            }

            var vars = "bid=' . $code . '&pid=' . $post['id'] . '&name=" + name + "&email=" + email + "&post=" + comment;
            $.ajax({
                type: "POST",
                url: url_send,
                data: vars,
                error: function( html ){
                    alert("Se produjo un error!");
                },
                success: function(html) {
                    $("#comments-' . $post['id'] . '").prepend(html);

                    $("input#name-' . $post['id'] . '").val("");
                    $("input#email-' . $post['id'] . '").val("");
                    $("textarea#txtcomment-' . $post['id'] . '").val("");
                }
            });
            return false;
        });
    });
</script>';

        echo '<div id="ComentPost">
                    <h4>Dejar comentario:</h4>
                  </div>
                  <div style="position:relative; width:505px; float:left">
                    <p>Nombre y Apellido:</p>
                    <input name="textfield" type="text" class="CampoTexto" id="name-' . $post['id'] . '" />
                    <p>Email:</p>
                    <input name="textfield" type="text" class="CampoTexto" id="email-' . $post['id'] . '" />
                    <p>Comentario:</p>
                    <textarea cols="" rows="5" class="CampoTexto" id="txtcomment-' . $post['id'] . '"></textarea>
                  </div>
                  <div style="position:relative; width:505px; float:left; margin:20px 0 20px 0">
                  <label>
                  <div id="resp-' . $post['id'] . '"></div>
                  <input type="button" name="button" id="sendcomment-' . $post['id'] . '" value="Comentar" class="ui-button ui-state-default ui-corner-all" />
                  </label>
                 </div>';

        echo "</div>";

        // Marcadores sociales

        echo '<div id="markers" >';

        $su = base_url . "index.php?url=" . $url . ( ( $code != "-1" && $code != "-2" ) ? "&id=" . $code : "" ) . "&post=" . $post['id'];

        $socialurl = getShortURL( $su );

        echo '<div id="socialmarker" >';
        echo '<a href="http://www.google.com/reader/link?url=' . $socialurl . '&title=' . utf8_encode( $post['tittle'] ) . '" ><img src="' . modules_url . 'blogpost/imgs/google.png" title="Compartir en Buzz" /></a>';
        echo '</div>';
        
        echo '<div id="socialmarker" >';
        echo '<a href="http://del.icio.us/post?url=' . $socialurl . '" ><img src="' . modules_url . 'blogpost/imgs/delicious.png" title="Compartir en Del.icio.us" /></a>';
        echo '</div>';

        echo '<div id="socialmarker" >';
        echo '<a href="javascript:void(window.open(\'http://www.myspace.com/Modules/PostTo/Pages/?u=' . $socialurl . '\',\'ptm\',\'height=450,width=440\').focus())" ><img src="' . modules_url . 'blogpost/imgs/myspace.png" title="Compartir en MySpace" /></a>';
        echo '</div>';

        echo '<div id="socialmarker" >';
        echo '<a href="http://www.linkedin.com/shareArticle?mini=true&url=' . $socialurl . '&title=' . utf8_encode( $post['tittle'] ) . '&source=http://cvclavoz.com" ><img src="' . modules_url . 'blogpost/imgs/linkedin.png" title="Compartir en LinkedIn" /></a>';
        echo '</div>';

        echo '<div id="socialmarker" >';
        echo '<a href="http://www.facebook.com/sharer.php?u=' . $socialurl . '" ><img src="' . modules_url . 'blogpost/imgs/facebook.png" title="Compartir en Facebook" /></a>';
        echo '</div>';

        echo '<div id="socialmarker" >';
        echo '<a href="http://twitter.com/home?status=' . utf8_encode( $post['tittle'] ) . ': ' . $socialurl . ' @cvclavoz" ><img src="' . modules_url . 'blogpost/imgs/twitter.png" title="Compartir en Twitter" /></a>';
        echo '</div>';

        echo "</div>";
        // -------------------
        
        echo "</div>";
    }
}

function getShortURL($url) {
    $user  = "sarriaroman";
    $akey  = "R_270a79d1f088faa0c769d45c90df9a8d";
    $path  = "http://api.bit.ly/shorten?version=2.0.1";
    $bitly = $path."&longUrl=".urlencode($url)."&login=".$user."&apiKey=".$akey;
    $data = file_get_contents($bitly);

    $obj = json_decode( $data );

    if ($obj->errorCode == 0) {
        return $obj->results->$url->shortUrl;
    } else {
        return $url;
    }
}

?>
