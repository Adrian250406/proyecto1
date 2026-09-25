<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restaurante - @yield('titulo')</title>


    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: system-ui, -apple-system, sans-serif;
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

    <nav>
        <a href="/">🏠 Inicio</a>
        <a href="/menu">🍔 Menú</a>
        <a href="/contacto">📞 Contacto</a>
        <a href="/reservas">📅 Reservas</a>
    </nav>

    <main class="card">
        @yield('contenido')
    </main>

    <footer>
        © 2026 Restaurante de Adrián
    </footer>

</body>

</html>