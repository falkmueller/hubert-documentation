# Routing

Als Standardrouter bringt hubert den [AltoRouter](https://github.com/dannyvankooten/AltoRouter) mit.

## Eine Route
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

Jede Route musss einen eindeutigen Namen haben, Im Beispiel ist dies _hello_. Eine Route kann aus drei Bestandteilen bestehen:
- _"route"_ definiert die Uri
- _"method"_ (optional) definiert, für welche Request-Typen die Route gilt. Es können mehrere Typen per _|_ kombiniert angegeben werden. Der Standardwert ist _"GET|POST"_
- _"target"_ definiert, was passieren soll, wenn die Route auf den Request zutrifft

## Route-Matching

Feste Routen werden nur ausgeführt, wenn diese exakt auf die Request Uri zutreffen:
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

Die Route "hello" trifft nur auf _"/hello"_ zu, nicht auf _"/hello/"_. Mann könnte _"route" => "/hello/"_ verwenden, damit die Route zutrifft, wenn ein Slash am Ende steht, oder über _[/]?_ am Ende der Route den letzten Slash optionalisieren:
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

Parameter in der Route sehen wie folgt aus:
```php
"mvc" => array(
    "route" => "/[:controller]/[:action]",
    "method" => "GET|POST",
    "target" => function($request, $response, $args){
        echo "Controller: {$args['controller']}, Action: {$args['action']}";
    }
),
```

Optionale Parameter enden auf _"?"_
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

Der Router bietet die Funktion _getBasePath()_, welche die Basis-Url der Anwendung liefert. Des Weiteren gibt es die Funktion _get($name, $params = array(), $query = array())_, über welche man Urls zu definierten Routen bilden kann.
