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
        <style>
        .paypal-wrapper {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 100%;
            margin-top: 20px;
        }
        
    </style>
    <!-- Integración del SDK de PayPal -->
    <script src="https://www.paypal.com/sdk/js?client-id=AR-o9CqQWJXQo7XK1TY8_wJufbwZaDY7XI3gF-VGsblpD82fySPE-vigrIzPAZ3HqkcsmptklLGL1AXx"></script>
    <script>
        paypal.Buttons({
            createOrder: function(data, actions) {
                // Crear la orden con el monto total a pagar
                return actions.order.create({
                    purchase_units: [{
                        amount: {
                            value: '<?= number_format($total, 2, '.', '') ?>' // Precio calculado dinámicamente
                        }
                    }]
                });
            },
            onApprove: function(data, actions) {
                // Capturar el pago cuando se aprueba
                return actions.order.capture().then(function(details) {
                    alert('Pago completado por ' + details.payer.name.given_name); // Mostrar mensaje de éxito
                    window.location.href = "confirmacion.php"; // Redirigir a la página de confirmación
                });
            }
        }).render('#paypal-button-container'); // Renderizar el botón de PayPal
    </script>
    <h2 class="body-unete">Realizar Pago</h2>
            <div class="paypal-wrapper">
                <div id="paypal-button-container" class="paypal-container"></div>
            </div>

    <?php endif; ?>
</section>

<?php include('../includes/footer.php'); ?>
