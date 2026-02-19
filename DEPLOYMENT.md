# Deployment

## 505 / 502 with no errors in logs

If you see a **505** or **502** and nothing appears in Laravel Cloud logs, the request is often failing before Laravel runs (PHP crash, OOM, or proxy). Try:

1. **Health check** – Open `https://your-app-url/up` in the browser. If this returns `OK`, the app boots and the problem is likely on a specific route (e.g. homepage); if this also fails, the app or PHP is crashing before any route runs.
2. **Env** – In Laravel Cloud → Environment, confirm `APP_KEY` is set (run `php artisan key:generate --show` locally and paste the value). Missing `APP_KEY` can cause early failures.
3. **Stack traces** – This repo has `includeStacktraces` enabled for the `stderr` log channel so Laravel Cloud can show full exception traces. Redeploy and trigger the error again, then check the logs.
4. **Resources** – If the instance is small (e.g. 256MB RAM), try a larger size; 502/505 can be from the app being killed (OOM) before it can log.

## /up works but no application is displaying (blank page)

If the health check (`/up`) says the app is up but the rest of the site is blank or doesn’t load, **the most common cause is a missing `APP_KEY`**.

Laravel needs `APP_KEY` for sessions, cookies, CSRF, and encryption. Without it, pages can fail silently or show nothing.

**Fix:**

1. **Get your key** – Locally in the project run:
   ```bash
   php artisan key:generate --show
   ```
   Copy the full line (e.g. `base64:xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx=`).

2. **Set it on Laravel Cloud** – In the Laravel Cloud dashboard: your project → **Environment** (or **General** / deploy settings) → add or edit **`APP_KEY`** and paste that value.

3. **Redeploy** – Save the environment, then trigger a new deploy (Laravel Cloud usually needs a redeploy for env changes to apply). After that, the site should load.

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
