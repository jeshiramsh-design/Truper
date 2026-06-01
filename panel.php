<?php
// 1. CONTROL DE SESIÓN Y SEGURIDAD PERIMETRAL
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Si no hay sesión activa, redirigir al login inmediatamente
if (!isset($_SESSION['db_user'])) {
    header("Location: login.php");
    exit();
}

// Capturar el usuario de la sesión
$db_user = $_SESSION['db_user'];
$db_pass = ($db_user === 'dev_user') ? 'TruperDev2026!' : 'TruperAudit2026!';
$tiene_permiso_escritura = ($db_user === 'dev_user');

// 2. CONEXIÓN DINÁMICA A LA BASE DE DATOS
$host = "localhost";
$database = "truper_equipo_ocho"; 

$conn = new mysqli($host, $db_user, $db_pass, $database);

if ($conn->connect_error) {
    die("Error de infraestructura: " . $conn->connect_error);
}

// 3. PROCESAMIENTO DEL FORMULARIO (Solo para dev_user)
$mensaje_insercion = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['agregar_producto'])) {
    if ($tiene_permiso_escritura) {
        $codigo = trim($_POST['codigo']);
        $nombre = trim($_POST['nombre']);
        $categoria = trim($_POST['categoria']);
        $precio = floatval($_POST['precio']);
        $stock = intval($_POST['stock']);

        // Consulta preparada con las columnas exactas de tu base de datos
        $stmt = $conn->prepare("INSERT INTO productos (codigo, nombre, categoria, precio, stock) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssi", $codigo, $nombre, $categoria, $precio, $stock);
        
        if ($stmt->execute()) {
            $mensaje_insercion = "<p style='color: #00ff7f; margin-bottom: 20px; font-weight: 500;'>✓ Producto registrado exitosamente.</p>";
        } else {
            $mensaje_insercion = "<p style='color: #ff4444; margin-bottom: 20px; font-weight: 500;'>Error al registrar: " . $stmt->error . "</p>";
        }
        $stmt->close();
    } else {
        $mensaje_insercion = "<p style='color: #ff4444; margin-bottom: 20px; font-weight: 500;'>⚠️ Error: Tu usuario no cuenta con privilegios de escritura.</p>";
    }
}

