<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
*/

function getLastHelpYou() {
    global $dbprefix;
    $con = new Connection();

    $url = $_GET['url'];

    $sql = "select c.created, c.post from {$dbprefix}blogcomments as c
            inner join {$dbprefix}blogpost as p
            where c.postid = p.id
            and p.bid = -1
            order by c.created DESC
            limit 1";

    $req = $con->make_request($sql);

    $post = mysql_fetch_array( $req );

    echo "<p>" . $post['created'] . "</p>";
    if( strlen( $post['post'] ) > 100 ) {
        echo "<p>" . substr( $post['post'], 0, 100 ) . "..." . "</p>";
    } else {
        echo "<p>" . $post['post'] . "</p>";
    }
}

function getLastHearYou() {
    global $dbprefix;
    $con = new Connection();

    $url = $_GET['url'];

    $sql = "select c.created, c.post from {$dbprefix}blogcomments as c
            inner join {$dbprefix}blogpost as p
            where c.postid = p.id
            and p.bid = -2
            order by c.created DESC
            limit 1";

    $req = $con->make_request($sql);

    $post = mysql_fetch_array( $req );

    echo "<p>" . $post['created'] . "</p>";
    if( strlen( $post['post'] ) > 100 ) {
        echo "<p>" . substr( $post['post'], 0, 100 ) . "..." . "</p>";
    } else {
        echo "<p>" . $post['post'] . "</p>";
    }
}

function getLastChat() {
    global $dbprefix;
    $con = new Connection();

    $sql = "select message, created from {$dbprefix}chat
            order by id DESC
            limit 1";

    $req = $con->make_request($sql);

    $post = mysql_fetch_array( $req );

    echo "<p>" . $post['created'] . "</p>";

    $len = 100;

    if( strlen( $post['message'] ) > $len ) {
        echo "<p>" . substr( strip_tags( $post['message'] ), 0, $len ) . "..." . "</p>";
    } else {
        echo "<p>" . strip_tags( $post['message'] ) . "</p>";
    }
}

function getChatLink() {
    $browser = new Browser();
    if( $browser->getBrowser() == Browser::BROWSER_ANDROID ||
            $browser->getBrowser() == Browser::BROWSER_IPHONE ) {
        $open = "window.location = '" . base_url . "index.php?url=mobilechat';";
    } else {
        $open = "window.open('" . base_url . "index.php?url=chat','Chat','menubar=no,toolbar=no,resizable=no,scrollbars=no,status=no,width=500,height=600');";
    }

    if( get_config('chat:enabled') == 'yes' ) {
        echo 'onclick="' .  $open . '"';
    } else {
        echo 'onclick="alert(\'El chat esta actualmente deshabilitado!\');"';
    }
}

function getHelpLink() {
        echo 'onclick="window.location=\'' . get_config("menu:wehelp") . '\';"';
}

function getHearLink() {
        echo 'onclick="window.location=\'' . get_config("menu:welisten") . '\';"';
}

?>
