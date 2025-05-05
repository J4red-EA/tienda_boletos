<?php include('includes/header.php'); ?>

<section class="login-container">
    <h2>Iniciar Sesión</h2>

    <?php if (isset($_GET['registro']) && $_GET['registro'] == 'ok'): ?>
        <p class="mensaje-exito">✅ Registro exitoso. Ahora puedes iniciar sesión.</p>
    <?php endif; ?>

    <form method="POST" action="php/sesion.php" class="form-login">
        <label for="email">Correo electrónico</label>
        <input type="email" name="email" id="email" required>

        <label for="password">Contraseña</label>
        <input type="password" name="password" id="password" required>

        <button type="submit">Ingresar</button>
        <p class="texto-extra">¿No tienes una cuenta? <a href="registro.php">Regístrate aquí</a>.</p>
    </form>
</section>

<?php include('includes/footer.php'); ?>
