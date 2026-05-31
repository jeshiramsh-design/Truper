<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Truper - Bienvenidos</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }
        body {
            background: #1a1a1a;
            color: #fff;
            line-height: 1.6;
        }
        /* Barra de Navegación Superior */
        header {
            background: #262626;
            padding: 20px 10%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 3px solid #ff6b00; /* Naranja Truper */
            position: sticky;
            top: 0;
            z-index: 100;
        }
        header .logo h1 {
            font-weight: 700;
            letter-spacing: 2px;
            color: #fff;
            font-size: 24px;
        }
        header .logo span {
            color: #ff6b00;
        }
        .btn-nav-login {
            padding: 10px 20px;
            background: transparent;
            border: 2px solid #ff6b00;
            color: #ff6b00;
            border-radius: 6px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        .btn-nav-login:hover {
            background: #ff6b00;
            color: #fff;
            box-shadow: 0 4px 15px rgba(255, 107, 0, 0.4);
        }

        /* Sección Hero (Bienvenida Principal) */
        .hero {
            background: linear-gradient(rgba(26,26,26,0.8), rgba(26,26,26,0.95)), url('https://images.unsplash.com/photo-1581092160607-ee22621dd758?q=80&w=1200') no-repeat center center/cover;
            height: 60vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            padding: 0 20px;
        }
        .hero h2 {
            font-size: 42px;
            font-weight: 700;
            margin-bottom: 15px;
            letter-spacing: 1px;
        }
        .hero p {
            font-size: 18px;
            color: #ccc;
            max-width: 600px;
            margin-bottom: 30px;
        }

        /* Sección Misión y Visión (Tarjetas Elegantes) */
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 60px 20px;
        }
        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
        }
        .card {
            background: #262626;
            padding: 40px 30px;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.3);
            border-left: 5px solid #ff6b00;
            transition: transform 0.3s ease;
        }
        .card:hover {
            transform: translateY(-5px);
        }
        .card h3 {
            font-size: 22px;
            color: #ff6b00;
            margin-bottom: 15px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .card p {
            color: #ddd;
            font-size: 15px;
            text-align: justify;
        }

        /* Sección de Llamado a la Acción Inferior */
        .cta-section {
            background: #212121;
            text-align: center;
            padding: 50px 20px;
            border-top: 1px solid #333;
        }
        .cta-section h4 {
            font-size: 20px;
            margin-bottom: 20px;
            font-weight: 400;
        }
        .btn-cta {
            display: inline-block;
            padding: 14px 35px;
            background: #ff6b00;
            color: #fff;
            border-radius: 6px;
            text-decoration: none;
            font-weight: 600;
            font-size: 16px;
            transition: background 0.3s ease;
            box-shadow: 0 4px 15px rgba(255, 107, 0, 0.3);
        }
        .btn-cta:hover {
            background: #e05e00;
        }

        /* Footer */
        footer {
            background: #151515;
            text-align: center;
            padding: 20px;
            color: #666;
            font-size: 13px;
            border-top: 1px solid #222;
        }
    </style>
</head>
<body>

    <header>
        <div class="logo">
            <h1>TRUPER<span>.</span></h1>
        </div>
        <a href="login.php" class="btn-nav-login">Portal Empleados</a>
    </header>

    <section class="hero">
        <h2>Herramientas con Fuerza Corporativa</h2>
        <p>Líderes en la fabricación y comercialización de herramientas para todas las industrias de América Latina.</p>
    </section>

    <main class="container">
        <div class="grid">
            <div class="card">
                <h3>Misión</h3>
                <p>Mantener una secuencia de crecimiento acelerado orientada a consolidar a Truper como el proveedor más eficiente y competitivo de herramientas y productos para ferretería en el mundo, garantizando la máxima calidad en cada solución.</p>
            </div>

            <div class="card">
                <h3>Visión</h3>
                <p>Establecer redes de distribución global y optimización de operaciones tecnológicas que permitan acercar nuestras herramientas a cada rincón del desarrollo industrial, manteniendo la rentabilidad y el liderazgo absoluto del mercado.</p>
            </div>

            <div class="card">
                <h3>Valores</h3>
                <p>Nos rige la congruencia, la honestidad, el trabajo en equipo y el compromiso absoluto con la innovación. Desarrollamos sistemas robustos y estables para garantizar la confianza de nuestros colaboradores y clientes.</p>
            </div>
        </div>
    </main>

    <section class="cta-section">
        <h4>¿Eress miembro del equipo administrativo u operativo?</h4>
        <a href="login.php" class="btn-cta">Ingresar al Panel de Control</a>
    </section>

    <footer>
        Taller de Sistemas Operativos • Instituto Tecnológico de Oaxaca • Equipo 8 © 2026
    </footer>

</body>
</html>
