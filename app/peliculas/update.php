<?php
require_once(__DIR__ . '/../db.php');

$id = $_POST['id'];
$titulo = $_POST['titulo'];
$director_id = $_POST['director_id'];
$actor_id = $_POST['actor_id'];
$anio = $_POST['anio'];
if (empty($anio) || trim($anio) === '') {
    $anio = null; // O un valor por defecto como '1900-01-01'
}

$stmt = $pdo->prepare("UPDATE peliculas SET titulo = ?, director_id = ?, actor_id = ?, anio = ? WHERE id = ?");
$stmt->execute([$titulo, $director_id, $actor_id, $anio, $id]);

header("Location: lista.php");
?>
