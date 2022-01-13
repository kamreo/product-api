# product-api
A project for recruitment process

## Prerequisites

* PHP >= 8.0.2
* Composer
* Symfony CLI (used as local server)
* MySQL DB (Personally used XAMPP on Windows)

## Instalation

1. Clone this repository
2. Install dependencies `composer install`
3. Create database `php bin/console doctrine:database:create`
4. Generate migration `php bin/console doctrine:migrations:generate`
5. Run migration `php bin/console doctrine:migrations:migrate`
7. Run local server `symfony server:start`

## API 

## Tests
Run tests using `php ./vendor/bin/phpunit`

