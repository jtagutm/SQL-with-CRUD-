<?php
require_once(__DIR__ . '/../db.php');

$id = $_GET['id'] ?? null;
if (!$id) {
    die("ID no proporcionado.");
}

$stmt = $pdo->prepare("SELECT p.*, a.nombre as actor_nombre, d.nombre as director_nombre 
                       FROM peliculas p 
                       LEFT JOIN actores a ON p.actor_id = a.id 
                       LEFT JOIN directores d ON p.director_id = d.id 
                       WHERE p.id = ?");
$stmt->execute([$id]);
$pelicula = $stmt->fetch();
if (!$pelicula) {
    die("Película no encontrada.");
}

// Obtener listas de actores y directores
$actores = $pdo->query("SELECT id, nombre FROM actores ORDER BY nombre")->fetchAll();
$directores = $pdo->query("SELECT id, nombre FROM directores ORDER BY nombre")->fetchAll();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Película - Sistema de Gestión</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .container {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
            padding: 40px;
            width: 100%;
            max-width: 500px;
            position: relative;
            overflow: hidden;
        }

        .container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 5px;
            background: linear-gradient(90deg, #667eea, #764ba2);
        }

        .form-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .form-header h2 {
            color: #333;
            font-size: 28px;
            font-weight: 600;
            margin-bottom: 8px;
        }

        .form-header p {
            color: #666;
            font-size: 14px;
        }

        .movie-info {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 25px;
            border-left: 4px solid #667eea;
        }

        .movie-info strong {
            color: #667eea;
            font-weight: 600;
        }

        .movie-info .current-cast {
            margin-top: 10px;
            font-size: 14px;
            color: #666;
        }

        .cast-item {
            display: inline-block;
            background: #e9ecef;
            padding: 4px 8px;
            border-radius: 12px;
            margin: 2px;
            font-size: 12px;
        }

        .form-group {
            margin-bottom: 25px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: #555;
            font-weight: 500;
            font-size: 14px;
        }

        .form-control {
            width: 100%;
            padding: 12px 16px;
            border: 2px solid #e1e5e9;
            border-radius: 10px;
            font-size: 16px;
            transition: all 0.3s ease;
            background: #f8f9fa;
        }

        .form-control:focus {
            outline: none;
            border-color: #667eea;
            background: white;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        .form-control:hover {
            border-color: #c1c7d0;
        }

        select.form-control {
            cursor: pointer;
        }

        .button-group {
            display: flex;
            gap: 15px;
            margin-top: 30px;
        }

        .btn {
            flex: 1;
            padding: 14px 24px;
            border: none;
            border-radius: 10px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            text-align: center;
            display: inline-block;
        }

        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.3);
        }

        .btn-secondary {
            background: #f8f9fa;
            color: #555;
            border: 2px solid #e1e5e9;
        }

        .btn-secondary:hover {
            background: #e9ecef;
            border-color: #c1c7d0;
        }

        @media (max-width: 768px) {
            .container {
                padding: 30px 20px;
                margin: 10px;
            }
            
            .button-group {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="form-header">
            <h2>✏️ Editar Película</h2>
            <p>Modifica los datos de la película seleccionada</p>
        </div>

        <div class="movie-info">
            <strong>ID:</strong> <?= $pelicula['id'] ?> | 
            <strong>Año:</strong> <?= $pelicula['anio'] ?>
            <div class="current-cast">
                <strong>Reparto actual:</strong><br>
                <span class="cast-item">🎭 <?= htmlspecialchars($pelicula['actor_nombre']) ?></span>
                <span class="cast-item">🎬 <?= htmlspecialchars($pelicula['director_nombre']) ?></span>
            </div>
        </div>

        <form action="update.php" method="POST">
            <input type="hidden" name="id" value="<?= $pelicula['id'] ?>">

            <div class="form-group">
                <label for="titulo">Título de la película</label>
                <input type="text" id="titulo" name="titulo" class="form-control" required 
                       value="<?= htmlspecialchars($pelicula['titulo']) ?>"
                       placeholder="Ingresa el título de la película">
            </div>

            <div class="form-group">
                <label for="anio">Año de estreno</label>
                <input type="number" id="anio" name="anio" class="form-control" required 
                       value="<?= $pelicula['anio'] ?>"
                       min="1900" max="<?php echo date('Y') + 5; ?>">
            </div>

            <div class="form-group">
                <label for="director_id">Director</label>
                <select id="director_id" name="director_id" class="form-control" required>
                    <option value="">-- Selecciona un director --</option>
                    <?php foreach ($directores as $d): ?>
                        <option value="<?= $d['id'] ?>" <?= $pelicula['director_id'] == $d['id'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($d['nombre']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="actor_id">Actor principal</label>
                <select id="actor_id" name="actor_id" class="form-control" required>
                    <option value="">-- Selecciona un actor --</option>
                    <?php foreach ($actores as $a): ?>
                        <option value="<?= $a['id'] ?>" <?= $pelicula['actor_id'] == $a['id'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($a['nombre']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="button-group">
                <button type="submit" class="btn btn-primary">💾 Actualizar Película</button>
                <a href="lista.php" class="btn btn-secondary">❌ Cancelar</a>
            </div>
        </form>
    </div>
</body>
</html>