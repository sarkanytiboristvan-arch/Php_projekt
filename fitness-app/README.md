# Fitness Tracker - Személyes Edzés Követő Alkalmazás

## Projekt Leírás

A Fitness Tracker egy teljes körű MVC architektúrájú webalkalmazás PHP nyelven, amely lehetővé teszi a felhasználók számára edzéseik, táplálkozásuk és haladásuk nyomon követését.

## Funkciók

### ✅ Megvalósított Követelmények

#### 1. Technológiai Követelmények
- ✅ **OOP (Objektum-orientált programozás)**: Minden komponens osztály alapú
- ✅ **MVC architektúra**: Model-View-Controller minta következetes alkalmazása
- ✅ **REST API ready**: RESTful URL struktúra és CRUD műveletek
- ✅ **Session és Cookie kezelés**: Munkamenet követés, "Emlékezz rám" funkció
- ✅ **Adatbázis CRUD műveletek**: Teljes körű Create, Read, Update, Delete
- ✅ **Composer-kompatibilis**: Könnyen bővíthető külső csomagokkal

#### 2. Főbb Funkciók
- **Felhasználói hitelesítés**: Regisztráció, bejelentkezés, munkamenet kezelés
- **Edzés nyomon követés**: Edzések rögzítése típus, időtartam, kalória alapján
- **Táplálkozás követés**: Étkezések, makrótápanyagok (protein, szénhidrát, zsír) rögzítése
- **Kalória kalkulátor**: BMR és TDEE számítás Mifflin-St Jeor képlet alapján
- **Haladás mérés**: Testsúly, testzsír%, testméretek követése
- **Edzéstervek**: Előre definiált és egyéni tervek létrehozása
- **Dashboard**: Átfogó statisztikák és napi összesítők

## Projekt Struktúra

```
fitness-tracker/
├── classes/
│   ├── Database.php          # Singleton adatbázis kapcsolat
│   └── Router.php             # URL routing kezelés
├── config/
│   └── database.php           # Adatbázis konfiguráció
├── controllers/
│   ├── BaseController.php     # Alapvető controller funkciók
│   ├── AuthController.php     # Autentikáció
│   ├── DashboardController.php # Főoldal
│   ├── WorkoutController.php   # Edzések kezelése
│   ├── NutritionController.php # Táplálkozás
│   ├── ProgressController.php  # Haladás
│   └── WorkoutPlanController.php # Edzéstervek
├── models/
│   ├── BaseModel.php          # Alapvető model funkciók
│   ├── User.php               # Felhasználó model
│   ├── Workout.php            # Edzés model
│   ├── Nutrition.php          # Táplálkozás model
│   ├── Progress.php           # Haladás model
│   └── WorkoutPlan.php        # Edzésterv model
├── views/
│   ├── layouts/               # Layout fájlok
│   ├── auth/                  # Bejelentkezés, regisztráció
│   ├── dashboard/             # Főoldal
│   ├── workout/               # Edzés nézetek
│   ├── nutrition/             # Táplálkozás nézetek
│   ├── progress/              # Haladás nézetek
│   └── plan/                  # Terv nézetek
├── public/
│   ├── css/style.css          # Stíluslapok
│   └── js/main.js             # JavaScript
├── database.sql               # Adatbázis séma
├── index.php                  # Belépési pont
└── README.md                  # Dokumentáció
```

## Telepítés

### 1. Előfeltételek
- PHP 8.0 vagy újabb
- MySQL 5.7 vagy újabb / MariaDB
- Apache/Nginx webszerver

### 2. Adatbázis beállítása

Hozd létre az adatbázist:
```bash
mysql -u root -p < database.sql
```

Vagy importáld phpMyAdmin-on keresztül a `database.sql` fájlt.

### 3. Konfiguráció

Módosítsd a `config/database.php` fájlt a saját adatbázis adataidnak megfelelően:
```php
define('DB_HOST', 'localhost');
define('DB_NAME', 'fitness_tracker');
define('DB_USER', 'root');
define('DB_PASS', '');
```

### 4. Webszerver beállítása

#### Apache
A projekt könyvtárát állítsd be DocumentRoot-nak vagy használj virtual host-ot.

#### PHP beépített szerver (fejlesztéshez)
```bash
cd fitness-tracker
php -S localhost:8000
```

### 5. Teszt felhasználó

