<?php
require_once(__DIR__ . '/../db.php');

$id = $_POST['id'];
$nombre = $_POST['nombre'];
$nacionalidad = $_POST['nacionalidad'];
$nacimiento = $_POST['nacimiento'];
$genero = $_POST['genero'];
$peliculas_dirigidas = $_POST['peliculas_dirigidas'];
if (empty($nacimiento) || trim($nacimiento) === '') {
    $nacimiento = null; // O un valor por defecto como '1900-01-01'
}

$stmt = $pdo->prepare("UPDATE directores SET nombre = ?, nacionalidad = ?, nacimiento = ?, genero = ?, peliculas_dirigidas = ? WHERE id = ?");
$stmt->execute([$nombre, $nacionalidad, $nacimiento, $genero, $peliculas_dirigidas, $id]);

header("Location: lista.php");
?>
