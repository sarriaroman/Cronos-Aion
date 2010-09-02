<?php

require_once( dirname(dirname(__FILE__)) . "/engine/start.php" );

echo '<object width="420" height="267">
                <param name="movie" value="' . get_config( "home:video" . $_GET['number'] ) . '" />
                <param name="allowFullScreen" value="true" />
                <param name="allowscriptaccess" value="always" />
                <embed src="' . get_config( "home:video" . $_GET['number'] ) . '" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" width="420" height="267">
            </object>';

?>
