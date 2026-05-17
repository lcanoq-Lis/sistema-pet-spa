<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pet Spa 🐾</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Google Fonts --}}
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        * { font-family: 'Poppins', sans-serif; }

        body {
            min-height: 100vh;
            background: linear-gradient(135deg, #fef3e2 0%, #fde8c8 50%, #e8f5e9 100%);
            background-attachment: fixed;
        }

        /* Animación de entrada */
        .page-enter {
            animation: fadeInUp 0.4s ease forwards;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Cards con hover */
        .card-hover {
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        .card-hover:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }

        /* Botones con efecto */
        .btn-primary {
            background: linear-gradient(135deg, #ff7043, #ff8f00);
            color: white;
            font-weight: 700;
            padding: 12px 24px;
            border-radius: 12px;
            border: none;
            cursor: pointer;
            transition: opacity 0.2s, transform 0.1s;
            width: 100%;
        }
        .btn-primary:hover { opacity: 0.9; transform: scale(1.01); }
        .btn-primary:active { transform: scale(0.99); }

        .btn-success {
            background: linear-gradient(135deg, #43a047, #66bb6a);
            color: white;
            font-weight: 700;
            padding: 12px 24px;
            border-radius: 12px;
            border: none;
            cursor: pointer;
            transition: opacity 0.2s, transform 0.1s;
            width: 100%;
        }
        .btn-success:hover { opacity: 0.9; transform: scale(1.01); }

        /* Inputs */
        .input-field {
            width: 100%;
            border: 2px solid #d7ccc8;
            border-radius: 12px;
            padding: 12px 16px;
            font-size: 14px;
            outline: none;
            transition: border-color 0.2s;
            font-family: 'Poppins', sans-serif;
        }
        .input-field:focus { border-color: #ff7043; }

        /* Alertas */
        .alert-success {
            background: #e8f5e9;
            color: #2e7d32;
            border-left: 4px solid #43a047;
            padding: 12px 16px;
            border-radius: 8px;
            font-size: 14px;
            margin-bottom: 16px;
        }
        .alert-error {
            background: #fff3e0;
            color: #e65100;
            border-left: 4px solid #ff7043;
            padding: 12px 16px;
            border-radius: 8px;
            font-size: 14px;
            margin-bottom: 16px;
        }

        /* Scrollbar bonito */
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: #fef3e2; }
        ::-webkit-scrollbar-thumb { background: #ffab91; border-radius: 10px; }
    </style>
</head>
<body>
    <div class="page-enter">
        @yield('content')
    </div>

    {{-- Footer --}}
    <footer class="text-center py-6 mt-8" style="color:#bcaaa4; font-size:12px;">
        🐾 Pet Spa © {{ date('Y') }} — Todos los derechos reservados
    </footer>
</body>
</html>