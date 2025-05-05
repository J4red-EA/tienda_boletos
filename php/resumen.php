<?php
session_start();
include('../includes/header.php');
?>

<section class="catalogo-container">
    <h2>Resumen de Compra</h2>

    <?php if (!isset($_SESSION['carrito']) || empty($_SESSION['carrito'])): ?>
        <p>No has seleccionado ningún asiento todavía.</p>
    <?php else: ?>
        <div class="catalogo-grid">
            <?php
            $total = 0;
            foreach ($_SESSION['carrito'] as $item):
                $subtotal = $item['precio'] * $item['cantidad'];
                $total += $subtotal;
            ?>
                <div class="tarjeta-producto">
                    <div class="contenido-producto">
                        <h3><?php echo $item['nombre']; ?></h3>
                        <p><strong>Precio unitario:</strong> $<?php echo number_format($item['precio'], 2); ?></p>
                        <p><strong>Cantidad:</strong> <?php echo $item['cantidad']; ?></p>
                        <p><strong>Asientos:</strong> <?php echo implode(', ', $item['asientos']); ?></p>
                        <p><strong>Subtotal:</strong> $<?php echo number_format($subtotal, 2); ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="form-footer">
            <p class="precio">Total a pagar: <strong>$<?php echo number_format($total, 2); ?></strong></p>
            <br>
            <a href="pago.php" class="btn-agregar">Proceder al Pago</a>
        </div>
    <?php endif; ?>
</section>

<?php include('../includes/footer.php'); ?>
