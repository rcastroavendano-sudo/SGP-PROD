<?php

class ControladorQuotes{
	/*=============================================
	MOSTRAR EL VALOR DEL ITEM DEL DATACENTER
	ES LLAMADA DESDE:
	quotes.ajax.php
	=============================================*/

    static public function ctrMostrarCostoXValorItem($valor, $tabla) { 
		$respuesta = ModeloQuotes::mdlMostrarCostoXValorItem($valor, $tabla); // Pasar valor de vCPU
        return $respuesta;
    }

	/*=============================================
	MOSTRAR TODOS LOS COSTOS DE LA CLOUD
	ES LLAMADA DESDE:
	quotes-cloud-precios-venta.ajax.php
	quotes.ajax.php
	quotes-cloud-precios-venta.php
	=============================================*/
	static public function ctrMostrarCostos($item, $valor){
		$tabla = "datacenter";
		$respuesta = ModeloQuotes::mdlMostrarCostos($tabla, $item, $valor);
		return $respuesta;
	}

	/*=============================================
	MOSTRAR TODOS LOS VENDEDORES y ADMINISTRADOR
	QUE ESTAN REGISTRADOS EN EL SISTEMA
	ES LLAMADA DESDE:
	quotes-cloud.PHP
	=============================================*/
	static public function ctrMostrarVendedores(){
		$tabla = "usuarios";
		$respuesta = ModeloQuotes::mdlMostrarVendedores($tabla);
		return $respuesta;
	}


	/*=============================================
	EDITAR ITEM
	ES LLAMADA DESDE:
	quotes-cloud-precios-venta.PHP
	=============================================*/
	static public function ctrEditarCosto(){
		if(isset($_POST["editarItem"])){
			if(preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ _-]+$/', $_POST["editarItem"])){
				$tabla = "datacenter";
				$datos = array("id"=>$_POST["idCosto"],
							   "item"=>$_POST["editarItem"],
							   "valor"=>$_POST["editarValor"],
							   "descripcion"=>$_POST["editarDescripcion"]
							);
			
				$respuesta = ModeloQuotes::mdlEditarItem($tabla, $datos);
				if($respuesta == "ok"){
					echo'<script>
					swal({
						  type: "success",
						  title: "El costo ha sido cambiado correctamente",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result){
									if (result.value) {
									window.location = "quotes-cloud-precios-venta";
									}
								})
					</script>';
				}
			}else{
				echo'<script>
					swal({
						  type: "error",
						  title: "¡El costo no puede ir vacío o llevar caracteres especiales!",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result){
							if (result.value) {
							    window.location = "quotes-cloud-precios-venta";
							}
						})
			  	</script>';
			}
		}
	}
}
?>
