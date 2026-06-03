<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['db_user'])) {
    header("Location: login.php");
    exit();
}

$db_user = $_SESSION['db_user'];
$db_pass = ($db_user === 'dev_user') ? 'TruperDev2026!' : 'TruperAudit2026!';
$tiene_permiso_escritura = ($db_user === 'dev_user');

$host = "localhost";
$database = "truper_equipo_ocho"; 

$conn = new mysqli($host, $db_user, $db_pass, $database);

if ($conn->connect_error) {
    die("Error de infraestructura: " . $conn->connect_error);
}

$mensaje_alerta = "";

// --- ACCIÓN: ACCIONES DE ESCRITURA (SOLO DEV_USER) ---
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $tiene_permiso_escritura) {
    
    // 1. INSERTAR PRODUCTO
    if (isset($_POST['agregar_producto'])) {
        $codigo = trim($_POST['codigo']);
        $nombre = trim($_POST['nombre']);
        $categoria = trim($_POST['categoria']);
        $precio = floatval($_POST['precio']);
        $stock = intval($_POST['stock']);

        $stmt = $conn->prepare("INSERT INTO productos (codigo, nombre, categoria, precio, stock) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssi", $codigo, $nombre, $categoria, $precio, $stock);
        if ($stmt->execute()) {
            $mensaje_alerta = "<p style='color: #00ff7f; margin-bottom: 20px;'>✓ Producto registrado exitosamente.</p>";
        } else {
            $mensaje_alerta = "<p style='color: #ff4444; margin-bottom: 20px;'>Error al registrar: " . $stmt->error . "</p>";
        }
        $stmt->close();
    }

    // 2. ACTUALIZAR/EDITAR PRODUCTO
    if (isset($_POST['editar_producto'])) {
        $id = intval($_POST['id']);
        $codigo = trim($_POST['codigo']);
        $nombre = trim($_POST['nombre']);
        $categoria = trim($_POST['categoria']);
        $precio = floatval($_POST['precio']);
        $stock = intval($_POST['stock']);

        $stmt = $conn->prepare("UPDATE productos SET codigo=?, nombre=?, categoria=?, precio=?, stock=? WHERE id=?");
        $stmt->bind_param("ssssii", $codigo, $nombre, $categoria, $precio, $stock, $id);
        if ($stmt->execute()) {
            $mensaje_alerta = "<p style='color: #00ff7f; margin-bottom: 20px;'>✓ Producto actualizado correctamente.</p>";
        } else {
            $mensaje_alerta = "<p style='color: #ff4444; margin-bottom: 20px;'>Error al actualizar: " . $stmt->error . "</p>";
        }
        $stmt->close();
    }

    // 3. ELIMINAR PRODUCTO
    if (isset($_POST['eliminar_producto'])) {
        $id = intval($_POST['id_eliminar']);

        $stmt = $conn->prepare("DELETE FROM productos WHERE id = ?");
        $stmt->bind_param("i", $id);
        if ($stmt->execute()) {
            $mensaje_alerta = "<p style='color: #ff4444; margin-bottom: 20px;'>✓ Producto eliminado del inventario.</p>";
        } else {
            $mensaje_alerta = "<p style='color: #ff4444; margin-bottom: 20px;'>Error al eliminar: " . $stmt->error . "</p>";
        }
        $stmt->close();
    }
}

// Obtener el total de artículos registrados en tiempo real
$total_articulos = 0;
$res_count = $conn->query("SELECT COUNT(*) AS total FROM productos");
if ($res_count) {
    $row_count = $res_count->fetch_assoc();
    $total_articulos = $row_count['total'];
}

