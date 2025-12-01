# Warehouse Management System - PT. Fia Express

Sistem Warehouse Management System untuk PT. Fia Express yang mengelola pengiriman paket ke luar negeri. Sistem ini dirancang untuk mengoptimalkan operasi gudang, tracking paket, dan manajemen inventori untuk pengiriman internasional.

## 📋 Table of Contents

-   [Features](#features)
-   [Tech Stack](#tech-stack)
-   [Prerequisites](#prerequisites)
-   [Installation](#installation)
-   [Usage](#usage)
-   [Project Structure](#project-structure)
-   [User Roles](#user-roles)
-   [Key Features](#key-features)
-   [Database Schema](#database-schema)
-   [Design System](#design-system)
-   [Development](#development)

## ✨ Features

### Core Features

-   **Inventory Management**

    -   Real-time stock tracking
    -   Multi-location warehouse support
    -   Product categorization
    -   SKU management
    -   Low stock alerts

-   **Inbound Management**

    -   Package receiving workflow
    -   HS Code and customs description
    -   Status tracking (Received, Inspected, Stored)
    -   Automatic stock updates

-   **Outbound Management**

    -   Package selection and grouping
    -   Auto-calculate shipping rates
    -   Shipping label printing with barcode
    -   Picking list generation
    -   Quick status updates

-   **International Shipping**

    -   Shipping zone configuration
    -   Country-based rate calculation
    -   Customs documentation
    -   HS Code management
    -   Multiple carrier support

-   **Package Tracking**

    -   Real-time status updates
    -   Location tracking
    -   Tracking number lookup
    -   Status history

-   **Reporting & Analytics**

    -   Dashboard with key metrics
    -   Inventory reports
    -   Shipping reports
    -   Data export (Excel)
    -   Revenue tracking

-   **User Management**
    -   Role-based access control (RBAC)
    -   User CRUD operations
    -   Activity logging
    -   Secure authentication

## 🛠 Tech Stack

-   **Backend**: Laravel 12.40.2
-   **Frontend**: TailwindCSS v4
-   **Database**: SQLite (development) / MySQL/PostgreSQL (production)
-   **PHP**: >= 8.2
-   **Node.js**: >= 20.19.0 atau >= 22.12.0
-   **Additional Packages**:
    -   Maatwebsite/Excel (^3.1) - Data export

## 📦 Prerequisites

Before you begin, ensure you have the following installed:

-   PHP >= 8.2
-   Composer
-   Node.js >= 20.19.0 atau >= 22.12.0
-   npm

## 🚀 Installation

### 1. Clone the repository

```bash
git clone <repository-url>
cd warehouse_management_system
```

### 2. Install PHP Dependencies

```bash
composer install
```

### 3. Install Node.js Dependencies

```bash
npm install
```

### 4. Environment Configuration

The `.env` file is already configured to use SQLite:

```env
DB_CONNECTION=sqlite
```

The SQLite database file is located at `database/database.sqlite`.

### 5. Generate Application Key

```bash
php artisan key:generate
```

### 6. Run Migrations

```bash
php artisan migrate
```

This will create all necessary database tables.

### 7. Seed Database (Optional)

```bash
php artisan db:seed
```

This will create default admin, manager, and staff users, plus shipping zones.

### 8. Build Assets

For development:

```bash
npm run dev
```

For production:

```bash
npm run build
```

### 9. Start Development Server

```bash
php artisan serve
```

Access the application at: `http://localhost:8000`

## 📖 Usage

### Default Login Credentials

After seeding, you can login with:

**Admin:**

-   Email: `admin@fiaexpress.com`
-   Password: `password`

**Manager:**

-   Email: `manager@fiaexpress.com`
-   Password: `password`

**Staff:**

-   Email: `staff@fiaexpress.com`
-   Password: `password`

### Main Workflows

1. **Inbound Shipment**

    - Create inbound shipment
    - Add packages with HS Code and customs info
    - Update status (Received → Inspected → Stored)
    - Stock automatically updates when status is "Stored"

2. **Outbound Shipment**

    - Select available packages
    - Choose destination country (auto-selects shipping zone)
    - Shipping cost auto-calculates based on zone rates
    - Generate shipping label with barcode
    - Print picking list

3. **Package Tracking**
    - Search by tracking number
    - View package status and location
    - Track through inbound and outbound shipments

## 📁 Project Structure

```
warehouse_management_system/
├── app/
│   ├── Exports/              # Excel export classes
│   ├── Http/
│   │   ├── Controllers/      # Application controllers
│   │   └── Middleware/       # Custom middleware (CheckRole)
│   └── Models/              # Eloquent models
├── database/
│   ├── migrations/          # Database migrations
│   ├── seeders/             # Database seeders
│   └── database.sqlite      # SQLite database file
├── resources/
│   ├── css/
│   │   └── app.css          # TailwindCSS with design system
│   ├── js/
│   │   └── app.js           # JavaScript entry point
│   ├── views/
│   │   ├── components/      # Reusable Blade components
│   │   ├── layouts/         # Layout templates
│   │   └── [resources]/    # Resource views
│   └── design-system.json   # Design system configuration
├── routes/
│   └── web.php              # Web routes
├── .env                     # Environment configuration
├── PROJECT_BRIEF.md         # Detailed project documentation
└── SETUP.md                 # Setup instructions
```

## 👥 User Roles

### Admin

-   Full system access
-   User management (create, edit, delete)
-   System configuration
-   All reports and exports
-   Activity logs access

### Manager

-   Warehouse operations
-   View user list
-   Reports viewing
-   All CRUD operations (except user management)
-   Activity logs access

### Staff

-   Package receiving and processing
-   Inventory updates
-   Basic CRUD operations
-   View-only access to reports

## 🎯 Key Features

### 1. Auto-Calculate Shipping Rates

-   Automatically calculates shipping cost based on:
    -   Selected shipping zone
    -   Total package weight
    -   Base rate + (weight × per kg rate)

### 2. Shipping Label Printing

-   Professional 4×6 inch shipping labels
-   Barcode generation (CODE128)
-   Print-optimized layout
-   Classic and elegant design

### 3. HS Code Management

-   Add HS Code and customs description to packages
-   Stored in JSON format
-   Displayed in package details and labels

### 4. Picking List Generation

-   Printable picking list for outbound shipments
-   Packages grouped by location
-   Summary information included

### 5. Activity Logging

-   Tracks all user actions
-   Filterable by user, action, model type, date range
-   Detailed change tracking
-   IP address and user agent logging

### 6. Data Export

-   Export to Excel format
-   Available for:
    -   Products
    -   Customers
    -   Inbound Shipments
    -   Outbound Shipments

## 🗄 Database Schema

### Core Tables

-   **users** - User accounts with roles
-   **warehouses** - Warehouse/location information
-   **categories** - Product categories
-   **products** - Product inventory
-   **customers** - Customer information
-   **inbound_shipments** - Incoming shipments
-   **outbound_shipments** - Outgoing shipments
-   **packages** - Individual packages
-   **shipping_zones** - Shipping zone configuration
-   **activity_logs** - System activity tracking

See `PROJECT_BRIEF.md` for detailed schema information.

## 🎨 Design System

The application uses a custom design system defined in `design-system.json`:

-   **Primary Color**: Blue (#3b82f6) - Trust, reliability
-   **Secondary Color**: Green (#22c55e) - Success, growth
-   **Accent Color**: Orange (#f97316) - Action, urgency
-   **Neutral Colors**: Gray scale for backgrounds and text

### Reusable Components

-   `<x-button>` - Base button component
-   `<x-button-edit>` - Edit button with icon
-   `<x-button-back>` - Back button with icon

## 🔧 Development

### Useful Commands

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

# Run migrations
php artisan migrate

# Rollback migrations
php artisan migrate:rollback

# Seed database
php artisan db:seed

# Run tests
php artisan test
```

### Development Workflow

1. Make changes to code
2. Run migrations if database changes
3. Build assets: `npm run dev` (watch mode) or `npm run build` (production)
4. Test the application

### Code Style

The project follows Laravel coding standards. Use Laravel Pint for code formatting:

```bash
./vendor/bin/pint
```

## 🔐 Security

-   Password hashing using bcrypt
-   CSRF protection on all forms
-   Role-based access control (RBAC)
-   SQL injection protection via Eloquent ORM
-   XSS protection via Blade templating

## 📝 License

This project is proprietary software for PT. Fia Express.

## 📞 Support

For issues or questions, please contact the development team.

---

**Built with ❤️ for Praesepe Labs**
