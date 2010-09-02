<?
	function load_language() {
	
		return $language = array(
		
			// Estados de conexion
		
			"connect:error" 			=> "La conexion no se pudo establecer",
			"connect:db_error"			=> "Error al intentar vincular la base de datos",
			"connect:data_error"		=> "No se pudo obtener los datos solicitados",
			"connect:query_error"		=> "Error al solicitar los datos, puede haber un error en la sentencia SQL",
			"connect:insert_error"		=> "Ha habido un error al insertar los datos",
                        "connect:update_error"		=> "Ha habido un error al actualizar los datos",
                        "connect:delete_error"		=> "Ha habido un error al eliminar los datos",
		
			// Estados del API
		
			"api:api_connection"		=> "Usted no posee acceso al servidor",
		
			// Estado de la Sesion
		
			"session:error"				=> "La sesion no existe o ha caducado",
		
			// Usuarios
		
			"user:login_error"			=> "Los datos suministrados son incorrectos",
			
			// Estados de las funciones
			"function:not_exist"		=> "La funcion solicitada no existe",
			"function:parameters_error"	=> "Parametros incorrectos!",

                        // Dias de la semana
                        "week:monday"           => "Lunes",
                        "week:tuesday"          => "Martes",
                        "week:wednesday"        => "Miércoles",
                        "week:thursday"         => "Jueves",
                        "week:friday"           => "Viernes",
                        "week:saturday"         => "Sábado",
                        "week:sunday"           => "Domingo",
			
			// Idioma para el sitio home
			"home:hello"				=> "",
			
			// Idioma parala red
			"red:tittle"				=> "RED",
			"red:login"					=> "Ingreso",
			"red:mail"					=> "Email:",
			"red:password"				=> "Contrase&ntilde;a:",
			"red:remembermessage"		=> "Olvid&eacute; mi contrase&ntilde;a",
			"red:register"				=> "Registrarme",
			"red:welcome"				=> "BIENVENIDOS A LA RED",
			"red:welcomemessage"		=> "<h3><span class=\"azul\">BIENVENIDOS A NUESTRA RED DE AFILIADAS.</span><br />
                    Si ya eres parte de nuestra red de afiliadas, ingresa tu nombre de usuario y contrase&ntilde;a para disrutar de todos los contenidos que cvc tiene para compartir.</h3>",
			"red:onair"					=> "EN EL AIRE",
			"red:mostposters"			=> "USUARIOS QUE M&Aacute;S POSTEARON:",
			"red:lastpodcast"			=> "&Uacute;LTIMOS PODCASTS",
			"red:join"					=> "<h3><span class=\"naranja\">SUMATE A NUESTRA RED DE AFILIADAS.</span><br />
                    tu puedes ser parte de nuestra red satelital, hace <a href=\"http://cvclavoz.com/cvc/index.php?url=redsignup\">click aqui</a>, envianos tus datos para poder disfrutar de los beneficios de nuestra plataforma digital.</h3>",
			"red:joininfo"				=> "<ul>
                    <li>                      
                      <p>Contenidos muy variados y artisticamente bien dise&ntilde;ados para una audiencia moderna.</p>
                    </li>
                    <li>                      
                      <p>Programas en vivo de actualidad y vida espiritual</p>
                    </li>
                    <li>                      
                      <p>Enfoque en la familia para promover el bienestar diario.</p>
                    </li>
                    <li>                      
                      <p>Programacion en Espa&ntilde;ol.</p>
                    </li>
                  </ul>
                  </div>",
				  
			"red:moreinfo"				=> "<p>Para mayor informacion ingresa a <a href=\"http://www.cvcafiliadas.com\" target=\"_blank\">www.cvcafiliadas.com</a></p>",
			"red:banneduser"			=> "El usuario est&aacute; inactivo.",
			"red:loginerror"			=> "Usuario o clave incorrecto.",
                        "red:ilegalaccess"			=> "Usted intento un acceso ilegal, su IP ha sido almacenado y probablemente ser&aacute; denunciado a las autoridades correspondientes.",
			
			// Virtual egg's
			"egg:z"						=> "Algo copado deberia pasar aqui =P"

		);
		
	}
?>