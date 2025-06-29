<?php
require_once(__DIR__ . '/../db.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'] ?? '';
    $nacionalidad = $_POST['nacionalidad'] ?? '';
    $nacimiento = $_POST['nacimiento'] ?? '';
    $genero = $_POST['genero'] ?? '';
    $premio = $_POST['premio'] ?? '';
    $activo = isset($_POST['activo']) ? 1 : 0;

    if ($nombre && $nacionalidad && $nacimiento && $genero) {
        $stmt = $pdo->prepare("INSERT INTO actores (nombre, nacionalidad, nacimiento, genero, premio, activo) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([$nombre, $nacionalidad, $nacimiento, $genero, $premio, $activo]);
        header("Location: lista.php");
    } else {
        $error = "Todos los campos obligatorios deben ser completados.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nuevo Actor - Sistema de Gestión</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #ff6b6b 0%, #ffa500 100%);
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
            background: linear-gradient(90deg, #ff6b6b, #ffa500);
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
            border-color: #ff6b6b;
            background: white;
            box-shadow: 0 0 0 3px rgba(255, 107, 107, 0.1);
        }

        .form-control:hover {
            border-color: #c1c7d0;
        }

        select.form-control {
            cursor: pointer;
        }

        .checkbox-group {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-top: 10px;
        }

        .checkbox-group input[type="checkbox"] {
            width: 20px;
            height: 20px;
            border: 2px solid #e1e5e9;
            border-radius: 4px;
            cursor: pointer;
        }

        .checkbox-group label {
            margin: 0;
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
            background: linear-gradient(135deg, #ff6b6b 0%, #ffa500 100%);
            color: white;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(255, 107, 107, 0.3);
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
            <h2>🎭 Nuevo Actor</h2>
            <p>Completa los datos para agregar un nuevo actor</p>
        </div>

        <?php if (isset($error)): ?>
            <div class="error-message">
                ⚠️ <?php echo htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>

        <form action="create.php" method="POST">
            <div class="form-group">
                <label for="nombre">Nombre completo</label>
                <input type="text" id="nombre" name="nombre" class="form-control" required 
                       placeholder="Ingresa el nombre completo del actor">
            </div>

            <div class="form-group">
                <label for="nacionalidad">Nacionalidad</label>
                <input type="text" id="nacionalidad" name="nacionalidad" class="form-control" required 
                       placeholder="Ej: Estadounidense, Mexicano, Español">
            </div>

            <div class="form-group">
                <label for="nacimiento">Año de nacimiento</label>
                <input type="number" id="nacimiento" name="nacimiento" class="form-control" required 
                       min="1900" max="<?php echo date('Y') - 18; ?>" 
                       placeholder="<?php echo date('Y') - 30; ?>">
            </div>

            <div class="form-group">
                <label for="genero">Género</label>
                <select id="genero" name="genero" class="form-control" required>
                    <option value="">-- Selecciona un género --</option>
                    <option value="M">Masculino</option>
                    <option value="F">Femenino</option>
                    <option value="Otro">Otro</option>
                </select>
            </div>

            <div class="form-group">
                <label for="premio">Premio (opcional)</label>
                <input type="text" id="premio" name="premio" class="form-control" 
                       placeholder="Ej: Oscar, Emmy, Globo de Oro">
            </div>

            <div class="form-group">
                <label>Estado del actor</label>
                <div class="checkbox-group">
                    <input type="checkbox" id="activo" name="activo">
                    <label for="activo">Actualmente activo en la industria</label>
                </div>
            </div>

            <div class="button-group">
                <button type="submit" class="btn btn-primary">✨ Crear Actor</button>
                <a href="lista.php" class="btn btn-secondary">❌ Cancelar</a>
            </div>
        </form>
    </div>
</body>
</html>