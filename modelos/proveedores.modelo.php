<?php

require_once "conexion.php";

class ModeloProveedores{
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
	CREAR PROVEEDOR
	=============================================*/
	static public function mdlIngresarProveedor($tabla, $datos){
		// Validar si la tabla existe
		if (!self::tablaExiste($tabla)) {
			error_log("Error: La tabla '$tabla' no existe en la base de datos."); // Registro en el log
			return "La tabla '$tabla' no existe en la base de datos. Por favor, contacte con el administrador.";
		}

		try {
			// Preparar la consulta SQL para insertar en la tabla de proveedores
			$stmt1 = Conexion::conectar()->prepare("INSERT INTO $tabla (nombre, celular, correo, rol, empresa_id, comentarios, fecha, mostrar) VALUES (:proveedor, :celular, :correo, :rol, :empresa, :comentarios, NOW(), 1)");
		
			// Vincular los parámetros para la primera inserción en proveedores
			$stmt1->bindParam(":proveedor", $datos["proveedor"], PDO::PARAM_STR);
			$stmt1->bindParam(":celular", $datos["celular"], PDO::PARAM_STR);
			$stmt1->bindParam(":correo", $datos["correo"], PDO::PARAM_STR);
			$stmt1->bindParam(":rol", $datos["rol"], PDO::PARAM_STR);
			$stmt1->bindParam(":empresa", $datos["empresa"], PDO::PARAM_STR);
			$stmt1->bindParam(":comentarios", $datos["comentario"], PDO::PARAM_STR);
		
			// Ejecutar la primera consulta
			if ($stmt1->execute()) {
				// Obtener el último ID insertado usando otra consulta
				$sqlLastId = "SELECT id FROM $tabla WHERE nombre = :proveedor ORDER BY fecha DESC LIMIT 1";
				$stmtLastId = Conexion::conectar()->prepare($sqlLastId);
				$stmtLastId->bindParam(":proveedor", $datos["proveedor"], PDO::PARAM_STR);
	
				if ($stmtLastId->execute()) {
					$lastIdRow = $stmtLastId->fetch();
					if ($lastIdRow) {
						$newProveedorId = $lastIdRow["id"];

						// Preparar la segunda consulta para insertar en la tabla proveedor_marca
						$stmt2 = Conexion::conectar()->prepare("INSERT INTO proveedor_marca (proveedor_id, marca_id, fecha, mostrar) VALUES (:proveedorID, :marcaID, NOW(), 1)");
						
						// Vincular los parámetros para la segunda inserción
						$stmt2->bindParam(":proveedorID", $newProveedorId, PDO::PARAM_INT);
						$stmt2->bindParam(":marcaID", $datos["marca"], PDO::PARAM_INT);
						
						// Ejecutar la segunda consulta
						if ($stmt2->execute()) {
							return "ok"; // Ambas inserciones fueron exitosas
						} else {
							$errorInfo = $stmt2->errorInfo();
							return "error"; // Fallo en la inserción de proveedor_marca
						}
					} else {
						return "error";
					}
				} else {
					$errorInfo = $stmtLastId->errorInfo();
					return "error";
				}
			} else {
				$errorInfo = $stmt1->errorInfo();
				return "error"; // Fallo en la inserción en la tabla principal
			}
		} catch (PDOException $e) {
			return "error: " . $e->getMessage();
		}
	}

	
	/*=============================================
	MOSTRAR TODOS LOS ATRIBUTOS DE TODOS LOS CONTACTOS.
	=============================================*/
	public static function mdlMostrarProveedores($tabla) {
		// Validar si la tabla existe
		if (!self::tablaExiste($tabla)) {
			error_log("Error: La tabla '$tabla' no existe en la base de datos."); // Registro en el log
			return "La tabla '$tabla' no existe en la base de datos. Por favor, contacte con el administrador.";
		}
	
		// Consulta modificada para incluir proveedor_marca
		$query = "SELECT p.id, p.nombre, p.celular, p.correo, p.rol, p.fecha, p.comentarios, 
					e.empresa, m.marca, pm.marca_id
				FROM $tabla p
				LEFT JOIN empresas e ON p.empresa_id = e.id
				LEFT JOIN proveedor_marca pm ON p.id = pm.proveedor_id
				LEFT JOIN marcas m ON pm.marca_id = m.id
				WHERE p.mostrar = '1'
				ORDER BY p.fecha DESC
				";
		$stmt = Conexion::conectar()->prepare($query);
		$stmt->execute();
		return $stmt->fetchAll();
		$stmt->close();
		$stmt = null;
	}
		

