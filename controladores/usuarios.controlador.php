<?php

class ControladorUsuarios{
	/*=============================================
	INGRESO DE USUARIO AL SISTEMA
	=============================================*/
	static public function ctrIngresoUsuario(){
		if(isset($_POST["ingUsuario"])){
			if(preg_match('/^[a-zA-Z0-9]+$/', $_POST["ingUsuario"]) &&
			   preg_match('/.*/', $_POST["ingPassword"])){
			   	$encriptar = crypt($_POST["ingPassword"], '$2a$07$asxx54ahjppf45sd87a5a4dDDGsystemdev$');
				$tabla = "usuarios";
				$item = "usuario";
				$valor = $_POST["ingUsuario"];

				$respuesta = ModeloUsuarios::mdlMostrarUsuarios($tabla, $item, $valor);

				if ($respuesta && is_array($respuesta) && $respuesta["usuario"] == $_POST["ingUsuario"] && password_verify($_POST["ingPassword"], $respuesta["password"]))
				{
					if($respuesta["estado"] == 1){
						$_SESSION["iniciarSesion"] = "ok";
						$_SESSION["id"] = $respuesta["id"];
						$_SESSION["nombre"] = $respuesta["nombre"];
						$_SESSION["usuario"] = $respuesta["usuario"];
						$_SESSION["perfil"] = $respuesta["perfil"];

						/*=============================================
						REGISTRAR FECHA PARA SABER EL ÚLTIMO LOGIN
						=============================================*/
						date_default_timezone_set('America/Santiago');
						$fecha = date('Y-m-d');
						$hora = date('H:i:s');
						$fechaActual = $fecha.' '.$hora;
						$item1 = "ultimo_login";
						$valor1 = $fechaActual;
						$item2 = "id";
						$valor2 = $respuesta["id"];

						$ultimoLogin = ModeloUsuarios::mdlActualizarUsuario($tabla, $item1, $valor1, $item2, $valor2);
						
                        error_log("Usuario:|". $_POST["ingUsuario"]. "| Ingreso al sistema");

	
						if($ultimoLogin == "ok"){
							echo '<script>
								window.location = "inicio";
							</script>';
						}
					}else{
						echo '<br>
							<div class="alert alert-danger">El usuario aún no está activado</div>';
					}		
				}else{		
					echo '<br><div class="alert alert-danger">Usuario o password incorrecto, vuelve a intentarlo</div>';
					error_log("Error al ingresar al sistema. Usuario Ingresado: |". $_POST["ingUsuario"]. "| Password: |".$_POST["ingPassword"]."|");
				}
			}	
		}
	}

	/*=============================================
	REGISTRO DE USUARIO (AGREGAR NUEVO USUARIO)
	=============================================*/
	static public function ctrCrearUsuario(){
		if(isset($_POST["nuevoUsuario"])){

			if(preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["nuevoNombre"]) &&
			   preg_match('/^[a-zA-Z0-9]+$/', $_POST["nuevoUsuario"]) &&
			   preg_match('/^[a-zA-Z0-9]+$/', $_POST["nuevoPassword"])){

				$tabla = "usuarios";
				$encriptar = crypt($_POST["nuevoPassword"], '$2a$07$asxx54ahjppf45sd87a5a4dDDGsystemdev$');
				$datos = array("nombre" => $_POST["nuevoNombre"],
					           "usuario" => $_POST["nuevoUsuario"],
							   "correo" => $_POST["nuevoCorreo"],
					           "password" => $encriptar,
					           "perfil" => $_POST["nuevoPerfil"]
					           );

				$respuesta = ModeloUsuarios::mdlIngresarUsuario($tabla, $datos);
			
				if($respuesta == "ok"){
					echo '<script>
					swal({

						type: "success",
						title: "¡El usuario ha sido guardado correctamente!",
						showConfirmButton: true,
						confirmButtonText: "Cerrar"

					}).then(function(result){
						if(result.value){					
							window.location = "usuarios";
						}
					});
					</script>';
				}
			}else{
				echo '<script>
					swal({
						type: "error",
						title: "¡El usuario no puede ir vacío o llevar caracteres especiales!",
						showConfirmButton: true,
						confirmButtonText: "Cerrar"
					}).then(function(result){
						if(result.value){
							window.location = "usuarios";
						}
					});
				</script>';
			}
		}
	}

	/*=============================================
	MOSTRAR USUARIO
	=============================================*/
	static public function ctrMostrarUsuarios($item, $valor){
		$tabla = "usuarios";
		$respuesta = ModeloUsuarios::MdlMostrarUsuarios($tabla, $item, $valor);
		return $respuesta;
	}

	/*=============================================
	EDITAR USUARIO
	=============================================*/
	static public function ctrEditarUsuario(){
		if(isset($_POST["editarUsuario"])){
			$_POST['editarCorreo'] = trim($_POST['editarCorreo']) === '' ? 'vacio@vacio.com' : trim($_POST['editarCorreo']);
			if(preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["editarNombre"])){
				$tabla = "usuarios";
				if($_POST["editarPassword"] != ""){
					if (preg_match('/.*/', $_POST["editarPassword"])) {
						$encriptar = crypt($_POST["editarPassword"], '$2a$07$asxx54ahjppf45sd87a5a4dDDGsystemdev$');
					}else{
						echo'<script>
								swal({
									  type: "error",
									  title: "¡La contraseña no puede ir vacía o llevar caracteres especiales!",
									  showConfirmButton: true,
									  confirmButtonText: "Cerrar"
									  }).then(function(result){
										if (result.value) {
											window.location = "usuarios";
										}
									})
						  	</script>';
					}
				}else{
					$encriptar = $_POST["passwordActual"];
				}

				$datos = array("nombre" => $_POST["editarNombre"],
							   "usuario" => $_POST["editarUsuario"],
							   "correo" => $_POST["editarCorreo"],
							   "password" => $encriptar,
							   "perfil" => $_POST["editarPerfil"]
							);

				$respuesta = ModeloUsuarios::mdlEditarUsuario($tabla, $datos);
				if($respuesta == "ok"){
					echo'<script>
					swal({
						  type: "success",
						  title: "El usuario ha sido editado correctamente",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result){
									if (result.value) {
										window.location = "usuarios";
									}
								})
					</script>';
				}
			}else{
				echo'<script>
					swal({
						  type: "error",
						  title: "¡El nombre no puede ir vacío o llevar caracteres especiales!",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result){
							if (result.value) {
								window.location = "usuarios";
							}
						})
			  	</script>';
			}
		}
	}

	/*=============================================
	BORRAR USUARIO
	=============================================*/

	static public function ctrBorrarUsuario(){
		if(isset($_GET["idUsuario"])){
			$tabla ="usuarios";
			$datos = $_GET["idUsuario"];
			$respuesta = ModeloUsuarios::mdlBorrarUsuario($tabla, $datos);
			if($respuesta == "ok"){
				echo'<script>
				swal({
					  type: "success",
					  title: "El usuario ha sido borrado correctamente",
					  showConfirmButton: true,
					  confirmButtonText: "Cerrar"
					  }).then(function(result){
								if (result.value) {
									window.location = "usuarios";
								}
							})
				</script>';
			}		
		}
	}
}