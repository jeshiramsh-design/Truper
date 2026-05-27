<?php
session_start();
if (isset($_SESSION['usuario'])) {
    header("Location: panel.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TRUPER - Portal Corporativo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/theme/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f4f6f9;
            color: #333;
        }
        .navbar-truper {
            background-color: #222222;
            border-bottom: 4px solid #ff6b00;
        }
        .navbar-truper .navbar-brand {
            color: #ffffff;
            font-weight: 700;
            letter-spacing: 1px;
        }
        .brand-orange { color: #ff6b00; }
        
        /* Tarjetas de Contenido */
        .card-institutional {
            background: #ffffff;
            border: none;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.05);
            transition: transform 0.3s;
        }
        .section-title {
            color: #222222;
            font-weight: 600;
            position: relative;
            padding-bottom: 10px;
        }
        .section-title::after {
            content: '';
            position: absolute;
            left: 0;
            bottom: 0;
            width: 50px;
            height: 3px;
            background-color: #ff6b00;
            border-radius: 2px;
        }
        
        /* Tarjeta de Login */
        .card-login {
            background: #ffffff;
            border: none;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.08);
            border-top: 5px solid #ff6b00;
        }
        .form-control {
            border-radius: 8px;
            padding: 12px;
            border: 1px solid #ced4da;
            background-color: #f8f9fa;
        }
        .form-control:focus {
            background-color: #fff;
            border-color: #ff6b00;
            box-shadow: 0 0 0 0.25rem rgba(255, 107, 0, 0.15);
        }
        .btn-truper {
            background-color: #ff6b00;
            color: white;
            font-weight: 600;
            border-radius: 8px;
            padding: 12px;
            border: none;
            transition: all 0.3s;
        }
        .btn-truper:hover {
            background-color: #e05e00;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(255, 107, 0, 0.3);
        }
        .icon-box {
            color: #ff6b00;
            font-size: 1.5rem;
            margin-right: 10px;
        }
    </style>
</head>
<body>

    <nav class="navbar navbar-truper shadow-sm mb-5 py-3">
        <div class="container">
            <span class="navbar-brand mb-0 h1">🛠️ TRUPER <span class="brand-orange">PRO</span></span>
        </div>
    </nav>

    <div class="container">
        <div class="row g-4 align-items-stretch">
            
            <div class="col-md-7">
                <div class="card-institutional p-5 h-100">
                    <h2 class="section-title mb-4">Gobernanza e Identidad Corporativa</h2>
                    
                    <div class="mb-4 mt-4">
                        <h5 class="d-flex align-items-center fw-bold text-dark">
                            <span class="icon-box">🎯</span> Misión
                        </h5>
                        <p class="text-muted lh-base" style="text-align: justify;">
                            Mantener una posición de liderazgo en el mercado de herramientas y productos ferreteros, ofreciendo un catálogo de la más alta calidad con la mejor relación costo-beneficio, asegurando la eficiencia operativa mediante tecnologías de infraestructura de vanguardia.
                        </p>
                    </div>

                    <div class="mb-4">
                        <h5 class="d-flex align-items-center fw-bold text-dark">
                            <span class="icon-box">👁️</span> Visión
                        </h5>
                        <p class="text-muted lh-base" style="text-align: justify;">
                            Ser la empresa de manufactura, distribución y comercialización de herramientas más competitiva de América Latina, consolidando la transformación digital constante y la disponibilidad de inventarios en tiempo real estructurados en la nube.
                        </p>
                    </div>

                    <div class="mt-4 pt-3 border-top">
                        <div class="row text-center text-secondary small fw-medium">
                            <div class="col-4 border-end">🛡️ DATOS SEGUROS</div>
                            <div class="col-4 border-end">⚡ ALTA DISPONIBILIDAD</div>
                            <div class="col-4">🚀 CLOUD NODE</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-5 d-flex align-items-center">
                <div class="card-login p-5 w-100">
                    <div class="text-center mb-4">
                        <h4 class="fw-bold text-dark mb-1">Control de Acceso</h4>
                        <p class="text-muted small">Entorno seguro de producción - Equipo Ocho</p>
                    </div>
                    
                    <?php if (isset($_GET['error'])): ?>
                        <div class="alert alert-danger text-center py-2 small border-0 shadow-sm" role="alert">
                            ⚠️ Credenciales de autenticación incorrectas.
                        </div>
                    <?php endif; ?>

                    <form action="login_process.php" method="POST">
                        <div class="mb-3">
                            <label for="username" class="form-label small fw-semibold text-secondary">Usuario del Sistema</label>
                            <input type="text" class="form-control" id="username" name="username" placeholder="Usuario de producción" required autocomplete="off">
                        </div>
                        <div class="mb-4">
                            <label for="password" class="form-label small fw-semibold text-secondary">Contraseña Criptográfica</label>
                            <input type="password" class="form-control" id="password" name="password" placeholder="••••••••" required>
                        </div>
                        <button type="submit" class="btn btn-truper w-100 shadow-sm">Autenticar Entrada</button>
                    </form>
                </div>
            </div>

        </div>
    </div>

    <footer class="text-center my-5 text-muted small">
        <hr class="w-25 mx-auto mb-3">
        <p class="mb-0 fw-medium">Taller de Sistemas Operativos — Instituto Tecnológico de Oaxaca</p>
    </footer>

</body>
</html>
