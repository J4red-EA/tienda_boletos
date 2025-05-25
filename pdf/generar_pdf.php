<?php
session_start();
require('fpdf/fpdf.php');
require_once(_DIR_ . '/../admin/includes/conexion.php');

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

$pdf = new FPDF('L', 'mm', array(85,66)); // Tamaño tipo boleto
$pdf->SetAutoPageBreak(false);
$pdf->AddPage();
$pdf->SetMargins(5, 5, 5);

// Borde exterior
$pdf->SetLineWidth(1);
$pdf->Rect(3, 3, 79, 60, 'D');

// Encabezado
$pdf->SetFont('Arial', 'B', 14); // Más pequeño
$pdf->SetTextColor(40,40,120);

$pdf->Cell(0, 10, 'CINE BOLETOS', 0, 1, 'C');
$pdf->SetDrawColor(200,200,200);
$pdf->Line(5, 18, 80, 18);

$pdf->SetFont('Arial', '', 8); // Más pequeño
$pdf->SetTextColor(0,0,0);
$pdf->Cell(0, 5, 'Recibo de Compra', 0, 1, 'C');
$pdf->Cell(0, 5, 'Folio: ' . $compra['id'], 0, 1, 'C');
$pdf->Cell(0, 5, 'Fecha: ' . date('d/m/Y', strtotime($compra['fecha'])), 0, 1, 'C');
$pdf->Ln(1);
$pdf->Line(5, $pdf->GetY(), 80, $pdf->GetY());
$pdf->Ln(1);

// Detalles de la compra
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(0, 6, 'Detalle:', 0, 1);

$pdf->SetFont('Arial', '', 8);
$query_detalles = $conn->prepare("SELECT * FROM detalle_compra WHERE compra_id = ?");
$query_detalles->bind_param("i", $compra_id);
$query_detalles->execute();
$detalles = $query_detalles->get_result();

while ($detalle = $detalles->fetch_assoc()) {
    $query_producto = $conn->prepare("SELECT nombre, precio FROM productos WHERE id = ?");
    $query_producto->bind_param("i", $detalle['producto_id']);
    $query_producto->execute();
    $producto = $query_producto->get_result()->fetch_assoc();

    $linea = $producto['nombre'] . ' x' . $detalle['cantidad'] . '   $' . number_format($producto['precio'], 2);
    $pdf->Cell(0, 5, $linea, 0, 1); // Menos alto
}

$pdf->Ln(1);
$pdf->Line(5, $pdf->GetY(), 80, $pdf->GetY());
$pdf->Ln(1);

// Total
$pdf->SetFont('Arial', 'B', 11);
$pdf->SetTextColor(40,40,120);
$pdf->Cell(0, 8, 'TOTAL: $' . number_format($compra['total'], 2), 0, 1, 'C');
$pdf->SetTextColor(0,0,0);


// Generar el PDF
$pdf->Output('I', 'boleto.pdf');


?>