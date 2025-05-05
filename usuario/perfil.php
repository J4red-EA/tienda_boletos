<?php
session_start();
require_once(__DIR__ . '/../includes/funciones.php');

if (!usuarioAutenticado()) {
    header("Location: ../login.php");
    exit;
}

include('../includes/header.php');

$usuario = $_SESSION['usuario'];
?>

<h2>Mi Perfil</h2>

<div class="perfil">
    <p><strong>Nombre:</strong> <?php echo htmlspecialchars($usuario['nombre']); ?></p>
    <p><strong>Correo:</strong> <?php echo htmlspecialchars($usuario['email']); ?></p>
    <p><strong>Rol:</strong> <?php echo htmlspecialchars($usuario['rol']); ?></p>
</div>

<?php include('../includes/footer.php'); ?>