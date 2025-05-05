<?php
session_start();
include('../admin/includes/conexion.php');

$id = $_POST['id'];
$cantidad = $_POST['cantidad'] ?? 1;

// Obtener producto desde la base de datos
$query = $conn->prepare("SELECT * FROM productos WHERE id = ?");
$query->bind_param("i", $id);
$query->execute();
$result = $query->get_result();
$producto = $result->fetch_assoc();

if ($producto && $producto['disponibles'] >= $cantidad) {
    // Crear item del carrito
    $item = [
        'id' => $producto['id'],
        'nombre' => $producto['nombre'],
        'precio' => $producto['precio'],
        'cantidad' => $cantidad
    ];

    if (!isset($_SESSION['carrito'])) {
        $_SESSION['carrito'] = [];
    }

    // Si ya existe el producto en el carrito, actualizar cantidad
    $existe = false;
    foreach ($_SESSION['carrito'] as &$p) {
        if ($p['id'] == $id) {
            $p['cantidad'] += $cantidad;
            $existe = true;
            break;
        }
    }

    if (!$existe) {
        $_SESSION['carrito'][] = $item;
    }
}

header("Location: ../catalogo.php");
exit;
