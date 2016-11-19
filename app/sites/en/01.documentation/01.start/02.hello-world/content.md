# Simple example

This is an easy example in a php file. At first you have to insert the composer autoloader.
```php
require 'vendor/autoload.php'
```

Now you define the configuration. In this example the configuration contains only one route for the home page that returns "Hello World":
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

Now Hubert can be initialised using this configuration:
```php
hubert($config);
```

At last you fire off the core components _run()_ command:
```php
hubert()->core()->run();
```


This is the full _index.php_:
```php
<?php

require 'vendor/autoload.php';

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

hubert($config);
hubert()->core()->run();
```

## Serverkonfiguration

The server must be configured to redirect all request to _index.php_. Using Apache you create a new _.htaccess_ file with the following content:
```rouge
RewriteEngine on
RewriteCond %{REQUEST_FILENAME} !-d
RewriteCond %{REQUEST_FILENAME} !-f
RewriteRule . index.php [L]
```