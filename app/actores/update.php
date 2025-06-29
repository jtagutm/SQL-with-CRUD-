<?php
require_once(__DIR__ . '/../db.php');

$id = $_POST['id'];
$nombre = $_POST['nombre'];
$nacionalidad = $_POST['nacionalidad'];
$nacimiento = $_POST['nacimiento'];
$genero = $_POST['genero'];
$premio = $_POST['premio'];
$activo = isset($_POST['activo']) ? 1 : 0;
if (empty($nacimiento) || trim($nacimiento) === '') {
    $nacimiento = null; // O un valor por defecto como '1900-01-01'
}

$stmt = $pdo->prepare("UPDATE actores SET nombre = ?, nacionalidad = ?, nacimiento = ?, genero = ?, premio = ?, activo = ? WHERE id = ?");
$stmt->execute([$nombre, $nacionalidad, $nacimiento, $genero, $premio, $activo, $id]);

header("Location: lista.php");
?>
