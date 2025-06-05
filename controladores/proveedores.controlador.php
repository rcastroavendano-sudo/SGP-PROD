<?php

class ControladorProveedores{
	/*=============================================
	CREAR PROVEEDOR
	LLAMADA DESDE:
	PROVEEDORES.PHP
	=============================================*/
	static public function ctrCrearProveedor(){
		if(isset($_POST["agregarProveedor"]))
		{
			$errorMsg = ""; // Variable para almacenar el mensaje de error

			//Elimina los espacios en blanco al principio y al final del valor y Asigna un valor por defecto si el campo está vacío 
			$_POST['agregarProveedor'] = trim($_POST['agregarProveedor']) === '' ? 'Sin nombre' : trim($_POST['agregarProveedor']);
			$_POST['agregarCelular'] = trim($_POST['agregarCelular']) === '' ? '0' : trim($_POST['agregarCelular']);
			$_POST['agregarCorreo'] = trim($_POST['agregarCorreo']) === '' ? 'vacio@vacio.com' : trim($_POST['agregarCorreo']);
			$_POST['agregarRol'] = trim($_POST['agregarRol']) === '' ? 'No sabemos el rol' : trim($_POST['agregarRol']);
			$_POST['agregarComentarios'] = trim($_POST['agregarComentarios']) === '' ? 'Sin comentarios' : trim($_POST['agregarComentarios']);

			
			// Validar que "agregarProveedor" contenga solo letras, espacios y opcionalmente un punto al final.
			if (!preg_match('/^[a-zA-ZñÑáéíóúÁÉÍÓÚ]+(?:[\s][a-zA-ZñÑáéíóúÁÉÍÓÚ]+)*(?:\.[a-zA-ZñÑáéíóúÁÉÍÓÚ]+)?\.?$/', $_POST["agregarProveedor"])) {
				$errorMsg .= "El nombre y apellido solo puede contener letras, espacios y puede terminar con un punto.";
			}

			// Validar que "agregarCelular" contenga solo números, más, menos, espacios, paréntesis y letras.
			if (!preg_match('/^[\+\s0-9a-zA-Z\/\-\(\)]+$/', $_POST["agregarCelular"])) {
				$errorMsg .= "El celular solo puede contener números, más, menos, espacios, paréntesis y letras.";
			}

		
			// Validar que "agregarCorreo" contenga un correo electrónico válido.
			if (!preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ._%+-]+@[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ.-]+\.[a-zA-Z]{2,}$/', $_POST["agregarCorreo"])) {
				$errorMsg .= "El correo debe ser un formato válido y debe incluir un '@'. ";
			}
		
			// Validar que "agregarRol" contenga solo letras, números, espacios, guiones, comas, y los caracteres "/" y "&".
			if (!preg_match('/^[a-zA-ZñÑáéíóúÁÉÍÓÚ0-9\s,\-\/&]+$/', $_POST["agregarRol"])) {
				$errorMsg .= "El rol solo puede contener letras, números, espacios, guiones, comas, y los caracteres \"/\" y \"&\". ";
			}
			
			
			// Validar que "agregarComentario" contenga letras, números, espacios, caracteres válidos y URLs.
			if (!preg_match('/^[a-zA-ZñÑáéíóúÁÉÍÓÚ0-9\s\.\,\-\/:]+(https?:\/\/[a-zA-Z0-9\-\.]+(\.[a-zA-Z]{2,})(\/\S*)?)?$/', $_POST["agregarComentarios"])) {
				$errorMsg .= "El comentario solo puede contener letras, números, espacios, puntos, comas y URLs. ";
			}

		
			// Verificar si hay algún mensaje de error
			if ($errorMsg) {
				echo '<script>
					swal({
						type: "error",
						title: "Error en la validación",
						text: "' . addslashes($errorMsg) . '",
						showConfirmButton: true,
						confirmButtonText: "Cerrar"
					}).then(function(result) {
						if (result.value) {
							window.location = "proveedores";
						}
					});
				</script>';
			}
			else {
				$tabla = "proveedores";
				$datos = array(
					"proveedor" => $_POST["agregarProveedor"],
					"celular" => $_POST["agregarCelular"],
					"correo" => $_POST["agregarCorreo"],
					"rol" => $_POST["agregarRol"],
					"empresa" => $_POST["agregarEmpresa"],
					"comentario" => $_POST["agregarComentarios"],
					"marca" => $_POST["agregarMarca"]
				);

				$respuesta = ModeloProveedores::mdlIngresarProveedor($tabla, $datos);

				if ($respuesta == "ok") {
					echo '<script>
						swal({
							type: "success",
							title: "El proveedor ha sido guardado correctamente",
							showConfirmButton: true,
							confirmButtonText: "Cerrar"
						}).then(function(result) {
							if (result.value) {
								window.location = "proveedores";
							}
						});
					</script>';
				}
			}
		}
	}
			

	/*=============================================
	MOSTRAR TODOS LOS ATRIBUTOS DE TODOS LOS PROVEEDORES.
	LLAMADA DESDE:
	PROVEEDORES.PHP
	PROVEEDORES.AJAX.PHP
	=============================================*/
	static public function ctrMostrarProveedores(){
		$tabla = "proveedores";
		$respuesta = ModeloProveedores::mdlMostrarProveedores($tabla);
		return $respuesta;
	}


	/*=============================================
	MOSTRAR TODOS LOS ATRIBUTOS DE TODOS LOS PROVEEDORES INCLUYENDO EL NOMBRE DEL PAIS Y NOMBRE DE LA MARCA
	ES LLAMADA DESDE:
	PROVEEDORES.AJAX.PHP
	=============================================*/
	static public function ctrMostrarProveedoresFull($item, $valor){
			$tabla = "proveedores";
			$respuesta = ModeloProveedores::mdlMostrarProveedoresFull($tabla, $item, $valor);
			return $respuesta;
	}


	/*=============================================
	EDITAR PROVEEDOR
	ES LLAMADA DESDE:
	PROVEEDORES.PHP
	=============================================*/
	static public function ctrEditarProveedor(){
		if ($_SERVER['REQUEST_METHOD'] === 'POST'){  
			// Solo entra si el método es POST
			if(isset($_POST["editarProveedor"])){
				//Elimina los espacios en blanco al principio y al final del valor y Asigna un valor por defecto si el campo está vacío 
				$_POST['editarProveedor'] = trim($_POST['editarProveedor']) === '' ? 'Sin nombre' : trim($_POST['editarProveedor']);
				$_POST['editarCelular'] = trim($_POST['editarCelular']) === '' ? '0' : trim($_POST['editarCelular']);
				$_POST['editarCorreo'] = trim($_POST['editarCorreo']) === '' ? 'vacio@vacio.com' : trim($_POST['editarCorreo']);
				$_POST['editarRol'] = trim($_POST['editarRol']) === '' ? 'No sabemos el rol' : trim($_POST['editarRol']);
				$_POST['editarComentarios'] = trim($_POST['editarComentarios']) === '' ? 'Sin comentarios' : trim($_POST['editarComentarios']);

				// Validación del nombre
				if (preg_match('/^[a-zA-ZñÑáéíóúÁÉÍÓÚ]+(?:\s+[a-zA-ZñÑáéíóúÁÉÍÓÚ]+)*\.?$/', $_POST["editarProveedor"])) {
					// Si el nombre es válido, se continúa con la actualización
					$tabla = "proveedores";
					$datos = array(
						"id" => $_POST["idProveedor"],
						"nombre" => $_POST["editarProveedor"],
						"celular" => $_POST["editarCelular"],
						"correo" => $_POST["editarCorreo"],
						"rol" => $_POST["editarRol"],
						"empresa" => $_POST["editarEmpresa"],
						"marca" => $_POST["editarMarca"],
						"comentarios" => $_POST["editarComentarios"]
					);
		
					// Log para comprobar datos que se van a guardar
					$respuesta = ModeloProveedores::mdlEditarProveedor($tabla, $datos);
					if($respuesta == "ok"){
						echo '<script>
						swal({
							type: "success",
							title: "El proveedor ha sido cambiado correctamente",
							showConfirmButton: true,
							confirmButtonText: "Cerrar"
							}).then(function(result){
										if (result.value) {
										window.location = "proveedores";
										}
									})
						</script>';
					} else {
						error_log("Error al editar proveedor: " . $respuesta);
						echo '<script>
							swal({
								type: "error",
								title: "Error al editar el proveedor",
								text: "' . $respuesta . '",
								showConfirmButton: true,
								confirmButtonText: "Cerrar"
							}).then(function(result){
								if (result.value) {
									window.location = "proveedores";
								}
							});
						</script>';
					}
				} else {
					error_log("El nombre y apellido no es válido, no se puede guardar.");
					echo '<script>
						swal({
							type: "error",
							title: "Error al editar el proveedor",
							text: "El nombre y apellido solo puede contener letras, espacios y puede terminar con un punto.",
							showConfirmButton: true,
							confirmButtonText: "Cerrar"
						}).then(function(result){
							if (result.value) {
								window.location = "proveedores";
							}
						});
					</script>';
				}
			}
		}
	}	
	

	/*=============================================
	BORRAR PROVEEDOR
	ES LLAMADA DESDE:
	PROVEEDORES.PHP
	=============================================*/
	static public function ctrBorrarProveedor(){
		if(isset($_GET["idProveedor"])){
			$tabla ="proveedores";
			$datos = $_GET["idProveedor"];
			$respuesta = ModeloProveedores::mdlBorrarProveedor($tabla, $datos);
			if($respuesta == "ok"){
				echo'<script>
					swal({
						  type: "success",
						  title: "La proveedor ha sido borrado correctamente",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result){
									if (result.value) {
									    window.location = "proveedores";
									}
								})
					</script>';
			}
		}	
	}
}