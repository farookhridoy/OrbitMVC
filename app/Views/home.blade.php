@extends('layout')

@section('title', 'OrbitMVC - High Performance PHP')

@section('content')
    <div class="hero">
        <h1>OrbitMVC <span class="badge">v1.0.3</span></h1>
        <p class="subtitle">Scaffolded successfully. You're ready to build at scale.</p>
    </div>

    <div class="card-grid">
        <div class="card">
            <h3>🚀 Fast & Efficient</h3>
            <p>Built with a high-speed Blade-like template engine and atomic caching.</p>
        </div>
        <div class="card">
            <h3>📦 Ready to Scale</h3>
            <p>Integrated Redis-backed async queues for 70k+ concurrent tasks.</p>
        </div>
        <div class="card">
            <h3>🛠️ Modern CLI</h3>
            <p>Scaffold controllers, models, and environments in seconds.</p>
        </div>
    </div>

    <div class="footer-msg">
        <p>Current Session: <strong>{{ $username }}</strong></p>
    </div>
@endsection
