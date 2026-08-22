# Ceylon Aroma — Deployment Guide

## Server Requirements
- PHP 8.2+
- MySQL 5.7+ / MariaDB 10.3+
- mod_rewrite enabled
- Composer
- Node.js + npm (for asset build)

## Step-by-Step Deployment

### 1. Upload all files to server
Upload the entire project to your hosting root (e.g. `/home/procare/ceylon_aroma/`).
The `public/` folder maps to public_html or your domain's document root.

Set `.htaccess` on document root to point to `public/`:
```
RewriteEngine On
RewriteCond %{REQUEST_URI} !^/public/
RewriteRule ^(.*)$ /public/$1 [L]
```
OR — symlink/alias document root directly to `public/`.

### 2. Configure environment
```
cp .env.example .env
# Edit .env with your DB credentials, APP_URL, MAIL settings
nano .env
```

### 3. Install dependencies
```bash
composer install --no-dev --optimize-autoloader
npm install
npm run build
```

### 4. Run migrations & seed
```bash
php artisan key:generate
php artisan migrate
php artisan db:seed
```

### 5. Storage symlink
```bash
php artisan storage:link
```

### 6. Set permissions
```bash
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
```

### 7. Optimize (production)
```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

## Admin Panel
URL: `https://yourdomain.com/admin`  
Default login: see ADMIN_EMAIL / ADMIN_PASSWORD in your `.env`

## Staging (procare.lk)
- Upload to: FTP `213.165.241.225` (user: procare)
- Document root: `/public_html/`
- Set APP_URL=https://procare.lk in `.env`

## Production (ceylonaroma.com)
Same steps, update APP_URL=https://ceylonaroma.com
