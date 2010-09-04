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
			
			// Virtual egg's
			"egg:z"						=> "Algo copado deberia pasar aqui =P"

		);
		
	}
?>