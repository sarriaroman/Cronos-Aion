<?php

require_once( dirname(dirname(__FILE__)) . "/engine/start.php" );

$width = $_GET['w'];

$purl = "http://www.live365.com/play/cvclavoz/";

$browser = new Browser();
if( $browser->getBrowser() == Browser::BROWSER_CHROME ||
        $browser->getBrowser() == Browser::BROWSER_SAFARI ) {
    echo "<audio src='$purl' controls='controls' autoplay='autoplay' style='width:" . $width . "px;' ></audio>";
} else if( $browser->getBrowser() == Browser::BROWSER_IPHONE ) {
    echo "<audio src='{$purl}' controls='controls' autoplay='true' style='width:" . $width . "px; height: 50px' ></audio>";
} else if( $browser->getBrowser() == Browser::BROWSER_ANDROID ) {
    echo "<script> window.location.href=\"$purl\"; </script>";
} else {
    echo "<object type=\"application/x-shockwave-flash\" data=\"http://flash-mp3-player.net/medias/player_mp3_maxi.swf\" width=\"" . $width . "\" height=\"20\">
              <param name=\"movie\" value=\"http://flash-mp3-player.net/medias/player_mp3_maxi.swf\" />
              <param name=\"bgcolor\" value=\"#000000\" />
              <param name=\"FlashVars\" value=\"mp3=" . $purl . "&amp;width=" . $width . "&amp;autoplay=1&amp;bgcolor=000000&amp;bgcolor1=000000&amp;bgcolor2=000000\" />
              </object>";
}

?>
