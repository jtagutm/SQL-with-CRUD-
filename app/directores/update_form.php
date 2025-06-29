<?php
require_once(__DIR__ . '/../db.php');

$id = $_GET['id'] ?? null;
if (!$id) {
    die("ID no proporcionado.");
}

$stmt = $pdo->prepare("SELECT * FROM directores WHERE id = ?");
$stmt->execute([$id]);
$director = $stmt->fetch();
if (!$director) {
    die("Director no encontrado.");
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Director - Sistema de Gestión</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
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
            background: linear-gradient(90deg, #11998e, #38ef7d);
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

        .director-info {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 25px;
            border-left: 4px solid #11998e;
        }

        .director-info strong {
            color: #11998e;
            font-weight: 600;
        }

        .stats-badge {
            display: inline-block;
            background: #11998e;
            color: white;
            padding: 4px 12px;
            border-radius: 15px;
            font-size: 12px;
            font-weight: 600;
            margin-left: 10px;
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
            border-color: #11998e;
            background: white;
            box-shadow: 0 0 0 3px rgba(17, 153, 142, 0.1);
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
            background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
            color: white;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(17, 153, 142, 0.3);
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
            <h2>✏️ Editar Director</h2>
            <p>Modifica los datos del director seleccionado</p>
        </div>

        <div class="director-info">
            <strong>ID:</strong> <?= $director['id'] ?> | 
            <strong>Películas dirigidas:</strong> <?= $director['peliculas_dirigidas'] ?>
            <span class="stats-badge"><?= $director['peliculas_dirigidas'] > 5 ? 'Experimentado' : 'En desarrollo' ?></span>
        </div>

        <form action="update.php" method="POST">
            <input type="hidden" name="id" value="<?= $director['id'] ?>">

            <div class="form-group">
                <label for="nombre">Nombre completo</label>
                <input type="text" id="nombre" name="nombre" class="form-control" required 
                       value="<?= htmlspecialchars($director['nombre']) ?>"
                       placeholder="Ingresa el nombre completo del director">
            </div>

            <div class="form-group">
                <label for="nacionalidad">Nacionalidad</label>
                <input type="text" id="nacionalidad" name="nacionalidad" class="form-control" required 
                       value="<?= htmlspecialchars($director['nacionalidad']) ?>"
                       placeholder="Ej: Estadounidense, Mexicano, Español">
            </div>

            <div class="form-group">
                <label for="nacimiento">Año de nacimiento</label>
                <input type="number" id="nacimiento" name="nacimiento" class="form-control" required 
                       value="<?= $director['nacimiento'] ?>"
                       min="1900" max="<?= date('Y') - 18; ?>">
            </div>

            <div class="form-group">
                <label for="genero">Género</label>
                <select id="genero" name="genero" class="form-control" required>
                    <option value="M" <?= $director['genero'] == 'M' ? 'selected' : '' ?>>Masculino</option>
                    <option value="F" <?= $director['genero'] == 'F' ? 'selected' : '' ?>>Femenino</option>
                    <option value="Otro" <?= $director['genero'] == 'Otro' ? 'selected' : '' ?>>Otro</option>
                </select>
            </div>

            <div class="form-group">
                <label for="peliculas_dirigidas">Películas dirigidas</label>
                <input type="number" id="peliculas_dirigidas" name="peliculas_dirigidas" 
                       class="form-control" value="<?= $director['peliculas_dirigidas'] ?>" 
                       min="0" placeholder="Número de películas dirigidas">
            </div>

            <div class="button-group">
                <button type="submit" class="btn btn-primary">💾 Actualizar Director</button>
                <a href="lista.php" class="btn btn-secondary">❌ Cancelar</a>
            </div>
        </form>
    </div>
</body>
</html>