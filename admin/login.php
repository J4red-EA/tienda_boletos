<?php
session_start();
include('includes/conexion.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['usuario']; // Usamos 'usuario' del formulario, pero se refiere al correo
    $clave = $_POST['clave'];

    $stmt = $conn->prepare("SELECT * FROM usuarios WHERE email=? LIMIT 1");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($user = $result->fetch_assoc()) {
        // Verificar contraseña hasheada
        if (password_verify($clave, $user['password'])) {
            $_SESSION['usuario'] = $user['nombre'];
            $_SESSION['rol'] = $user['rol'];
            header("Location: productos.php");
            exit;
        } else {
            $error = "Contraseña incorrecta.";
        }
    } else {
        $error = "Usuario no encontrado.";
    }
}
?>

