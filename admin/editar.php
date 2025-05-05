<?php
session_start();
require_once('../includes/funciones.php');
require_once('includes/conexion.php');

if (!usuarioAutenticado() || !esAdmin()) {
    header("Location: ../login.php");
    exit;
}

if (!isset($_GET['id'])) {
    header("Location: productos.php");
    exit;
}

$id = intval($_GET['id']);
$stmt = $conn->prepare("SELECT * FROM productos WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$resultado = $stmt->get_result();

if ($resultado->num_rows === 0) {
    echo "Producto no encontrado.";
    exit;
}

$producto = $resultado->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'];
    $precio = $_POST['precio'];
    $disponibles = $_POST['disponibles'];

    // Si se subió una nueva imagen
    if (!empty($_FILES['imagen']['name'])) {
        $imagen = basename($_FILES['imagen']['name']);
        move_uploaded_file($_FILES['imagen']['tmp_name'], "../uploads/$imagen");

        $stmt = $conn->prepare("UPDATE productos SET nombre=?, precio=?, disponibles=?, imagen=? WHERE id=?");
        $stmt->bind_param("sdisi", $nombre, $precio, $disponibles, $imagen, $id);
    } else {
        $stmt = $conn->prepare("UPDATE productos SET nombre=?, precio=?, disponibles=? WHERE id=?");
        $stmt->bind_param("sdis", $nombre, $precio, $disponibles, $id);
    }

    if ($stmt->execute()) {
        header("Location: productos.php");
        exit;
    } else {
        $error = "Error al actualizar.";
    }
}
?>

<?php include('../includes/header.php'); ?>

<div class="admin-panel">
    <h2>Editar Película</h2>
    <?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>

    <form method="POST" enctype="multipart/form-data" class="form-admin">
        <label>Nombre:</label><br>
        <input type="text" name="nombre" value="<?php echo htmlspecialchars($producto['nombre']); ?>" required><br><br>

        <label>Precio:</label><br>
        <input type="number" name="precio" step="0.01" value="<?php echo $producto['precio']; ?>" required><br><br>

        <label>Disponibles:</label><br>
        <input type="number" name="disponibles" value="<?php echo $producto['disponibles']; ?>" required><br><br>

        <label>Imagen actual:</label><br>
        <img src="../uploads/<?php echo $producto['imagen']; ?>" width="120"><br><br>

        <label>¿Deseas cambiar la imagen?</label><br>
        <input type="file" name="imagen"><br><br>

        <button type="submit" class="btn-agregar">Guardar Cambios</button>
    </form>

    <br>
    <a href="productos.php">⬅️ Volver al panel</a>
</div>

<?php include('../includes/footer.php'); ?>
