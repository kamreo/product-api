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
6. Load fixtures `php bin/console doctrine:fixtures:load`
7. Run local server `symfony server:start`

## API 
App consists of endpoints for two entities Product and ProductOption

Product endpoints:

product_get - get particular product by id (and its options if there are any)
    path: /api/product/{id}
    controller: App\Controller\ProductController::getById
    methods: GET
    
product_get_filtered - gets products and product options by specified filters such as productType, priceFrom, priceTo, sortProperty(by what property you want to sort results) and sortValue(ASC or DESC)
    path: /api/product
    controller: App\Controller\ProductController::filter
    methods: GET

product_create - creates instance of a product, properties needed are: name, price, quantity and type 
    path: /api/product
    methods: POST
    controller: App\Controller\ProductController::create

product_delete - deletes product by id
    path: /api/product/{id}
    methods: DELETE
    controller: App\Controller\ProductController::delete
    
product_update - updates product resource
    path: /api/product
    methods: PUT
    controller: App\Controller\ProductController::update
    
Product option endpoints:

product_option_create - creates product option resource, apart from standard product fields it needs parentId for reference
    path: /api/product_option
    methods: POST
    controller: App\Controller\ProductOptionController::create

product_option_delete - deletes product option by id
    path: /api/product_option/{id}
    methods: DELETE
    controller: App\Controller\ProductOptionController::delete
    
## Tests
Run tests using `php ./vendor/bin/phpunit`

