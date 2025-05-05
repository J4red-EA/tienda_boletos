<?php 
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}  // Asegura que la sesión se inicie correctamente

function conectarBD() {
    $host = 'localhost';
    $usuario = 'root';
    $clave = ''; // cambia si tu contraseña de MySQL es diferente
    $bd = 'tienda_boletos';

    $conn = new mysqli($host, $usuario, $clave, $bd);

    if ($conn->connect_error) {
        die('Error en la conexión: ' . $conn->connect_error);
    }

    return $conn;
}

function usuarioAutenticado() {
    return isset($_SESSION['usuario']);
}

function esAdmin() {
    return isset($_SESSION['usuario']) && $_SESSION['usuario']['rol'] === 'admin';
}
?>
