<?php
session_start();
require_once('../includes/funciones.php');
require_once('includes/conexion.php');

if (!usuarioAutenticado() || !esAdmin()) {
    header("Location: ../login.php");
    exit;
}

$id = $_GET['id'] ?? 0;

$conn->query("DELETE FROM productos WHERE id = $id");

header("Location: productos.php");
exit;

