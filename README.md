# Sirkus Media - back-end
CMS for Sirkus Media's website

## Install

1. `composer install`
2. `cp .env.example .env`
3. Fill in your information in .env
4. `php artisan migrate --seed`
5. `php artisan key:generate`
7. `npm install`

## Develop
1. `php artisan serve`
2. `npm run watch`

You need to put this in the top of your `routes/api.php` file if you are going to be working on the front-end repository.
```php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
```

## Contributions
The master branch is protected. Create your own branch and start a pull request when you want to merge.
