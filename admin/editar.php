<?php
session_start();
require_once('../includes/funciones.php');
require_once('includes/conexion.php');

if (!usuarioAutenticado() || !esAdmin()) {
    header("Location: ../login.php");
    exit;
}

$id = $_GET['id'];
$resultado = $conn->query("SELECT * FROM productos WHERE id = $id");
$producto = $resultado->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'];
    $precio = $_POST['precio'];
    $disponibles = $_POST['disponibles'];

    if ($_FILES['imagen']['name']) {
        $imagen = $_FILES['imagen']['name'];
        move_uploaded_file($_FILES['imagen']['tmp_name'], "../uploads/" . $imagen);
    } else {
        $imagen = $producto['imagen'];
    }

    $stmt = $conn->prepare("UPDATE productos SET nombre = ?, precio = ?, disponibles = ?, imagen = ? WHERE id = ?");
    $stmt->bind_param("sdisi", $nombre, $precio, $disponibles, $imagen, $id);
    $stmt->execute();

    header("Location: productos.php");
    exit;
}
?>

<?php include('../includes/header.php'); ?>

<h2>Editar Película</h2>

<form method="POST" enctype="multipart/form-data">
    <label>Nombre:</label><br>
    <input type="text" name="nombre" value="<?php echo $producto['nombre']; ?>" required><br><br>

    <label>Precio:</label><br>
    <input type="number" name="precio" step="0.01" value="<?php echo $producto['precio']; ?>" required><br><br>

    <label>Disponibles:</label><br>
    <input type="number" name="disponibles" value="<?php echo $producto['disponibles']; ?>" required><br><br>

    <label>Imagen actual:</label><br>
    <img src="../uploads/<?php echo $producto['imagen']; ?>" width="100"><br><br>

    <label>Actualizar imagen:</label><br>
    <input type="file" name="imagen"><br><br>

    <button type="submit">Actualizar</button>
</form>

<?php include('../includes/footer.php'); ?>

