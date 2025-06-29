<?php
require_once(__DIR__ . '/../db.php');
$id = $_GET['id'];

$stmt = $pdo->prepare("DELETE FROM actores WHERE id = ?");
$stmt->execute([$id]);

header("Location: lista.php");
?>
