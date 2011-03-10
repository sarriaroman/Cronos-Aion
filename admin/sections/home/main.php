<?php admin_module("header"); ?>

<div id="containerHolder">
    <div id="container">

        <?php
        if( isset ($_GET['module']) ) {
            admin_module("home-" . $_GET['module'] );
        } else {
            admin_module("home-log" );
        }
        ?>

        <div class="spacer"></div>

        <div class="clear"></div>
    </div>
    <!-- // #container -->
</div>
<!-- // #containerHolder -->

<?php admin_module("footer"); ?>