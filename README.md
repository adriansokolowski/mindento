## Stack
- PHP 8.1
- Laravel 9
- MySQL 8.0

## Setup Project
```bash
./vendor/bin/sail up -d

composer install

cp .env.example .env

php artisan key:generate

php artisan migrate
