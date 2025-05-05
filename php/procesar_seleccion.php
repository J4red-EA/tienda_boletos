<?php
session_start();
include('../admin/includes/conexion.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $producto_id = $_POST['producto_id'];
    $asientos_seleccionados = isset($_POST['asientos']) ? $_POST['asientos'] : [];

    if (empty($asientos_seleccionados)) {
        header("Location: ../seleccionar_asientos.php?id=$producto_id&error=seleccion");
        exit();
    }

    // Validar la cantidad disponible
    $stmt = $conn->prepare("SELECT nombre, disponibles, precio FROM productos WHERE id = ?");
    $stmt->bind_param("i", $producto_id);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows === 0) {
        die("Película no encontrada.");
    }

    $producto = $resultado->fetch_assoc();
    $disponibles = (int)$producto['disponibles'];
    $cantidad_seleccionada = count($asientos_seleccionados);

    if ($cantidad_seleccionada > $disponibles) {
        header("Location: ../seleccionar_asientos.php?id=$producto_id&error=exceso");
        exit();
    }

    // Guardar en sesión (simular carrito)
    $_SESSION['carrito'] = [];
    $_SESSION['carrito'][] = [
        'id' => $producto_id,
        'nombre' => $producto['nombre'],
        'precio' => $producto['precio'],
        'asientos' => $asientos_seleccionados,
        'cantidad' => $cantidad_seleccionada
    ];

    // Redirigir al resumen
    header("Location: ../php/resumen.php");
    exit();
} else {
    echo "Acceso no válido.";
}
?>