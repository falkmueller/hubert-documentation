#Routing

Für unser Beispiel erstellen wir die Datei "config/routes.global.php":
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

In der Konfiguration wird man über "controller_namespace" den Namespace der Controller an.   
Bei den Routen wird nun als target-Wert keine Funktion (Callable) mehr angegeben, sondern ein Array mit Controller und Action Name.   
Sollte ein Controller einen anderen Namespace haben als der konfigurierte "controller_namespace" kann auch im target-Wert ein "Attrebut "namespace" angegeben werden mit dem abweischenden Namespace.   

## preDispatch
Manchmal möchte man ein Event ausführen, nachdem die Route bestimmt wurde,
aber noch befor die eigendliche Route ausgeführt wird.
Hierfür kann man in der Configuration ein "preDispatch" definieren:
```php
 "factories" => array(
        "preDispatch" => array(src\service\preDispatcher::class, 'get')
    ),
```
Dies kann auch als Array definiert werden, wenn es mehrere preDisptcher gibt.

in dem Beispiel wäre der preDispatch definiert in der Datei "src/service/preDispatcher":
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

im Predispatcher könnte man nun zum Beispiel anhand der Browser-Variablen die Sprache bestimmen, etc.  
Wenn die Funktion eine Rückgabe vom Type Response hat, wird diese Rückgabe ausgegeben und die eigendliche Route gar nicht ausgeführt.
Dies kann man zum Beispiel für ein Rechtemanagment nutzen.

## postDispatch
postDisptach-Funktionen werden nach dem Routing ausgeführt und dienen dazu den Response zu manipulieren.
Hierfür kann man in der Configuration ein "postDispatch" definieren:
```php
 "factories" => array(
        "postDispatch" => array(src\service\postDispatcher::class, 'get')
    ),
```
Dies kann auch als Array definiert werden, wenn es mehrere postDisptcher gibt.

in dem Beispiel wäre der postDispatch definiert in der Datei "src/service/postDispatcher":
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