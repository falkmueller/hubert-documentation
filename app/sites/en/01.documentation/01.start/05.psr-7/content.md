# PSR-7

As you have learned in the routes section thier target functions get the _$request_ and _$response_ variables returned
```php
"mvc" => array(
   "route" => "/[:controller]/[:action]",
   "method" => "GET|POST",
   "target" => function($request, $response, $args){
        echo "Controller: {$args['controller']}, Action: {$args['action']}";
    }
),
```

These are [PSR-7](http://www.php-fig.org/psr/psr-7/) standardized objects. Hubert uses the PSR-7 Implementation from [Zend](https://zendframework.github.io/zend-diactoros/).This is a short example on how to use it.

```php
"test" => array(
    "route" => "/test",
    "method" => "GET|POST",
    "target" => function($request, $response, $args){
        $get_params = $request->getQueryParams();
        $html = "Get Params: ".print_r($get_params, true);
        $response->getBody()->write($html);
        return $response;
    }
),
```
For instance if you call the url _/test?name=hubert_ the route returns _"Get Params: Array("name" => "hubert")"_. Hubert expects a PSR-7 object from every route by default. For compatibility reasons routes can also return strings or even nothing. The server request is globally available using _hubert()->request_.

