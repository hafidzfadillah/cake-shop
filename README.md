# Cake Shop Project

A web-based cake shop management system built with Laravel.

## Prerequisites

Before you begin, ensure you have met the following requirements:
* PHP >= 8.1
* Composer
* Node.js and NPM
* Git
* MySQL/MariaDB

## Installation

1. Clone the repository
```
git clone https://github.com/hafidzfadillah/cake-shop.git
cd cake-shop
```

2. Install PHP Dependencies
```
composer install
```

3. Install NPM dependencies (download https://nodejs.org/en)
```
npm install
```

4. Env Setup (private)
5. DB Setup (private)
6. Run Migration
```
php artisan migrate
```

7. Optional: Populate database & storage setup
```
php artisan db:seed
php artisan storage:link
```

8. Start development server
```
php artisan serve
```

9. Build asset
```
npm run dev
```
