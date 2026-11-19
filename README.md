# Kaon Ta! Davao - Hisu-an's Food Guide

A curated Davao City carinderia and food guide web application built with **Laravel 12**, **Tailwind CSS**, and **SQLite**, created for the Prefinal project.

Developed by **Al Franzianne Hisu-an** (`afdhisu-an@addu.edu.ph`).

---

## 🌟 Features & Highlights

- **Davao City Carinderia Directory**: Browse local dining spots, carinderias, stalls, and grills across key Davao districts (*Poblacion*, *Talomo*, *Agdao*, *Buhangin*, *Toril*, *Tugbok*).
- **Personalized Signature Eatery**: Includes *Carinderia ni Hisu-an* located in *Poblacion*, featuring authentic *Tinolang Manok* (Bestseller), *Kinilaw na Tuna*, and fresh *Durian Shake*, tagged with `Suki ni Hisu-an`.
- **Davao Business Permits**: Every eatery records its Davao City business permit (`DVO-YYYY-NNNN`), expiry tracking, and alert indicators (`Permit expired` in red when past expiry).
- **Community Reviews & Ratings**: Davao residents share authentic reviews and star ratings. If an eatery is closed, reviews are automatically paused and unauthorized submissions return HTTP 403 Forbidden.
- **District Explorer**: View eateries grouped by district with aggregated counts (`N reviews in [District name]`) via `hasManyThrough` relationships without N+1 query overhead.
- **Search & Multi-Filter**: Filter eateries by search term (`?q=`), district (`?district=`), and specialty feature tags (`?feature=`), with pagination that retains query parameters.
- **Festive Carinderia Theme**: Celebratory fiesta color scheme with Filipino banderitas and authentic Davao street addresses.

---

## 🛠️ Tech Stack & Requirements

- **PHP**: 8.2+ (Developed on PHP 8.5)
- **Framework**: Laravel 12
- **Database**: SQLite
- **Frontend**: Blade components, Tailwind CSS v3, and Vite
- **Testing**: PHPUnit / Feature tests

---

## 🚀 Installation & Local Setup

1. **Clone the repository**:
   ```bash
   git clone https://github.com/BrnToLrn/PrefinalProject-Hisu-an-KaonTaDavao.git
   cd PrefinalProject-Hisu-an-KaonTaDavao
   ```

2. **Install PHP and Node dependencies**:
   ```bash
   composer install
   npm install
   ```

3. **Configure Environment**:
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Run Migrations and Seeders**:
   ```bash
   touch database/database.sqlite
   php artisan migrate:fresh --seed
   ```

   *Seeders will populate:*
   - **6 Districts**: *Poblacion*, *Talomo*, *Agdao*, *Buhangin*, *Toril*, *Tugbok*
   - **6 Feature Tags**: `Suki ni Hisu-an`, `Budget Meal`, `Halal`, `Open 24 Hours`, `Aircon`, `Free Wi-Fi`
   - **12 Users**: `Al Franzianne Hisu-an` (`hisu-an@kaonta.test`), `Tita Hisu-an` (`tita.hisu-an@kaonta.test`), plus 10 community users
   - **15 Eateries**: Hand-made *Carinderia ni Hisu-an* + 14 realistic Davao eateries (with exactly 3 closed)
   - **15 Business Permits**: Fully linked through `hasOne` relationships
   - **Menu Dishes & Reviews**: Dishes seeded via `DishSeeder` and reviews seeded via `ReviewSeeder`

5. **Build Frontend Assets**:
   ```bash
   npm run build
   ```

6. **Start the Local Development Server**:
   ```bash
   php artisan serve
   ```
   Visit `http://127.0.0.1:8000` in your web browser.

---

## 🧪 Running Tests & Quality Check

Run the feature test suite:
```bash
php artisan test
```

Run code formatting check via Laravel Pint:
```bash
vendor/bin/pint --test
```

---

## 📜 License

This project was built for educational purposes for the Prefinal examination. Open-sourced software licensed under the [MIT license](LICENSE).
