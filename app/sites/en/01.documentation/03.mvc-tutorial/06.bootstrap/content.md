# Bootstrap

Botstrap classes can be used to initialise code before and after the initialisation of the whole application. This is useful if you maybe want to pass the username from the session globally to the templates. To use a bootstrap class you have to define it in the configuration. In this case we add it in _config/general.global.php_:
```php
<?php
return array( 
    "config" => array(
        "bootstrap" => src\bootstrap::class,
    ),
);
```

If there are multiple bootstrap classes you can also define them using an array. The final bootstrap class would be located at _src\bootstrap.php_:
```php
<?php

namespace src;

class bootstrap extends \hubert\generic\bootstrap {
    
    public function init(){
        //if you use the template engine, you can set shared data for all templates here
        hubert()->template->addData(array("name" => "ronny"));
    }

    public function preDispatch(){
        //access to current route using hubert()->current_route
        //routing ends here if function returns an object of type response
    }

    public function postDispatch($response){
        //response after route ist dispatched can be manipulated here
    }

```

Bootstrap classes inherit _\hubert\generic\bootstrap_. Otherwise you have to implement the interface _hubert\interfaces\bootstrap_ by yourself. The init function of a bootstrap class is executed before routing. PreDispatch functions are executed after getting the current route but before the final dispatch event. If the preDispatch returns an object of type "response" the routing will be stopped. The postDispatch function is called after route execution and serves to manipulate the response.
