<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Truper - Acceso al Sistema</title>
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
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            overflow: hidden;
        }
        /* Fondo decorativo sutil */
        body::before {
            content: '';
            position: absolute;
            width: 300px;
            height: 300px;
            background: rgba(255, 107, 0, 0.15);
            border-radius: 50%;
            top: -50px;
            right: -50px;
            blur: 80px;
            filter: blur(80px);
        }

        .login-card {
            background: #1e1e1e;
            width: 100%;
            max-width: 420px;
            padding: 40px;
            border-radius: 16px;
            border: 1px solid #2d2d2d;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
            text-align: center;
            z-index: 1;
        }

        .brand {
            font-size: 32px;
            font-weight: 700;
            letter-spacing: 3px;
            margin-bottom: 5px;
        }
        .brand span { color: #ff6b00; }
        
        .subtitle {
            color: #777;
            font-size: 14px;
            margin-bottom: 30px;
        }

        /* Selector de Rol Bonito */
        .role-selector {
            display: flex;
            background: #2a2a2a;
            padding: 5px;
            border-radius: 8px;
            margin-bottom: 25px;
            border: 1px solid #3a3a3a;
        }
        .role-btn {
            flex: 1;
            padding: 10px;
            background: transparent;
            color: #aaa;
            border: none;
            border-radius: 6px;
            font-weight: 600;
            font-size: 13px;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        .role-btn.active {
            background: #ff6b00;
            color: #fff;
            box-shadow: 0 4px 10px rgba(255, 107, 0, 0.3);
        }

        /* Inputs Estilizados */
        .form-group {
            text-align: left;
            margin-bottom: 20px;
        }
        .form-group label {
            display: block;
            font-size: 12px;
            color: #888;
            margin-bottom: 6px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .input-wrapper {
            position: relative;
        }
        .form-group input {
            width: 100%;
            padding: 12px 16px;
            background: #252525;
            border: 1px solid #333;
            border-radius: 8px;
            color: #fff;
            font-size: 14px;
            transition: all 0.3s ease;
        }
        .form-group input:focus {
            border-color: #ff6b00;
            background: #2a2a2a;
            outline: none;
            box-shadow: 0 0 8px rgba(255, 107, 0, 0.1);
        }

        .btn-login {
            width: 100%;
            padding: 14px;
            background: #ff6b00;
            color: #fff;
            border: none;
            border-radius: 8px;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            margin-top: 10px;
            transition: all 0.3s ease;
        }
        .btn-login:hover {
            background: #e05e00;
            transform: translateY(-1px);
            box-shadow: 0 6px 15px rgba(255, 107, 0, 0.2);
        }

        /* Mensajes de Error */
        .error-msg {
            background: rgba(255, 68, 68, 0.1);
            color: #ff4444;
            padding: 10px;
            border-radius: 6px;
            font-size: 13px;
            margin-bottom: 20px;
            border: 1px solid rgba(255, 68, 68, 0.2);
        }
    </style>
</head>
<body>

    <div class="login-card">
        <div class="brand">TRUPER<span>.</span></div>
        <div class="subtitle">Control de Infraestructura y Datos</div>

        <?php if (isset($_GET['error'])): ?>
            <div class="error-msg">❌ Credenciales de acceso incorrectas</div>
        <?php endif; ?>

        <form action="login_process.php" method="POST">
            
            <input type="hidden" name="rol" id="rol_input" value="dev">

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Truper - Acceso al Sistema</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Poppins', sans-serif; }
        body { background: #141414; color: #fff; display: flex; justify-content: center; align-items: center; min-height: 100vh; position: relative; }
        
        /* Brillo de fondo sutil */
        body::before { content: ''; position: absolute; width: 300px; height: 300px; background: rgba(255, 107, 0, 0.12); border-radius: 50%; top: -50px; right: -50px; filter: blur(80px); z-index: 0; }

        .login-card { background: #1e1e1e; width: 100%; max-width: 400px; padding: 40px; border-radius: 16px; border: 1px solid #2d2d2d; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5); text-align: center; z-index: 1; }
        .brand { font-size: 32px; font-weight: 700; letter-spacing: 3px; margin-bottom: 5px; }
        .brand span { color: #ff6b00; }
        .subtitle { color: #777; font-size: 14px; margin-bottom: 35px; }

        .form-group { text-align: left; margin-bottom: 22px; }
        .form-group label { display: block; font-size: 12px; color: #888; margin-bottom: 6px; text-transform: uppercase; letter-spacing: 0.5px; }
        .form-group input { width: 100%; padding: 12px 16px; background: #252525; border: 1px solid #333; border-radius: 8px; color: #fff; font-size: 14px; transition: all 0.3s ease; }
        .form-group input:focus { border-color: #ff6b00; background: #2a2a2a; outline: none; }

        .btn-login { width: 100%; padding: 14px; background: #ff6b00; color: #fff; border: none; border-radius: 8px; font-size: 15px; font-weight: 600; cursor: pointer; margin-top: 10px; transition: all 0.3s ease; }
        .btn-login:hover { background: #e05e00; box-shadow: 0 6px 15px rgba(255, 107, 0, 0.2); }

        .error-msg { background: rgba(255, 68, 68, 0.1); color: #ff4444; padding: 10px; border-radius: 6px; font-size: 13px; margin-bottom: 25px; border: 1px solid rgba(255, 68, 68, 0.2); }
    </style>
</head>
<body>

    <div class="login-card">
        <div class="brand">TRUPER<span>.</span></div>
        <div class="subtitle">Autenticación de Infraestructura</div>

        <?php if (isset($_GET['error'])): ?>
            <div class="error-msg">❌ Usuario o contraseña incorrectos</div>
        <?php endif; ?>

        <form action="login_process.php" method="POST">
            <div class="form-group">
                <label>Usuario del Sistema</label>
                <input type="text" name="username" placeholder="Ej: dev_user" required>
            </div>

            <div class="form-group">
                <label>Contraseña</label>
                <input type="password" name="password" placeholder="••••••••" required>
            </div>

            <button type="submit" class="btn-login">Iniciar Sesión</button>
        </form>
    </div>

</body>
</html>
