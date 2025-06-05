<?php

class ControladorEmpresas{
	/*=============================================
	CREAR EMPRESAS
	ES LLAMADA DESDE:
	EMPRESAS.PHP
	=============================================*/
	static public function ctrCrearEmpresa(){
		if(isset($_POST["nuevaEmpresa"])){
			if(preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ \-]+$/', $_POST["nuevaEmpresa"])){
				$tabla = "empresas";
				$datos = array(
                    "empresa" => $_POST["nuevaEmpresa"],
                );

				$respuesta = ModeloEmpresas::mdlIngresarEmpresa($tabla, $datos);
				if($respuesta == "ok"){
    				echo'<script>
					swal({
						  type: "success",
						  title: "La empresa ha sido guardada correctamente",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result){
									if (result.value) {
									window.location = "empresas";
									}
								})
					</script>';
				}
			}else{
				echo'<script>
					swal({
						  type: "error",
						  title: "¡La empresa no puede ir vacía o llevar caracteres especiales!",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result){
							if (result.value) {
							window.location = "empresas";
							}
						})
			  	</script>';
			}
		}
	}

	/*=============================================
	MOSTRAR TODOS LOS ATRIBUTOS DE TODAS LAS EMPRESAS.
	ES LLAMADA DESDE:
	EMPRESAS.AJAX.PHP
	CONTACTOS.PHP
	EMPRESAS.PHP
	=============================================*/
	static public function ctrMostrarEmpresas($item, $valor){
		$tabla = "empresas";
		$respuesta = ModeloEmpresas::mdlMostrarEmpresas($tabla, $item, $valor);
		return $respuesta;
	}


	/*=============================================
	MOSTRAR EMPRESA SEGÚN EL ID DE LA EMPRESA.
	ES LLAMADA DESDE:
	PROVEEDOR.PHP
	=============================================*/
	static public function ctrMostrarEmpresasPorIDEmpresa($valor){
		$tabla = "empresas";
		$respuesta = ModeloEmpresas::mdlMostrarEmpresasPorIDEmpresa($tabla, $valor);
		return $respuesta;
	}


	/*=============================================
	MOSTRAR EMPRESAS ORDENADAS POR EL NOMBRE DE LA EMPRESA
	ES LLAMADA DESDE:
	PROVEEDOR.PHP
	=============================================*/
	static public function ctrMostrarEmpresasOrdenadasPorNombre(){
		$tabla = "empresas";
		$respuesta = ModeloEmpresas::mdlMostrarEmpresasOrdenadasPorNombre($tabla);
		return $respuesta;
	}


	/*=============================================
	EDITAR EMPRESA
	ES LLAMADA DESDE:
	EMPRESAS.PHP
	=============================================*/
	static public function ctrEditarEmpresa(){
		if(isset($_POST["editarEmpresa"])){
			if(preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ _-]+$/', $_POST["editarEmpresa"])){
				$tabla = "empresas";

				
				$datos = array("id"=>$_POST["idEmpresa"],
								"empresa"=>$_POST["editarEmpresa"],
							);
				//echo '<script> console.log("Valores de datos:", ' . json_encode($datos) . '); </script>';
				$respuesta = ModeloEmpresas::mdlEditarEmpresa($tabla, $datos);
				if($respuesta == "ok"){
					echo'<script>
					swal({
						  type: "success",
						  title: "La empresa ha sido cambiada correctamente",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result){
									if (result.value) {
									window.location = "empresas";
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
							    window.location = "empresas";
							}
						})
			  	</script>';
			}
		}
	}

	/*=============================================
	BORRAR EMPRESA
	ES LLAMADA DESDE:
	EMPRESAS.PHP
	=============================================*/
	static public function ctrBorrarEmpresa(){
		if(isset($_GET["idEmpresa"])){
			$tabla ="empresas";
			$datos = $_GET["idEmpresa"];

			$respuesta = ModeloEmpresas::mdlBorrarEmpresa($tabla, $datos);
			if($respuesta == "ok"){
				echo'<script>
					swal({
						  type: "success",
						  title: "La empresa ha sido borrada correctamente",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result){
									if (result.value) {
									    window.location = "empresas";
									}
								})
					</script>';
			}
		}	
	}
}
