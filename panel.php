<?php
// 1. Iniciar sesión para saber qué usuario está navegando
session_start();

// Validar qué usuario de base de datos se va a usar. 
// Si no hay sesión activa (por ejemplo, directo del login), por defecto usamos dev_user para la vista
$db_user = isset($_SESSION['db_user']) ? $_SESSION['db_user'] : 'dev_user';
$db_pass = ($db_user == 'dev_user') ? 'TruperDev2026!' : 'TruperAudit2026!';

// Determinar si el usuario actual tiene permisos de escritura
$tiene_permiso_escritura = ($db_user == 'dev_user');

// Configuración de la conexión
$host = "localhost";
$database = "truper_equipo_ocho"; 

$conn = new mysqli($host, $db_user, $db_pass, $database);

if ($conn->connect_error) {
    die("Error crítico de infraestructura: " . $conn->connect_error);
}

// 2. LÓGICA DE INSERCIÓN: Solo se ejecuta si viene del formulario y el usuario es 'dev_user'
$mensaje_insercion = "";
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['agregar_producto'])) {
    if ($tiene_permiso_escritura) {
        $codigo = $_POST['codigo'];
        $nombre = $_POST['nombre'];
        $categoria = $_POST['categoria'];
        $precio = $_POST['precio'];
        $stock = $_POST['stock'];

        // Preparar la consulta para evitar inyecciones
        $stmt = $conn->prepare("INSERT INTO productos (codigo, nombre, categoria, precio, stock) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssi", $codigo, $nombre, $categoria, $precio, $stock);
        
        if ($stmt->execute()) {
            $mensaje_insercion = "<p style='color: #00ff7f; margin-bottom: 20px;'>✓ Producto agregado correctamente a la base de datos.</p>";
        } else {
            $mensaje_insercion = "<p style='color: #ff4444; margin-bottom: 20px;'>Error al insertar: " . $stmt->error . "</p>";
        }
        $stmt->close();
    } else {
        $mensaje_insercion = "<p style='color: #ff4444; margin-bottom: 20px;'>⚠️ Error: Tu usuario (Audit) no tiene permisos de escritura en el SGBD.</p>";
    }
}