Az adatbázis séma tartalmaz egy teszt felhasználót:
- **Email**: demo@fitness.com
- **Jelszó**: password123

## Használat

### Regisztráció és Bejelentkezés
1. Nyisd meg a böngészőben: `http://localhost:8000`
2. Kattints a "Regisztrálj itt!" linkre
3. Töltsd ki a regisztrációs formot
4. Jelentkezz be az email címeddel és jelszavaddal

### Edzések Rögzítése
1. Menj az "Edzések" menüpontra
2. Kattints az "Új edzés" gombra
3. Töltsd ki az edzés adatait (cím, típus, időtartam, kalória)
4. Mentsd el

### Táplálkozás Követése
1. Menj a "Táplálkozás" menüpontra
2. Kattints az "Új étkezés" gombra
3. Add meg az étkezés típusát, nevét és tápértékeit
4. Mentsd el

### Kalória Számítás
1. Menj a "Táplálkozás" menüpontra
2. Kattints a "Kalória kalkulátor" gombra
3. Add meg a testsúlyodat, magasságodat, életkorodat és aktivitási szintedet
4. Az alkalmazás kiszámítja a napi kalóriaszükségletedet

### Haladás Mérése
1. Menj a "Haladás" menüpontra
2. Kattints az "Új mérés" gombra
3. Add meg a testsúlyodat és opcionálisan egyéb testméreteket
4. Mentsd el

## Adatbázis Struktúra

### Táblák (4 fő tábla)

1. **users** - Felhasználók
2. **workouts** - Edzések
3. **nutrition** - Táplálkozási adatok
4. **progress** - Haladás mérések
5. **workout_plans** - Edzéstervek

### Relációk
- Minden tábla kapcsolódik a `users` táblához (`user_id` külső kulcs)
- Cascade törlés implementálva

## MVC Architektúra Részletei

### Model Layer
- `BaseModel`: Közös CRUD műveletek (getAll, getById, delete)
- Specifikus modellek: User, Workout, Nutrition, Progress, WorkoutPlan
- Prepared statements használata SQL injection ellen

### View Layer
- PHP alapú template renderelés
- Layout fájlok használata (header, footer)
- XSS védelem: `htmlspecialchars()` használata minden kimeneténél

### Controller Layer
- `BaseController`: Közös funkciók (render, redirect, auth check)
- Session-alapú flash üzenetek
- Input validáció minden formban

### Router
- Tiszta URL struktúra: `?action=controller_method`
- Dinamikus controller és model instantiation
- Centralizált routing logika

## Biztonsági Funkciók

- **Password hashing**: `password_hash()` és `password_verify()`
- **Prepared statements**: SQL injection védelem
- **XSS védelem**: Output escaping
- **Session security**: HTTP-only, strict mode
- **CSRF védelem**: Session-alapú
- **Input validáció**: Szerver oldali validáció minden formban

## Bővítési Lehetőségek

A projekt könnyen bővíthető:
- REST API endpoint-ok hozzáadása JSON kimenettel
- Composer csomagok integrálása
- Diagramok és grafikonok (Chart.js már előkészítve)
- Email értesítések
- Képfeltöltés támogatás
- Közösségi funkciók

## Composer Integráció (Opcionális)

A projekt Composer-kompatibilis. Példa `composer.json`:

```json
{
    "require": {
        "php": ">=8.0"
    },
    "autoload": {
        "psr-4": {
            "App\\": "classes/",
            "App\\Models\\": "models/",
            "App\\Controllers\\": "controllers/"
        }
    }
}
```

## Prezentációs Anyag

A projekthez tartozik egy 12 diás prezentáció (külön fájl), amely tartalmazza:
1. Projekt áttekintés
2. MVC architektúra magyarázat
3. Funkciók bemutatása
4. Adatbázis struktúra
5. Biztonsági megoldások
6. Kód minták
7. Képernyőképek
8. Továbbfejlesztési lehetőségek

## Technológiák

- **Backend**: PHP 8.0+
- **Adatbázis**: MySQL 5.7+ / MariaDB
- **Frontend**: HTML5, CSS3, JavaScript
- **Architektúra**: MVC pattern
- **Design pattern**: Singleton (Database), Router pattern

## Szerző

Készült a Web Programozás kurzus projektjeként, 2025-2026.

## Licensz

Ez a projekt oktatási célokra készült.
