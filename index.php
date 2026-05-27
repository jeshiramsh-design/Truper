k<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Truper - Control de Operaciones</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }
        body {
            background: #1a1a1a;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            color: #fff;
        }
        .login-container {
            background: #262626;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.5);
            width: 100%;
            max-width: 400px;
            border-top: 5px solid #ff6b00; /* Naranja Truper */
            text-align: center;
        }
        .login-container h2 {
            margin-bottom: 10px;
            font-weight: 600;
            letter-spacing: 1px;
        }
        .login-container p {
            color: #aaa;
            font-size: 14px;
            margin-bottom: 30px;
        }
        .input-group {
            margin-bottom: 20px;
            text-align: left;
        }
        .input-group label {
            display: block;
            margin-bottom: 8px;
            color: #ddd;
            font-size: 14px;
        }
        .input-group input {
            width: 100%;
            padding: 12px;
            border-radius: 6px;
            border: 1px solid #444;
            background: #333;
            color: #fff;
            font-size: 16px;
            transition: all 0.3s ease;
        }
        .input-group input:focus {
            border-color: #ff6b00;
            outline: none;
            background: #3a3a3a;
        }
        .btn-login {
            width: 100%;
            padding: 12px;
            background: #ff6b00;
            border: none;
            border-radius: 6px;
            color: white;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.3s ease;
            box-shadow: 0 4px 12px rgba(255, 107, 0, 0.3);
        }
        .btn-login:hover {
            background: #e05e00;
        }
        .footer-text {
            margin-top: 25px;
            font-size: 11px;
            color: #666;
        }
    </style>
</head>
<body>

    <div class="login-container">
        <h2>TRUPER</h2>
        <p>Iniciar Sesión | Panel de Operaciones</p>
        
        <form action="login_process.php" method="POST">
            <div class="input-group">
                <label for="username">Usuario Institucional</label>
                <input type="text" id="username" name="username" placeholder="ej. jeshi" required>
            </div>
            
            <div class="input-group">
                <label for="password">Contraseña</label>
                <input type="password" id="password" name="password" placeholder="••••••••" required>
            </div>
            
            <button type="submit" class="btn-login">Ingresar al Sistema</button>
        </form>

        <div class="footer-text">
            Sistemas Operativos • Equipo 8
        </div>
    </div>

</body>
</html>
