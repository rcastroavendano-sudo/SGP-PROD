<?php

require_once "conexion.php";

class ModeloMarcas{
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
	CREAR MARCA
	LLAMADA DESDE:
	MARCAS.CONTROLADOR.PHP
	=============================================*/
	static public function mdlIngresarMarca($tabla, $datos){
		// Validar si la tabla existe
		if (!self::tablaExiste($tabla)) {
			error_log("Error: La tabla '$tabla' no existe en la base de datos."); // Registro en el log
			return "La tabla '$tabla' no existe en la base de datos. Por favor, contacte con el administrador.";
		}

		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(marca) VALUES (:marca)");
		$stmt->bindParam(":marca", $datos, PDO::PARAM_STR);
		if($stmt->execute()){
			return "ok";
		}else{
	    	return "error";
		}
		$stmt->close();
		$stmt = null;
	}
	

	/*=============================================
	MOSTRAR TODOS LOS ATRIBUTOS DE TODAS LAS MARCAS.
	LLAMADA DESDE:
	MARCAS.CONTROLADOR.PHP
	=============================================*/
	static public function mdlMostrarMarcas($tabla, $item, $valor){
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
	MOSTRAR MARCAS POR EL ID DE LA MARCA.
	LLAMADA DESDE:
	MARCAS.CONTROLADOR.PHP
	=============================================*/
	static public function mdlMostrarMarcasPorIDMarca($tabla, $valor) {
		// Validar si la tabla existe
		if (!self::tablaExiste($tabla) || !self::tablaExiste('proveedor_marca')) {
			error_log("Error: La tabla '$tabla' no existe en la base de datos."); // Registro en el log
			return "La tabla '$tabla' o 'proveedor_marca' no existe en la base de datos. Por favor, contacte con el administrador.";
		}


		// Prepara la consulta SQL para obtener la primera marca asociada a un proveedor
		$stmt = Conexion::conectar()->prepare("SELECT marcas.marca 
											   FROM proveedor_marca 
											   JOIN marcas ON proveedor_marca.marca_id = marcas.id 
											   WHERE proveedor_marca.proveedor_id = :id
											   ");
	
		// Vincula el valor del parámetro
		$stmt->bindParam(":id", $valor, PDO::PARAM_INT);
	
		// Ejecuta la consulta y devuelve el resultado
		if ($stmt->execute()) {
			return $stmt->fetch(PDO::FETCH_ASSOC); // Retorna solo una marca
		} else {
			return null; // Cambiar a null en caso de error
		}
	
		$stmt = null; // No es necesario cerrar el statement
	}
	
	
	/*=============================================
	MOSTRAR MARCAS ORDENADAS POR EL NOMBRE DE LA MARCA
	ES LLAMADA DESDE:
	MARCAS.CONTROLADOR.PHP
	=============================================*/
	static public function mdlMostrarMarcasOrdenadasPorNombre($tabla) {
		// Validar si la tabla existe
		if (!self::tablaExiste($tabla)) {
			error_log("Error: La tabla '$tabla' no existe en la base de datos."); // Registro en el log
			return "La tabla '$tabla' no existe en la base de datos. Por favor, contacte con el administrador.";
		}

		$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE mostrar = '1' ORDER BY marca ASC");
		$stmt->execute();
		$resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);
		$stmt->closeCursor();
		$stmt = null;
		return $resultado;
	}


	/*=============================================
	EDITAR MARCA
	LLAMADA DESDE:
	MARCAS.CONTROLADOR.PHP
	=============================================*/
	static public function mdlEditarMarca($tabla, $datos){
		// Validar si la tabla existe
		if (!self::tablaExiste($tabla)) {
			error_log("Error: La tabla '$tabla' no existe en la base de datos."); // Registro en el log
			return "La tabla '$tabla' no existe en la base de datos. Por favor, contacte con el administrador.";
		}

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET marca = :marca, fecha = NOW() WHERE id = :id");
		$stmt -> bindParam(":marca", $datos["marca"], PDO::PARAM_STR);
		$stmt -> bindParam(":id", $datos["id"], PDO::PARAM_INT);
		if($stmt->execute()){
			return "ok";
		}else{
			return "error";
		}
		$stmt->close();
		$stmt = null;
	}


	/*=============================================
	BORRAR MARCAS
	ES LLAMADA DESDE:
	MARCAS.CONTROLADOR.PHP
	=============================================*/
	static public function mdlBorrarMarca($tabla, $datos){
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

