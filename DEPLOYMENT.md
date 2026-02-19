# Deployment

## Required environment variables

In your host’s **deploy / environment** settings, set at least:

- **`APP_ENV=production`**
- **`APP_KEY`** – run `php artisan key:generate --show` and paste the value (or use the same key as in your `.env`).
- **`APP_DEBUG=false`**
- **`APP_URL`** – your live URL (e.g. `https://your-app.example.com`).
- **`IGDB_CLIENT_ID`** and **`IGDB_CLIENT_SECRET`** – your IGDB API credentials.

## Why the “database does not exist” error happened

The app was using **database** for cache and sessions. On the server there was no database (no SQLite file and no MySQL/Postgres configured), so the first request failed when it tried to read the cache.

The project is now set up so that when **`APP_ENV=production`**:

- **Cache** defaults to **file** (no database needed).
- **Sessions** default to **file** (no database needed).

So with only the variables above set, the app can run without a database. You do **not** need to set `CACHE_STORE` or `SESSION_DRIVER` unless you want something different (e.g. Redis).

## Optional: use a real database

If you add a MySQL/Postgres (or similar) database on your host, set:

- `DB_CONNECTION=mysql` (or `pgsql`, `mariadb`)
- `DB_HOST=...`
- `DB_PORT=...`
- `DB_DATABASE=...`
- `DB_USERNAME=...`
- `DB_PASSWORD=...`

Then run migrations in your deploy/build (e.g. `php artisan migrate --force`). You can then set `CACHE_STORE=database` and `SESSION_DRIVER=database` if you prefer.

## Optional: use SQLite on the server

If your host gives you a persistent disk and you want SQLite:

1. In deploy env, set: `DB_CONNECTION=sqlite` and leave other `DB_*` unset (or set `DB_DATABASE` to the path of the SQLite file).
2. In a **deploy or build hook**, create the file and run migrations, for example:
   - `touch database/database.sqlite`
   - `php artisan migrate --force`
3. Cache and session will still use **file** by default in production, so they won’t depend on SQLite.
