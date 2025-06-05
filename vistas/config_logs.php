<?php
date_default_timezone_set('America/Santiago');  // Zona horaria 'America/Santiago'

// Obtén el directorio raíz del proyecto
$projectRoot = dirname(__DIR__, 1);  // Un nivel arriba de la carpeta 'vistas'

// Construye la ruta al directorio de logs usando DIRECTORY_SEPARATOR
$logDir = $projectRoot . DIRECTORY_SEPARATOR . "logs";

// Verifica si el directorio logs existe, si no, lo crea
if (!is_dir($logDir)) {
    mkdir($logDir, 0777, true);  // Crea el directorio con permisos recursivos
}

// Define la ruta completa del archivo de logs
$logFile = $logDir . DIRECTORY_SEPARATOR . "sgp_error.log";

// Configura el archivo de log para error_log
ini_set("log_errors", "On");  // Activa el registro de errores
ini_set("error_log", $logFile);  // Establece el archivo de log

?>
