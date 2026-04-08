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

### Method 1: Create Project (Recommended)
Start a new project with the full scaffold structure:
```bash
composer create-project farook/orbitmvc my-app
cd my-app
php orbit orbit:serve
```

### Method 2: Manual Installation
Install the core into an existing project:
```bash
composer require farook/orbitmvc
vendor/bin/orbit init
php orbit orbit:serve
```

## 💻 CLI Commands
OrbitMVC comes with a built-in CLI tool for fast development:

- `php orbit init` - Scaffold the project structure (app, public, routes, storage)
- `php orbit orbit:serve` - Start the development server at localhost:8000
- `php orbit make:controller <Name>` - Create a new controller
- `php orbit make:model <Name>` - Create a new Active Record model
- `php orbit view:clear` - Purge compiled view cache
- `php orbit queue:work` - Start the background job worker

## 🤝 Contributing

Contributions are welcome! Please check the [CONTRIBUTING.md](CONTRIBUTING.md) for guidelines.

## 👤 Author

**Md Omar farook**
- Website: [farookhridoy.com](http://farookhridoy.com)
- Email: farookhridoy@gmail.com
- GitHub: [@farookhridoy](https://github.com/farookhridoy)

## 📄 License

The OrbitMVC framework is open-sourced software licensed under the [MIT license](LICENSE).
