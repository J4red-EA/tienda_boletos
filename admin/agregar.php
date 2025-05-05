<?php
session_start();
require_once(__DIR__ . '/../includes/funciones.php');

if (!usuarioAutenticado() || !esAdmin()) {
    header("Location: ../login.php");
    exit;
}
?>

<?php
include('includes/conexion.php');
include('includes/auth.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'];
    $precio = $_POST['precio'];
    $disponibles = $_POST['disponibles'];

    // Guardar imagen
    $imagen_nombre = $_FILES['imagen']['name'];
    $imagen_tmp = $_FILES['imagen']['tmp_name'];
    move_uploaded_file($imagen_tmp, "../uploads/" . $imagen_nombre);

    // Insertar en BD
    $stmt = $conn->prepare("INSERT INTO productos (nombre, precio, disponibles, imagen) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("sdis", $nombre, $precio, $disponibles, $imagen_nombre);
    $stmt->execute();

    header("Location: productos.php");
    exit;
}
?>

<?php include('../includes/header.php'); ?>

<h2>Agregar Producto</h2>

<form method="POST" enctype="multipart/form-data">
    <label>Nombre:</label><br>
    <input type="text" name="nombre" required><br><br>

    <label>Precio:</label><br>
    <input type="number" step="0.01" name="precio" required><br><br>

    <label>Asientos disponibles:</label><br>
    <input type="number" name="disponibles" required><br><br>

    <label>Imagen:</label><br>
    <input type="file" name="imagen" required><br><br>

    <button type="submit">Guardar</button>
</form>

<?php include('../includes/footer.php'); ?>
