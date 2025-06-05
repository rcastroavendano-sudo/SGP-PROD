<?php

class ControladorMarcas{
	/*=============================================
	CREAR MARCAS
	ES LLAMADA DESDE:
	MARCAS.PHP
	=============================================*/
	static public function ctrCrearMarca(){
		if(isset($_POST["nuevaMarca"])){
			if(preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ \/\-]+$/', $_POST["nuevaMarca"])){
				$tabla = "marcas";
					$datos = $_POST["nuevaMarca"];
				$respuesta = ModeloMarcas::mdlIngresarMarca($tabla, $datos);
				if($respuesta == "ok"){
    				echo'<script>
					swal({
						  type: "success",
						  title: "La marca ha sido guardada correctamente",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result){
									if (result.value) {
									window.location = "marcas";
									}
								})
					</script>';
				}
			}else{
				echo'<script>
					swal({
						  type: "error",
						  title: "¡La marca no puede ir vacía o llevar caracteres especiales!",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result){
							if (result.value) {
							window.location = "marcas";
							}
						})
			  	</script>';
			}
		}
	}

	/*=============================================
	MOSTRAR TODOS LOS ATRIBUTOS DE TODAS LAS MARCAS.
	ES LLAMADA DESDE:
	MARCAS.AJAX.PHP
	CONTACTOS.PHP
	MARCAS.PHP
	=============================================*/
	static public function ctrMostrarMarcas($item, $valor){
		$tabla = "marcas";
		$respuesta = ModeloMarcas::mdlMostrarMarcas($tabla, $item, $valor);
		return $respuesta;
	}


	/*=============================================
	MOSTRAR MARCA SEGÚN EL ID DE LA MARCA.
	ES LLAMADA DESDE:
	PROVEEDOR.PHP
	=============================================*/
	static public function ctrMostrarMarcasPorIDMarca($valor){
		$tabla = "marcas";
		$respuesta = ModeloMarcas::mdlMostrarMarcasPorIDMarca($tabla, $valor);
		return $respuesta;
	}


	/*=============================================
	MOSTRAR MARCAS ORDENADAS POR EL NOMBRE DE LA MARCA
	ES LLAMADA DESDE:
	PROVEEDOR.PHP
	=============================================*/
	static public function ctrMostrarMarcasOrdenadasPorNombre(){
		$tabla = "marcas";
		$respuesta = ModeloMarcas::mdlMostrarMarcasOrdenadasPorNombre($tabla);
		return $respuesta;
	}


	/*=============================================
	EDITAR MARCA
	ES LLAMADA DESDE:
	MARCAS.PHP
	=============================================*/
	static public function ctrEditarMarca(){
		if(isset($_POST["editarMarca"])){
			if(preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ _-]+$/', $_POST["editarMarca"])){
				$tabla = "marcas";
				$datos = array("marca"=>$_POST["editarMarca"],
							   "id"=>$_POST["idMarca"]);
							   $respuesta = ModeloMarcas::mdlEditarMarca($tabla, $datos);
				if($respuesta == "ok"){
					echo'<script>
					swal({
						  type: "success",
						  title: "La marca ha sido cambiada correctamente",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result){
									if (result.value) {
									window.location = "marcas";
									}
								})
					</script>';
				}
			}else{
				echo'<script>
					swal({
						  type: "error",
						  title: "¡La categoría no puede ir vacía o llevar caracteres especiales!",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result){
							if (result.value) {
							    window.location = "marcas";
							}
						})
			  	</script>';
			}
		}
	}

	
	/*=============================================
	BORRAR MARCA
	ES LLAMADA DESDE:
	MARCAS.PHP
	=============================================*/
	static public function ctrBorrarMarca(){
		if(isset($_GET["idMarca"])){
			$tabla ="Marcas";
			$datos = $_GET["idMarca"];
			$respuesta = ModeloMarcas::mdlBorrarMarca($tabla, $datos);
			if($respuesta == "ok"){
				echo'<script>
					swal({
						  type: "success",
						  title: "La marca ha sido borrada correctamente",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result){
									if (result.value) {
									    window.location = "marcas";
									}
								})
					</script>';
			}
		}	
	}
}
