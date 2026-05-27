<?php
// Activar reporte de errores para depuración en vivo
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// 1. Configuración de la conexión utilizando los datos de tu acordeón
$host = "localhost";
$user = "dev_user"; 
$password = "TruperDev2026!"; 
$database = "truper_equipo_ocho"; 

// Crear la conexión
$conn = new mysqli($host, $user, $password, $database);

// Validar si la conexión falló
if ($conn->connect_error) {
    die("Error crítico de infraestructura: " . $conn->connect_error);
}

// 2. Consulta adaptada EXACTAMENTE a las columnas de tu Workbench
$query = "SELECT id, codigo, nombre, categoria, precio, stock FROM productos"; 
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Truper - Panel de Producción</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }
        body {
            background: #141414;
            color: #fff;
            display: flex;
            min-height: 100vh;
        }

        /* Sidebar Menú */
        .sidebar {
            width: 260px;
            background: #1e1e1e;
            border-right: 1px solid #2d2d2d;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 30px 20px;
            position: fixed;
            height: 100vh;
        }
        .sidebar .brand {
            font-size: 24px;
            font-weight: 700;
            letter-spacing: 2px;
            margin-bottom: 40px;
            padding-left: 10px;
        }
        .sidebar .brand span { color: #ff6b00; }
        .sidebar-menu { list-style: none; flex-grow: 1; }
        .sidebar-menu li { margin-bottom: 8px; }
        .sidebar-menu a {
            display: block;
            padding: 12px 15px;
            color: #aaa;
            text-decoration: none;
            border-radius: 8px;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        .sidebar-menu a:hover, .sidebar-menu a.active {
            background: #ff6b00;
            color: #fff;
        }
        .btn-logout {
            padding: 12px 15px;
            background: #2a2a2a;
            color: #ff4444;
            text-align: center;
            text-decoration: none;
            border-radius: 8px;
            font-weight: 600;
            border: 1px solid #3a3a3a;
        }

        /* Contenido Principal */
        .main-content {
            margin-left: 260px;
            flex-grow: 1;
            padding: 40px;
        }
        .header-panel {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #2d2d2d;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        .header-panel h2 { font-size: 28px; font-weight: 600; }

        /* Tabla de Control */
        .table-container {
            background: #1e1e1e;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.2);
        }
        .table-container h3 {
            font-size: 18px;
            margin-bottom: 20px;
            font-weight: 600;
            color: #ff6b00;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
        }
        th {
            padding: 15px;
            color: #888;
            font-size: 13px;
            text-transform: uppercase;
            border-bottom: 1px solid #2d2d2d;
        }
        td {
            padding: 15px;
            border-bottom: 1px solid #2d2d2d;
            color: #ddd;
            font-size: 14px;
        }
        tr:hover td { background: #252525; color: #fff; }
        
        .badge {
            padding: 5px 10px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: 600;
        }
        .badge.success { background: rgba(0, 255, 127, 0.15); color: #00ff7f; }
        .badge.warning { background: rgba(255, 165, 0, 0.15); color: #ffa500; }
    </style>
</head>
<body>

    <div class="sidebar">
        <div>
            <div class="brand">TRUPER<span>.</span></div>
            <ul class="sidebar-menu">
                <li><a href="#" class="active">📦 Inventario Real</a></li>
                <li><a href="#">📊 Estadísticas</a></li>
                <li><a href="#">📋 Reportes</a></li>
            </ul>
        </div>
        <a href="logout.php" class="btn-logout">Cerrar Sesión</a>
    </div>

    <div class="main-content">
        <div class="header-panel">
            <div>
                <h2>Panel de Control de Almacén</h2>
                <p>Infraestructura LEMP - Datos reales desde la tabla 'productos'.</p>
            </div>
            <div>
                <p>Usuario BD: <strong style="color: #ff6b00;">dev_user</strong></p>
                <p style="color: #666; font-size: 12px; text-align: right;">Gobernanza: Equipo 8</p>
            </div>
        </div>

        <div class="table-container">
            <h3>Catálogo de Herramientas Registradas</h3>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Código</th>
                        <th>Descripción del Artículo</th>
                        <th>Categoría</th>
                        <th>Precio</th>
                        <th>Stock Disponible</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // 3. Renderizado mapeado uno a uno con la estructura de tu Workbench
                    if ($result && $result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            // Cambia dinámicamente el badge de stock si hay pocas unidades
                            $badgeClass = ($row['stock'] > 10) ? 'success' : 'warning';
                            
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($row['id']) . "</td>";
                            echo "<td><strong>" . htmlspecialchars($row['codigo']) . "</strong></td>";
                            echo "<td>" . htmlspecialchars($row['nombre']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['categoria']) . "</td>";
                            echo "<td>$" . number_format($row['precio'], 2) . " MXN</td>";
                            echo "<td><span class='badge " . $badgeClass . "'>" . htmlspecialchars($row['stock']) . " uds</span></td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='6' style='text-align:center; color:#888;'>No hay registros en la base de datos 'truper_equipo_ocho'.</td></tr>";
                    }
                    $conn->close();
                    ?>
                </tbody>
            </table>
        </div>
    </div>

</body>
</html>
