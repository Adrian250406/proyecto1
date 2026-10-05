<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>El Buen Sabor - @yield('titulo')</title>

    <!-- 🌟 Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">
    <!-- 📱 Metadatos PWA (Icono, Colores y Manifiesto) -->
    <link rel="manifest" href="/manifest.json">
    <meta name="theme-color" content="#0b0f19">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">


    <style>
        :root {
            --bg-main: #0b0f19;
            --bg-card: rgba(255, 255, 255, 0.04);
            --border-glass: rgba(255, 255, 255, 0.08);
            --color-gold: #f59e0b;
            --color-crimson: #f43f5e;
            --text-primary: #f8fafc;
            --text-muted: #94a3b8;
            --shadow-card: 0 25px 50px -12px rgba(0, 0, 0, 0.6);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Plus Jakarta Sans', system-ui, -apple-system, sans-serif;
        }

        body {
            background: radial-gradient(circle at top right, #1e1b4b, var(--bg-main), #020617);
            color: var(--text-primary);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding-bottom: 2.5rem;
        }

        /* 📢 1. CINTILLO SUPERIOR ELEGANTE (Arriba del todo) */
        .top-banner {
            width: 100%;
            padding: 0.6rem 1rem;
            text-align: center;
            font-size: 0.85rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            margin-bottom: 1.8rem;
        }

        .banner-abierto {
            background: rgba(16, 185, 129, 0.12);
            color: #6ee7b7;
            border-bottom: 1px solid rgba(16, 185, 129, 0.3);
        }

        .banner-cerrado {
            background: rgba(239, 68, 68, 0.12);
            color: #fca5a5;
            border-bottom: 1px solid rgba(239, 68, 68, 0.3);
        }

        /* 💡 Luz de Radar Pulsante */
        @keyframes radar {
            0% {
                box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.8);
            }

            70% {
                box-shadow: 0 0 0 8px rgba(16, 185, 129, 0);
            }

            100% {
                box-shadow: 0 0 0 0 rgba(16, 185, 129, 0);
            }
        }

        .led-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            display: inline-block;
        }

        .led-verde {
            background: #10b981;
            animation: radar 1.5s infinite;
        }

        .led-rojo {
            background: #ef4444;
        }

        /* 🧭 2. BARRA DE NAVEGACIÓN FLOTANTE */
        nav {
            background: var(--bg-card);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            padding: 0.65rem 1.8rem;
            border-radius: 9999px;
            margin-bottom: 2.5rem;
            border: 1px solid var(--border-glass);
            display: flex;
            align-items: center;
            gap: 0.3rem;
            box-shadow: var(--shadow-card);
        }

        nav a {
            color: var(--text-muted);
            text-decoration: none;
            padding: 0.5rem 1rem;
            border-radius: 9999px;
            font-weight: 600;
            font-size: 0.92rem;
            transition: all 0.2s ease;
        }

        nav a:hover {
            color: #ffffff;
            background: rgba(255, 255, 255, 0.08);
        }

        /* 🎴 3. TARJETA CONTENEDORA PRINCIPAL */
        .card {
            background: var(--bg-card);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid var(--border-glass);
            border-radius: 1.5rem;
            padding: 2.5rem;
            max-width: 850px;
            width: 90%;
            text-align: center;
            box-shadow: var(--shadow-card);
        }

        footer {
            margin-top: auto;
            color: var(--text-muted);
            font-size: 0.85rem;
            padding-top: 2.5rem;
            letter-spacing: 0.02em;
        }
    </style>

    @livewireStyles
</head>

<body>

    @php
        $horaLima = now('America/Lima')->hour;
        $abierto = ($horaLima >= 12 && $horaLima < 23);
    @endphp

    {{-- 📢 1. CINTILLO SUPERIOR (Separado y arriba de todo) --}}
    @if($abierto)
        <div class="top-banner banner-abierto">
            <span class="led-dot led-verde"></span>
            <span>🔥 <strong>¡Cocina Abierta!</strong> Tomando pedidos y reservas para hoy.</span>
        </div>
    @else
        <div class="top-banner banner-cerrado">
            <span class="led-dot led-rojo"></span>
            <span>🌙 <strong>Cocina en Reposo:</strong> Atendemos de 12:00 PM a 11:00 PM. ¡Puedes agendar tu reserva!</span>
        </div>
    @endif

    {{-- 🧭 2. BARRA DE NAVEGACIÓN FLOTANTE (Centrada y limpia) --}}
    <nav>
        <a href="/" wire:navigate>🏠 Inicio</a>
        <a href="/menu" wire:navigate>🍔 Menú</a>
        <a href="/contacto" wire:navigate>📞 Contacto</a>
        <a href="/reservas" wire:navigate>📅 Reservas</a>

        @auth
            <a href="/admin/dashboard" wire:navigate>📊 Dashboard</a>
            <a href="/admin/reservas" wire:navigate>⚙️ Salón</a>
            <a href="/admin/productos" wire:navigate>🍔 Platos</a>
            <form action="{{ route('logout') }}" method="POST" style="display: inline; margin-left: 0.5rem;">
                @csrf
                <button type="submit"
                    style="background: none; border: none; color: #f43f5e; cursor: pointer; font-weight: 600; font-size: 0.92rem;">
                    🚪 Salir
                </button>
            </form>
        @endauth


        @guest
            <a href="/login" wire:navigate style="color: #64748b; font-size: 0.85rem; margin-left: 0.5rem;">
                🔑 Acceso Admin
            </a>
        @endguest
    </nav>

    {{-- 🎴 3. CONTENIDO HIJO --}}
    <main class="card" style="max-width: 1100px; width: 95%;">
        @yield('contenido')
        @yield('content')
    </main>


    {{-- 🦶 4. PIE DE PÁGINA --}}
    <footer>
        © 2026 Restaurante "El Buen Sabor" — Diseñado por Adrián Jara
    </footer>

    {{-- 💬 5. BOTÓN FLOTANTE DE WHATSAPP --}}
    <a href="https://wa.me/51987654321?text=Hola,%20quisiera%20información%20o%20hacer%20un%20pedido%20en%20El%20Buen%20Sabor"
        target="_blank"
        style="position: fixed; bottom: 1.8rem; right: 1.8rem; z-index: 9999; background: linear-gradient(135deg, #25D366, #128C7E); color: white; padding: 0.75rem 1.25rem; border-radius: 9999px; display: inline-flex; align-items: center; gap: 0.5rem; text-decoration: none; font-weight: 700; font-size: 0.9rem; box-shadow: 0 10px 25px rgba(37, 211, 102, 0.45); transition: transform 0.2s;"
        onmouseover="this.style.transform='scale(1.06)'" onmouseout="this.style.transform='scale(1)'">
        <span>💬 Pedir por WhatsApp</span>
    </a>

    @livewireScripts
    <!-- ⚙️ Registro del Service Worker para Modo Offline PWA -->
    <script>
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', function () {
                navigator.serviceWorker.register('/sw.js')
                    .then(function (reg) {
                        console.log('✅ [PWA] Service Worker registrado con éxito:', reg.scope);
                    })
                    .catch(function (err) {
                        console.error('❌ [PWA] Error al registrar Service Worker:', err);
                    });
            });
        }
    </script>

</body>

</html>