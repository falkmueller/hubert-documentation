routes.global.php
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
