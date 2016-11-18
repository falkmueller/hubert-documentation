#Routing

Für unser Beispiel erstellen wir die Datei _config/routes.global.php_:
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

In der Konfiguration gibt man über _"controller\_namespace"_ den Namespace der Controller an. Bei den Routen wird nun als target-Wert keine Funktion (Callable) mehr angegeben, sondern ein Array mit Controller und Action Name. Sollte ein Controller einen anderen Namespace als den konfigurierten _"controller\_namespace"_ haben, kann auch im target-Wert ein Attribut _"namespace"_ mit dem abweichenden Namespace angegeben werden.

## preDispatch
Manchmal möchte man ein Event ausführen, nachdem die Route bestimmt wurde, aber noch bevor die eigentliche Route ausgeführt wird. Hierfür kann man in der Konfiguration ein _"preDispatch"_ definieren:

```php
"factories" => array(
    "preDispatch" => array(src\service\preDispatcher::class, 'get')
),
```

Dies kann auch als Array definiert werden, wenn es mehrere preDisptcher gibt. In diesem Beispiel wäre der preDispatch in der Datei _src/service/preDispatcher.php_ definiert:
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

Im preDispatcher könnte man nun zum Beispiel anhand der Browser-Variablen die Sprache bestimmen. Wenn die Funktion eine Rückgabe vom Typ "Response" hat, wird diese Rückgabe ausgegeben und die eigentliche Route nicht ausgeführt. Dies kann man beispielsweise für Rechtemanagment nutzen.

## postDispatch
postDisptach Funktionen werden nach dem Routing ausgeführt und dienen dazu, den Response zu manipulieren. Hierfür kann man in der Konfiguration ein _"postDispatch"_ definieren:

```php
"factories" => array(
    "postDispatch" => array(src\service\postDispatcher::class, 'get')
),
```

Dies kann auch als Array definiert werden, wenn es mehrere postDisptcher gibt. Im folgenden Beispiel wäre der postDispatch in der Datei _src/service/postDispatcher.php_ definiert:
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