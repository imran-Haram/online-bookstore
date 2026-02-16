# Online Bookstore — macOS Setup Guide

This guide walks you through configuring and running the Online Bookstore project on a **MacBook** (macOS).

---

## Prerequisites

Before starting, ensure the following tools are installed on your Mac:

| Tool | Minimum Version | Purpose |
|------|----------------|---------|
| PHP | 8.2+ | Laravel 12 runtime |
| Composer | 2.x | PHP dependency manager |
| Node.js | 18+ | Frontend build tooling |
| npm | 9+ | JavaScript package manager |
| MySQL | 8.0+ | Database server |
| Git | 2.x | Version control |

---

## Step 1: Install Dependencies (if not already installed)

The easiest way to install these on macOS is via [Homebrew](https://brew.sh/).

### Install Homebrew (if you don't have it)

```bash
/bin/bash -c "$(curl -fsSL https://raw.githubusercontent.com/Homebrew/install/HEAD/install.sh)"
```

### Install PHP, MySQL, Composer, Node.js, and Git

```bash
brew install php
brew install mysql
brew install composer
brew install node
brew install git
```

### Start MySQL Service

```bash
brew services start mysql
```

### Secure MySQL (optional but recommended)

```bash
mysql_secure_installation
```

This will prompt you to set a root password. **Remember this password** — you'll need it for the `.env` file.

---

## Step 2: Clone the Repository

```bash
cd ~/Desktop
git clone https://github.com/imran-Haram/online-bookstore.git
cd online-bookstore
```

---

## Step 3: Create the Database

```bash
mysql -u root -p
```

Once inside the MySQL shell:

```sql
CREATE DATABASE online_bookstore;
EXIT;
```

### Import the SQL Dump

```bash
mysql -u root -p online_bookstore < database/online_bookstore.sql
```

---

## Step 4: Configure Environment Variables

Copy the example environment file:

```bash
cp .env.example .env
```

Open `.env` in a text editor and update the database settings:

```dotenv
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=online_bookstore
DB_USERNAME=root
DB_PASSWORD=your_mysql_password_here
```

> **Note:** Replace `your_mysql_password_here` with the actual MySQL root password you set during installation. If you didn't set a password, leave it empty: `DB_PASSWORD=`

---

## Step 5: Install PHP Dependencies

```bash
composer install
```

If you encounter any PHP extension errors, install the missing extensions via Homebrew. Common ones:

```bash
# If you need specific extensions:
brew install php@8.2
# PHP extensions like mbstring, xml, curl, etc. come bundled with Homebrew PHP
```

---

## Step 6: Install JavaScript Dependencies

```bash
npm install
```

---

## Step 7: Generate Application Key

```bash
php artisan key:generate
```

---

## Step 8: Run Database Migrations (if needed)

If the SQL import already created the tables, you can skip this. Otherwise:

```bash
php artisan migrate
```

### Seed the Admin User

```bash
php artisan db:seed --class=AdminUserSeeder
```

This creates the admin account:
- **Email:** `admin@bookstore.com`
- **Password:** `admin123`

---

## Step 9: Start the Development Servers

You need **two terminal windows/tabs** running simultaneously:

### Terminal 1 — Laravel Backend

```bash
php artisan serve
```

This starts the Laravel server at **http://127.0.0.1:8000**

### Terminal 2 — Vite Frontend (CSS/JS compilation)

```bash
npm run dev
```

This starts the Vite dev server at **http://localhost:5173** (handles TailwindCSS and JavaScript hot-reloading).

---

## Step 10: Open the Application

Open your browser and navigate to:

```
http://127.0.0.1:8000
```

### Test Accounts

| Role | Email | Password |
|------|-------|----------|
| Admin | `admin@bookstore.com` | `admin123` |
| Customer | `imran@example.com` | `password` |

> **Note:** If the customer account password doesn't work, register a new account through the registration page.

---

## Troubleshooting

### "MySQL server has gone away" or connection refused

```bash
# Check if MySQL is running
brew services list

# Restart MySQL
brew services restart mysql
```

### "Permission denied" on storage or cache

```bash
chmod -R 775 storage bootstrap/cache
```

### "Vite manifest not found" error

Make sure the Vite dev server is running in a separate terminal:

```bash
npm run dev
```

### PHP version mismatch

```bash
# Check your PHP version
php -v

# If below 8.2, install the correct version
brew install php@8.3
brew link php@8.3
```

### Port 8000 already in use

```bash
# Use a different port
php artisan serve --port=8080
```

### Missing PHP extensions

```bash
# Check installed extensions
php -m

# Common required extensions for Laravel:
# BCMath, Ctype, Fileinfo, JSON, Mbstring, OpenSSL, PDO, Tokenizer, XML, cURL
# These are all included with Homebrew PHP by default
```

---

## Quick Start (All Commands Summary)

```bash
# Clone
git clone https://github.com/imran-Haram/online-bookstore.git
cd online-bookstore

# Database
mysql -u root -p -e "CREATE DATABASE online_bookstore;"
mysql -u root -p online_bookstore < database/online_bookstore.sql

# Environment
cp .env.example .env
# Edit .env → set DB_PASSWORD

# Dependencies
composer install
npm install

# Setup
php artisan key:generate
php artisan db:seed --class=AdminUserSeeder

# Fix permissions
chmod -R 775 storage bootstrap/cache

# Run (two terminals)
php artisan serve          # Terminal 1 → http://127.0.0.1:8000
npm run dev                # Terminal 2 → Vite HMR
```

---

## Project Structure Quick Reference

```
online-bookstore/
├── app/                  # Application code (Controllers, Models, Middleware)
├── config/               # Configuration files
├── database/             # Migrations, seeders, SQL dump
├── doc/                  # Project documentation
├── public/               # Web root (index.php, assets)
├── resources/views/      # Blade templates (37 views)
├── routes/               # web.php (main routes), auth.php
├── storage/              # Logs, cache, sessions
├── tests/                # PHPUnit tests
├── .env                  # Environment config (not in repo)
├── composer.json         # PHP dependencies
├── package.json          # JS dependencies
└── vite.config.js        # Vite build configuration
```
