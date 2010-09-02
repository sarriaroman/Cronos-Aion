<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
*/

/**
 * Description of accouns
 *
 * @author ESCRITORIO
 */
global $dbprefix;

$con = new Connection();

$sql = "select id, name, email, level from {$dbprefix}profile";

$req = $con->make_request($sql);

while( $profile = mysql_fetch_array( $req, MYSQL_ASSOC ) ) {
    echo '<div style="border-bottom: black 1px solid;">';
    echo $profile['name'] . "<br />" . $profile['email'] . "<br />";
    echo '</div>';
}
?>
