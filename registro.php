<?php include('includes/header.php'); ?>

<section class="login-container">
    <h2>Registro de Usuario</h2>

    <?php if (isset($_GET['error']) && $_GET['error'] == 'email'): ?>
        <p class="mensaje-error">⚠️ El correo ya está registrado. Intenta con otro.</p>
    <?php endif; ?>

    <form method="POST" action="php/registro.php" class="form-login">
        <label for="nombre">Nombre completo</label>
        <input type="text" name="nombre" id="nombre" required>

        <label for="email">Correo electrónico</label>
        <input type="email" name="email" id="email" required>

        <label for="password">Contraseña</label>
        <input type="password" name="password" id="password" required>

        <label for="confirmar">Confirmar contraseña</label>
        <input type="password" name="confirmar" id="confirmar" required>

        <button type="submit">Registrarme</button>
        <p class="texto-extra">¿Ya tienes cuenta? <a href="login.php">Inicia sesión</a>.</p>
    </form>
</section>

<?php include('includes/footer.php'); ?>
