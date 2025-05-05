<?php 
include('admin/includes/conexion.php');

session_start();

$resultado = $conn->query("SELECT * FROM productos");
?>

<?php include('includes/header.php'); ?>
<section class="catalogo-container">
    <h2>Catálogo de Películas</h2>
    <div class="catalogo-grid">
        <?php while ($boleto = $resultado->fetch_assoc()): ?>
            <div class="tarjeta-producto">
                <img src="uploads/<?php echo $boleto['imagen']; ?>" alt="<?php echo $boleto['nombre']; ?>">
                <div class="contenido-producto">
                    <h3><?php echo $boleto['nombre']; ?></h3>
                    <p class="descripcion"><?php echo $boleto['descripcion']; ?></p>
                    <p class="precio">Precio: $<?php echo number_format($boleto['precio'], 2); ?></p>
                    <?php if ($boleto['disponibles'] > 0): ?>
                        <form method="GET" action="seleccionar_asientos.php">
                            <input type="hidden" name="id" value="<?php echo $boleto['id']; ?>">
                            <input type="hidden" name="nombre" value="<?php echo $boleto['nombre']; ?>">
                            <input type="hidden" name="precio" value="<?php echo $boleto['precio']; ?>">
                            <button type="submit" class="btn-agregar">Seleccionar asientos</button>
                        </form>
                    <?php else: ?>
                        <p class="agotado">AGOTADO</p>
                    <?php endif; ?>
                </div>
            </div>
        <?php endwhile; ?>
    </div>
</section>

<?php include('includes/footer.php'); ?>