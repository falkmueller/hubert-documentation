# Routing

Hubert comes with [AltoRouter](https://github.com/dannyvankooten/AltoRouter).

## A Route
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

Every Route must have a unique name, in our example it's _hello_. A route consists of thee parts:
- _"route"_ defines a Uri
- _"method"_ (optional) defines for which request types use this route. Multiple types can be combined using _|_. The default value is _"GET|POST"_.
- _"target"_ defines what happens when the route matches the request

## Route-Matching

Static routes are only executed when they match the request uri exactly:
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

The route "hello" only matches _"/hello"_ but not _"/hello/"_. If there is a slash at the end of the route you can use _"route" => "/hello/"_ to create a matching route or simply use _[/]?_ at the end to optionalise slashes:
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

Routing parameters look as follows:
```php
"mvc" => array(
    "route" => "/[:controller]/[:action]",
    "method" => "GET|POST",
    "target" => function($request, $response, $args){
        echo "Controller: {$args['controller']}, Action: {$args['action']}";
    }
),
```

Optional parameters end with _"?"_
```php
"mvc" => array(
    "route" => "/[:controller]/[:action]?",
    "method" => "GET|POST",
    "target" => function($request, $response, $args){
        echo empty($args["action"]) ? "index"  : $args["action"];
    }
),
```

You can find more about routing at [altorouter.com](http://altorouter.com/)

## Forming urls
```php
$base = hubert()->router->getBasePath();
$url_home = hubert()->router->get("home");
$mvc_url = hubert()->router->get("mvc", ["controller" => "index", "action" => "index"])
```

The router provides the function _getBasePath()_ that returns the base url of the application. Moreover there is the function _get($name, $params = array(), $query = array())_ you can use to form urls to defined routes.
