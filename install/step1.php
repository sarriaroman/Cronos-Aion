<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Installer</title>

        <script src="js/jquery-1.5.1.min.js" type="text/javascript"></script>
        <script src="js/jquery.form.js" type="text/javascript"></script>
        <script src="js/passwordStrengthMeter.js" type="text/javascript"></script>

        <link type="text/css" href="css/style.css" rel="stylesheet" />

        <script type="text/javascript">
            $(document).ready(function(){
                $('#form1').submit( function() {
                    $(this).ajaxSubmit({
                        dataType: "json",
                        success: function( data ) {
                            if( data.response ) {
                                //$('#response').html("<br/>");
                                window.location = 'step2.php';
                            } else {
                                $('#response').html("<br/><p class='msg error'>There was an error in the process. Please review the info and try again.<br/>Error: " + data.error + "</p>");
                            }
                        }
                    });
                    return false;
                });

                $('#password').keyup(function(){
                    var val = passwordStrength($('#password').val(),$('#username').val());
                    $('#result').html( "<span style='color: " + ( ( val == "Too short" || val == "Bad" ) ? "red" : "green" ) + ";'>" + val + "</span>" );
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
                    <div class="step">1</div>
                    <div class="step-active">2</div>
                    <div class="step">3</div>
                </div>
            </div>
            <div class="container">
                <form id="form1" name="form1" method="post" action="actions.php?action=create">
                    <p>
                        <span>Admin User data: </span>
                    </p>
                    <p>
                        <span>Username: </span><br/>
                        <input type="text" name="username" id="username" />
                    </p>
                    <p>
                        <span>E-mail: </span><br/>
                        <input type="text" name="email" id="email" />
                    </p>
                    <p>
                        <span>Password: </span><br/>
                        <input type="password" name="password" id="password" /><br/>
                        <div id="result"></div>
                    </p>
                    <p>
                        <span>Do you want to enable the developer Access ( <a href="http://en.wikipedia.org/wiki/Application_programming_interface" target="_BLANK">API</a> ): </span><br/>
                        <input type="checkbox" name="enableapi" id="enableapi"/>
                    </p>
                    <p>
                        <span>Do you want create tha API Key for the Admin user? </span><br/>
                        <input type="checkbox" name="enableapiadmin" id="enableapiadmin"/>
                    </p>
                    <input type="submit" name="complete" id="complete" value="Check" />
                </form>
                <div id="response"></div>
                <br/>
            </div>
        </div>

    </body>
</html>