<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- 1. Título dinámico: cambia según la página -->
    <title>Restaurante - @yield('titulo')</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=outfit:400,600,700" rel="stylesheet" />

    <!-- 2. Los estilos CSS globales (se aplican a todo el sistema) -->
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Outfit', sans-serif;
        }

        body {
            background: radial-gradient(circle at top right, #1e1b4b, #0f172a, #020617);
            color: #f8fafc;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 2rem;
        }

        nav {
            background: rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(12px);
            padding: 0.8rem 2rem;
            border-radius: 9999px;
            margin-bottom: 2.5rem;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        nav a {
            color: #94a3b8;
            text-decoration: none;
            margin: 0 1rem;
            font-weight: 600;
        }

        nav a:hover {
            color: #f43f5e;
        }

        .card {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 1.5rem;
            padding: 2.5rem;
            max-width: 650px;
            width: 100%;
            text-align: center;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
        }

        footer {
            margin-top: auto;
            color: #64748b;
            font-size: 0.9rem;
            padding-top: 2rem;
        }
    </style>
</head>

<body>

    <!-- 3. Barra de navegación común -->
    <nav>
        <a href="/">🏠 Inicio</a>
        <a href="/menu">🍔 Menú</a>
        <a href="/contacto">📞 Contacto</a>
    </nav>

    <!-- 4. 📍 EL HUECO MÁGICO donde se inserta cada página -->
    <main class="card">
        @yield('contenido')
    </main>

    <!-- 5. Pie de página común -->
    <footer>
        © 2026 Restaurante de Adrián
    </footer>

</body>

</html>