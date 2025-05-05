<?php
session_start();
require_once(__DIR__ . '/../includes/funciones.php');
require_once(__DIR__ . '/../admin/includes/conexion.php');

if (!usuarioAutenticado()) {
    header("Location: ../login.php");
    exit;
}

include('../includes/header.php');
$usuario_id = $_SESSION['usuario']['id'];

$query = $conn->prepare("SELECT * FROM compras WHERE usuario_id = ? ORDER BY fecha DESC");
$query->bind_param("i", $usuario_id);
$query->execute();
$resultado = $query->get_result();
?>

<h2>Historial de Compras</h2>

<?php if ($resultado->num_rows > 0): ?>
    <table>
        <thead>
            <tr>
                <th>Fecha</th>
                <th>Total</th>
                <th>Recibo</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($compra = $resultado->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $compra['fecha']; ?></td>
                    <td>$<?php echo number_format($compra['total'], 2); ?></td>
                    <td>
                        <a href="../pdf/generar_pdf.php?id=<?php echo $compra['id']; ?>" target="_blank">Ver PDF</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
<?php else: ?>
    <p>No tienes compras registradas aún.</p>
<?php endif; ?>

<?php include('../includes/footer.php'); ?>