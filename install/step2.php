<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Installer</title>

        <script src="js/jquery-1.5.1.min.js" type="text/javascript"></script>
        <script src="js/jquery.form.js" type="text/javascript"></script>

        <link type="text/css" href="css/style.css" rel="stylesheet" />

    </head>

    <body>
        <?php
        require_once( dirname(dirname(__FILE__)) . '/engine/start.php' );
        ?>
        <div class="main">
            <div class="title">
                Installer
                <div style="float:right; margin-right: 2px;">
                    <div class="step">1</div>
                    <div class="step">2</div>
                    <div class="step-active">3</div>
                </div>
            </div>
            <div class="container">
                <p class='msg done'>You finish all the steps, click the link below to enter</p>

                <br/>
                <a href="<?=base_url . 'admin.php';?>">Go to Administration Panel</a>
                <br/>
            </div>
        </div>

    </body>
</html>