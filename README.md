# Cache Query Builder for Laravel

[![Software License][ico-license]](LICENSE.md)

## About

The `cache-query-builder` package allows you to increase the performance and low pressure to database request.

##### [Tutorial how create composer package](https://cirelramos.blogspot.com/2022/04/how-create-composer-package.html)

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
    Cirelramos\Cache\Providers\ServiceProvider::class,
],
```


The defaults are set in `config/cache-query.php`. Publish the config to copy the file to your own config:
```sh
php artisan vendor:publish --provider="Cirelramos\Cache\Providers\ServiceProvider"
```

> **Note:** this is necessary to yo can change default config



## Usage

To cache for query you need use extend Class

```php
class Product extends CacheModel
{
    //custom name tag cache by model
    public const TAG_CACHE_MODEL = 'TAG_CACHE_PRODUCT_';
    // custom time cache by model
    public const TIME_CACHE_MODEL = ModelConst::CACHE_TIME_DAY;
}
```

To cache for query you need use methods: getFromCache or firstCache

```php
    public function index(Request $request)
    {
        $relations = ['prices'];
        $tags = Product::TAG_CACHE_MODEL;
        $products = Product::query()
            ->where('name','like','%'.$request->name.'%')
            ->with($relations)
            ->getFromCache(['*'], $tags);

        $code = 200;
        $message = '';
        $data = ['products' => $products];
        return response()->json(['code' => $code, 'message' => $message, 'data' => $data], $code);
    }
```


if you want purge cache can use methods: saveWithCache, insertWithCache, deleteWithCache

```php
            $product = new Product();
            $product->saveWithCache();
```

```php
            Product::insertWithCache($values);
```

```php
            $product->deleteWithCache();
```

cache to method of controller, this use increase a lot your application performance
```php
    public function index(Request $request)
    {
        //this key is important!!, you cant add more values to differentiate cache or parameter request to method
        $customKey = "global_active_products_".$request->name;
        $dataCache = GetCacheService::execute($customKey);
        if (empty($dataCache) === false) {
            return $dataCache;
        }
    
        $products = Product::where('name','like','%'.$request->name.'%')->get();
    
        $code = 200;
        $message = '';
        $data = ['products' => $products];
        $response = response()->json(['code' => $code, 'message' => $message, 'data' => $data], $code);
    
        SetCacheService::execute($customKey, $response, [], ModelConst::CACHE_TIME_THIRTY_MINUTES);
    
        return $response;
    }
```



## License

Released under the MIT License, see [LICENSE](LICENSE).


[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square

