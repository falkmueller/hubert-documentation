# Simple example

at first, require the composer autoloader
```php
require 'vendor/autoload.php'
```

than crate a instance of the app class
```php
$app = new hubert\app();
```

now define the route and what been happen
```php
$config = array(
    "routes" => array(
        "home" => array(
            "route" => "/", 
            "target" => function($request, $response, $args){
                echo "Hello World";
            }
        )
    )
);
```

at the end, load the configuraion in the app, execute the app by the "run"-command and emit the response
```php
$app->emit($app->run());
```

the code of the complede example

```php
<?php

require 'vendor/autoload.php';

$app = new hubert\app();

$config = array(
    "routes" => array(
        "home" => array(
            "route" => "/", 
            "target" => function($request, $response, $args){
                echo "Hello World";
            }
        )
    )
);

$app->loadConfig($config);
$app->emit($app->run());
```
### Serverconfiguration

your server must be configurate to route all requests to this index.php file.
For Apache, you create a .htaccess
```rouge
RewriteEngine on
RewriteCond %{REQUEST_FILENAME} !-d
RewriteCond %{REQUEST_FILENAME} !-f
RewriteRule . index.php [L]
```