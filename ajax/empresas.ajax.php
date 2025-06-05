<?php
require_once "../controladores/empresas.controlador.php";
require_once "../modelos/empresas.modelo.php";
require_once "../vistas/config_logs.php";


class AjaxEmpresas{
	/*=============================================
	EDITAR EMPRESA
	=============================================*/	
	public $idMarca;

	public function ajaxEditarEmpresa(){
		$item = "id";	
		$valor = $this->idEmpresa;
		$respuesta = ControladorEmpresas::ctrMostrarEmpresas($item, $valor);
		echo json_encode($respuesta);
	}
}

/*=============================================
EDITAR EMPRESA
=============================================*/	
if(isset($_POST["idEmpresa"])){ 
	$empresa = new AjaxEmpresas();
	$empresa -> idEmpresa = $_POST["idEmpresa"];
	$empresa -> ajaxEditarEmpresa();
}

