# 🚀 Custom PHP MVC Framework

> Welcome to your very own PHP MVC Application — a modern, lightweight PHP MVC framework designed for rapid web application development.  
> This framework is built from scratch, featuring a clean architecture, robust routing, session and flash messaging, CSRF protection, and a simple ORM-like model layer.

---

## ✨ Features

- **MVC Architecture**: Clean separation of concerns with Controllers, Models, and Views.
- **Elegant Routing**: Grouped routes, controller binding, and middleware support (auth, guest, CSRF).
- **ORM-like Models**: Abstract base model for easy database interaction.
- **Session & Flash Messaging**: User authentication, flash messages, and session management.
- **CSRF Protection**: Secure your forms with built-in CSRF tokens and middleware.
- **Validation**: Laravel-inspired validation rules for user input.
- **Migration System**: Simple migration classes for database schema management, with CLI commands.
- **Helpers**: Utility functions for views, forms, and authentication.
- **Modern UI**: Tailwind CSS and Flowbite integration for rapid UI development.
- **Error Handling**: Custom static HTML error views for common HTTP errors (403, 404, 405, 419, 500).

---

## 🗂️ Project Structure

```plaintext
Project_root/
│
├── app/
│   ├── controllers/      # Controllers (e.g., AuthController, HomeController)
│   ├── core/             # Framework core (Application, Router, Request, etc.)
│   │   └── middlewares/  # Built-in middlewares (Auth, Guest, CSRF)
│   ├── models/           # Models (e.g., User)
│
├── bootstrap/            # Bootstrap and helper files
├── config/               # Configuration (e.g., database.php)
├── database/
│   └── migrations/       # Migration classes for schema setup
├── public/               # Public web root (index.php, assets, .htaccess)
│   ├── assets/
│   │   ├── css/          # Tailwind and custom CSS
│   │   └── js/           # JS libraries (e.g., Flowbite)
│   └── errors/           # Static HTML error views (403, 404, 405, 419, 500)
├── resources/
│   ├── css/              # Source CSS (Tailwind entrypoint)
│   ├── js/               # Source JS
│   └── views/            # Views and layouts
│       └── layouts/      # Layout partials (header, footer)
├── routes/               # Route definitions (web.php)
├── runtime/              # Runtime files (cache, logs, etc.)
├── composer.json         # Composer dependencies
├── package.json          # Node.js dependencies (Tailwind, Flowbite)
└── README.md             # This file!
```

---

## 🚀 Getting Started

### 1. **Clone the Repository**

```bash
git clone https://github.com/yourusername/HSS_Main.git
cd HSS_Main
```

### 2. **Install PHP Dependencies**

```bash
composer install
```

### 3. **Install Node.js Dependencies (for CSS/UI)**

```bash
npm install
```

### 4. **Build or Watch CSS (Tailwind/Flowbite)**

To build CSS for production:
```bash
npm run build:css
```
To watch and auto-rebuild CSS during development:
```bash
npm run watch:css
```

### 5. **Environment Setup**

Copy `.env.example` to `.env` and set your database credentials:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=hss_main
DB_USERNAME=root
DB_PASSWORD=yourpassword
```

### 6. **Run Database Migrations (CLI Tool)**

Apply all database migrations using the built-in CLI tool:

```bash
php console migrate
```
This command will execute all migration scripts in the `database/migrations/` directory, creating the necessary tables (such as `users`) for your application.

#### Rollback Migrations
To undo the most recent migration(s):
```bash
php console migrate:rollback
```
This will call the `down()` method of the latest migration(s) and remove their record from the database.

#### CLI Help
If you run `php console` with no or unknown command, it will show available commands:

```bash
Available commands:
  serve              Start development server at http://localhost:8000
  migrate            Run database migrations
  migrate:rollback   Rollback the latest migration(s)
```

### 7. **Start the Application**

You have several options to start your application:

#### Option A: Using the Built-in Development Server (Recommended for Development)
```bash
php console serve
```
This will start a development server at `http://localhost:8000` and automatically serve files from the `public/` directory.

#### Option B: Using PHP's Built-in Server Manually
```bash
php -S localhost:8080 -t public/
```

#### Option C: Using Apache/XAMPP
Set your web server's document root to the `public/` directory and access the app in your browser.

**Apache Users: Enable Pretty URLs**
If using Apache, the included `.htaccess` in `public/` enables pretty URLs:
```apacheconf
<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteRule ^ index.php [QSA,L]
</IfModule>
```

---

## 🛠️ Application Overview

### Application Bootstrap
- **public/index.php**: Entry point, loads the app and routes, then runs the application.
- **bootstrap/app.php**: Loads environment, helpers, config, and returns the Application instance.

### Routing & Middleware
- **routes/web.php**: Define routes using expressive, grouped syntax with middleware:
    ```php
    Route::group(['middleware' => 'guest'], function () {
        Route::controller(AuthController::class, function () {
            Route::get('/login', 'login');
            Route::post('/loginForm', 'loginForm');
            Route::get('/register', 'register');
            Route::post('/registerForm', 'registerForm');
        });
    });
    
    Route::group(['middleware' => 'auth'], function () {
        Route::controller(HomeController::class, function () {
            Route::get('/home', 'index');
            Route::get('/contact', 'contact');
            Route::post('/contactForm', 'contactForm');
            Route::get('/profile', 'profile');
            Route::get('/logout', 'logout');
        });
    });
    ```
- **Middleware**: Built-in support for `auth`, `guest`, and `csrf` middleware. Easily add your own in `app/core/middlewares/`.

### Controllers
- Extend `app\core\Controller`
- Render views with `$this->view('viewname', ['data' => $value])`

### Models
- Extend `app\core\Model`
- Define `tableName()`, `attributes()`, and `primaryKey()`
- Use `insert()`, `update()`, and `findOne()` for database operations

### Views
- PHP view files in `resources/views/`
- Use helper functions: `old()`, `isInvalid()`, `error()`, `flash()`, `csrf_token()`
- Layouts in `resources/views/layouts/`

### Helpers
- **layout($layout)**: Loads a layout file
- **redirect($url)**: Redirects to a URL
- **setFlash($key, $msg)**: Sets a flash message
- **auth() / guest()**: User authentication helpers

### Error Handling
- Custom static HTML error views for 403, 404, 405, 419 (CSRF), and 500 errors in `public/errors/`

### CSRF Protection
- All POST forms should include `<?= csrf_token() ?>`.
- CSRF middleware automatically validates tokens on POST requests.

---

## 🧩 Example: Register Route

```php
// GET /register → shows the registration form
// POST /registerForm → handles registration logic
```

---

## 🎨 Design & Philosophy

- **Minimalism**: Only what you need, clearly named.
- **Readability**: Clear, well-documented code.
- **Extendability**: Easy to add controllers, models, and routes.
- **Security**: Includes CSRF protection and input validation.

---

## 🧙 About the Framework

This is a made-up, educational PHP MVC framework inspired by Laravel, CodeIgniter, and Symfony, but designed for learning and rapid prototyping.  

---

## 👑 Author

- **RLASH18** (lacdangryan18@gmail.com)

---

> Build, break, and learn.  
> Happy Coding!