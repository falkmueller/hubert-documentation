# Bootstrap

Bootstrap classes containes function, wich been called befor and after routing.
it is helpful, for example, if you would set varibales from session in template-variable-Scope ( language, username, ...).

Add the following line to your configuration:
```php
"display_errors" => true
```

In the basic examle, the file config/general.global.php
```php
<?php
return array( 
   "config" => array(
       "bootstrap" => src\bootstrap::class,
       "display_errors" => true, 
    ),
);
```

The bootstrap-configuration can afso bea array with multible classes. (is usefull vor extensions, that not implement a container)
The bootstrap class must be implements the interface "\hubert\interfaces\bootstrap".    
Use kann use the abstract "\hubert\generic\bootstrap", witch containes the implementation.

Example for "src\bootstrap.php":
```php
<?php

namespace src;

class bootstrap extends \hubert\generic\bootstrap {
    
    public function init(){
        //For example, if you use the template engine, you can here set shared data vor all Templates
        //$this->_container["template"]->addData(array("name" => "ronny"));
    }

    public function postDispatch($response){
        //here you can manipulate the response after route ist dirpatched
    }
```