	/*=============================================
	MOSTRAR TODOS LOS ATRIBUTOS DE TODOS LOS CONTACTOS INCLUYENDO EL NOMBRE DE LA EMPRESA Y EL NOMBRE DE LA MARCA
	PERMITE QUE EL MODAL QUE SE ABRE AL MOMENTO DE EDITAR, MUESTRE TODOS LOS DATOS DEL PROVEEDOR
	=============================================*/
	static public function mdlMostrarProveedoresFull($tabla, $item, $valor){
		// Validar si la tabla existe
		if (!self::tablaExiste($tabla)) {
			error_log("Error: La tabla '$tabla' no existe en la base de datos."); // Registro en el log
			return "La tabla '$tabla' no existe en la base de datos. Por favor, contacte con el administrador.";
		}

		$stmt = Conexion::conectar()->prepare("SELECT c.id AS proveedor_id, c.nombre, c.celular, c.correo, c.rol, e.id AS empresa_id, e.empresa AS nombre_empresa, m.id AS marca_id, m.marca AS marca_empresa, c.comentarios FROM proveedores c JOIN empresas e ON c.empresa_id = e.id JOIN proveedor_marca cm ON c.id = cm.proveedor_id JOIN marcas m ON cm.marca_id = m.id WHERE c.id = :valor AND c.mostrar = '1'");
		$stmt->bindParam(":valor", $valor, PDO::PARAM_STR); // Correcto uso de bindParam
		$stmt->execute();
		$resultado = $stmt->fetch();
		// Cerrando correctamente la declaración y liberando recursos
		$stmt->closeCursor();
		$stmt = null;

		return $resultado;
	}