// 4. CONSULTA DE HERRAMIENTAS (Columnas reales de tu Workbench)
$query = "SELECT id, codigo, nombre, categoria, precio, stock FROM productos"; 
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Truper - Panel de Almacén</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Poppins', sans-serif; }
        body { background: #141414; color: #fff; display: flex; min-height: 100vh; }

        /* Estilos de la Barra Lateral */
        .sidebar { width: 260px; background: #1e1e1e; border-right: 1px solid #2d2d2d; display: flex; flex-direction: column; justify-content: space-between; padding: 30px 20px; position: fixed; height: 100vh; }
        .sidebar .brand { font-size: 24px; font-weight: 700; letter-spacing: 2px; margin-bottom: 40px; padding-left: 10px; }
        .sidebar .brand span { color: #ff6b00; }
        .sidebar-menu { list-style: none; flex-grow: 1; }
        .sidebar-menu li { margin-bottom: 8px; }
        .sidebar-menu a { display: block; padding: 12px 15px; color: #aaa; text-decoration: none; border-radius: 8px; font-weight: 500; transition: all 0.3s ease; }
        .sidebar-menu a:hover, .sidebar-menu a.active { background: #ff6b00; color: #fff; }
        .btn-logout { padding: 12px 15px; background: #2a2a2a; color: #ff4444; text-align: center; text-decoration: none; border-radius: 8px; font-weight: 600; border: 1px solid #3a3a3a; transition: background 0.3s; }
        .btn-logout:hover { background: #331c1c; }

        /* Área de Contenido */
        .main-content { margin-left: 260px; flex-grow: 1; padding: 40px; }
        .header-panel { display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #2d2d2d; padding-bottom: 20px; margin-bottom: 30px; }
        .header-panel h2 { font-size: 28px; font-weight: 600; }
        
        /* Layout Adaptable (Grid) */
        .grid-panel { display: grid; grid-template-columns: <?php echo $tiene_permiso_escritura ? '2fr 1fr' : '1fr'; ?>; gap: 30px; }
        .table-container, .form-container { background: #1e1e1e; padding: 30px; border-radius: 12px; border: 1px solid #2d2d2d; box-shadow: 0 4px 20px rgba(0,0,0,0.2); }
        h3 { font-size: 18px; margin-bottom: 20px; font-weight: 600; color: #ff6b00; text-transform: uppercase; letter-spacing: 0.5px; }
        
        /* Formulario */
        .form-group { margin-bottom: 15px; text-align: left; }
        .form-group label { display: block; font-size: 13px; color: #888; margin-bottom: 5px; }
        .form-group input { width: 100%; padding: 11px; background: #2a2a2a; border: 1px solid #3a3a3a; border-radius: 6px; color: #fff; font-size: 14px; }
        .form-group input:focus { border-color: #ff6b00; outline: none; }
        .btn-submit { width: 100%; padding: 12px; background: #ff6b00; color: #fff; border: none; border-radius: 6px; font-weight: 600; cursor: pointer; transition: background 0.3s; }
        .btn-submit:hover { background: #e05e00; }

        /* Tabla Estilizada */
        table { width: 100%; border-collapse: collapse; text-align: left; }
        th { padding: 15px; color: #888; font-size: 13px; text-transform: uppercase; border-bottom: 1px solid #2d2d2d; }
        td { padding: 15px; border-bottom: 1px solid #2d2d2d; color: #ddd; font-size: 14px; }
        tr:hover td { background: #252525; color: #fff; }
        
        /* Componentes de Estado */
        .badge { padding: 5px 10px; border-radius: 4px; font-size: 12px; font-weight: 600; }
        .badge.success { background: rgba(0, 255, 127, 0.15); color: #00ff7f; }
        .badge.warning { background: rgba(255, 165, 0, 0.15); color: #ffa500; }
    </style>
</head>
<body>

    <!-- SIDEBAR -->
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

    <!-- MAIN CONTENT -->
    <div class="main-content">
        <div class="header-panel">
            <div>
                <h2>Panel de Control de Almacén</h2>
                <p>Mapeo directo de infraestructura con privilegios asignados en el SGBD.</p>
            </div>
            <div>
                <p>Usuario Conectado: <strong style="color: #ff6b00;"><?php echo htmlspecialchars($db_user); ?></strong></p>
                <p style="color: #666; font-size: 12px; text-align: right;">Gobernanza: Equipo 8</p>
            </div>
        </div>

        <?php echo $mensaje_insercion; ?>

        <div class="grid-panel">
            
            <!-- VISTA DEL INVENTARIO -->
            <div class="table-container">
                <h3>Catálogo de Herramientas Registradas</h3>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Código</th>
                            <th>Descripción</th>
                            <th>Categoría</th>
                            <th>Precio</th>
                            <th>Stock Disponible</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($result && $result->num_rows > 0) {
                            while($row = $result->fetch_assoc()) {
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
                            echo "<tr><td colspan='6' style='text-align:center; color:#888;'>No hay registros en la base de datos.</td></tr>";
                        }
                        $conn->close();
                        ?>
                    </tbody>
                </table>
            </div>

            <!-- FORMULARIO CONDICIONAL (Solo aparece para dev_user) -->
            <?php if ($tiene_permiso_escritura): ?>
            <div class="form-container">
                <h3>Agregar Nuevo Artículo</h3>
                <form action="panel.php" method="POST">
                    <div class="form-group">
                        <label>Código Truper</label>
                        <input type="text" name="codigo" placeholder="Ej: TRU-4501" required>
                    </div>
                    <div class="form-group">
                        <label>Nombre del Producto</label>
                        <input type="text" name="nombre" placeholder="Ej: Martillo Galame 16oz" required>
                    </div>
                    <div class="form-group">
                        <label>Categoría</label>
                        <input type="text" name="categoria" placeholder="Ej: Carpintería" required>
                    </div>
                    <div class="form-group">
                        <label>Precio Público</label>
                        <input type="number" step="0.01" name="precio" placeholder="0.00" required>
                    </div>
                    <div class="form-group">
                        <label>Stock Inicial</label>
                        <input type="number" name="stock" placeholder="0" required>
                    </div>
                    <button type="submit" name="agregar_producto" class="btn-submit">Registrar en Catálogo</button>
                </form>
            </div>
            <?php endif; ?>

        </div>
    </div>

</body>
</html>
