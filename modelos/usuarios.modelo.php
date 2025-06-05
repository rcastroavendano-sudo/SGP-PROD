<?php

require_once "conexion.php";

class ModeloUsuarios{
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
	MOSTRAR USUARIOS
	=============================================*/
	static public function mdlMostrarUsuarios($tabla, $item, $valor){
		// Validar si la tabla existe

		if (!self::tablaExiste($tabla)) {
			error_log("Error: La tabla '$tabla' no existe en la base de datos."); // Registro en el log
			return "La tabla '$tabla' no existe en la base de datos. Por favor, contacte con el administrador.";
		}
		
		if($item != null){
			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item AND mostrar='1' ORDER BY id");
			$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);
			$stmt -> execute();
			return $stmt -> fetch();
		}else{
			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE mostrar='1' ORDER BY id");
			$stmt -> execute();
			return $stmt -> fetchAll();
		}	
		$stmt -> close();
		$stmt = null;
	}

	/*=============================================
	REGISTRO DE USUARIO (NUEVO USUARIO)
	=============================================*/
	static public function mdlIngresarUsuario($tabla, $datos){
		// Validar si la tabla existe
		if (!self::tablaExiste($tabla)) {
			error_log("Error: La tabla '$tabla' no existe en la base de datos."); // Registro en el log
			return "La tabla '$tabla' no existe en la base de datos. Por favor, contacte con el administrador.";
		}
		
		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(nombre, usuario, correo, password, perfil) VALUES (:nombre, :usuario, :correo, :password, :perfil)");
		$stmt->bindParam(":nombre", $datos["nombre"], PDO::PARAM_STR);
		$stmt->bindParam(":usuario", $datos["usuario"], PDO::PARAM_STR);
		$stmt->bindParam(":correo", $datos["correo"], PDO::PARAM_STR);
		$stmt->bindParam(":password", $datos["password"], PDO::PARAM_STR);
		$stmt->bindParam(":perfil", $datos["perfil"], PDO::PARAM_STR);
		if($stmt->execute()){
			return "ok";	
		}else{
			return "error";
		}
		$stmt->close();
		$stmt = null;
	}

	/*=============================================
	EDITAR USUARIO
	=============================================*/
	static public function mdlEditarUsuario($tabla, $datos){
		// Validar si la tabla existe
		if (!self::tablaExiste($tabla)) {
			error_log("Error: La tabla '$tabla' no existe en la base de datos."); // Registro en el log
			return "La tabla '$tabla' no existe en la base de datos. Por favor, contacte con el administrador.";
		}
		
		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET nombre = :nombre, correo = :correo, password = :password, perfil = :perfil, fecha = NOW() WHERE usuario = :usuario");
		$stmt -> bindParam(":nombre", $datos["nombre"], PDO::PARAM_STR);
		$stmt -> bindParam(":correo", $datos["correo"], PDO::PARAM_STR);
		$stmt -> bindParam(":password", $datos["password"], PDO::PARAM_STR);
		$stmt -> bindParam(":perfil", $datos["perfil"], PDO::PARAM_STR);
		$stmt -> bindParam(":usuario", $datos["usuario"], PDO::PARAM_STR);
		if($stmt -> execute()){
			return "ok";	
		}else{
			return "error";	
		}
		$stmt -> close();
		$stmt = null;
	}

	/*=============================================
	ACTUALIZAR USUARIO
	=============================================*/
	static public function mdlActualizarUsuario($tabla, $item1, $valor1, $item2, $valor2){
		// Validar si la tabla existe
		if (!self::tablaExiste($tabla)) {
			error_log("Error: La tabla '$tabla' no existe en la base de datos."); // Registro en el log
			return "La tabla '$tabla' no existe en la base de datos. Por favor, contacte con el administrador.";
		}
		
		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET $item1 = :$item1, fecha = NOW() WHERE $item2 = :$item2");
		$stmt -> bindParam(":".$item1, $valor1, PDO::PARAM_STR);
		$stmt -> bindParam(":".$item2, $valor2, PDO::PARAM_STR);
		if($stmt -> execute()){
			return "ok";
		}else{
			return "error";	
		}
		$stmt -> close();
		$stmt = null;
	}

	/*=============================================
	BORRAR USUARIO
	=============================================*/
	static public function mdlBorrarUsuario($tabla, $datos){
		// Validar si la tabla existe
		if (!self::tablaExiste($tabla)) {
			error_log("Error: La tabla '$tabla' no existe en la base de datos."); // Registro en el log
			return "La tabla '$tabla' no existe en la base de datos. Por favor, contacte con el administrador.";
		}
		
		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET mostrar = '0', fecha = NOW() WHERE id = :id");
		//$stmt = Conexion::conectar()->prepare("DELETE FROM $tabla WHERE id = :id");
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