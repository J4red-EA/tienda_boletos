<?php
session_start();
require_once('../includes/funciones.php');
require_once('includes/conexion.php');

if (!usuarioAutenticado() || !esAdmin()) {
    header("Location: ../login.php");
    exit;
}

$resultado = $conn->query("SELECT * FROM productos");
?>

<?php include('../includes/header.php'); ?>

<h2>Panel de Administración</h2>
<a href="agregar.php">➕ Agregar Nueva Película</a>

<table border="1" cellpadding="10">
    <tr>
        <th>Imagen</th>
        <th>Nombre</th>
        <th>Precio</th>
        <th>Disponibles</th>
        <th>Acciones</th>
    </tr>

    <?php while ($row = $resultado->fetch_assoc()): ?>
        <tr>
            <td><img src="../uploads/<?php echo $row['imagen']; ?>" width="80"></td>
            <td><?php echo $row['nombre']; ?></td>
            <td>$<?php echo number_format($row['precio'], 2); ?></td>
            <td><?php echo $row['disponibles']; ?></td>
            <td>
                <a href="editar.php?id=<?php echo $row['id']; ?>">✏️ Editar</a> |
                <a href="eliminar.php?id=<?php echo $row['id']; ?>" onclick="return confirm('¿Estás seguro?')">🗑️ Eliminar</a>
            </td>
        </tr>
    <?php endwhile; ?>
</table>

<?php include('../includes/footer.php'); ?>
