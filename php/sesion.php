<?php
session_start();
require(__DIR__ . '/../admin/includes/conexion.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM usuarios WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    
    $resultado = $stmt->get_result();
    $usuario = $resultado->fetch_assoc();

    if ($usuario && password_verify($password, $usuario['password'])) {
        $_SESSION['usuario'] = [
            'id' => $usuario['id'],
            'nombre' => $usuario['nombre'],
            'email' => $usuario['email'], // ✅ agregado
            'rol' => $usuario['rol']
            
            
        ];

        if ($usuario['rol'] === 'admin') {
            header("Location: /tienda_boletos/admin/productos.php");
        } else {
            header("Location: /tienda_boletos/catalogo.php");
        }
        exit;
    } else {
        echo "Correo o contraseña incorrectos.";
    }

    $stmt->close();
}
?>
