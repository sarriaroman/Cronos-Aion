<?php

require_once( dirname(dirname(__FILE__)) . "/engine/start.php" );

$action = $_POST['action'];
if (empty($action))
    $action = $_GET['action'];

switch ($action) {
    /**
     * Función encargada de crear una sesion de para un usuario registrado que hace un login
     *
     * user     Email del usuario registrado
     * pass     Contraseña del usuario registrado
     */
    case "login":
        $ERROR = array();
        $er = false;

        $email = $_POST['user'];
        $psw = $_POST['pass'];

        if (!strlen($email) || !strlen($psw)) {
            $er = true;
            $ERROR = array_merge($ERROR, array("message" => "Por favor complete todos los campos requeridos para continuar."));
        }

        if (!Users::exist($email) && !$er) {
            $er = true;
            $ERROR = array_merge($ERROR, array("message" => "El correo electrónico introducido no está registrado.</ br>Por favor verifique nuevamente."));
        }

        if ($er) {
            $ERROR = array_merge($ERROR, array("error" => "error"));
            $ERROR = array_merge($ERROR, array("message" => "Usuario/Clave incorrecto."));
            echo json_encode($ERROR);
            return;
        }

        $user = Users::validate($email, $psw);
        if ($user) {
            if (create_session(array($user->id, $user->email), "sitio")) {
                $ERROR = array_merge($ERROR, array("error" => "ok"));
                $ERROR = array_merge($ERROR, array("message" => "Entrando a su cuenta."));
            } else {
                $ERROR = array_merge($ERROR, array("error" => "error"));
                $ERROR = array_merge($ERROR, array("message" => "Hubo un error al crear la sesión."));
            }
        } else {
            $ERROR = array_merge($ERROR, array("error" => "error"));
            $ERROR = array_merge($ERROR, array("message" => "Usuario/Clave incorrecto."));
        }

        echo json_encode($ERROR);
        break;

    /**
     * Función encargada de cerrar cualquier sesion creada con un login
     */
    case "logout":
        close_session();
        echo json_encode(array("error" => "ok"));
        break;

    /**
     * Función encargada de registrar un usuario
     */
    case "register":
        $ERROR = array();
        $er = false;

        $rol = $_POST['rol'];
        $username = $_POST['user'];
        $pass = $_POST['pass'];
        $repass = $_POST['repass'];

        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
        $dni = $_POST['dni'];
        $email = $_POST['email'];
        $gender = $_POST['gender'];

        $phone = $_POST['phone'];
        $pin = $_POST['pin'];

        $month = $_POST['month'];
        $day = $_POST['day'];
        $year = $_POST['year'];

        if (!strlen($gender)) {
            $er = true;
            $ERROR = array_merge($ERROR, array("gender" => "*"));
        } else {
            $gender = ($_POST['gender'] == '1') ? true : false;
            $ERROR = array_merge($ERROR, array("gender" => ""));
        }

        $ERROR = array_merge($ERROR, array("message" => "Controle los campos destacados."));
        if (!strlen($email)) {
            $er = true;
            $ERROR = array_merge($ERROR, array("email" => "*"));
        } else {
            if (!ereg('^[a-z0-9]+([\.]?[a-z0-9_-]+)*@' . // usuario
                            '[a-z0-9]+([\.-]+[a-z0-9]+)*\.[a-z]{2,}$', // server
                            $email)) {
                $er = true;
                $ERROR = array_merge($ERROR, array("message" => "El email ingresado no es válido."));
            } else {
                $tmp = Users::getUser($email);
                if ($tmp->id) {
                    $er = true;
                    if ($tmp->enabled == "0")
                        $ERROR = array_merge($ERROR, array("message" => "El correo electrónico que ha indicado ya está registrado en Mobbex pero no esta activado."));
                    else
                        $ERROR = array_merge($ERROR, array("message" => "El correo electrónico que ha indicado ya está registrado en Mobbex."));
                } else
                    $ERROR = array_merge($ERROR, array("email" => ""));
            }
        }
        if (!strlen($username)) {
            $er = true;
            $ERROR = array_merge($ERROR, array("user" => "*"));
        } else {
            $tmp = Users::getUser($username);
            if ($tmp->id) {
                $er = true;
                if ($tmp->enabled == "0")
                    $ERROR = array_merge($ERROR, array("message" => "El correo electrónico que ha indicado ya está registrado en Mobbex pero no esta activado."));
                else
                    $ERROR = array_merge($ERROR, array("message" => "El correo electrónico que ha indicado ya está registrado en Mobbex."));
            } else
                $ERROR = array_merge($ERROR, array("user" => ""));
        }
        if (!strlen($pass) || $pass != $repass) {
            $er = true;
            $ERROR = array_merge($ERROR, array("pass" => "*"));
        }
        else
            $ERROR = array_merge($ERROR, array("pass" => ""));

        if (!strlen($first_name)) {
            $er = true;
            $ERROR = array_merge($ERROR, array("first_name" => "*"));
        }
        else
            $ERROR = array_merge($ERROR, array("first_name" => ""));

        if (!strlen($last_name)) {
            $er = true;
            $ERROR = array_merge($ERROR, array("last_name" => "*"));
        }
        else
            $ERROR = array_merge($ERROR, array("last_name" => ""));

        if (!strlen($dni) || !is_numeric($dni)) {
            $er = true;
            $ERROR = array_merge($ERROR, array("dni" => "*"));
        }
        else
            $ERROR = array_merge($ERROR, array("dni" => ""));

        if (!strlen($phone) || !is_numeric($phone)) {
            $er = true;
            $ERROR = array_merge($ERROR, array("phone" => "*"));
        }
        else
            $ERROR = array_merge($ERROR, array("phone" => ""));
        if (!strlen($pin) || !is_numeric($pin)) {
            $er = true;
            $ERROR = array_merge($ERROR, array("pin" => "*"));
        }
        else
            $ERROR = array_merge($ERROR, array("pin" => ""));

        if (!strlen($month)) {
            $er = true;
            $ERROR = array_merge($ERROR, array("birth" => "*"));
        }
        else
            $ERROR = array_merge($ERROR, array("birth" => ""));
        if (!strlen($day)) {
            $er = true;
            $ERROR = array_merge($ERROR, array("birth" => "*"));
        }
        else
            $ERROR = array_merge($ERROR, array("birth" => ""));
        if (!strlen($year)) {
            $er = true;
            $ERROR = array_merge($ERROR, array("birth" => "*"));
        }
        else
            $ERROR = array_merge($ERROR, array("birth" => ""));

        if ($er) {
            $ERROR = array_merge($ERROR, array("error" => "error"));
            echo json_encode($ERROR);
            break;
        }

        $user = new Users();

        $user->username = $username;
        $user->password = md5($pass);
        $user->name = $first_name;
        $user->lastname = $last_name;

        $user->DNI = $dni;
        $user->email = $email;
        $user->PIN = md5($pin);
        $user->gender = $gender;
        $user->birthdate = $year . '-' . $month . '-' . $day;
        $user->roleid = $rol;
        $user->phonenumber = $phone;

        $user->enabled = false;

        if ($user->save()) {
            $headers = 'MIME-Version: 1.0' . "\r\n";
            $headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
            $headers .= 'From: Mobbex <rcontacto@mobbex.com>' . "\r\n";

            $html = get_message("email:activation", array(
                        "company" => "Mobbex",
                        "user" => $user->name,
                        "url" => actions_url . "actions.php?action=activate&e=" . base64_encode($email) . "&u=" . base64_encode(base_url)
                    ));
            mail($email, "Bienvenido a Mobbex", $html, $headers);

            $save = array("error" => "ok");
            $save = array_merge($save, array("result_user" => $email));
            $save = array_merge($save, array("result_pass" => $pass));
            $save = array_merge($save, array("message" => "Registrando nuevo usuario..."));

            if ($rol == "2") {
                $merchant = new Merchant();

                $usertmp = Users::getUser($email);
                $merchant->iduser = $usertmp->id;
                $merchant->idtypemerchant = $_POST['companyinfo'];
                $merchant->companyname = $_POST['company_name'];
                $merchant->storename = $_POST['store_name'];
                $merchant->address = $_POST['address'];
                $merchant->phone = $_POST['phone_company'];
                if (!$merchant->save()) {
                    $save = array("error" => "error");
                    $save = array_merge($save, array("error" => "No se pudo guardar el usuario"));
                }
            }
        } else {
            $save = array("error" => "error");
            $save = array_merge($save, array("error" => "No se pudo guardar el usuario"));
        }

        $ERROR = array_merge($ERROR, $save);

        echo json_encode($ERROR);
        break;

    case "activate":
        $save = array();

        $email = base64_decode($_REQUEST['e']);
        header('Location: ' . base64_decode($_REQUEST['u']));

        $tmp = Users::getUser($email);

        $tmp->activate = true;

        if (!$tmp->save()) {
            echo "Bien!! =)";
        } else {
            echo "Todo mal =(";
        }
        break;

    /**
     * Función encargada de editar la información de un usuario reguistrado
     *
     * first_name       Nombre del usuario
     * last_name        Apellido del usuario
     * country          Ciudad de recidencia del usuario
     * pass             Contraseña de la cuenta del usuario
     * pass2            Duplicado de la contraseña
     */
    case "edituser":
        $ERROR = array();
        $er = false;

        $userid = $_POST['id'];
        $pass = $_POST['pass'];
        $repass = $_POST['repass'];

        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
        $dni = $_POST['dni'];
        $email = $_POST['email'];

        $phone = $_POST['phone'];
        $pin = $_POST['pin'];
        $gender = $_POST['gender'];

        $month = $_POST['month'];
        $day = $_POST['day'];
        $year = $_POST['year'];

        if (!strlen($gender)) {
            $er = true;
            $ERROR = array_merge($ERROR, array("gender" => "*"));
        } else {
            $gender = ($_POST['gender'] == '1') ? true : false;
            $ERROR = array_merge($ERROR, array("gender" => ""));
        }

        $ERROR = array_merge($ERROR, array("message" => "Controle los campos destacados."));
        if (!strlen($email)) {
            $er = true;
            $ERROR = array_merge($ERROR, array("email" => "*"));
        } else {
            if (!ereg('^[a-z0-9]+([\.]?[a-z0-9_-]+)*@' . // usuario
                            '[a-z0-9]+([\.-]+[a-z0-9]+)*\.[a-z]{2,}$', // server
                            $email)) {
                $er = true;
                $ERROR = array_merge($ERROR, array("message" => "El email ingresado no es válido."));
            }
        }
        if ($pass != $repass) {
            $er = true;
            $ERROR = array_merge($ERROR, array("pass" => "*"));
        }
        else
            $ERROR = array_merge($ERROR, array("pass" => ""));

        if (!strlen($first_name)) {
            $er = true;
            $ERROR = array_merge($ERROR, array("first_name" => "*"));
        }
        else
            $ERROR = array_merge($ERROR, array("first_name" => ""));

        if (!strlen($last_name)) {
            $er = true;
            $ERROR = array_merge($ERROR, array("last_name" => "*"));
        }
        else
            $ERROR = array_merge($ERROR, array("last_name" => ""));

        if (!strlen($dni) || !is_numeric($dni)) {
            $er = true;
            $ERROR = array_merge($ERROR, array("dni" => "*"));
        }
        else
            $ERROR = array_merge($ERROR, array("dni" => ""));

        if (!strlen($phone) || !is_numeric($phone)) {
            $er = true;
            $ERROR = array_merge($ERROR, array("phone" => "*"));
        }
        else
            $ERROR = array_merge($ERROR, array("phone" => ""));

        if (!strlen($month)) {
            $er = true;
            $ERROR = array_merge($ERROR, array("birth" => "*"));
        } else if (((int) $month) < 1 || ((int) $month) > 12) {
            $er = true;
            $ERROR = array_merge($ERROR, array("birth" => "*"));
        } else
            $ERROR = array_merge($ERROR, array("birth" => ""));


        if (!strlen($day)) {
            $er = true;
            $ERROR = array_merge($ERROR, array("birth" => "*"));
        } else
        if (((int) $day) < 1 || ((int) $day) > 31) {
            $er = true;
            $ERROR = array_merge($ERROR, array("birth" => "*"));
        } else if (!$er
            )$ERROR = array_merge($ERROR, array("birth" => "--"));

        if (!strlen($year)) {
            $er = true;
            $ERROR = array_merge($ERROR, array("birth" => "*"));
        } else
        if (!$er
            )$ERROR = array_merge($ERROR, array("birth" => ""));


        if ($er) {
            $ERROR = array_merge($ERROR, array("result" => "error"));
            echo json_encode($ERROR);
            break;
        }

        $user = new Users($userid);

        if ($pass != "")
            $user->password = md5($pass);
        $user->name = $first_name;
        $user->lastname = $last_name;

        $user->DNI = $dni;
        $user->email = $email;
        if ($pin != "")
            $user->PIN = md5($pin);

        $user->email = $email;
        $user->gender = $gender;
        $user->birthdate = $year . '-' . $month . '-' . $day;
        $user->phonenumber = $phone;

        if ($user->save()) {
            $ERROR = array_merge($ERROR, array("message" => "Cambios guardados con éxito."));
            $ERROR = array_merge($ERROR, array("error" => "ok"));
        } else {
            $ERROR = array_merge($ERROR, array("message" => "No se pudo guardar los cambios realizados."));
            $ERROR = array_merge($ERROR, array("error" => "error"));
        }

        echo json_encode($ERROR);
        break;

    /**
     * Función encargadad de actualizar las notificaciones de un usuario    (activado[1] - desactivado[0])
     *
     * approcomm    Notificarme cuando mi comentario sea aprobado
     * commcomm     Notificarme cuando alguien comente mi comentario
     * commafter    Notificarme cuando alguien comente despues de mi comentario
     */
    case "contact":
        $ERROR = array();
        $er = false;

        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
        $job_title = $_POST['job_title'];
        $job_function = $_POST['job_function'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $mail_list = ($_POST['mail_list'] == 'on') ? true : false;

        $rate = ($_POST['cb_excelent'] == 'on') ? "<li>excelent</li>" : "- without selection -";
        $rate .= ( $_POST['cb_good'] == 'on') ? "<li>good</li>" : "";
        $rate .= ( $_POST['cb_fair'] == 'on') ? "<li>fair</li>" : "";
        $rate .= ( $_POST['cb_poor'] == 'on') ? "<li>poor</li>" : "";

        $improve = (strlen($_POST['improve'])) ? $_POST['improve'] : "- without improve -";
        $comment = (strlen($_POST['comment'])) ? $_POST['comment'] : "- without comments -";

        $ERROR = array_merge($ERROR, array("message" => "Controle los campos destacados."));
        if (!strlen($email)) {
            $er = true;
            $ERROR = array_merge($ERROR, array("email" => "*"));
        } else {
            if (!ereg('^[a-z0-9]+([\.]?[a-z0-9_-]+)*@' . // usuario
                            '[a-z0-9]+([\.-]+[a-z0-9]+)*\.[a-z]{2,}$', // server
                            $email)) {
                $er = true;
                $ERROR = array_merge($ERROR, array("message" => "El email ingresado no es válido."));
                $ERROR = array_merge($ERROR, array("email" => "*"));
            } else
                $ERROR = array_merge($ERROR, array("email" => ""));
        }
        if (!strlen($first_name)) {
            $er = true;
            $ERROR = array_merge($ERROR, array("first_name" => "*"));
        } else
            $ERROR = array_merge($ERROR, array("first_name" => ""));
        if (!strlen($last_name)) {
            $er = true;
            $ERROR = array_merge($ERROR, array("last_name" => "*"));
        } else
            $ERROR = array_merge($ERROR, array("last_name" => ""));
        if (!strlen($job_title)) {
            $er = true;
            $ERROR = array_merge($ERROR, array("job_title" => "*"));
        } else
            $ERROR = array_merge($ERROR, array("job_title" => ""));
        if (!strlen($job_function)) {
            $er = true;
            $ERROR = array_merge($ERROR, array("job_function" => "*"));
        } else
            $ERROR = array_merge($ERROR, array("job_function" => ""));
        if (!strlen($phone) || !is_numeric($phone)) {
            $er = true;
            $ERROR = array_merge($ERROR, array("phone" => "*"));
        } else
            $ERROR = array_merge($ERROR, array("phone" => ""));

        if ($er) {
            $ERROR = array_merge($ERROR, array("error" => "error"));
            $ERROR = array_merge($ERROR, array("message" => "controle los campos resaltados"));
            echo json_encode($ERROR);
            return;
        }

        $user = Users::getUser($email);
        $user->maillist = $mail_list;
        $user->save();


        /* -> */$company = "Mobbex";
        $headers = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
        $headers .= 'From: ' . $company . ' <rcontacto@mobbex.com>' . "\r\n";

        $html = get_message("email:contact_user", array(
                    "company" => $company,
                    "user" => $first_name . " " . $last_name
                ));

        if (mail($email, "Contacto con " . $company, $html, $headers)) {
            $ERROR = array_merge($ERROR, array("error" => "ok"));
            $ERROR = array_merge($ERROR, array("message" => "Mensaje enviado con éxito."));
        } else {
            $ERROR = array_merge($ERROR, array("error" => "error"));
            $ERROR = array_merge($ERROR, array("message" => "Ocurrio un error!"));
            /* <- */
        }

        /* -> */$html = get_message("email:contact_comp", array(
                    "company" => $company,
                    "user" => ucfirst($first_name) . " " . ucfirst($last_name),
                    "email" => $email . " Mail List: " . $mail_list,
                    "phone" => $phone,
                    "job_title" => $job_title,
                    "job_function" => $job_function,
                    "rate" => $rate,
                    "improve" => $improve,
                    "comment" => $comment
                ));

        if (mail("rcontacto@mobbex.com", "Contacto con " . $company, $html, $headers)) {
            $ERROR = array_merge($ERROR, array("error" => "ok"));
            $ERROR = array_merge($ERROR, array("message" => "Mensaje enviado con éxito."));
        } else {
            $ERROR = array_merge($ERROR, array("error" => "error"));
            $ERROR = array_merge($ERROR, array("message" => "Ocurrio un error!"));
            /* <- */
        }

        echo json_encode($ERROR);
        break;

    case "newpayment":
        $user = new Users($_POST['id']);
        $pass = $_POST['pass'];
        $amount = $_POST['amo'];

        if(md5($pass) != $user->password) {
            $ERROR = array("result" => "error");
            $ERROR = array_merge($ERROR, array("message" => "Password incorrecto!"));

            echo json_encode($ERROR);
            break;
        }

        $id = str_pad($user->id, 7, "0", STR_PAD_LEFT);
        $imei = str_pad($user->imei, 15, "0", STR_PAD_LEFT);
        $control = str_pad(ControlCodeGenerator($imei), 2, "0", STR_PAD_LEFT);
        $counter = str_pad($user->counter, 4, "0", STR_PAD_LEFT);

        $code = "mobbex://" . $id . $control . $counter;

        $qrurl = GoogleQRCode($code, "300", "300");

        $ERROR = array("result" => "ok");
        $ERROR = array_merge($ERROR, array("message" => $qrurl));

        echo json_encode($ERROR);
        break;

    case "return":
        $result = Operations::restore($_POST['user'], $_POST['user_reseiver'], $_POST['ammo'], $_POST['opration']);

        $ERROR = array("result" => "ok");
        $ERROR = array_merge($ERROR, array("message" => $result));

        echo json_encode($ERROR);
        break;
}
?>