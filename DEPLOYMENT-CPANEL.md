# cPanel Deployment Guide – Laravel at public_html Root

Deploy your Laravel app so that:
- All project files live under `public_html`
- The web root behaves as if it's Laravel's `public` folder (via `.htaccess`)

---

## Final Structure

```
/home/YOUR_CPANEL_USER/
  public_html/
    .htaccess          ← Routes all requests to public/
    app/
    bootstrap/
    config/
    database/
    public/            ← Laravel's public folder (index.php, assets)
    resources/
    routes/
    storage/
    vendor/
    .env
    ...
```

---

## Step 1: Clone the Repository

In **cPanel Terminal** or via **SSH**:

```bash
cd ~
git clone https://github.com/YOUR_USERNAME/YOUR_REPO_NAME.git public_html_temp
```

Replace with your actual Git repository URL.

---

## Step 2: Move Files into public_html

```bash
# Remove any default files in public_html (index.html, etc.)
rm -rf ~/public_html/*

# Move everything from the clone into public_html
mv ~/public_html_temp/* ~/public_html/
mv ~/public_html_temp/.[!.]* ~/public_html/ 2>/dev/null || true

# Remove the empty temp folder
rmdir ~/public_html_temp 2>/dev/null || true
```

---

## Step 3: Create the Root .htaccess

Create or overwrite `~/public_html/.htaccess` with this content.  
This makes all requests go through Laravel's `public` folder:

```apache
<IfModule mod_rewrite.c>
    RewriteEngine On

    # Route all requests to Laravel's public folder
    RewriteCond %{REQUEST_URI} !^/public/
    RewriteRule ^(.*)$ public/$1 [L,QSA]
</IfModule>
```

**What it does:**
- `/` → `public/` (DirectoryIndex serves `public/index.php`)
- `/css/app.css` → `public/css/app.css`
- `/tours/my-tour` → `public/tours/my-tour` → `public/.htaccess` sends to `index.php`

---

## Step 4: Set Up .env

```bash
cd ~/public_html

# Create .env if it doesn't exist
cp .env.example .env

# Generate application key
php artisan key:generate
```

Edit `.env` for production:

- `APP_ENV=production`
- `APP_DEBUG=false`
- `APP_URL=https://albaniatravelbysonilakosta.com` (your domain)
- `DB_*` – your cPanel database credentials

---

## Step 5: Create the Database in cPanel

1. **MySQL Databases**
2. **Create New Database** (e.g. `cpanel_user_tours`)
3. **Create MySQL User** (username + password)
4. **Add User to Database** → All Privileges
5. Add to `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=cpanel_user_tours
DB_USERNAME=cpanel_user_dbuser
DB_PASSWORD=your_password
```

---

## Step 6: Install Dependencies & Run Migrations

```bash
cd ~/public_html

# Install PHP dependencies (no dev packages)
composer install --optimize-autoloader --no-dev

# Run migrations
php artisan migrate --force

# Create storage link
php artisan storage:link

# Build frontend assets (if you use npm)
npm ci --omit=dev
npm run build
```

---

## Step 7: Fix Permissions

```bash
chmod -R 755 ~/public_html/storage ~/public_html/bootstrap/cache
chown -R $USER:$USER ~/public_html/storage ~/public_html/bootstrap/cache
```

---

## Step 8: Cache Config & Routes

```bash
cd ~/public_html

php artisan config:cache
php artisan route:cache
php artisan view:cache
```

---

## Step 9: Point Domain to public_html

1. **cPanel → Domains** (or Addon Domains)
2. Confirm the domain points to `public_html`
3. For addon domains, set Document Root to `public_html` (or `public_html` as the main directory)

---

## Future Updates (Git Pull)

```bash
cd ~/public_html
git pull origin main

composer install --optimize-autoloader --no-dev
npm ci --omit=dev && npm run build

php artisan migrate --force
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

---

## Troubleshooting

| Issue | Fix |
|-------|-----|
| **500 Error** | Check `storage/logs/laravel.log`; ensure `storage` and `bootstrap/cache` are writable |
| **404 on all routes** | Confirm `mod_rewrite` is enabled; verify root `.htaccess` content |
| **CSS/JS not loading** | Run `npm run build`; ensure `public/build/` exists; clear browser cache |
| **Database connection error** | Check `.env` DB_*; cPanel DB host is usually `localhost` |
| **APP_KEY error** | Run `php artisan key:generate` |

---

## Quick Reference – Root .htaccess

Save as `public_html/.htaccess`:

```apache
<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteCond %{REQUEST_URI} !^/public/
    RewriteRule ^(.*)$ public/$1 [L,QSA]
</IfModule>
```
