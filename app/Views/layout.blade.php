<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }} - OrbitMVC</title>
    <style>
        body { font-family: 'Outfit', 'Inter', sans-serif; background: #0f172a; color: #e2e8f0; line-height: 1.6; margin: 0; display: flex; align-items: center; justify-content: center; min-height: 100vh; }
        .container { max-width: 900px; width: 90%; background: #1e293b; padding: 60px; border-radius: 24px; box-shadow: 0 25px 50px -12px rgba(0,0,0,0.5); border: 1px solid #334155; }
        .hero { text-align: center; margin-bottom: 50px; }
        h1 { color: #f8fafc; font-size: 3rem; margin: 0; letter-spacing: -0.05em; }
        .badge { background: linear-gradient(135deg, #38bdf8, #818cf8); color: white; padding: 4px 12px; border-radius: 9999px; font-size: 0.4em; vertical-align: middle; }
        .subtitle { color: #94a3b8; font-size: 1.25rem; margin-top: 10px; }
        .card-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 24px; margin-top: 40px; }
        .card { background: #334155; padding: 24px; border-radius: 16px; border: 1px solid #475569; transition: transform 0.2s; }
        .card:hover { transform: translateY(-5px); border-color: #38bdf8; }
        .card h3 { margin-top: 0; color: #38bdf8; }
        .footer { margin-top: 50px; font-size: 0.9rem; color: #64748b; text-align: center; border-top: 1px solid #334155; padding-top: 20px; }
        .footer-msg { text-align: center; margin-top: 20px; font-size: 0.9rem; color: #94a3b8; }
    </style>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;600;800&display=swap" rel="stylesheet">
</head>
<body>
    <div class="container">
        @yield('content')
        
        <div class="footer">
            Powered by <strong>OrbitMVC</strong> High-Performance Core
        </div>
    </div>
</body>
</html>
