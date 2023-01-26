# PHP service

### Core packages:

* https://github.com/sebastianbergmann/phpunit
* https://github.com/nikic/FastRoute
* https://symfony.com/doc/current/components/http_foundation.html
* https://github.com/illuminate/validation
  * https://github.com/laravel/laravel/blob/master/resources/lang/en/validation.php
* https://github.com/vlucas/phpdotenv
* https://github.com/filp/whoops
* https://github.com/Seldaek/monolog

### Packages:

* https://github.com/guzzle/guzzle
  * http://docs.guzzlephp.org/en/stable/index.html


### Install:

```
docker network create listing-gateway
docker-compose up
docker-compose exec php-listing-gateway composer install

### Test:

```
docker-compose exec php-listing-gateway ./vendor/bin/phpunit
```
