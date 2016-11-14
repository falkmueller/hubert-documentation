# controller

a example for a controller-file "src/controller/indexController":
```php
<?php

namespace src\controller;

class indexController extends \hubert\generic\controller {
    
    public function indexAction($params){
        return $this->responseTemplate("index/index", ["name" => "Hubert"]);
    }
    
    public function apiAction(){
        $data = ["users" => ["Falk", "Ronny"]];
        return $this->responseJson($data);
    }

    public function redirectAction(){
        $home_route = $this->getContainer()["router"]->get("home");
        return $this->responseRedirect($home_route);
    }
}
```

## Routing to controller

First, define the default controllernamespace.
Add the following line to your configuration:
```php
 "controller_namespace" => "src\\controller"
```

In the basic examle, the file config/general.global.php
```php
<?php
return array( 
   "config" => array(
       "bootstrap" => src\bootstrap::class,
        "controller_namespace" => "src\\controller",
       "display_errors" => true, 
    ),
);
```

Now, you can change de route definition
```php
...
        "routes" => array(
            "home" => array(
                "route" => "/", 
                "method" => "GET|POST", 
                "target" => array("controller" => "index", "action" => "index")
            ),
...
```
If the target not container a Action-Value, then it is "index" as default.


If a controller have a other namespace, then you can set this in the target-value:
```php
...
        "routes" => array(
            "home" => array(
                "route" => "/test", 
                "method" => "GET|POST", 
                "target" => array("namespace" => "test\\controller", "controller" => "index", "action" => "index")
            ),
...
```

you can also define the Action or controller-Name as route-Param:
```php
...
        "routes" => array(
            "route1" => array(
                "route" => "/test/[:action]", 
                "method" => "GET|POST", 
                "target" => array("controller" => "index", "action" => "index")
            ),
        "route2" => array(
                "route" => "/[:controller]/[:action]", 
                "method" => "GET|POST", 
                "target" => array("controller" => "index", "action" => "index")
            ),
...
```
The defined Controller and action-names in the target are default-values.
