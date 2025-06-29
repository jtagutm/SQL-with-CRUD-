<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>CRUD Películas</title>
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
      justify-content: center;
      align-items: center;
      padding: 20px;
      position: relative;
      overflow: hidden;
    }
    
    body::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background: 
        radial-gradient(circle at 20% 80%, rgba(120, 119, 198, 0.3) 0%, transparent 50%),
        radial-gradient(circle at 80% 20%, rgba(255, 119, 198, 0.3) 0%, transparent 50%);
      pointer-events: none;
    }
    
    .container {
      position: relative;
      z-index: 1;
    }
    
    .menu {
      background: rgba(255, 255, 255, 0.95);
      backdrop-filter: blur(20px);
      padding: 40px;
      border-radius: 20px;
      box-shadow: 
        0 20px 40px rgba(0, 0, 0, 0.1),
        0 0 0 1px rgba(255, 255, 255, 0.2);
      text-align: center;
      max-width: 400px;
      width: 100%;
      border: 1px solid rgba(255, 255, 255, 0.3);
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
    
    .menu h1 {
      font-size: 2.2rem;
      margin-bottom: 30px;
      background: linear-gradient(135deg, #667eea, #764ba2);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
      font-weight: 700;
      letter-spacing: -1px;
    }
    
    .menu-grid {
      display: grid;
      gap: 15px;
    }
    
    .menu a {
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 16px 24px;
      background: linear-gradient(135deg, #667eea, #764ba2);
      color: white;
      text-decoration: none;
      border-radius: 12px;
      font-weight: 600;
      font-size: 1.1rem;
      transition: all 0.3s ease;
      position: relative;
      overflow: hidden;
      box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
    }
    
    .menu a::before {
      content: '';
      position: absolute;
      top: 0;
      left: -100%;
      width: 100%;
      height: 100%;
      background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
      transition: left 0.5s;
    }
    
    .menu a:hover::before {
      left: 100%;
    }
    
    .menu a:hover {
      transform: translateY(-2px);
      box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);
      background: linear-gradient(135deg, #5a67d8, #6b46c1);
    }
    
    .menu a:active {
      transform: translateY(0);
    }
    
    .icon {
      margin-right: 10px;
      font-size: 1.2rem;
    }
    
    .subtitle {
      color: #666;
      font-size: 1rem;
      margin-bottom: 25px;
      opacity: 0.8;
    }
    
    @media (max-width: 480px) {
      .menu {
        padding: 30px 20px;
        margin: 10px;
      }
      
      .menu h1 {
        font-size: 1.8rem;
      }
      
      .menu a {
        padding: 14px 20px;
        font-size: 1rem;
      }
    }
    
    /* Efectos adicionales */
    .floating-shapes {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      pointer-events: none;
      overflow: hidden;
    }
    
    .shape {
      position: absolute;
      background: rgba(255, 255, 255, 0.1);
      border-radius: 50%;
      animation: float 20s infinite linear;
    }
    
    .shape:nth-child(1) {
      width: 80px;
      height: 80px;
      left: 10%;
      animation-delay: 0s;
    }
    
    .shape:nth-child(2) {
      width: 60px;
      height: 60px;
      left: 70%;
      animation-delay: 5s;
    }
    
    .shape:nth-child(3) {
      width: 100px;
      height: 100px;
      left: 40%;
      animation-delay: 10s;
    }
    
    @keyframes float {
      0% {
        transform: translateY(100vh) rotate(0deg);
      }
      100% {
        transform: translateY(-100px) rotate(360deg);
      }
    }
  </style>
</head>
<body>
  <div class="floating-shapes">
    <div class="shape"></div>
    <div class="shape"></div>
    <div class="shape"></div>
  </div>
  
  <div class="container">
    <div class="menu">
      <h1>Sistema de Gestión</h1>
      <p class="subtitle">Administra tu contenido audiovisual</p>
      
      <div class="menu-grid">
        <a href="peliculas/lista.php">
          <span class="icon">🎬</span>
          Películas
        </a>
        <a href="actores/lista.php">
          <span class="icon">🎭</span>
          Actores
        </a>
        <a href="directores/lista.php">
          <span class="icon">🎯</span>
          Directores
        </a>
      </div>
    </div>
  </div>
</body>
</html>