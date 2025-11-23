<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Error 404 - Página no encontrada</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <style>
        :root {
            --bg: #0f172a;
            --card: #111827;
            --accent: #16a34a;
            --text: #e5e7eb;
            --muted: #9ca3af;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
            background: radial-gradient(circle at top, #1f2937 0, #020617 60%);
            color: var(--text);
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
        }

        .container {
            max-width: 480px;
            width: 100%;
            padding: 1.5rem;
        }

        .card {
            background: var(--card);
            border-radius: 1rem;
            padding: 2rem 1.75rem;
            box-shadow:
                0 20px 45px rgba(0,0,0,0.5),
                0 0 0 1px rgba(148,163,184,0.08);
            text-align: center;
        }

        .code {
            font-size: 4rem;
            font-weight: 800;
            letter-spacing: 0.08em;
            color: var(--accent);
            margin-bottom: 0.25rem;
        }

        .title {
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 0.75rem;
        }

        .message {
            font-size: 0.95rem;
            color: var(--muted);
            margin-bottom: 1.75rem;
            line-height: 1.5;
        }

        .btn {
            display: inline-block;
            padding: 0.75rem 1.6rem;
            border-radius: 999px;
            background: var(--accent);
            color: #022c22;
            font-weight: 600;
            text-decoration: none;
            font-size: 0.95rem;
            border: none;
            cursor: pointer;
        }

        .btn:hover {
            filter: brightness(1.1);
        }

        .hint {
            margin-top: 1.25rem;
            font-size: 0.8rem;
            color: var(--muted);
        }

        .hint code {
            font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, "Liberation Mono", "Courier New", monospace;
            background: rgba(15,23,42,0.9);
            padding: 0.15rem 0.4rem;
            border-radius: 0.25rem;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="card">
        <div class="code">404</div>
        <div class="title">Página no encontrada</div>
        <p class="message">
            La ruta que estás intentando acceder no existe o ya no está disponible.<br>
            Verifica la URL o vuelve a la página principal de la API.
        </p>
        <a href="{{ url('/') }}" class="btn">
            Volver al inicio
        </a>
        <p class="hint">
            Si eres desarrollador, revisa tus rutas en <code>routes/api.php</code> o <code>routes/web.php</code>.
        </p>
    </div>
</div>
</body>
</html>
