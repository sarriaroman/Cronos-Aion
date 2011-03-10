<?

function load_language() {

    return $language = array(
            // Estados de conexion

            "connect:error" => "La conexion no se pudo establecer",
             "connect:db_error" => "Error al intentar vincular la base de datos",
             "connect:data_error" => "No se pudo obtener los datos solicitados",
             "connect:query_error" => "Error al solicitar los datos, puede haber un error en la sentencia SQL",
             "connect:insert_error" => "Ha habido un error al insertar los datos",
             "connect:update_error" => "Ha habido un error al actualizar los datos",
             "connect:delete_error" => "Ha habido un error al eliminar los datos",
             // Estados del API

            "api:api_connection" => "Usted no posee acceso al servidor",
             // Estado de la Sesion

            "session:error" => "La sesion no existe o ha caducado",
             // Usuarios

            "user:login_error" => "Los datos suministrados son incorrectos",
             // Estados de las funciones
            "function:not_exist" => "La funcion solicitada no existe",
             "function:parameters_error" => "Parametros incorrectos!",
             // Dias de la semana
            "week:monday" => "Lunes",
             "week:tuesday" => "Martes",
             "week:wednesday" => "Miércoles",
             "week:thursday" => "Jueves",
             "week:friday" => "Viernes",
             "week:saturday" => "Sábado",
             "week:sunday" => "Domingo",
             // Virtual egg's
            "egg:z" => "Algo copado deberia pasar aqui =P",

             // Email de activación
            "email:activation" => "<html><head></head><body>
                                        Estimado {user},<br /><br />
                                        !Gracias por unirte a {company}<br />
                                        Para completar tu registro, debes confirmar tu cuenta haciendo click sobre el siguiente enlace, o copiándolo y pegándolo en tu navegador:<br /><br />
                                        {url}<br /><br />
                                        Como miembro registrado de {company} puedes aprovechar toda la información que ponemos a tu disposición.<br />
                                        Esperamos que utilices {company}.<br />
                                        !Gracias!<br /><br />
                                        Sinceramente,<br />
                                        {company}<br />
                                    </body></html>",

             // Email de activación
            "email:contact_user" => "<html><head></head><body>
                                        Estimado {user},<br /><br />
                                        !Gracias por comunicarte con {company}<br /><br />
                                        Nos comunicaremos a la brevedad.<br /><br />
                                        Sinceramente,<br />
                                        {company}<br />
                                    </body></html>",

             // Email de activación
            "email:contact_comp" => "<html><head></head><body>
                                        <strong><u>INFORMACIÓN DE CONTACTO:</u></strong><br /><br />
                                        <strong>Name:</strong><ul>{user}</ul>
                                        <strong>Email:</strong><ul>{email}</ul>
                                        <strong>Phone:</strong><ul>{phone}</ul>
                                        <strong>Job Title:</strong><ul>{job_title}</ul>
                                        <strong>Job Function:</strong><ul>{job_function}</ul><br />
                                        <strong>Rate:</strong><ul>{rate}</ul><br /><br />
                                        <strong>Improve:</strong><br /><ul>{improve}</ul><br /><br />
                                        <strong>Comment:</strong><br /><ul>{comment}</ul><br />
                                    </body></html>",
    );
}

?>