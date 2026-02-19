# Game API App

A Laravel 11 app for browsing games, built with Livewire, Volt, and Tailwind CSS. Game data is powered by the [IGDB API](https://api-docs.igdb.com/).

## Prerequisites

- **PHP 8.2+** with extensions: sqlite3, xml, mbstring, curl, zip
- **Composer**
- **Node.js** (for npm or pnpm)

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

## Clone and run locally

1. **Clone the repo** (use your repo URL), then enter the project:
   ```bash
   git clone <your-repo-url>
   cd Game-Api-app
   ```

2. **Copy the environment file and generate app key:**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

3. **Install dependencies:**
   ```bash
   composer install
   npm install
   ```
   Or use `pnpm install` if you prefer pnpm.

4. **Set up the database** (SQLite by default in `.env.example`):
   ```bash
   touch database/database.sqlite
   php artisan migrate
   ```

5. **Optional – IGDB API keys** (needed for live game data):
   - Create a [Twitch](https://dev.twitch.tv/) app to get **Client ID** and **Client Secret** (IGDB uses Twitch OAuth).
   - In `.env`, set:
     ```env
     IGDB_CLIENT_ID=your_client_id
     IGDB_CLIENT_SECRET=your_client_secret
     ```
   - Without these, game listings may be empty or the app may not fetch data from IGDB.

6. **Run the app:**
   ```bash
   composer dev
   ```
   This starts the Laravel server, Vite, queue worker, and log tail in one command.

   Or run in two terminals:
   ```bash
   php artisan serve
   npm run dev
   ```

7. **Open** [http://localhost:8000](http://localhost:8000)

## Alternative: Laravel Sail (Docker)

You can run the app in Docker using Sail. Use `./sail` from the project directory, or set up a `sail` command that works from any folder inside the project.

**Option 1 – Use `./sail`** (no setup):

```bash
./sail up -d
./sail npm install
./sail npm run dev
./sail artisan migrate
```

**Option 2 – Use `sail` without `./`** (one-time setup). Remove any broken alias, then install the launcher:

```bash
unalias sail 2>/dev/null
mkdir -p ~/bin && cp bin/sail ~/bin/sail && chmod +x ~/bin/sail
grep -q 'export PATH="$HOME/bin:$PATH"' ~/.bashrc || echo 'export PATH="$HOME/bin:$PATH"' >> ~/.bashrc
source ~/.bashrc
```

(Use `~/.zshrc` instead of `~/.bashrc` if you use zsh.) Then:

```bash
sail up -d
sail npm run dev
sail artisan migrate
```

If you use Docker, ensure Docker Desktop has WSL2 integration enabled (on Windows).

1. **Install Composer dependencies** on the host so Sail is available:
   ```bash
   composer install
   ```

2. **Configure for Sail:** copy `.env.example` to `.env`, generate the key, then in `.env` set:
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```
   In `.env`, set the Sail block:
   - `DB_CONNECTION=mysql`
   - `DB_HOST=mariadb`
   - `DB_DATABASE=laravel`
   - `DB_USERNAME=sail`
   - `DB_PASSWORD=password`
   - `REDIS_HOST=redis`  
   Optionally set `WWWGROUP` and `WWWUSER` to your host user/group id (e.g. `id -g` and `id -u`).

3. **Start Sail:**
   ```bash
   ./sail up -d
   ```

4. **First run – run migrations:**
   ```bash
   ./sail artisan migrate
   ```

5. **Open** [http://localhost](http://localhost) (or the port set as `APP_PORT` in `.env`, default 80).

**Rebuild Sail image** (e.g. after changing PHP or Sail):

```bash
./sail build --no-cache
./sail up -d
```

**Artisan inside the container:**

```bash
./sail artisan make:model Game
./sail artisan make:migration create_games_table
./sail artisan migrate
./sail artisan tinker
```

Files created (models, migrations, etc.) are written into your project directory via the mounted volume.
