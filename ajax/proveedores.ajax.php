<?php
require_once "../controladores/proveedores.controlador.php";
require_once "../modelos/proveedores.modelo.php";
require_once "../vistas/config_logs.php";


class AjaxProveedores {
    /*=============================================
    EDITAR PROVEEDOR
    =============================================*/    
    public $idProveedor;

    public function ajaxEditarProveedor() {
        $item = "id";    
        $valor = $this->idProveedor;
        $respuesta = ControladorProveedores::ctrMostrarProveedoresFull($item, $valor);
        echo json_encode($respuesta);
    }
}

/*=============================================
EDITAR CLIENTE
=============================================*/    
if (isset($_POST["idProveedor"])) {
    $proveedor = new AjaxProveedores();
    $proveedor -> idProveedor = $_POST["idProveedor"];
    $proveedor -> ajaxEditarProveedor();
}
