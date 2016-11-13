# Configuration

The configuration is a array, how defined services (or factorys fpr services), routes for the router or sonfigurations like booleans ans strings.    
In the "Tutorial"-Section are explain, how you do this and wich standard-options are aviable.

There are two ways to load the configuration.    

### Configutation array

The simple way is to define a array and get them to the app via the "loadConfig"-method, like the "Hello world"-example:
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

$app->loadConfig($config);
```

### Configuration file loader
The better way is tho use a configuraion-folder.
in this folder you can create multible configuration files, they must end on "default.php", "global.php" or "local.php".
A example for the configutation is "config/general.global.php"
```php
<?php
return array(
    "config" => array(
        "display_errors" => false
    ),
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

In your lokal development envirement, you add for examle a file "config/general.local.php":
```php
<?php
return array(
    "config" => array(
        "display_errors" => true
    )
);
```

Now, the method "loadConfig" load all fires from the config folder,
first with extension "default.php", then "global.php" and then "local.php".
The alleys will be merged. Has a config file, later in the order, the same property, then ther override it.
```php
$app->loadConfig(__dir__.'/config/');
```
