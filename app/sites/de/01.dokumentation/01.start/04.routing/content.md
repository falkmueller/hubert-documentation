# Routing

Als Standard-Router bring hubert den [altorouter](https://github.com/dannyvankooten/AltoRouter) mit.

## eine Route


```php
$config = array(
    "routes" => array(
        "hello" => array(
            "route" => "/hello[/]", 
            "method" => "GET"
            "target" => function($request, $response, $args){
                echo "Hello-Route";
            }
        )
    )
);
```

Jede Route musss einen eindeutigen namen haben, Im Beispiel ist dies "hello".
eine Route kann aus drei Bestandteilen bestehen:
- **route**: definiert die Uri
- **method**: (optional) Definiert für welche Request-Typen die Route gilt. Es können mehrere Typen per "|" kombiniert angegeben werden. der Standardwert ist "GET|POST"
- **target**: definiert, was passieren soll, wenn die Route auf den Request zutrifft. 


## Route-Matching

Feste Routen werden nur ausgeführt, wenn diese exakt auf die Request Uri zutrifft.
```php
$config = array(
    "routes" => array(
        "home" => array(
            "route" => "/", 
            "target" => function($request, $response, $args){
                echo "Hello World";
            }
        ),
        "hello" => array(
            "route" => "/hello", 
            "target" => function($request, $response, $args){
                echo "Hello-Route";
            }
        )
    )
);
```

die Route "hello" trifft nur auf "/hello" zu, nicht auf "/hello/".
Mann könnte '"route" => "/hello/"' verwenden, damit die Route zutrifft, wenn ein Slash am ende steht,
oder über "[/]?" am Ende der Route das letzte Slash optional machen: 

```php
$config = array(
    "routes" => array(
        "hello" => array(
            "route" => "/hello[/]?", 
            "target" => function($request, $response, $args){
                echo "Hello-Route";
            }
        )
    )
);
```

Parameter in der Route sehen wie folt aus.
```php
            "mvc" => array(
               "route" => "/[:controller]/[:action]", 
               "method" => "GET|POST", 
               "target" => function($request, $response, $args){
                echo "Controller: {$args['controller']}, Action: {$args['action']}";
            }
           ),
```

Optionale Parameter enden auf "?"
```php
            "mvc" => array(
               "route" => "/[:controller]/[:action]?", 
               "method" => "GET|POST", 
               "target" => function($request, $response, $args){
                    echo empty($args["action"]) ? "index"  : $args["action"];
            }
           ),
```

Weitere Informationen findest du auf [altorouter.com](http://altorouter.com/)

## Urls bilden
```php
$base = hubert()->router->getBasePath();
$url_home = hubert()->router->get("home");
$mvc_url = hubert()->router->get("mvc", ["controller" => "index", "action" => "index"])
```

Der Router hat die Function "getBasePath()", welche einen die Basis-Ulr der Anwendung liefert.
Des weiteren gibt es die Funktion "get($name, $params = array(), $query = array())", über welche man Urls zu fefinieren Routen bilden kann.
