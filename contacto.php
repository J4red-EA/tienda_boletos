<?php include('includes/header.php'); ?>

<section class="login-container">
    <h2>Contáctanos</h2>
    <p class="intro-text">¿Tienes dudas, sugerencias o comentarios? ¡Escríbenos!</p>

    <?php if (isset($_GET['enviado']) && $_GET['enviado'] == 'ok'): ?>
        <p class="mensaje exito">¡Tu mensaje fue enviado con éxito!</p>
    <?php elseif (isset($_GET['error'])): ?>
        <p class="mensaje error">Hubo un error al enviar el mensaje. Intenta de nuevo más tarde.</p>
    <?php endif; ?>


    <form action="php/enviar_contacto.php" method="POST" class="form-login">
        <label for="nombre">Nombre completo</label>
        <input type="text" id="nombre" name="nombre" required>

        <label for="email">Correo electrónico</label>
        <input type="email" id="email" name="email" required>

        <label for="asunto">Asunto</label>
        <input type="text" id="asunto" name="asunto" required>

        <label for="mensaje">Mensaje</label>
        <textarea id="mensaje" name="mensaje" rows="5" required></textarea>

        <button type="submit">Enviar mensaje</button>
    </form>
</section>

<?php include('includes/footer.php'); ?>