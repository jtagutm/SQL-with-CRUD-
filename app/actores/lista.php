<?php
require_once(__DIR__ . '/../db.php');

$stmt = $pdo->query("SELECT * FROM actores ORDER BY nombre");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Actores</title>
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
            padding: 20px;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            animation: slideUp 0.8s ease-out;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            flex-wrap: wrap;
            gap: 15px;
        }

        .title {
            font-size: 2.5rem;
            background: linear-gradient(135deg, #667eea, #764ba2);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .actions {
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
        }

        .btn {
            padding: 12px 24px;
            border-radius: 12px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 8px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .btn-primary {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
        }

        .btn-secondary {
            background: white;
            color: #667eea;
            border: 2px solid #667eea;
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
        }

        .actors-grid {
            display: grid;
            gap: 20px;
            grid-template-columns: repeat(auto-fill, minmax(380px, 1fr));
        }

        .actor-card {
            background: white;
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            border: 1px solid rgba(0, 0, 0, 0.05);
            position: relative;
            overflow: hidden;
        }

        .actor-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(135deg, #ff6b6b, #ffd93d);
        }

        .actor-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.15);
        }

        .actor-name {
            font-size: 1.4rem;
            font-weight: 700;
            color: #333;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .actor-info {
            display: grid;
            gap: 10px;
            margin-bottom: 20px;
        }

        .info-item {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 0.95rem;
            color: #666;
        }

        .info-label {
            font-weight: 600;
            color: #333;
            min-width: 100px;
        }

        .info-value {
            flex: 1;
        }

        .status-badge {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 600;
            display: inline-block;
        }

        .status-active {
            background: linear-gradient(135deg, #28a745, #20c997);
            color: white;
        }

        .status-inactive {
            background: linear-gradient(135deg, #6c757d, #adb5bd);
            color: white;
        }

        .award-badge {
            background: linear-gradient(135deg, #ffd700, #ffb347);
            color: #333;
            padding: 4px 10px;
            border-radius: 15px;
            font-size: 0.8rem;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }

        .actor-actions {
            display: flex;
            gap: 10px;
            justify-content: flex-end;
        }

        .btn-small {
            padding: 8px 16px;
            font-size: 0.9rem;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-edit {
            background: #007bff;
            color: white;
        }

        .btn-delete {
            background: #dc3545;
            color: white;
        }

        .btn-small:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }

        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: #666;
            grid-column: 1 / -1;
        }

        .empty-icon {
            font-size: 4rem;
            margin-bottom: 20px;
            opacity: 0.5;
        }

        @media (max-width: 768px) {
            .header {
                flex-direction: column;
                align-items: stretch;
            }

            .title {
                font-size: 2rem;
                text-align: center;
            }

            .actions {
                justify-content: center;
            }

            .actors-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1 class="title">
                🎭 Actores
            </h1>
            <div class="actions">
                <a href="../index.php" class="btn btn-secondary">
                    ← Volver al menú
                </a>
                <a href="create.php" class="btn btn-primary">
                    + Nuevo actor
                </a>
            </div>
        </div>

        <div class="actors-grid">
            <?php 
            $hasActors = false;
            while ($row = $stmt->fetch()): 
                $hasActors = true;
                $activo = $row['activo'] ? 'Sí' : 'No';
                $activoClass = $row['activo'] ? 'status-active' : 'status-inactive';
            ?>
                <div class="actor-card">
                    <h3 class="actor-name">
                        🌟 <?= htmlspecialchars($row['nombre']) ?>
                    </h3>
                    
                    <div class="actor-info">
                        <div class="info-item">
                            <span class="info-label">Nacionalidad:</span>
                            <span class="info-value">🌍 <?= htmlspecialchars($row['nacionalidad']) ?></span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Nacimiento:</span>
                            <span class="info-value">📅 <?= htmlspecialchars($row['nacimiento']) ?></span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Género:</span>
                            <span class="info-value">👤 <?= htmlspecialchars($row['genero']) ?></span>
                        </div>
                        <?php if (!empty($row['premio'])): ?>
                        <div class="info-item">
                            <span class="info-label">Premio:</span>
                            <span class="award-badge">🏆 <?= htmlspecialchars($row['premio']) ?></span>
                        </div>
                        <?php endif; ?>
                        <div class="info-item">
                            <span class="info-label">Estado:</span>
                            <span class="status-badge <?= $activoClass ?>">
                                <?= $row['activo'] ? '✅ Activo' : '❌ Inactivo' ?>
                            </span>
                        </div>
                    </div>
                    
                    <div class="actor-actions">
                        <a href="update_form.php?id=<?= $row['id'] ?>" class="btn-small btn-edit">
                            ✏️ Editar
                        </a>
                        <a href="delete.php?id=<?= $row['id'] ?>" class="btn-small btn-delete" 
                           onclick="return confirm('¿Estás seguro de eliminar este director?')">
                            🗑️ Eliminar
                        </a>
                    </div>
                </div>
            <?php endwhile; ?>
            
            <?php if (!$hasActors): ?>
                <div class="empty-state">
                    <div class="empty-icon">🎯</div>
                    <h3>No hay actores registrados</h3>
                    <p>Comienza agregando tu primer actor</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>