// Obtener catálogo actualizado
$query = "SELECT id, codigo, nombre, categoria, precio, stock FROM productos"; 
$result = $conn->query($query);
$conn->close(); 
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
        body { background: #141414; color: #fff; display: flex; flex-direction: column; min-height: 100vh; padding: 40px; }
        
        .header-panel { display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #2d2d2d; padding-bottom: 20px; margin-bottom: 30px; }
        .header-panel h2 { font-size: 28px; font-weight: 600; }
        .btn-logout { padding: 10px 20px; background: #2a2a2a; color: #ff4444; text-align: center; text-decoration: none; border-radius: 8px; font-weight: 600; border: 1px solid #3a3a3a; transition: 0.3s; }
        .btn-logout:hover { background: #331c1c; }

        /* Tarjeta de Contador Global */
        .counter-card { background: #1e1e1e; border: 1px solid #ff6b00; padding: 15px 25px; border-radius: 10px; display: inline-flex; align-items: center; gap: 15px; margin-bottom: 25px; width: fit-content; }
        .counter-card .num { font-size: 32px; font-weight: 700; color: #ff6b00; line-height: 1; }
        .counter-card .label { font-size: 13px; color: #aaa; text-transform: uppercase; letter-spacing: 0.5px; }

        .grid-panel { display: grid; grid-template-columns: <?php echo $tiene_permiso_escritura ? '1.8fr 1.2fr' : '1fr'; ?>; gap: 30px; }
        .table-container, .form-container { background: #1e1e1e; padding: 30px; border-radius: 12px; border: 1px solid #2d2d2d; box-shadow: 0 4px 20px rgba(0,0,0,0.2); }
        h3 { font-size: 18px; margin-bottom: 20px; font-weight: 600; color: #ff6b00; text-transform: uppercase; letter-spacing: 0.5px; }
        
        /* Formulario */
        .form-group { margin-bottom: 15px; text-align: left; }
        .form-group label { display: block; font-size: 13px; color: #888; margin-bottom: 5px; }
        .form-group input { width: 100%; padding: 11px; background: #2a2a2a; border: 1px solid #3a3a3a; border-radius: 6px; color: #fff; font-size: 14px; }
        .form-group input:focus { border-color: #ff6b00; outline: none; }
        .btn-submit { width: 100%; padding: 12px; background: #ff6b00; color: #fff; border: none; border-radius: 6px; font-weight: 600; cursor: pointer; transition: background 0.3s; margin-bottom: 10px;}
        .btn-submit:hover { background: #e05e00; }
        .btn-cancel { width: 100%; padding: 10px; background: #333; color: #ccc; border: none; border-radius: 6px; font-weight: 500; cursor: pointer; display: none; }

        /* Tabla */
        table { width: 100%; border-collapse: collapse; text-align: left; }
        th { padding: 15px; color: #888; font-size: 13px; text-transform: uppercase; border-bottom: 1px solid #2d2d2d; }
        td { padding: 15px; border-bottom: 1px solid #2d2d2d; color: #ddd; font-size: 14px; }
        tr:hover td { background: #252525; color: #fff; }
        
        .badge { padding: 5px 10px; border-radius: 4px; font-size: 12px; font-weight: 600; }
        .badge.success { background: rgba(0, 255, 127, 0.15); color: #00ff7f; }
        .badge.warning { background: rgba(255, 165, 0, 0.15); color: #ffa500; }

        /* Botones de acción en tabla */
        .actions-cell { display: flex; gap: 8px; }
        .btn-action { padding: 6px 12px; border: none; border-radius: 4px; font-size: 12px; font-weight: 600; cursor: pointer; transition: 0.2s; text-decoration: none; }
        .btn-edit { background: rgba(255, 165, 0, 0.2); color: #ffa500; }
        .btn-edit:hover { background: #ffa500; color: #000; }
        .btn-delete { background: rgba(255, 68, 68, 0.2); color: #ff4444; }
        .btn-delete:hover { background: #ff4444; color: #fff; }
        .inline-form { margin: 0; padding: 0; display: inline; }
    </style>
</head>
<body>

    <!-- CONTROL HEADER -->
    <div class="header-panel">
        <div>
            <h2>Panel de Control de Almacén (CRUD)</h2>
            <p>Mapeo directo de infraestructura | Privilegios actuales: <strong style="color: #ff6b00;"><?php echo htmlspecialchars($db_user); ?></strong></p>
        </div>
        <a href="logout.php" class="btn-logout">Cerrar Sesión</a>
    </div>

    <!-- CONTADOR GLOBAL DE ARTÍCULOS -->
    <div class="counter-card">
        <div class="num"><?php echo $total_articulos; ?></div>
        <div class="label">Artículos Totales<br>en Almacén</div>
    </div>

    <?php echo $mensaje_alerta; ?>

    <div class="grid-panel">
        <!-- VISTA DEL INVENTARIO -->
        <div class="table-container">
            <h3>Catálogo de Herramientas Registradas</h3>
            <table>
                <thead>
                    <tr>
                        <th style="width: 60px;">#</th>
                        <th>Código</th>
                        <th>Descripción</th>
                        <th>Categoría</th>
                        <th>Precio</th>
                        <th>Stock</th>
                        <?php if ($tiene_permiso_escritura): ?><th>Acciones</th><?php endif; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result && $result->num_rows > 0) {
                        $consecutivo = 1; // Variable para contar visualmente 1, 2, 3...
                        while($row = $result->fetch_assoc()) {
                            $badgeClass = ($row['stock'] > 10) ? 'success' : 'warning';
                            echo "<tr>";
                            echo "<td style='color: #666;'># " . $consecutivo . "</td>"; // Consecutivo visual
                            echo "<td><strong>" . htmlspecialchars($row['codigo']) . "</strong></td>";
                            echo "<td>" . htmlspecialchars($row['nombre']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['categoria']) . "</td>";
                            echo "<td>$" . number_format($row['precio'], 2) . " MXN</td>";
                            echo "<td><span class='badge " . $badgeClass . "'>" . htmlspecialchars($row['stock']) . " uds</span></td>";
                            
                            if ($tiene_permiso_escritura) {
                                echo "<td class='actions-cell'>";
                                echo "<button class='btn-action btn-edit' onclick='cargarDatosEditar(".json_encode($row).")'>Editar</button>";
                                
                                echo "<form method='POST' action='panel.php' class='inline-form' onsubmit='return confirm(\"¿Estás seguro de eliminar este artículo?\");'>";
                                echo "<input type='hidden' name='id_eliminar' value='".$row['id']."'>"; // Mantiene el ID oculto para MySQL
                                echo "<button type='submit' name='eliminar_producto' class='btn-action btn-delete'>Eliminar</button>";
                                echo "</form>";
                                echo "</td>";
                            }
                            echo "</tr>";
                            $consecutivo++;
                        }
                    } else {
                        echo "<tr><td colspan='7' style='text-align:center; color:#888;'>No hay registros en la base de datos.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <!-- FORMULARIO DINÁMICO (CREAR / EDITAR) -->
        <?php if ($tiene_permiso_escritura): ?>
        <div class="form-container">
            <h3 id="form-title">Agregar Nuevo Artículo</h3>
            <form id="producto-form" action="panel.php" method="POST">
                <input type="hidden" id="prod-id" name="id" value="">

                <div class="form-group">
                    <label>Código Truper</label>
                    <input type="text" id="prod-codigo" name="codigo" placeholder="Ej: TRU-4501" required>
                </div>
                <div class="form-group">
                    <label>Nombre del Producto</label>
                    <input type="text" id="prod-nombre" name="nombre" placeholder="Ej: Martillo Galame" required>
                </div>
                <div class="form-group">
                    <label>Categoría</label>
                    <input type="text" id="prod-categoria" name="categoria" placeholder="Ej: Manuales" required>
                </div>
                <div class="form-group">
                    <label>Precio Público</label>
                    <input type="number" step="0.01" id="prod-precio" name="precio" placeholder="0.00" required>
                </div>
                <div class="form-group">
                    <label>Stock Inicial</label>
                    <input type="number" id="prod-stock" name="stock" placeholder="0" required>
                </div>
                
                <button type="submit" id="btn-submit-action" name="agregar_producto" class="btn-submit">Registrar en Catálogo</button>
                <button type="button" id="btn-cancel-action" class="btn-cancel" onclick="resetearFormulario()">Cancelar Edición</button>
            </form>
        </div>
        <?php endif; ?>
    </div>

    <script>
    function cargarDatosEditar(producto) {
        document.getElementById('form-title').innerText = "Modificar Artículo";
        document.getElementById('btn-submit-action').innerText = "Guardar Cambios";
        document.getElementById('btn-submit-action').name = "editar_producto";
        document.getElementById('btn-cancel-action').style.display = "block";

        document.getElementById('prod-id').value = producto.id;
        document.getElementById('prod-codigo').value = producto.codigo;
        document.getElementById('prod-nombre').value = producto.nombre;
        document.getElementById('prod-categoria').value = producto.categoria;
        document.getElementById('prod-precio').value = producto.precio;
        document.getElementById('prod-stock').value = producto.stock;
        
        document.getElementById('producto-form').scrollIntoView({ behavior: 'smooth' });
    }

    function resetearFormulario() {
        document.getElementById('form-title').innerText = "Agregar Nuevo Artículo";
        document.getElementById('btn-submit-action').innerText = "Registrar en Catálogo";
        document.getElementById('btn-submit-action').name = "agregar_producto";
        document.getElementById('btn-cancel-action').style.display = "none";
        
        document.getElementById('producto-form').reset();
        document.getElementById('prod-id').value = "";
    }
    </script>
</body>
</html>
