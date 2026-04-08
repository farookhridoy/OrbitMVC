# OrbitMVC Framework

[![Latest Version on Packagist](https://img.shields.io/packagist/v/farook/orbitmvc.svg?style=flat-square)](https://packagist.org/packages/farook/orbitmvc)
[![Total Downloads](https://img.shields.io/packagist/dt/farook/orbitmvc.svg?style=flat-square)](https://packagist.org/packages/farook/orbitmvc)
[![License](https://img.shields.io/packagist/l/farook/orbitmvc.svg?style=flat-square)](https://github.com/farookhridoy/OrbitMVC/blob/main/LICENSE)

**OrbitMVC** is a high-performance, reusable PHP MVC framework core designed specifically for massive concurrency. It remains lightweight while providing the essential tools for modern web development.

---

## 🚀 Key Features

- **High-Performance View Engine:** Compiled Blade-like templates with Zero-overhead caching.
- **Active Record ORM:** Fluent, object-oriented database interactions.
- **Async Redis Queue:** Process heavy tasks (like registrations) in the background.
- **Stateless Architecture:** Fully compatible with RoadRunner, Swoole, and traditional servers.
- **Orbit CLI:** Developer-friendly terminal tool for scaffolding and maintenance.

## 📦 Installation

You can install the core framework via Composer:

```bash
composer require farook/orbitmvc
```

Or clone the repository to start a new project:

```bash
git clone https://github.com/farookhridoy/OrbitMVC.git
cd OrbitMVC
composer install
```

## 🛠 Usage

### Routing & Views
Define your routes in `public/index.php` (or your routes file) and render compiled views:

```php
$router->add('GET', '/', function() {
    return view('home', ['name' => 'OrbitMVC']);
});
```

### Active Record ORM
Interact with your data using simple model classes:

```php
// Find all active users
$users = User::where('status', 'active')->get();

// Find a single user
$user = User::find(1);
```

### High-Speed Queue
Offload heavy tasks to the Redis queue:

```php
(new RegistrationService())->register($userData);
// Response is sent immediately while processing happens in the background
```

## 💻 CLI Commands
OrbitMVC comes with a built-in CLI tool for fast development:

- `php orbit make:controller UserController` - Scaffold a controller
- `php orbit make:model User` - Scaffold an ORM model
- `php orbit view:clear` - Purge compiled view cache
- `php orbit queue:work` - Start the background job worker
- `php orbit:serve` - Start the development server

## 🤝 Contributing

Contributions are welcome! Please check the [CONTRIBUTING.md](CONTRIBUTING.md) for guidelines.

## 👤 Author

**Md Omar farook**
- Website: [farookhridoy.com](http://farookhridoy.com)
- Email: farookhridoy@gmail.com
- GitHub: [@farookhridoy](https://github.com/farookhridoy)

## 📄 License

The OrbitMVC framework is open-sourced software licensed under the [MIT license](LICENSE).