// 3. Consultar los productos disponibles
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
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Poppins', sans-serif; }
        body { background: #141414; color: #fff; display: flex; min-height: 100vh; }

        /* Sidebar Menú */
        .sidebar { width: 260px; background: #1e1e1e; border-right: 1px solid #2d2d2d; display: flex; flex-direction: column; justify-content: space-between; padding: 30px 20px; position: fixed; height: 100vh; }
        .sidebar .brand { font-size: 24px; font-weight: 700; letter-spacing: 2px; margin-bottom: 40px; padding-left: 10px; }
        .sidebar .brand span { color: #ff6b00; }
        .sidebar-menu { list-style: none; flex-grow: 1; }
        .sidebar-menu li { margin-bottom: 8px; }
        .sidebar-menu a { display: block; padding: 12px 15px; color: #aaa; text-decoration: none; border-radius: 8px; font-weight: 500; transition: all 0.3s ease; }
        .sidebar-menu a:hover, .sidebar-menu a.active { background: #ff6b00; color: #fff; }
        .btn-logout { padding: 12px 15px; background: #2a2a2a; color: #ff4444; text-align: center; text-decoration: none; border-radius: 8px; font-weight: 600; border: 1px solid #3a3a3a; }

        /* Contenido Principal */
        .main-content { margin-left: 260px; flex-grow: 1; padding: 40px; }
        .header-panel { display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #2d2d2d; padding-bottom: 20px; margin-bottom: 30px; }
        
        /* Contenedores de Tablas y Formularios */
        .grid-panel { display: grid; grid-template-columns: <?php echo $tiene_permiso_escritura ? '2fr 1fr' : '1fr'; ?>; gap: 30px; }
        .table-container, .form-container { background: #1e1e1e; padding: 30px; border-radius: 12px; box-shadow: 0 4px 20px rgba(0,0,0,0.2); }
        h3 { font-size: 18px; margin-bottom: 20px; font-weight: 600; color: #ff6b00; text-transform: uppercase; letter-spacing: 0.5px; }
        
        /* Estilos del Formulario */
        .form-group { margin-bottom: 15px; }
        .form-group label { display: block; font-size: 13px; color: #888; margin-bottom: 5px; }
        .form-group input { width: 100%; padding: 10px; background: #2a2a2a; border: 1px solid #3a3a3a; border-radius: 6px; color: #fff; font-size: 14px; }
        .form-group input:focus { border-color: #ff6b00; outline: none; }
        .btn-submit { width: 100%; padding: 12px; background: #ff6b00; color: #fff; border: none; border-radius: 6px; font-weight: 600; cursor: pointer; transition: background 0.3s; }
        .btn-submit:hover { background: #e05e00; }

        /* Tabla */
        table { width: 100%; border-collapse: collapse; text-align: left; }
        th { padding: 15px; color: #888; font-size: 13px; text-transform: uppercase; border-bottom: 1px solid #2d2d2d; }
        td { padding: 15px; border-bottom: 1px solid #2d2d2d; color: #ddd; font-size: 14px; }
        tr:hover td { background: #252525; color: #fff; }
        
        .badge { padding: 5px 10px; border-radius: 4px; font-size: 12px; font-weight: 600; }
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
                <p>Infraestructura LEMP - Control de Roles Basado en Privilegios MySQL.</p>
            </div>
            <div>
                <p>Usuario Activo: <strong style="color: #ff6b00;"><?php echo htmlspecialchars($db_user); ?></strong></p>
                <p style="color: #666; font-size: 12px; text-align: right;">Rol: <?php echo $tiene_permiso_escritura ? 'Administrador / CRUD' : 'Auditor / Sólo Lectura'; ?></p>
            </div>
        </div>

        <?php echo $mensaje_insercion; ?>

        <!-- GRID DINÁMICO: Si es auditor ocupa todo el ancho, si es dev abre espacio al formulario -->
        <div class="grid-panel">
            
            <!-- SECCIÓN 1: TABLA DE PRODUCTOS (Visible para ambos usuarios) -->
            <div class="table-container">
                <h3>Catálogo de Herramientas</h3>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Código</th>
                            <th>Descripción</th>
                            <th>Categoría</th>
                            <th>Precio</th>
                            <th>Stock</th>
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
                        ?>
                    </tbody>
                </table>
            </div>

            <!-- SECCIÓN 2: FORMULARIO DE INSERCIÓN (Condicionado por código PHP) -->
            <?php if ($tiene_permiso_escritura): ?>
            <div class="form-container">
                <h3>Agregar Nuevo Artículo</h3>
                <form action="panel.php" method="POST">
                    <div class="form-group">
                        <label>Código Truper</label>
                        <input type="text" name="codigo" placeholder="Ej: TRU-1024" required>
                    </div>
                    <div class="form-group">
                        <label>Nombre del Producto</label>
                        <input type="text" name="nombre" placeholder="Ej: Pinzas de Presión 10'" required>
                    </div>
                    <div class="form-group">
                        <label>Categoría</label>
                        <input type="text" name="categoria" placeholder="Ej: Manuales" required>
                    </div>
                    <div class="form-group">
                        <label>Precio Público</label>
                        <input type="number" step="0.01" name="precio" placeholder="0.00" required>
                    </div>
                    <div class="form-group">
                        <label>Stock Inicial</label>
                        <input type="number" name="stock" placeholder="0" required>
                    </div>
                    <button type="submit" name="agregar_producto" class="btn-submit">Registrar en Almacén</button>
                </form>
            </div>
            <?php endif; ?>

        </div>
    </div>

</body>
</html>
