<?php

require_once( dirname(dirname(__FILE__)) . "/engine/start.php" );

$pid = $_GET['pid'];
$width = $_GET['w'];

$podcast = new Podcast($pid);

$purl = base_url . "podcast/" . $podcast->Filename;

?><script>
    $.ajax({
        type: 'POST',
        url: '<?php echo actions_url; ?>listencount.php',
        data: 'pid=<?php echo $podcast->Id; ?>'
    });
</script><?php

$browser = new Browser(); // ($browser->getBrowser() == Browser::BROWSER_FIREFOX && $browser->getVersion() >= "3.6" ) $browser->getBrowser() == Browser::BROWSER_SAFARI ||
if( $browser->getBrowser() == Browser::BROWSER_CHROME ) {
    echo "<audio src='$purl' controls='controls' autoplay='autoplay' style='width:" . $width . "px;' ></audio>";
} else if( $browser->getBrowser() == Browser::BROWSER_IPHONE ) {
    echo "<audio id='iPlayer' src='$purl' controls='controls' autoplay='true' style='width:" . $width . "px; height: " . $width . "px;' ></audio>";
    echo '<script type="text/javascript">
            $("#iPlayer").click();
          </script>';
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
