<?php

class Conexion {
    static public function conectar() {
        try {
            $link = new PDO(
                "mysql:host=localhost;dbname=tiersist_sgp;charset=utf8",
                "tiersist_tiersist",  // Usuario
                "Tier1.ltda.-"       // Contraseña
            );
            $link->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $link;
        }
         catch (PDOException $e){
 
            // Mensaje personalizado según el tipo de error
            $errorMessage = $e->getMessage();

            // Verificar si el error es de autenticación (usuario o contraseña incorrectos)
            if (strpos($errorMessage, 'Access denied') !== false)
            {
                error_log("Error de autenticación (usuario o contraseña incorrectos): " . $errorMessage);
                die('<br><div class="alert alert-danger">Usuario o contraseña incorrectos. Por favor, verifique sus credenciales.</div>');
            }
            
            else {
                error_log("Error de conexión: " . $errorMessage);
               die('<br><div class="alert alert-danger">Problemas con la base de datos. Por favor, contacte con el administrador.</div>');
            }
        }
    }
}
