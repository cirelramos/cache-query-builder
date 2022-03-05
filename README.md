# Cache Query Builder for Laravel

[![Software License][ico-license]](LICENSE.md)

## About

The `cache-query-builder` package allows you to increase the performance and low pressure to database request.


## Features

* cache query getting columns and values
* cache sub query / relationship
* set time individual by model
* methods to get and first values from cache
* methods to save, insert, delete to cache

## Installation

Require the `cirelramos/cache-query-builder` package in your `composer.json` and update your dependencies:
```sh
composer require cirelramos/cache-query-builder
```


## Configuration

set provider

```php
'providers' => [
    // ...
    Cirelramos\Cache\ServiceProvider::class,
],
```


The defaults are set in `config/cache-query.php`. Publish the config to copy the file to your own config:
```sh
php artisan vendor:publish --provider="Cirelramos\Cache\ServiceProvider"
```

> **Note:** this is necessary to yo can change default config



## Usage

To cache for query you need use extend Class

```php
class Product extends CacheModel
{
}
```

To cache for query you need use methods: getFromCache or firstCache

```php
        return Product::query()
            ->where('active', ModelConst::ENABLED)
            ->with($relations)
            ->getFromCache(['*'], $tags);
```


if you want purge cache can use methods: saveToCache insertToCache, deleteToCache

```php
            $product = new Product();
            $product->saveToCache();
```

```php
            Product::insertToCache($values);
```

```php
            $product->deleteToCache();
```



## License

Released under the MIT License, see [LICENSE](LICENSE).


[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square

