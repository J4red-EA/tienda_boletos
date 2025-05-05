<?php
session_start();
require('fpdf/fpdf.php');
require_once(__DIR__ . '/../admin/includes/conexion.php');

// Verificar si el usuario está autenticado
if (!isset($_SESSION['usuario'])) {
    header('Location: ../login.php');
    exit;
}

// Obtener el ID de la compra desde la URL
$compra_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Verificar si el ID es válido
if ($compra_id <= 0) {
    header('Location: ../usuario/historial.php');
    exit;
}

// Validar que la compra pertenece al usuario autenticado
$usuario_id = $_SESSION['usuario']['id'];
$query = $conn->prepare("SELECT * FROM compras WHERE id = ? AND usuario_id = ?");
$query->bind_param("ii", $compra_id, $usuario_id);
$query->execute();
$resultado = $query->get_result();

// Si no se encuentra la compra, redirigir al historial
if ($resultado->num_rows === 0) {
    header('Location: ../usuario/historial.php');
    exit;
}

$compra = $resultado->fetch_assoc();

// Crear el PDF
$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 16);
$pdf->Cell(0, 10, 'Recibo de Compra - Cine', 0, 1, 'C');
$pdf->Ln(10);
$pdf->SetFont('Arial', '', 12);

// Detalles de la compra
$query_detalles = $conn->prepare("SELECT * FROM detalle_compra WHERE compra_id = ?");
$query_detalles->bind_param("i", $compra_id);
$query_detalles->execute();
$detalles = $query_detalles->get_result();

while ($detalle = $detalles->fetch_assoc()) {
    // Obtener producto
    $query_producto = $conn->prepare("SELECT nombre, precio FROM productos WHERE id = ?");
    $query_producto->bind_param("i", $detalle['producto_id']);
    $query_producto->execute();
    $producto = $query_producto->get_result()->fetch_assoc();

    // Agregar al PDF
    $linea = $producto['nombre'] . ' x' . $detalle['cantidad'] . ' - $' . number_format($producto['precio'], 2);
    $pdf->Cell(0, 10, $linea, 0, 1);
}

$pdf->Ln(5);
$pdf->SetFont('Arial', 'B', 14);
$pdf->Cell(0, 10, 'Total: $' . number_format($compra['total'], 2), 0, 1);

// Generar el PDF
$pdf->Output('I', 'recibo.pdf');
?>