<?php
require_once "../controladores/quotes.controlador.php";
require_once "../modelos/quotes.modelo.php";
require_once "../vistas/config_logs.php";


class AjaxQuotes {
    /*=============================================
	EDITAR ITEM DE VENTA
	=============================================*/	
    public $idCosto;
    public $valorItem;

	public function ajaxEditarCosto() {
        $item = "id";    
        $valor = $this->idCosto;
    
        // Llama al controlador para obtener la respuesta
        $respuesta = ControladorQuotes::ctrMostrarCostos($item, $valor);

        // Devuelve la respuesta como JSON
        echo json_encode($respuesta);
    }
    

/*==================================================================================================*/
/*==========================INICIALIZANDO LAS VARIABLES DESDE LA BD=================================*/
/*==================================================================================================*/
//Funcion que obtiene los valores de todos los items de venta desde la BD, se llama desde un IF
    public function ajaxObtenerValorItem() {
        // Generar un identificador único para la solicitud (por ejemplo, timestamp con un sufijo aleatorio)
        $requestId = uniqid('request_', true);
    
        // Recibir el valor de "valorItem" de la instancia
        $valor = $this->valorItem;
        $tabla = "datacenter";
        // Llamamos a la función que obtiene el valor de vcpu
        $resultado = ControladorQuotes::ctrMostrarCostoXValorItem($valor, $tabla);
    
        // Registrar en el log el resultado obtenido con el identificador
        //error_log("[$requestId] ajaxObtenerValorItem: resultado obtenido -> " . json_encode($resultado));
    
        // Devolvemos la respuesta en formato JSON
        echo json_encode(['success' => true, 'valor' => $resultado]);
    }
    
}//Cierre Clase AjaxQuotes


