<?php
require_once(__DIR__ . '/../db.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = $_POST['titulo'] ?? '';
    $anio = $_POST['anio'] ?? '';
    $actor_id = $_POST['actor_id'] ?? '';
    $director_id = $_POST['director_id'] ?? '';

    if ($titulo && $anio && $actor_id && $director_id) {
        $stmt = $pdo->prepare("INSERT INTO peliculas (titulo, anio, actor_id, director_id) VALUES (?, ?, ?, ?)");
        $stmt->execute([$titulo, $anio, $actor_id, $director_id]);
        header("Location: lista.php");
    } else {
        $error = "Todos los campos son obligatorios.";
    }
}

// Obtener actores para el select
$actores = $pdo->query("SELECT id, nombre FROM actores ORDER BY nombre")->fetchAll();

// Obtener directores para el select
$directores = $pdo->query("SELECT id, nombre FROM directores ORDER BY nombre")->fetchAll();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nueva Película - Sistema de Gestión</title>
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

        .error-message {
            background: #fee;
            color: #c33;
            padding: 12px 16px;
            border-radius: 8px;
            margin-bottom: 20px;
            border-left: 4px solid #c33;
            font-size: 14px;
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

        .form-icon {
            position: absolute;
            top: 50%;
            right: 16px;
            transform: translateY(-50%);
            color: #999;
            pointer-events: none;
        }

        .input-wrapper {
            position: relative;
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
            <h2>🎬 Nueva Película</h2>
            <p>Completa los datos para agregar una nueva película</p>
        </div>

        <?php if (isset($error)): ?>
            <div class="error-message">
                ⚠️ <?php echo htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>

        <form action="create.php" method="POST">
            <div class="form-group">
                <label for="titulo">Título de la película</label>
                <input type="text" id="titulo" name="titulo" class="form-control" required 
                       placeholder="Ingresa el título de la película">
            </div>

            <div class="form-group">
                <label for="anio">Año de estreno</label>
                <input type="number" id="anio" name="anio" class="form-control" required 
                       min="1900" max="<?php echo date('Y') + 5; ?>" 
                       placeholder="<?php echo date('Y'); ?>">
            </div>

            <div class="form-group">
                <label for="actor_id">Actor principal</label>
                <select id="actor_id" name="actor_id" class="form-control" required>
                    <option value="">-- Selecciona un actor --</option>
                    <?php foreach ($actores as $actor): ?>
                        <option value="<?php echo $actor['id']; ?>">
                            <?php echo htmlspecialchars($actor['nombre']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="director_id">Director</label>
                <select id="director_id" name="director_id" class="form-control" required>
                    <option value="">-- Selecciona un director --</option>
                    <?php foreach ($directores as $director): ?>
                        <option value="<?php echo $director['id']; ?>">
                            <?php echo htmlspecialchars($director['nombre']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="button-group">
                <button type="submit" class="btn btn-primary">✨ Crear Película</button>
                <a href="lista.php" class="btn btn-secondary">❌ Cancelar</a>
            </div>
        </form>
    </div>
</body>
</html>