@extends('layout')

@section('title', 'Welcome Home')

@section('content')
    <h1>Welcome to OrbitMVC <span class="badge">v1.0</span></h1>
    <p>This page is rendered using our custom <strong>Blade-like Template Engine</strong>.</p>
    
    <h3>High-Performance Features Implemented:</h3>
    <ul>
        <li><strong>Compiled Views:</strong> Fast execution via filesystem caching.</li>
        <li><strong>Redis Queue:</strong> Ready for async processing (70k+ users).</li>
        <li><strong>Stateless Core:</strong> Optimized for RoadRunner/Swoole.</li>
    </ul>

    <p>Current User session mock: <strong>{{ $username }}</strong></p>

    @if(count($features) > 0)
        <h3>Core Modules:</h3>
        <ul>
            @foreach($features as $feature)
                <li>{{ $feature }}</li>
            @endforeach
        </ul>
    @endif
@endsection
