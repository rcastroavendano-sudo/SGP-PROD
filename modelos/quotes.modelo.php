<?php

require_once "conexion.php";

class ModeloQuotes{
	/*=============================================
	VERIFICAR SI LA TABLA EXISTE
	=============================================*/
	static public function tablaExiste($tabla) {
		try {
			$stmt = Conexion::conectar()->prepare("SHOW TABLES LIKE :tabla");
			$stmt->bindParam(":tabla", $tabla, PDO::PARAM_STR);
			$stmt->execute();
			$resultado = $stmt->fetch(PDO::FETCH_ASSOC);
			return $resultado ? true : false;
		} catch (Exception $e) {
			return false;
		} finally {
			$stmt = null;
		}
	}

	/*=============================================
	MOSTRAR EL COSTO DE UN ITEM EN PARTICULAR
	=============================================*/
	static public function mdlMostrarCostoXValorItem($valor, $tabla) { 
		if (!self::tablaExiste($tabla)) {
			error_log("Error: La tabla '$tabla' no existe en la base de datos."); // Registro en el log
			return "La tabla '$tabla' no existe en la base de datos. Por favor, contacte con el administrador.";
		}
		
        // Prepara la consulta SQL
        $stmt = Conexion::conectar()->prepare("SELECT valor FROM $tabla WHERE item = :item");
    
        // Vincula el parámetro de la consulta con el valor de 'vCPU'
        $stmt->bindParam(":item", $valor, PDO::PARAM_STR); // Cambiar a PDO::PARAM_STR
    
        // Ejecuta la consulta
        $stmt->execute();
    
        // Retorna el valor del costo
        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
    
        // Verifica si se encontró un valor y retorna el costo
        return $resultado ? $resultado['valor'] : null;
    }


  /*=============================================
	MOSTRAR TODOS LOS VENDEDORES Y ADMINISTRADOR
	=============================================*/
	public static function mdlMostrarVendedores($tabla){
		// Validar si la tabla existe
		if (!self::tablaExiste($tabla)) {
			error_log("Error: La tabla '$tabla' no existe en la base de datos."); // Registro en el log
			return "La tabla '$tabla' no existe en la base de datos. Por favor, contacte con el administrador.";
		}
		
		$stmt = Conexion::conectar()->prepare("SELECT nombre, usuario FROM $tabla WHERE (perfil = 'Venta' OR perfil ='Administrador') AND mostrar = '1' ORDER BY id ASC");
		$stmt -> execute();
		return $stmt -> fetchAll();
		$stmt -> close();
		$stmt = null;
	}


    /*=============================================
	MOSTRAR TODOS LOS ITEMS.
	=============================================*/
	public static function mdlMostrarCostos($tabla, $item, $valor){
		// Validar si la tabla existe
		if (!self::tablaExiste($tabla)) {
			error_log("Error: La tabla '$tabla' no existe en la base de datos."); // Registro en el log
			return "La tabla '$tabla' no existe en la base de datos. Por favor, contacte con el administrador.";
		}
		
		if($item != null){
			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item AND mostrar = '1' ORDER BY id ASC");
			$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);
			$stmt -> execute();
			return $stmt -> fetch();
		}else{
			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE mostrar = '1' ORDER BY id ASC");
			$stmt -> execute();
			return $stmt -> fetchAll();
		}
		$stmt -> close();
		$stmt = null;
	}

	/*=============================================
	EDITAR ITEM
	=============================================*/
	static public function mdlEditarItem($tabla, $datos){
		// Validar si la tabla existe
		if (!self::tablaExiste($tabla)) {
			error_log("Error: La tabla '$tabla' no existe en la base de datos."); // Registro en el log
			return "La tabla '$tabla' no existe en la base de datos. Por favor, contacte con el administrador.";
		}
		error_log("Datos recibidos: " . print_r($datos, true));
		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET item = :item, valor = :valor, descripcion = :descripcion, fecha = NOW() WHERE id = :id");
		$stmt -> bindParam(":id", $datos["id"], PDO::PARAM_INT);
		$stmt -> bindParam(":item", $datos["item"], PDO::PARAM_STR);
		$stmt -> bindParam(":valor", $datos["valor"], PDO::PARAM_STR);
		$stmt -> bindParam(":descripcion", $datos["descripcion"], PDO::PARAM_STR);
		if($stmt->execute()){
			return "ok";
		}else{
			return "error";
		}
		$stmt->close();
		$stmt = null;
	}
}

