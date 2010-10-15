<?php admin_module("header"); ?>

<?php admin_module("navbar"); ?>

<div id="containerHolder">
    <div id="container">

        <?php
        if( isset ($_GET['module']) ) {
            admin_module("profiles-" . $_GET['module'] );
        } else {
            admin_module("profiles-add" );
        }
        ?>

        <div class="spacer"></div>

        <div class="clear"></div>
    </div>
    <!-- // #container -->
</div>
<!-- // #containerHolder -->

<?php admin_module("footer"); ?>