	/*=============================================
	EDITAR PROVEEDOR
	=============================================*/
	static public function mdlEditarProveedor($tabla, $datos){
		// Validar si la tabla existe
		if (!self::tablaExiste($tabla)) {
			error_log("Error: La tabla '$tabla' no existe en la base de datos."); // Registro en el log
			return "La tabla '$tabla' no existe en la base de datos. Por favor, contacte con el administrador.";
		}
	
		// Paso 1: Verificar si la empresa está asociada al país seleccionado
		$sqlCheck = "SELECT id FROM empresas WHERE id = :empresa AND mostrar = '1'";
		$stmtCheck = Conexion::conectar()->prepare($sqlCheck);
		$stmtCheck->bindParam(":empresa", $datos["empresa"], PDO::PARAM_INT);
		
		if ($stmtCheck->execute()) {
			$existingCompany = $stmtCheck->fetch();
			$stmtCheck->closeCursor();
		} else {
			return "error";
		}
	
		// Paso 2: Si no hay relación entre empresa y país, insertar nueva relación
		if (!$existingCompany) {
			$sqlGetEmpresaNombre = "SELECT empresa FROM empresas WHERE id = :empresa AND mostrar = '1'";
			$stmtGetEmpresaNombre = Conexion::conectar()->prepare($sqlGetEmpresaNombre);
			$stmtGetEmpresaNombre->bindParam(":empresa", $datos["empresa"], PDO::PARAM_INT);
			
			if ($stmtGetEmpresaNombre->execute()) {
				$empresaRow = $stmtGetEmpresaNombre->fetch();
				$stmtGetEmpresaNombre->closeCursor();
			} else {
				return "error";
			}
	
			if ($empresaRow) {
				$empresaNombre = $empresaRow["empresa"];
				$sqlInsertEmpresa = "INSERT INTO empresas (empresa, fecha, mostrar) VALUES (:empresaNombre, NOW(), 1)";
				$stmtInsertEmpresa = Conexion::conectar()->prepare($sqlInsertEmpresa);
				$stmtInsertEmpresa->bindParam(":empresaNombre", $empresaNombre, PDO::PARAM_STR);
	
				if ($stmtInsertEmpresa->execute()) {
					// Obtener el último ID insertado usando otra consulta
					$sqlLastId = "SELECT id FROM empresas WHERE empresa = :empresaNombre ORDER BY fecha DESC LIMIT 1";
					$stmtLastId = Conexion::conectar()->prepare($sqlLastId);
					$stmtLastId->bindParam(":empresaNombre", $empresaNombre, PDO::PARAM_STR);
	
					if ($stmtLastId->execute()) {
						$lastIdRow = $stmtLastId->fetch();
						if ($lastIdRow) {
							$newEmpresaId = $lastIdRow["id"];
						} else {
							return "error";
						}
						$stmtLastId->closeCursor();
					} else {
						$errorInfo = $stmtLastId->errorInfo();
						return "error";
					}
					$stmtInsertEmpresa->closeCursor();
				} else {
					$errorInfo = $stmtInsertEmpresa->errorInfo();
					return "error";
				}
			} else {
				return "error";
			}
		} else {
			$newEmpresaId = $existingCompany["id"];
		}
	
		if (empty($datos["id"])) {
			return "error";
		}
	
		// Paso 3: Actualizar los datos del proveedor
		$sql = "UPDATE $tabla SET 
					nombre = :nombre, 
					celular = :celular, 
					correo = :correo, 
					rol = :rol, 
					comentarios = :comentarios, 
					fecha = NOW(), 
					mostrar = 1, 
					empresa_id = :empresa_id 
				WHERE id = :id AND mostrar = '1'";
	
		$stmt = Conexion::conectar()->prepare($sql);
	
		$stmt->bindParam(":nombre", $datos["nombre"], PDO::PARAM_STR);
		$stmt->bindParam(":celular", $datos["celular"], PDO::PARAM_STR);
		$stmt->bindParam(":correo", $datos["correo"], PDO::PARAM_STR);
		$stmt->bindParam(":rol", $datos["rol"], PDO::PARAM_STR);
		$stmt->bindParam(":comentarios", $datos["comentarios"], PDO::PARAM_STR);
		$stmt->bindParam(":empresa_id", $newEmpresaId, PDO::PARAM_INT);
		$stmt->bindParam(":id", $datos["id"], PDO::PARAM_INT);
	
		if ($stmt->execute()) {
			if ($stmt->rowCount() > 0) {
				$stmt->closeCursor();
			} else {
				return "no_update";
			}
		} else {
			$errorInfo = $stmt->errorInfo();
			return "error";
		}


		 // Paso adicional: Actualizar o insertar la marca en la tabla proveedor_marca
		 if (!empty($datos["marca"])) {
			$sqlMarcaCheck = "SELECT id FROM proveedor_marca WHERE proveedor_id = :proveedor_id";
			$stmtMarcaCheck = Conexion::conectar()->prepare($sqlMarcaCheck);
			$stmtMarcaCheck->bindParam(":proveedor_id", $datos["id"], PDO::PARAM_INT);
	
			if ($stmtMarcaCheck->execute()) {
				$existingMarca = $stmtMarcaCheck->fetch();
				$stmtMarcaCheck->closeCursor();
	
				if ($existingMarca) {
					// Si ya existe una relación, actualizamos la marca

					$sqlUpdateMarca = "UPDATE proveedor_marca SET marca_id = :marca_id, fecha = NOW(), mostrar = 1 WHERE proveedor_id = :proveedor_id";
					$stmtUpdateMarca = Conexion::conectar()->prepare($sqlUpdateMarca);
					$stmtUpdateMarca->bindParam(":marca_id", $datos["marca"], PDO::PARAM_INT);
					$stmtUpdateMarca->bindParam(":proveedor_id", $datos["id"], PDO::PARAM_INT);
					$stmtUpdateMarca->execute();
					$stmtUpdateMarca->closeCursor();
				} else {
					// Si no existe una relación, insertamos una nueva
					$sqlInsertMarca = "INSERT INTO proveedor_marca (proveedor_id, marca_id, fecha, mostrar) VALUES (:proveedor_id, :marca_id, NOW(), 1)";
					$stmtInsertMarca = Conexion::conectar()->prepare($sqlInsertMarca);
					$stmtInsertMarca->bindParam(":proveedor_id", $datos["id"], PDO::PARAM_INT);
					$stmtInsertMarca->bindParam(":marca_id", $datos["marca"], PDO::PARAM_INT);
					$stmtInsertMarca->execute();
					$stmtInsertMarca->closeCursor();
				}
			} else {
				return "error";
			}
		}
	    return "ok";
	}
	

	/*=============================================
	BORRAR PROVEEDOR
	=============================================*/
	static public function mdlBorrarProveedor($tabla, $datos) {
		// Validar si la tabla existe
		if (!self::tablaExiste($tabla)) {
			error_log("Error: La tabla '$tabla' no existe en la base de datos."); // Registro en el log
			return "La tabla '$tabla' no existe en la base de datos. Por favor, contacte con el administrador.";
		}

		// Preparar la consulta
		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET mostrar = '0', fecha = NOW() WHERE id = :id");
		$stmt->bindParam(":id", $datos, PDO::PARAM_INT);

		// Intentar ejecutar la consulta
		if ($stmt->execute()) {
			return "ok";
		} else {
			error_log("Error al ejecutar el borrado para el ID: $datos"); // Registro en el log
			return "error";    
		}

		// Cerrar la conexión (este bloque no se ejecutará después de los return)
		$stmt->close();
		$stmt = null;
	}
}


