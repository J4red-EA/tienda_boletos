<?php
include('includes/header.php');
include('admin/includes/conexion.php');

if (!isset($_GET['id'])) {
    echo "<p>Película no especificada.</p>";
    include('includes/footer.php');
    exit;
}

$id = intval($_GET['id']);
$resultado = $conn->query("SELECT * FROM productos WHERE id = $id");
$pelicula = $resultado->fetch_assoc();

if (!$pelicula) {
    echo "<p>Película no encontrada.</p>";
    include('includes/footer.php');
    exit;
}
?>

<section class="seleccionar-asientos">
    <h2>Selecciona tus asientos para: <?php echo $pelicula['nombre']; ?></h2>

    <div class="poster-container">
        <img src="uploads/<?php echo $pelicula['imagen']; ?>" alt="Póster" class="poster-img">
    </div>

    <p class="precio">Precio: $<?php echo $pelicula['precio']; ?></p>
    <p class="disponibles">Asientos disponibles: <?php echo $pelicula['disponibles']; ?></p>

    <form method="POST" action="php/procesar_seleccion.php">
        <input type="hidden" name="producto_id" value="<?php echo $pelicula['id']; ?>">


        
       

        <h3>Selecciona tus asientos:</h3>
        <div class="asientos">
            <?php
            $asientosOcupados = []; // Aquí puedes agregar los asientos ocupados si es necesario
            $resultadoAsientos = $conn->query("SELECT asientosBloqueados FROM asientosvendidos WHERE producto_id = $id");
            while ($fila = $resultadoAsientos->fetch_assoc()) {
                $asientosOcupados[] = $fila['asientosBloqueados'];
            }

            $filas = 5;
            $columnas = 8;
            $contador = 1;

            for ($fila = 0; $fila < $filas; $fila++) {
                for ($col = 0; $col < $columnas; $col++) {

                    $asientoId = "A$contador";
                    $ocupado = in_array($asientoId, $asientosOcupados);

                    echo '<div class="asiento ' . ($ocupado ? 'ocupado' : '') . '">';
                    echo "<input type='checkbox' name='asientos[]' id='$asientoId' value='$asientoId' " . ($ocupado ? 'disabled' : '') . ">";
                    echo "<label for='$asientoId'>$contador</label>";
                    echo '</div>';
                    $contador++;
                }
            }
            ?>
        </div>

        <div class="form-footer">
            <button type="submit">Proceder al pago</button>
        </div>
    </form>
</section>

<?php include('includes/footer.php'); ?>