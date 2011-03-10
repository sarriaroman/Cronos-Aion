<?php $session = check_session("sitio");
global $CONFIG;


if($session)
    $user = Users::getUser($session[1]);

function getClass($val) {
    $permalinks = explode("/", $_GET['url']);

    if( $permalinks[0] == $val ) return "menu-selected";
    else return "";
}
?>
