# Setup Instructions - Warehouse Management System

## Prerequisites

-   PHP >= 8.2
-   Composer
-   Node.js >= 20.19.0 atau >= 22.12.0
-   npm

## Installation Steps

### 1. Install Dependencies

```bash
# Install PHP dependencies
composer install

# Install Node.js dependencies
npm install
```

### 2. Environment Configuration

File `.env` sudah dikonfigurasi untuk menggunakan SQLite:

```
DB_CONNECTION=sqlite
```

Database SQLite sudah dibuat di `database/database.sqlite`

### 3. Generate Application Key (jika belum)

```bash
php artisan key:generate
```

### 4. Run Migrations

```bash
php artisan migrate
```

### 5. Build Assets

```bash
# Development mode (watch mode)
npm run dev

# Production build
npm run build
```

### 6. Start Development Server

```bash
php artisan serve
```

Akses aplikasi di: `http://localhost:8000`

## Project Structure

```
warehouse_management_system/
├── app/                    # Application logic
│   ├── Http/
│   │   └── Controllers/   # Controllers
│   └── Models/            # Eloquent models
├── database/
│   ├── migrations/        # Database migrations
│   ├── seeders/           # Database seeders
│   └── database.sqlite    # SQLite database file
├── resources/
│   ├── css/
│   │   └── app.css        # TailwindCSS dengan design system
│   ├── js/
│   │   └── app.js         # JavaScript entry point
│   └── views/             # Blade templates
├── routes/
│   └── web.php            # Web routes
├── design-system.json     # Design system configuration
└── PROJECT_BRIEF.md       # Project documentation
```

## Design System

Design system sudah dikonfigurasi di `resources/css/app.css` dengan:

-   **Primary Colors**: Blue (#3b82f6)
-   **Secondary Colors**: Green (#22c55e)
-   **Accent Colors**: Orange (#f97316)
-   **Neutral Colors**: Gray scale
-   **Status Colors**: Success, Warning, Error, Info

## Database

Sistem menggunakan SQLite untuk kemudahan development. File database ada di:
`database/database.sqlite`

Untuk production, bisa diganti ke MySQL/PostgreSQL dengan mengubah konfigurasi di `.env`.

## Next Steps

1. Buat migrations untuk tabel warehouse management
2. Setup authentication system
3. Buat controllers dan views untuk fitur utama
4. Implementasi RBAC (Role-Based Access Control)

## Useful Commands

```bash
# Create migration
php artisan make:migration create_table_name

# Create model
php artisan make:model ModelName

# Create controller
php artisan make:controller ControllerName

# Clear cache
php artisan cache:clear
php artisan config:clear
php artisan view:clear

# Run tests
php artisan test
```
