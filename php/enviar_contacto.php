<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = htmlspecialchars($_POST['nombre']);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $asunto = htmlspecialchars($_POST['asunto']);
    $mensaje = htmlspecialchars($_POST['mensaje']);

    $para = "admin@tudominio.com"; // 🛠️ Reemplaza con tu correo real
    $titulo = "Nuevo mensaje de contacto: $asunto";
    $contenido = "Nombre: $nombre\n";
    $contenido .= "Correo: $email\n\n";
    $contenido .= "Mensaje:\n$mensaje\n";

    $headers = "From: $email\r\n";
    $headers .= "Reply-To: $email\r\n";

    if (mail($para, $titulo, $contenido, $headers)) {
        header("Location: ../contacto.php?enviado=ok");
    } else {
        header("Location: ../contacto.php?error=1");
    }
    exit;
} else {
    header("Location: ../contacto.php");
    exit;
}
