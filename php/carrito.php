<?php
session_start();
include('../includes/header.php');
?>

<h2>Tu Carrito</h2>

<?php if (!isset($_SESSION['carrito']) || empty($_SESSION['carrito'])): ?>
    <p>Tu carrito está vacío.</p>
<?php else: ?>
    <table border="1" cellpadding="10">
        <tr>
            <th>Nombre</th>
            <th>Precio Unitario</th>
            <th>Cantidad</th>
            <th>Subtotal</th>
            <th>Acciones</th>
        </tr>
        <?php
        $total = 0;
        foreach ($_SESSION['carrito'] as $index => $item):
            $subtotal = $item['precio'] * $item['cantidad'];
            $total += $subtotal;
        ?>
        <tr>
            <td><?php echo htmlspecialchars($item['nombre']); ?></td>
            <td>$<?php echo number_format($item['precio'], 2); ?></td>
            <td><?php echo $item['cantidad']; ?></td>
            <td>$<?php echo number_format($subtotal, 2); ?></td>
            <td>
                <form method="POST" action="eliminar_carrito.php" onsubmit="return confirm('¿Eliminar este producto del carrito?');">
                    <input type="hidden" name="index" value="<?php echo $index; ?>">
                    <button type="submit">Eliminar</button>
                </form>
            </td>
        </tr>
        <?php endforeach; ?>
        <tr>
            <td colspan="4"><strong>Total</strong></td>
            <td><strong>$<?php echo number_format($total, 2); ?></strong></td>
        </tr>
    </table>

    <br>
    <a href="../catalogo.php">← Seguir comprando</a>
    <a href="pago.php"><button>Proceder al Pago</button></a>
<?php endif; ?>

<?php include('../includes/footer.php'); ?>

