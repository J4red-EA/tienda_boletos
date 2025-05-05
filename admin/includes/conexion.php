<?php
// Datos de conexión (ajusta según tu entorno)
$host = "localhost";
$usuario = "root";
$contrasena = "";
$bd = "tienda_boletos";
$puerto = "3306";

// Crear conexión
$conn = new mysqli($host, $usuario, $contrasena, $bd, $puerto);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Establecer codificación
$conn->set_charset("utf8");
?>