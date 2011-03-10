<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Installer</title>

        <script src="js/jquery-1.5.1.min.js" type="text/javascript"></script>
        <script src="js/jquery.form.js" type="text/javascript"></script>

        <link type="text/css" href="css/style.css" rel="stylesheet" />

        <script type="text/javascript">
            $(document).ready(function(){
                $('#form1').submit( function() {
                    $(this).ajaxSubmit({
                        dataType: "json",
                        success: function( data ) {
                            if( data.response ) {
                                $('#response').html("<br/><span>Your database was created. Copy this text inside a settings.php file inside engine folder in your Framework folder</span><br/><textarea style='width: 564px; height: 339px;'>" + data.file + "</textarea><br/><br/>");
                                $('#form2').show();
                            } else {
                                $('#response').html("<br/><p class='msg error'>There was an error in the process. Please review the settings and try again.<br/>Error: " + data.error + "</p>");
                            }
                        }
                    });
                    return false;
                });

                $('#form2').submit( function() {
                    $(this).ajaxSubmit({
                        dataType: "json",
                        success: function( data ) {
                            if( data.response ) {
                                document.location = 'step1.php';
                            } else {
                                $('#response1').html("<br/><span>The configuration file is missing.</span>");
                            }
                        }
                    });
                    return false;
                });
            });
        </script>
    </head>

    <body>
        <?php
        ?>
        <div class="main">
            <div class="title">
                Installer
                <div style="float:right; margin-right: 2px;">
                    <div class="step-active">1</div>
                    <div class="step">2</div>
                    <div class="step">3</div>
                </div>
            </div>
            <div class="container">
                <form id="form1" name="form1" method="post" action="actions.php?action=install">
                    <p>
                        <span>Server: </span><br/>
                        <input type="text" name="server" id="server" value="localhost" />
                    </p>
                    <p>
                        <span>Database: </span><br/>
                        <input type="text" name="database" id="database" />
                    </p>
                    <p>
                        <span>Username: </span><br/>
                        <input type="text" name="username" id="username" />
                    </p>
                    <p>
                        <span>Password: </span><br/>
                        <input type="password" name="password" id="password" />
                    </p>

                    <p>
                        <span>Administration Info</span>
                    </p>
                    <p>
                        <span>Administrator E-Mail: </span><br/>
                        <input type="text" name="email" id="email" />
                    </p>
                    <p>
                        <span>Site Base: ( if your site is in http://example.com/ this parameter must be empty, if your site is in http://example.com/site/ this parameter must be site ) </span><br/>
                        <input type="text" name="site" id="site" />
                    </p>
                    <input type="submit" name="complete" id="complete" value="Check" />
                </form>
                <div id="response"></div>
                <form method="POST" name="form2" id="form2" action="actions.php?action=check" style="display:none;">
                    <input type="submit" name="step" id="step" value="Next Step"/>
                </form>
                <div id="response1"></div>
                <br/>
            </div>
        </div>

    </body>
</html>