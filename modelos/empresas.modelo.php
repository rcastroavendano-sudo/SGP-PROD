<?php

require_once "conexion.php";

class ModeloEmpresas{
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
	CREAR EMPRESA
	LLAMADA DESDE:
	EMPRESAS.CONTROLADOR.PHP
	=============================================*/
	static public function mdlIngresarEmpresa($tabla, $datos){
		// Validar si la tabla existe
		if (!self::tablaExiste($tabla)) {
			error_log("Error: La tabla '$tabla' no existe en la base de datos."); // Registro en el log
			return "La tabla '$tabla' no existe en la base de datos. Por favor, contacte con el administrador.";
		}

		// Actualiza la consulta SQL para insertar tanto el nombre de la empresa como el país
		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(empresa) VALUES (:empresa)");
	
		// Enlaza el valor de la empresa y el país
		$stmt->bindParam(":empresa", $datos["empresa"], PDO::PARAM_STR);
	
		// Ejecuta la consulta
		if($stmt->execute()){
			return "ok";
		} else {
			return "error";
		}
	
		// Cierra la conexión
		$stmt->close();
		$stmt = null;
	}
	

	/*=============================================
	MOSTRAR TODOS LOS ATRIBUTOS DE TODAS LAS EMPRESAS.
	LLAMADA DESDE:
	EMPRESAS.CONTROLADOR.PHP
	=============================================*/
	static public function mdlMostrarEmpresas($tabla, $item, $valor){
		// Validar si la tabla existe
		if (!self::tablaExiste($tabla)) {
			error_log("Error: La tabla '$tabla' no existe en la base de datos."); // Registro en el log
			return "La tabla '$tabla' no existe en la base de datos. Por favor, contacte con el administrador.";
		}
		

		if($item != null){
			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item AND mostrar = '1' ORDER BY id DESC");
			$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);
			$stmt -> execute();
			return $stmt -> fetch();
		}else{
			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE mostrar = '1' ORDER BY id DESC");
			$stmt -> execute();
			return $stmt -> fetchAll();
		}
		$stmt -> close();
		$stmt = null;
	}


	/*=============================================
	MOSTRAR EMPRESAS POR EL ID DE LA EMPRESA.
	LLAMADA DESDE:
	EMPRESAS.CONTROLADOR.PHP
	=============================================*/
    public static function mdlMostrarEmpresasPorIDEmpresa($tabla, $empresaID) {
		// Validar si la tabla existe
		if (!self::tablaExiste($tabla)) {
			error_log("Error: La tabla '$tabla' no existe en la base de datos."); // Registro en el log
			return "La tabla '$tabla' no existe en la base de datos. Por favor, contacte con el administrador.";
		}

        // Prepara la consulta SQL
        $stmt = Conexion::conectar()->prepare("SELECT empresa FROM $tabla WHERE ID = :ID AND mostrar = '1'");
        // Vincula el parámetro de la consulta con el valor del ID proporcionado
        $stmt->bindParam(":ID", $empresaID, PDO::PARAM_INT);
        // Ejecuta la consulta
        $stmt->execute();
        // Retorna el valor del empresa
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }


	/*=============================================
	MOSTRAR EMPRESAS ORDENADAS POR EL NOMBRE DE LA EMPRESA
	LLAMADA DESDE:
	EMPRESAS.CONTROLADOR.PHP
	=============================================*/
	static public function mdlMostrarEmpresasOrdenadasPorNombre($tabla) {
		// Validar si la tabla existe
		if (!self::tablaExiste($tabla)) {
			error_log("Error: La tabla '$tabla' no existe en la base de datos."); // Registro en el log
			return "La tabla '$tabla' no existe en la base de datos. Por favor, contacte con el administrador.";
		}
		
		$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE mostrar = '1' ORDER BY empresa ASC");
		$stmt->execute();
		$resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);
		$stmt->closeCursor();
		$stmt = null;
		return $resultado;
	}
	

	/*=============================================
	EDITAR EMPRESAS
	LLAMADA DESDE:
	EMPRESAS.CONTROLADOR.PHP
	=============================================*/
	static public function mdlEditarEmpresa($tabla, $datos) {
		// Validar si la tabla existe
		if (!self::tablaExiste($tabla)) {
			error_log("Error: La tabla '$tabla' no existe en la base de datos."); // Registro en el log
			return "La tabla '$tabla' no existe en la base de datos. Por favor, contacte con el administrador.";
		}

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET empresa = :empresa, fecha = NOW() WHERE id = :id");
		$stmt->bindParam(":empresa", $datos["empresa"], PDO::PARAM_STR);
		$stmt->bindParam(":id", $datos["id"], PDO::PARAM_INT);
	
		if ($stmt->execute()) {
			return "ok";
		} else {
			return "error";
		}
	
		$stmt = null;
	}
		
		
	/*=============================================
	BORRAR EMPRESAS
	ES LLAMADA DESDE:
	EMPRESAS.CONTROLADOR.PHP
	=============================================*/
	static public function mdlBorrarEmpresa($tabla, $datos){
		// Validar si la tabla existe
		if (!self::tablaExiste($tabla)) {
			error_log("Error: La tabla '$tabla' no existe en la base de datos."); // Registro en el log
			return "La tabla '$tabla' no existe en la base de datos. Por favor, contacte con el administrador.";
		}

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET mostrar = '0', fecha = NOW() WHERE id = :id");
		$stmt -> bindParam(":id", $datos, PDO::PARAM_INT);
		if($stmt -> execute()){
			return "ok";
		}else{
			return "error";	
		}
		$stmt -> close();
		$stmt = null;
	}
}

