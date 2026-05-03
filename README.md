# Laravel Installer GUI 🚀

[![Latest Version on Packagist](https://img.shields.io/packagist/v/zakirjarir/laravel-installer.svg?style=flat-square)](https://packagist.org/packages/zakirjarir/laravel-installer)
[![Total Downloads](https://img.shields.io/packagist/dt/zakirjarir/laravel-installer.svg?style=flat-square)](https://packagist.org/packages/zakirjarir/laravel-installer)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE)

A premium, web-based installation wizard for Laravel applications. Simplify your deployment process with a stunning GUI that handles environment configuration, server requirements check, and database setup.

---

## ✨ Features

- 🎨 **Premium UI/UX**: Modern dark-themed design with glassmorphism and smooth animations.
- 🔍 **Requirements Checker**: Validates PHP version, extensions, and folder permissions.
- ⚙️ **Dynamic Environment Setup**: Automatically reads `.env.example` and generates a setup form.
- 🗄️ **Smart Database Setup**: Automatically creates the database if it doesn't exist.
- 🛠️ **One-Click Installation**: Runs migrations and seeders in a single, unified step.
- 🔒 **Security First**: Automatically locks itself after a successful installation.

---

## 🚀 Installation

You can install the package via composer:

```bash
composer require zakirjarir/laravel-installer
```

If you haven't published it to Packagist yet, use the following one-liner:

```bash
composer config repositories.zakirjarir/laravel-installer vcs https://github.com/zakirjarir/laravel-installer && composer require zakirjarir/laravel-installer:dev-main
```

---

## 🛠️ Usage

Once installed, simply visit the following URL in your browser to start the installation wizard:

`http://your-app.test/install`

The installer will guide you through:
1. **Welcome Screen**
2. **Server Requirements Check**
3. **Environment Configuration** (Dynamic fields from your `.env.example`)
4. **Database Installation** (Migrations & Seeders)
5. **Finalization**

---

## 🤝 Contributing

Contributions are welcome! Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

---

## 📄 License

The MIT License (MIT). Please see [License File](LICENSE) for more information.

---

## 👨‍💻 Developed By

Built with ❤️ by [Zakir Jarir](https://github.com/zakirjarir)
