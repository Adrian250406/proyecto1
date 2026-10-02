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

    @livewireStyles
</head>

<body>

    <nav>
        <a href="/" wire:navigate>🏠 Inicio</a>
        <a href="/menu" wire:navigate>🍔 Menú</a>
        <a href="/contacto" wire:navigate>📞 Contacto</a>
        <a href="/reservas" wire:navigate>📅 Reservas</a>
        @auth
            <a href="/admin/reservas" wire:navigate>⚙️ Panel Admin</a>
            <form action="{{ route('logout') }}" method="POST" style="display: inline; margin-left: 0.5rem;">
                @csrf
                <button type="submit"
                    style="background: none; border: none; color: #f43f5e; cursor: pointer; font-weight: 600; font-size: 0.95rem;">
                    🚪 Salir
                </button>
            </form>
        @endauth

        @guest
            <a href="/login" wire:navigate style="color: #64748b; font-size: 0.85rem; margin-left: 1rem;">
                🔑 Acceso Admin
            </a>
        @endguest

    </nav>

    <main class="card">
        @yield('contenido')
    </main>

    <footer>
        © 2026 Restaurante de Adrián Jara
    </footer>

    @livewireScripts
</body>

</html>