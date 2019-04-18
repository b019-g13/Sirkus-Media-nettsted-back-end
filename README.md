# Sirkus Media - back-end

CMS for Sirkus Media's website

## Install

1. `composer install`
2. `cp .env.example .env`
3. Fill in your information in .env
4. `php artisan migrate --seed`
5. `php artisan key:generate`
6. `php artisan storage:link`
7. `npm install`

## Develop

1. `php artisan serve`
2. `npm run watch`

## Contributions

The master branch is protected. Create your own branch and start a pull request when you want to merge.
