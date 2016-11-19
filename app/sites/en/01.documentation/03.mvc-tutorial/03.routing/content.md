#Routing

As an example we create the file _config/routes.global.php_:
```php
<?php return array(
    
    "config" => array(
        "controller_namespace" => "src\\controller",
    ),
    
    "routes" => array(
        "home" => array(
           "route" => "/",
           "method" => "GET|POST",
           "target" => array("controller" => "index", "action" => "index")
        ),
        "api" => array(
           "route" => "/api",
           "method" => "GET|POST",
           "target" => array("controller" => "index", "action" => "api")
        ),
        "controller" => array(
           "route" => "/[:controller][/]?",
           "method" => "GET|POST",
           "target" => array("controller" => "index", "action" => "index")
        ),
        "mvc" => array(
           "route" => "/[:controller]/[:action][/]?",
           "method" => "GET|POST",
           "target" => array("controller" => "index", "action" => "index")
        ),
    )

);
```

In the configuration you set a controllers namespace using _"controller\_namespace"_. In the routes section you then don't assign a function (callable) as target but you can assign an array containing controller and action name. If a controller has another namespace than the configured _"controller\_namespace"_ you can also define an attribute _"namespace"_ with the deviating namespace at the target value.

## preDispatch
Sometimes you want to call an event after a route has been matched but just before it is executed. Therefore you can define a _"preDispatch"_ function in the configuration:

```php
"factories" => array(
    "preDispatch" => array(src\service\preDispatcher::class, 'get')
),
```

It can also be defined as an array if there are more than one preDispatcher. In this case the preDispatcher would be defined in _src/service/preDispatcher.php_:
```php
<?php

namespace src\service;

class preDispatcher {
    
    public static function get($container){
        return array(new static(), 'preDispatch');
    }
    
    public function preDispatch(){
        //do something
    }

}
```

For instance at the preDispatcher you can define the language by the browser variables. If the function has a return of type "response" this return but not the route is emitted. You could use that for instance to implement some kind of rights management.

## postDispatch
PostDispatch functions are executed right after the routing and serve as an option to manipulate the response. Therefore you simply define a _"postDispatch"_ in the configuration:

```php
"factories" => array(
    "postDispatch" => array(src\service\postDispatcher::class, 'get')
),
```

This can also be defined as an array if there are more than one preDispatcher. In this case the preDispatcher would be defined in _src/service/postDispatcher.php_:
```php
<?php

namespace src\service;

class postDispatcher {
    
    public static function get($container){
        return array(new static(), 'postDispatch');
    }
    
    public function postDispatch($response){
        //do something
    }

}
```