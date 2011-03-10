<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Installer</title>

        <script src="js/jquery-1.5.1.min.js" type="text/javascript"></script>
        <script src="js/jquery.form.js" type="text/javascript"></script>

        <script type="text/javascript">
            $(document).ready(function(){
                $('#form1').submit( function() {
                    $(this).ajaxSubmit({
                        dataType: "json",
                        success: function( data ) {
                            if( data.response ) {
                                $('#response').html("Your database was created. Copy this text inside a settings.php file inside engine folder in your API folder<br/><textarea>" + data.file + "</textarea>");
                            } else {
                                $('#response').html("There was an error in the process. Please review the settings and try again.");
                            }
                        }
                    });
                    return false;
                });
            });
        </script>

        <style type="text/css">
            p span {
                font-family: sans-serif;
                font-size: 12px;
                color: #333;
            }

            input[type=text] {
                background-color: white;
                border: 1px solid #222;
                border-radius: 2px;
                -moz-border-radius: 2px;
                -webkit-border-radius: 2px;
                width: 220px
            }

            input[type=password] {
                background-color: white;
                border: 1px solid #222;
                border-radius: 2px;
                -moz-border-radius: 2px;
                -webkit-border-radius: 2px;
                width: 220px
            }
        </style>
    </head>

    <body>
<?php

    

?>
<div id="download" style="margin-right: auto; margin-left: auto; margin-top: 20px; width: 250px; border-radius: 5px; -moz-border-radius: 5px; -webkit-border-radius: 5px; background-color: #F8F8F8;">
            <div id="title" style="padding: 5px; color: white; font-weight: bold; font-family: sans-serif; font-size: 13px; background-color: #222;">
                Installer
            </div>
            <div id="container" style="display: block; overflow: hidden; position: relative; padding: 5px;">
                <form id="form1" name="form1" method="post" action="actions.php?action=install">
                    <p>
                        <span>Server: </span><br/>
                        <input type="text" name="server" id="server" />
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

                    <input type="submit" name="complete" id="complete" value="Complete!" />
                </form>
                <div id="response">
                </div>
                <br/>
                <span>
                    After generate your database you can create your API functions in this way: <br/>
                    Create a PHP file with the next structure: <br/><br/>

                    <textarea>register_function("execution name", "real function name", array(
    array("parameter" => "parameter name",
        "required" => ( true or false ),
        "post" => ( true or false )
    )
));
                    // Write your function and put the name of the real function parameter

                    function real_name( parameters in declaration order ) {
                        // make all you need

                        // The return must be an array. The API make the output in the selected type ( JSON or XML )
                        return array( all_you_need => all_data_needed );
                    }
                    </textarea>
                    <br/>
                    All functions files must be in the dev_functions folder inside engine/functions.<br/>
                    To call an API function you must create an user and asign an API key. After that you can invoke your function in the next way:<br/>
                    <textarea>http://API_FOLDER/API_KEY/RESPONSE_TYPE/FUNCTION_EXECUTION_NAME/PARAMETER=VALUE&PARAMETER=VALUE</textarea>
                    <br/>
                    You can custom the .htaccess. Don't forget to upload it.

                    <br/><br/>
                    In the dev_functions folder inside engine/functions you have 3 examples:<br/>
                    - dump.php ( make a dump of array functions )
                    - functions.php ( list of avaiable functions )
                    - phpinfo.php ( make a phpinfo output )
                </span>
            </div>
        </div>

</body>
</html>