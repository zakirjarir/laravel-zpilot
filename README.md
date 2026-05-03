# Z-laravel-installer 🚀

[![Latest Version on Packagist](https://img.shields.io/packagist/v/zakirjarir/laravel-installer.svg?style=flat-square)](https://packagist.org/packages/zakirjarir/laravel-installer)
[![Total Downloads](https://img.shields.io/packagist/dt/zakirjarir/laravel-installer.svg?style=flat-square)](https://packagist.org/packages/zakirjarir/laravel-installer)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE)

**Z-laravel-installer** is an ultra-modern, intelligent web-based installation wizard for Laravel applications. It simplifies the deployment process by handling everything from system requirements checks to database setup and package configuration in a single click.

---

## ✨ Key Features

- 🎨 **Premium Glassmorphism UI**: A state-of-the-art interface featuring modern animations and glassmorphism design.
- 🔍 **Dynamic Requirements Checker**: Automatically reads your project's `composer.json` to validate required PHP versions and extensions.
- ⚙️ **Smart .env Manager**: Automatically detects missing `.env` files. It copies from `.env.example` if available, or generates a default `.env` configuration if not.
- 🛡️ **Session Fallback Protection**: Automatically switches to `file` session mode during installation to prevent application crashes when the database is not yet configured.
- 🗄️ **Automatic Database Creator**: Capable of automatically creating the database if it does not already exist.
- 🤖 **Intelligent Package Setup**: Automatically detects and configures popular Laravel packages including **JWT, Passport, Sanctum, Telescope, Horizon, and Filament**.
- 🔑 **Auto Key Generation**: Automatically generates the `APP_KEY` and other package-specific secret keys upon successful installation.
- 🔄 **Unified Installation**: Simplifies the process by combining migrations, seeding, and key generation into a single-step workflow.
- 🔒 **Auto-Lock System**: For security, the installer automatically locks itself (returning a 404 error) after completion to prevent unauthorized access.
- 📱 **Fully Responsive**: Optimized for seamless performance on all devices including Mobile, Tablet, and Desktop.

---

## 🚀 Installation

Install the package into your Laravel project using the following command:

```bash
composer require zakirjarir/laravel-installer
```

---

## 🛠️ Usage

After installation, visit the following URL in your browser:

`http://your-app.test/install`

The installer will guide you through:
1. **Welcome Screen**
2. **Server Requirements Check** (Dynamic Detection)
3. **Dynamic Environment Setup** (Auto-detect from .env.example)
4. **Unified Installation** (Migrations, Seeders, Keys & Package Setup)
5. **Finalization**

---

## 🤝 Contributing

Contributions are welcome! Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

---

## 📄 License

The MIT License (MIT). Please see the [License File](LICENSE) for more information.

---

## 👨‍💻 Developed By

Built with ❤️ by [Zakir Jarir](https://github.com/zakirjarir)
