<? 
switch( $_GET['url'] ) {
    case "home":
        include( "home.html" );
        break;

    case "red":
        $mail = $_REQUEST['email'];
        $pass = $_REQUEST['psw'];
        if( !empty( $mail ) && !empty( $pass ) ) {
            if( ($user = User::validate( $mail, $pass )) ) {
                if( $user->banned == true ) {
                    $error_message = get_message("red:banneduser");
                    include( "red.html" );

                    break;
                }
                if( create_session( $user->email ) ) {
                    include("red_logon.html");
                } else {
                    include( "red.html" );
                }
            } else {
                $error_message = get_message("red:loginerror");
                include( "red.html" );

                break;
            }
        } else {
            if( ($user = check_session()) ) {
                if( $user->banned == true ) {
                    $error_message = get_message("red:banneduser");
                    include( "red.html" );

                    break;
                }
                switch( $_GET['action'] ) {
                    case "close":
                        close_session();
                        break;

                    case "data":
                        include("red_datos.html");
                        break;

                    case "mypodcast":
                        include("red_audios.html");
                        break;

                    case "upload":
                        include("red_editar.html");
                        break;

                    case "edit":
                        put_var("pid", $_GET['id']);
                        include("red_editar.html");
                        break;

                    case "blog":
                        if( !User::is_blog_admin( $user->uid ) ) {
                            header( "Location: " . base_url . "index.php?url=red" );
                        } else {
                            include("red_blog.html");
                        }
                        break;

                    default:
                        include("red_logon.html");
                        break;
                }
            } else {
                if( isset( $_GET['action']) || isset( $_GET['section'] ) ) $error_message = get_message("red:ilegalaccess");

                include( "red.html" );
            }
        }
        break;

    case "redsignup":
        include( "red_signup.html" );
        break;

    case "institutional":
        include( "institutional.html" );
        break;

    case "programmes":
        include( "programmes.html" );
        break;

    case "contact":
        include( "contact.html" );
        break;

    case "helpyou":
        include( "wehelpyou.html" );
        break;

    case "hearyou":
        include( "wehearyou.html" );
        break;

    case "blog":
        include( "blog.html" );
        break;

    case "online":
        include( "modules/online/online.html" );
        break;

    case "chat":
        include( "modules/chat/main.html" );
        break;

    case "mobilechat":
        include( "modules/mobilechat/main.html" );
        break;

    default:
        include( "home.html" );
        break;
}
?>