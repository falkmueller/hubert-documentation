# PSR-7

wie Ihr in den Routes gesehen habt, bekommen deren Ziel-Funktionen die Variablen _$request_ und _$response_ übergeben:
```php
            "mvc" => array(
               "route" => "/[:controller]/[:action]", 
               "method" => "GET|POST", 
               "target" => function($request, $response, $args){
                echo "Controller: {$args['controller']}, Action: {$args['action']}";
            }
           ),
```

Dies sind Standardisierte Objekte nach den [PSR-7](http://www.php-fig.org/psr/psr-7/) Standard. Hubert verwendet hierbei die PSR-7 implementation von [Zend](https://zendframework.github.io/zend-diactoros/).

Hier ein kleies Beispiel zur verwendung.
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
Ruft man zum Beispiel _"/test?name=hubert"_ auf gibt diese Route _"Get Params: Array("name" => "hubert")"_ zurück.

Hubert erwartet standardmäßig von jeder Route einen PSR-7 Response-Objekt zurück. Dieses wird dann ausgegeben. Aus kompatiblitätsgründen können Routen aber auch gar nichts zurückgeben oder zum einen String.

Die Server-Anfrage steht auch global über _hubert()->request_ zur verfügung.

