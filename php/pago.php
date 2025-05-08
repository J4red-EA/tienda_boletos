<?php
session_start();
include('../admin/includes/conexion.php');

if (!isset($_SESSION['carrito']) || empty($_SESSION['carrito'])) {
    header('Location: carrito.php');
    exit;
}

$total = 0;
foreach ($_SESSION['carrito'] as $item) {
    $total += $item['precio'] * $item['cantidad'];
}

// Aquí podrías validar pago con PayPal Sandbox o Stripe
$usuario_id = $_SESSION['usuario']['id']; // ID del usuario autenticado
$fecha_compra = date('Y-m-d H:i:s'); // Fecha y hora actual

$stmt = $conn->prepare("INSERT INTO compras (usuario_id, fecha, total) VALUES (?, ?, ?)");
$stmt->bind_param("isd", $usuario_id, $fecha, $total); // "i" para usuario_id, "s" para fecha, "d" para total
$stmt->execute();
$compra_id = $stmt->insert_id; // Obtener el ID de la compra recién creada
$stmt->close();

foreach ($_SESSION['carrito'] as $item) {
    $id = (int)$item['id']; // Asegurarse de que sea un entero
    $cantidad = (int)$item['cantidad']; // Asegurarse de que sea un entero
    $precio_unitario = (float)$item['precio']; // Asegurarse de que sea un float
    $stmt = $conn->prepare("INSERT INTO detalle_compra (compra_id, producto_id, cantidad, precio_unitario) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("iiid", $compra_id, $id, $cantidad, $precio_unitario); // "i" para enteros, "d" para double
    $stmt->execute();
    $stmt->close();

    // Convertir los asientos en un array si es una cadena separada por comas
    $asientos = is_array($item['asientos']) 
        ? $item['asientos'] 
        : explode(',', $item['asientos']);

    // Preparar y ejecutar la consulta para actualizar los productos
    $stmt = $conn->prepare("UPDATE productos SET disponibles = disponibles - ? WHERE id = ?");
    $stmt->bind_param("ii", $cantidad, $id);
    $stmt->execute();
    $stmt->close();

    // Insertar cada asiento individualmente en la tabla asientosvendidos
    foreach ($asientos as $asiento) {
        $asiento = $conn->real_escape_string(trim($asiento)); // Escapar y limpiar el asiento
        $stmt = $conn->prepare("INSERT INTO asientosvendidos (producto_id, asientosBloqueados) VALUES (?, ?)");
        $stmt->bind_param("is", $id, $asiento);
        $stmt->execute();
        $stmt->close();
    }
    /*echo "<script>
    window.location.href = '/tienda_boletos/catalogo.php';
    alert('Asientos reservados correctamente.');
    </script>";
    exit;*/
}
// Aquí podrías guardar la venta en la base de datos (ventas/detalles_venta)

// Guardar total en sesión para el PDF
$_SESSION['total_compra'] = $total;

// Redirigir a PDF
header('Location: ../pdf/generar_pdf.php');
exit;