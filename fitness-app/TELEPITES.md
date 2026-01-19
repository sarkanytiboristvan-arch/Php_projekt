# Fitness Tracker - Telepítési Útmutató

## Gyors Telepítés (5 lépés)

### 1. Fájlok másolása
Töltsd le és csomagold ki a `fitness-tracker.zip` fájlt a webszervered DocumentRoot könyvtárába.

### 2. Adatbázis létrehozása
Importáld a `database.sql` fájlt:

**phpMyAdmin használatával:**
1. Nyisd meg a phpMyAdmin-t
2. Kattints az "Import" fülre
3. Válaszd ki a `database.sql` fájlt
4. Kattints a "Go" gombra

**Parancssorból:**
```bash
mysql -u root -p < database.sql
```

### 3. Konfiguráció beállítása
Szerkeszd a `config/database.php` fájlt:

```php
define('DB_HOST', 'localhost');     // Általában 'localhost'
define('DB_NAME', 'fitness_tracker');
define('DB_USER', 'root');          // Az adatbázis felhasználóneved
define('DB_PASS', '');              // Az adatbázis jelszavad
```

### 4. Fájl jogosultságok (Linux/Mac)
```bash
chmod 755 fitness-tracker
chmod 644 fitness-tracker/*.php
```

### 5. Böngésző megnyitása
Nyisd meg a böngészőben:
```
http://localhost/fitness-tracker
```

## Teszt Felhasználó

Az adatbázis tartalmaz egy teszt felhasználót:
- **Email:** demo@fitness.com
- **Jelszó:** password123

## PHP Követelmények

- PHP 8.0 vagy újabb
- mysqli extension
- mbstring extension
- JSON extension

### Követelmények ellenőrzése
```bash
php -v                    # PHP verzió
php -m | grep mysqli      # mysqli extension
php -m | grep mbstring    # mbstring extension
```

## Webszerver Beállítás

### Apache
1. Engedélyezd a mod_rewrite modult:
```bash
sudo a2enmod rewrite
sudo service apache2 restart
```

2. Virtual host (opcionális):
```apache
<VirtualHost *:80>
    ServerName fitness.local
    DocumentRoot /var/www/html/fitness-tracker
    
    <Directory /var/www/html/fitness-tracker>
        AllowOverride All
        Require all granted
    </Directory>
</VirtualHost>
```

### PHP Beépített Szerver (Fejlesztéshez)
```bash
cd fitness-tracker
php -S localhost:8000
```
Nyisd meg: http://localhost:8000

## Hibaelhárítás

### Nem jelenik meg a weboldal
- Ellenőrizd, hogy a webszerver fut-e
- Nézd meg a PHP hibakeresési logokat

### "Database connection error"
- Ellenőrizd az adatbázis beállításokat a `config/database.php` fájlban
- Bizonyosodj meg róla, hogy a MySQL/MariaDB fut

### "Cannot find module" hiba
- Ez normális, a projekt működik PHP-val
- A Node.js csak a prezentáció generálásához kellett

### Session hibák
- Ellenőrizd, hogy a PHP session könyvtár írható-e
- Állítsd be: `session.save_path` a php.ini-ben

## Ajánlott Beállítások

### php.ini
```ini
session.cookie_httponly = 1
session.use_strict_mode = 1
upload_max_filesize = 10M
post_max_size = 10M
display_errors = Off
log_errors = On
```

## Következő Lépések

1. **Regisztráció**: Hozz létre saját felhasználói fiókot
2. **Első edzés**: Rögzítsd az első edzésedet
3. **Kalória számítás**: Használd a kalória kalkulátort
4. **Haladás követés**: Add meg a jelenlegi súlyodat

## Támogatás

Ha problémád van a telepítéssel:
1. Ellenőrizd a PHP verziódat (minimum 8.0)
2. Nézd meg a webszerver hibakeresési logját
3. Győződj meg róla, hogy az adatbázis fut

## Biztonság Éles Környezetben

Ha éles szerverre telepíted:
1. Változtasd meg az alapértelmezett teszt felhasználó jelszavát
2. Állítsd be az HTTPS-t
3. Engedélyezd a `session.cookie_secure = 1` beállítást
4. Használj erős adatbázis jelszót
5. Tiltsd le a `display_errors`-t a php.ini-ben

## Adatbázis Backup

Készíts rendszeres biztonsági mentéseket:
```bash
mysqldump -u root -p fitness_tracker > backup_$(date +%Y%m%d).sql
```

## Licence

Ez a projekt oktatási célokra készült a Web Programozás kurzus keretében.
