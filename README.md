# Game API App

A Laravel 11 app for browsing games, built with Livewire, Volt, and Tailwind CSS.

## Prerequisites

- **PHP 8.2+** with extensions: sqlite3, xml, mbstring, curl, zip
- **Composer**
- **Node.js** (for pnpm/npm)

### Install PHP on Ubuntu/WSL

```bash
sudo apt update
sudo apt install php8.3 php8.3-cli php8.3-sqlite3 php8.3-xml php8.3-mbstring php8.3-curl php8.3-zip
```

### Install Composer

```bash
curl -sS https://getcomposer.org/installer | php
sudo mv composer.phar /usr/local/bin/composer
```

## Getting Started

1. **Copy environment file** (already done if you ran setup):
   ```bash
   cp .env.example .env
   ```

2. **Install dependencies:**
   ```bash
   composer install
   pnpm install   # or: npm install
   ```

3. **Configure Laravel:**
   ```bash
   php artisan key:generate
   touch database/database.sqlite
   php artisan migrate
   ```

4. **Run the app:**
   ```bash
   composer dev
   ```
   This starts the Laravel server, Vite, queue worker, and log tail in one command.

   Or run separately in two terminals:
   ```bash
   php artisan serve
   pnpm run dev
   ```

5. **Open** [http://localhost:8000](http://localhost:8000)

## Alternative: Laravel Sail (Docker)

You can run Sail as `./sail` from the project directory, or set up a `sail` command (no `./`) that works from any folder inside the project.

**Option 1 – Use `./sail`** (no setup):
```bash
./sail up -d
./sail pnpm dev
./sail artisan migrate
```

**Option 2 – Use `sail` without `./`** (one-time setup): add this to your `~/.bashrc` (or `~/.zshrc`):
```bash
# Laravel Sail: run "sail" from anywhere inside a Sail project
source ~/Projects/Laracast/Game-Api-app/sail.sh
```
Then run `source ~/.bashrc` (or `source ~/.zshrc`). After that you can use:
```bash
sail up -d
sail pnpm dev
sail artisan migrate
```
The function finds the project by looking for `vendor/bin/sail` in the current or parent directories, so it works from any subdirectory of the project.

If you prefer Docker, ensure Docker Desktop has WSL2 integration enabled.

1. **Install dependencies** (on the host, so the `vendor` and `sail` script exist):
   ```bash
   composer install
   ```

2. **Configure for Sail:** copy `.env.example` to `.env`, then set these in `.env` so the app and MariaDB work:
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```
   In `.env`, set (or uncomment and use) the Sail block at the bottom:
   - `DB_CONNECTION=mysql`
   - `DB_HOST=mariadb`
   - `DB_DATABASE=laravel`
   - `DB_USERNAME=sail`
   - `DB_PASSWORD=password`
   - `REDIS_HOST=redis`
   Optionally set `WWWGROUP` and `WWWUSER` to your host user/group id (e.g. `id -g` and `id -u`).

3. **Start Sail:**
   ```bash
   ./sail up
   ```
   Or: `./vendor/bin/sail up`. Use `./sail up -d` to run in the background.

4. **First run:** run migrations inside the container:
   ```bash
   ./sail artisan migrate
   ```

5. **Open** [http://localhost](http://localhost) (or the port set as `APP_PORT` in `.env`, default 80).

**Rebuilding the Sail image** (e.g. after changing PHP/Sail or to fix build issues):
   ```bash
   ./sail build --no-cache
   ./sail up -d
   ```

**Artisan and generators:** run any Artisan command inside the container with `./sail artisan`:
   ```bash
   ./sail artisan make:model Game
   ./sail artisan make:migration create_games_table
   ./sail artisan migrate
   ./sail artisan tinker
   ```
   Files created (models, migrations, etc.) are written into your project directory via the mounted volume.