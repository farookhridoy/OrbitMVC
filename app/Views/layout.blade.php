<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }} - OrbitMVC</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: #f4f7f6; color: #333; line-height: 1.6; }
        .container { max-width: 800px; margin: 50px auto; background: white; padding: 40px; border-radius: 12px; box-shadow: 0 10px 30px rgba(0,0,0,0.1); }
        h1 { color: #2c3e50; border-bottom: 2px solid #3498db; padding-bottom: 10px; }
        .footer { margin-top: 30px; font-size: 0.8em; color: #7f8c8d; text-align: center; }
        .badge { background: #3498db; color: white; padding: 4px 8px; border-radius: 4px; font-size: 0.9em; }
    </style>
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
