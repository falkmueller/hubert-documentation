# PSR-7

Wie Ihr in den Routes gesehen habt, bekommen deren Ziel-Funktionen die Variablen _$request_ und _$response_ übergeben:
```php
"mvc" => array(
   "route" => "/[:controller]/[:action]",
   "method" => "GET|POST",
   "target" => function($request, $response, $args){
        echo "Controller: {$args['controller']}, Action: {$args['action']}";
    }
),
```

Dies sind standardisierte Objekte nach [PSR-7](http://www.php-fig.org/psr/psr-7/) Standard. Hubert verwendet hierbei die PSR-7 Implementation von [Zend](https://zendframework.github.io/zend-diactoros/). Hier ein kleines Beispiel zur Verwendung.

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
Ruft man zum Beispiel die Url _/test?name=hubert_ auf, gibt diese Route _"Get Params: Array("name" => "hubert")"_ zurück. Hubert erwartet standardmäßig von jeder Route ein PSR-7 Response-Objekt zurück. Dieses wird dann ausgegeben. Aus Kompatiblitätsgründen können Routen aber auch gar nichts oder aber auch einen String zurückgeben. Die Server-Anfrage steht auch global über _hubert()->request_ zur verfügung.