/*===========================================================
IF PARA LLAMAR AL ajaxObtenerValorItem Y QUE ASIGNA EL VALOR DE VENTA DE ITEM A CADA ITEM DESDE LA BD
===========================================================*/
if (
    isset($_POST['accion']) &&
    in_array(
        $_POST['accion'],
        [
            'obtenerValorDCBellet',
            'obtenerValorDCUBellet',
            'obtenerValorDCLiray',
            'obtenerValorDCULiray',
            'obtenerValorDCAmbos',
            'obtenerValorVcpu',
            'obtenerValorVmem',
            'obtenerValorVdisk',
            'obtenerValorBkpBronze',
            'obtenerValorBkpSilver',
            'obtenerValorBkpGold',
            'obtenerValorBkpPlatinum',
            'obtenerValorSOLinux',
            'obtenerValorSOWindows',
            'obtenerValorSOOracle',
            'obtenerValorSOCals',
            'obtenerValorBDMySQL',
            'obtenerValorBDSQLServer',
            'obtenerValorBDPostgreSQL',
            'obtenerValorBDSal',
            'obtenerValorRedesBWINET100PrimarioBellet',
            'obtenerValorRedesBWINET200PrimarioBellet',
            'obtenerValorRedesBWINET300PrimarioBellet',
            'obtenerValorRedesBWINET100SecundarioBellet',
            'obtenerValorRedesBWINET200SecundarioBellet',
            'obtenerValorRedesBWINET300SecundarioBellet',
            'obtenerValorRedesBWINET100PrimarioLiray',
            'obtenerValorRedesBWINET200PrimarioLiray',
            'obtenerValorRedesBWINET300PrimarioLiray',
            'obtenerValorRedesBWINET100SecundarioLiray',
            'obtenerValorRedesBWINET200SecundarioLiray',
            'obtenerValorRedesBWINET300SecundarioLiray',
            'obtenerValorRedesIPPublica'
        ]
    )
) {
    $accion = $_POST['accion'];

    //error_log("ajaxObtenerValorItem: acción recibida -> " . $accion); // Log de acción recibida

    $valorItem = "";

    switch ($accion) {
        case 'obtenerValorDCBellet':
            $valorItem = "DC_bellet";
            error_log("obtenerValorDCBellet: valorItem asignado -> DC_bellet"); // Log de valor asignado
            break;

        case 'obtenerValorDCUBellet':
            $valorItem = "DC_U_BELLET";
            error_log("obtenerValorDCUBellet: valorItem asignado -> DC_bellet"); // Log de valor asignado
            break;

        case 'obtenerValorDCLiray':
            $valorItem = "DC_liray";
            //error_log("obtenerValorDCLiray: valorItem asignado -> DC_liray"); // Log de valor asignado
            break;
        
        case 'obtenerValorDCULiray':
            $valorItem = "DC_U_LIRAY";
            error_log("obtenerValorDCUBellet: valorItem asignado -> DC_bellet"); // Log de valor asignado
            break;

        case 'obtenerValorDCAmbos':
            $valorItem = "DC_ambos";
            //error_log("obtenerValorDCAmbos: valorItem asignado -> DC_ambos"); // Log de valor asignado
            break;

        case 'obtenerValorVcpu':
            $valorItem = "VCPU";
            //error_log("obtenerValorVcpu: valorItem asignado -> VCPU"); // Log de valor asignado
            break;
        case 'obtenerValorVmem':
            $valorItem = "VMEM";
            //error_log("obtenerValorVmem: valorItem asignado -> VMEM"); // Log de valor asignado
            break;
        case 'obtenerValorVdisk':
            $valorItem = "VDISK";
            //error_log("obtenerValorVdisk: valorItem asignado -> VDISK"); // Log de valor asignado
            break;
        case 'obtenerValorBkpBronze':
            $valorItem = "BKP_BRONZE";
            //error_log("obtenerValorBkpBronze: valorItem asignado -> BKP_BRONZE"); // Log de valor asignado
            break;
        case 'obtenerValorBkpSilver':
            $valorItem = "BKP_SILVER";
            //error_log("obtenerValorBkpSilver: valorItem asignado -> BKP_SILVER"); // Log de valor asignado
            break; 
        case 'obtenerValorBkpGold':
            $valorItem = "BKP_GOLD";
            //error_log("obtenerValorBkpGold: valorItem asignado -> BKP_GOLD"); // Log de valor asignado
            break;             
        case 'obtenerValorBkpPlatinum':
            $valorItem = "BKP_PLATINUM";
            //error_log("obtenerValorBkpPlatinum: valorItem asignado -> BKP_PLATINUM"); // Log de valor asignado
            break;      
        case 'obtenerValorSOLinux':
            $valorItem = "LINUX";
            //error_log("obtenerValorSOLinux: valorItem asignado -> LINUX"); // Log de valor asignado
            break;  
        case 'obtenerValorSOWindows':
            $valorItem = "WINDOWS";
            //error_log("obtenerValorSOWindows: valorItem asignado -> WINDOWS"); // Log de valor asignado
            break; 
        case 'obtenerValorSOOracle':
            $valorItem = "ORACLE";
            //error_log("obtenerValorSOOracle: valorItem asignado -> ORACLE"); // Log de valor asignado
            break; 
        case 'obtenerValorSOCals':
            $valorItem = "CALS";
            //error_log("obtenerValorSOCals: valorItem asignado -> CALS"); // Log de valor asignado
            break;
        case 'obtenerValorBDMySQL':
            $valorItem = "MySQL";
            //error_log("obtenerValorBDMySQL: valorItem asignado -> MySQL"); // Log de valor asignado
            break;
        case 'obtenerValorBDSQLServer':
            $valorItem = "SQL_Server";
            //error_log("obtenerValorBDSQLServer: valorItem asignado -> SQL_Server"); // Log de valor asignado
            break;
        case 'obtenerValorBDPostgreSQL':
            $valorItem = "POSTGRESQL";
            //error_log("obtenerValorBDPostgreSQL: valorItem asignado -> POSTGRESQL"); // Log de valor asignado
            break;    
        case 'obtenerValorBDSal':
            $valorItem = "SAL";
            //error_log("obtenerValorBDSal: valorItem asignado -> SAL"); // Log de valor asignado
            break;  

        case 'obtenerValorRedesBWINET100PrimarioBellet':
            $valorItem = "BWINET100_PRIMARIO_DC_BELLET";
            //error_log("obtenerValorRedesBWINET100: valorItem asignado -> BWINET100"); // Log de valor asignado
            break;
        case 'obtenerValorRedesBWINET200PrimarioBellet':
            $valorItem = "BWINET200_PRIMARIO_DC_BELLET";
            //error_log("obtenerValorRedesBWINET200: valorItem asignado -> BWINET200"); // Log de valor asignado
            break;
        case 'obtenerValorRedesBWINET300PrimarioBellet':
            $valorItem = "BWINET300_PRIMARIO_DC_BELLET";
            //error_log("obtenerValorRedesBWINET300: valorItem asignado -> BWINET300"); // Log de valor asignado
            break;
        case 'obtenerValorRedesBWINET100SecundarioBellet':
            $valorItem = "BWINET100_SECUNDARIO_DC_BELLET";
            //error_log("obtenerValorRedesBWINET100: valorItem asignado -> BWINET100"); // Log de valor asignado
            break;
        case 'obtenerValorRedesBWINET200SecundarioBellet':
            $valorItem = "BWINET200_SECUNDARIO_DC_BELLET";
            //error_log("obtenerValorRedesBWINET200: valorItem asignado -> BWINET200"); // Log de valor asignado
            break;
        case 'obtenerValorRedesBWINET300SecundarioBellet':
            $valorItem = "BWINET300_SECUNDARIO_DC_BELLET";
            //error_log("obtenerValorRedesBWINET300: valorItem asignado -> BWINET300"); // Log de valor asignado
            break;
            
        case 'obtenerValorRedesBWINET100PrimarioLiray':
            $valorItem = "BWINET100_PRIMARIO_DC_LIRAY";
            //error_log("obtenerValorRedesBWINET100: valorItem asignado -> BWINET100"); // Log de valor asignado
            break;
        case 'obtenerValorRedesBWINET200PrimarioLiray':
            $valorItem = "BWINET200_PRIMARIO_DC_LIRAY";
            //error_log("obtenerValorRedesBWINET200: valorItem asignado -> BWINET200"); // Log de valor asignado
            break;
        case 'obtenerValorRedesBWINET300PrimarioLiray':
            $valorItem = "BWINET300_PRIMARIO_DC_LIRAY";
            //error_log("obtenerValorRedesBWINET300: valorItem asignado -> BWINET300"); // Log de valor asignado
            break;
        case 'obtenerValorRedesBWINET100SecundarioLiray':
            $valorItem = "BWINET100_SECUNDARIO_DC_LIRAY";
            //error_log("obtenerValorRedesBWINET100: valorItem asignado -> BWINET100"); // Log de valor asignado
            break;
        case 'obtenerValorRedesBWINET200SecundarioLiray':
            $valorItem = "BWINET200_SECUNDARIO_DC_LIRAY";
            //error_log("obtenerValorRedesBWINET200: valorItem asignado -> BWINET200"); // Log de valor asignado
            break;
        case 'obtenerValorRedesBWINET300SecundarioLiray':
            $valorItem = "BWINET300_SECUNDARIO_DC_LIRAY";
            //error_log("obtenerValorRedesBWINET300: valorItem asignado -> BWINET300"); // Log de valor asignado
            break;

        case 'obtenerValorRedesIPPublica':
            $valorItem = "IP_Publica";
            //error_log("obtenerValorRedesIPPublica: valorItem asignado -> IP_Publica"); // Log de valor asignado
            break;

        default:
            //error_log("Entro al default del quotes.ajax.php: acción no válida -> " . $accion); // Log si la acción no es válida
            //echo json_encode(['success' => false, 'message' => 'Acción no válida']);
            exit;
    }

    // Instancia de la clase y llamada al método genérico
    $ajax = new AjaxQuotes();
    $ajax->valorItem = $valorItem;
    $ajax->ajaxObtenerValorItem();
}
/*==================================================================================================*/
/*===============================FIN LAS VARIABLES DESDE LA BD======================================*/
/*==================================================================================================*/



/*===========================================================
IF PARA LLAMAR AL EDITAR ITEM DE VENTA QUE ESTA AL PRINCIPIO
===========================================================*/
if(isset($_POST["idCosto"])) {
	$costo = new AjaxQuotes();
	$costo -> idCosto = $_POST["idCosto"];
	$costo -> ajaxEditarCosto();
}
