<?php
require_once "../controladores/quotes.controlador.php";
require_once "../modelos/quotes.modelo.php";
require_once "../vistas/config_logs.php";


class AjaxQuotes {
    /*=============================================
	EDITAR COSTO
	=============================================*/	
    public $idCosto;

	public function ajaxEditarCosto() {
        $item = "id";    
        $valor = $this->idCosto;
        $respuesta = ControladorQuotes::ctrMostrarCostos($item, $valor);
        echo json_encode($respuesta);
    }
}

/*=============================================
EDITAR COSTO
=============================================*/	
if(isset($_POST["idCosto"])) {
	$costo = new AjaxQuotes();
	$costo -> idCosto = $_POST["idCosto"];
	$costo -> ajaxEditarCosto();
}