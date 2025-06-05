<?php
require_once "../controladores/marcas.controlador.php";
require_once "../modelos/marcas.modelo.php";
require_once "../vistas/config_logs.php";


class AjaxMarcas{
	/*=============================================
	EDITAR MARCA
	=============================================*/	
	public $idMarca;

	public function ajaxEditarMarca(){
		$item = "id";	
		$valor = $this->idMarca;
		$respuesta = ControladorMarcas::ctrMostrarMarcas($item, $valor);
		echo json_encode($respuesta);
	}
}

/*=============================================
EDITAR MARCAS
=============================================*/	
if(isset($_POST["idMarca"])){
	$marca = new AjaxMarcas();
	$marca -> idMarca = $_POST["idMarca"];
	$marca -> ajaxEditarMarca();
}