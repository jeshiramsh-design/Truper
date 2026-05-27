<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: index.php");
    exit();
}

$host = '127.0.0.1';
$user = 'dev_user';
$password = 'TruperDev2026!';
$database = 'truper_equipo_ocho';

$conn = new mysqli($host, $user, $password, $database);
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

$query = "SELECT * FROM productos";
$result = $conn->query($query);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Truper - Panel de Producción</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/theme/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f4f6f9;
        }
        .navbar-truper {
            background-color: #222222;
            border-bottom: 4px solid #ff6b00;
        }
        .navbar-truper .navbar-brand {
            color: #ffffff;
            font-weight: 700;
        }
        .brand-orange { color: #ff6b00; }
        
        /* Contenedores */
        .main-container {
            background: #ffffff;
            border-radius: 12px;
            box-shadow: 0 4px 25px rgba(0,0,0,0.04);
            border: none;
        }
        
        /* Tarjetas Informativas */
        .stat-card {
            background: #ffffff;
            border: none;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.02);
            border-left: 4px solid #ff6b00;
        }
        
        /* Estilos de Tabla */
        .table {
            border-collapse: separate;
            border-spacing: 0 8px;
        }
        .table thead th {
            background-color: #222222 !important;
            color: #ffffff !important;
            border: none;
            padding: 15px;
            font-weight: 500;
        }
        .table tbody tr {
            background-color: #ffffff;
            box-shadow: 0 2px 8px rgba(0,0,0,0.02);
            transition: all 0.2s;
        }
        .table tbody tr:hover {
            transform: scale(1.005);
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
            background-color: #fafafa;
        }
        .table tbody td {
            padding: 15px;
            border: none;
            vertical-align: middle;
        }
        .table tbody tr td:first-child {
            border-top-left-radius: 8px;
            border-bottom-left-radius: 8px;
        }
        .table tbody tr td:last-child {
            border-top-right-radius: 8px;
            border-bottom-right-radius: 8px;
        }
        
        /* Badges de Stock */
        .badge-stock-high { background-color: rgba(25, 135, 84, 0.1); color: #198754; font-weight: 600; padding: 8px 12px; }
        .badge-stock-low { background-color: rgba(255, 193, 7, 0.15); color: #b58100; font-weight: 600; padding: 8px 12px; }
        .badge-code { background-color: #e9ecef; color: #495057; font-weight: 500; }
    </style>
</head>
<body>

    <nav class="navbar navbar-truper shadow-sm mb-4 py-3">
        <div class="container-fluid px-4 d-flex justify-content-between align-items-center">
            <span class="navbar-brand mb-0 h1">🛠️ TRUPER <span class="brand-orange">CONSOLA</span></span>
            <div class="d-flex align-items-center text-white small fw-medium">
                <span class="me-3">👤 Identidad: <span class="text-warning fw-bold"><?php echo $_SESSION['usuario']; ?></span></span>
                <span class="badge bg-success me-3">ONLINE</span>
                <a href="logout.php" class="btn btn-sm btn-outline-light px-3 fw-semibold" style="border-radius: 6px;">Cerrar Sesión</a>
            </div>
        </div>
    </nav>

    <div class="container mb-5">
        
        <div class="row g-3 mb-4">
            <div class="col-md-4">
                <div class="stat-card p-3 d-flex justify-content-between align-items-center bg-white">
                    <div>
                        <p class="text-muted small mb-1 fw-medium">CONEXIÓN ORIGEN</p>
                        <h6 class="fw-bold text-dark mb-0">Localhost (127.0.0.1)</h6>
                    </div>
                    <span class="fs-3">🔌</span>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-card p-3 d-flex justify-content-between align-items-center bg-white" style="border-left-color: #198754;">
                    <div>
                        <p class="text-muted small mb-1 fw-medium">PERFIL GOBERNANZA</p>
                        <h6 class="fw-bold text-dark mb-0">dev_user (Escritura/Lectura)</h6>
                    </div>
                    <span class="fs-3">🔑</span>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-card p-3 d-flex justify-content-between align-items-center bg-white" style="border-left-color: #0dcaf0;">
                    <div>
                        <p class="text-muted small mb-1 fw-medium">TOTAL REGISTROS</p>
                        <h6 class="fw-bold text-dark mb-0"><?php echo $result->num_rows; ?> Productos activos</h6>
                    </div>
                    <span class="fs-3">📦</span>
                </div>
            </div>
        </div>

        <div class="main-container p-4 bg-white">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h4 class="fw-bold text-dark mb-1">Catálogo General en Producción</h4>
                    <p class="text-muted small mb-0">Datos consultados dinámicamente mediante extensión MySQLi nativa</p>
                </div>
            </div>
            
            <div class="table-responsive">
                <table class="table align-middle">
                    <thead>
                        <tr>
                            <th style="width: 80px; border-top-left-radius: 8px; border-bottom-left-radius: 8px;">ID</th>
                            <th style="width: 140px;">Código</th>
                            <th>Descripción de Producto</th>
                            <th>Categoría Logística</th>
                            <th>Precio Unitario</th>
                            <th style="border-top-right-radius: 8px; border-bottom-right-radius: 8px; width: 150px;">Disponibilidad</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($result->num_rows > 0): ?>
                            <?php while($row = $result->fetch_assoc()): ?>
                                <tr>
                                    <td class="fw-bold text-secondary">#<?php echo $row['id']; ?></td>
                                    <td><span class="badge badge-code px-2 py-2"><?php echo $row['codigo']; ?></span></td>
                                    <td class="fw-semibold text-dark"><?php echo $row['nombre']; ?></td>
                                    <td class="text-muted small"><?php echo $row['categoria']; ?></td>
                                    <td class="fw-bold text-dark">$<?php echo number_format($row['precio'], 2); ?></td>
                                    <td>
                                        <?php if($row['stock'] > 20): ?>
                                            <span class="badge badge-stock-high rounded-pill">📦 <?php echo $row['stock']; ?> pzs</span>
                                        <?php else: ?>
                                            <span class="badge badge-stock-low rounded-pill">⚠️ <?php echo $row['stock']; ?> pzs</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" class="text-center py-5 text-muted">
                                    <span class="fs-2 mb-2 d-block">❌</span> No se encontraron registros en la base de datos remota.
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <footer class="text-center my-5 text-muted small">
        <p>Taller de Sistemas Operativos — Instituto Tecnológico de Oaxaca</p>
    </footer>

</body>
</html>
<?php $conn->close(); ?>
