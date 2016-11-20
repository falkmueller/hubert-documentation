# Configuration

Hubert is configured by a single array.

## Configuation components

there are four types that can be configured:
- Namespaces
- Factories
- Settings
- Routes

### Namespaces

In this section you define namespaces with their equivalent directory:
```php
"namespace" => array(
    "app" => "app/"
),
```

In this example the namespace "app" is defined for a directory with the same name. for exapmle there could be a php class named "bootstrap" and with a namespace "app" in the file _app/bootstrap.php_. If now for instance the class _$bootstrap = new \app\bootstrap()_ is used in a route this file will finally be included. This part is also covered later in the [MVC](/en/documentation/mvc-tutorial/start) section of this documentation.

### Factories

Factories are static functions that initialise a service.
```php
"factories" => array(
    "router" => array(\hubert\service\router::class, 'factory'),
),
```
This is an example from the Hubert standard configuration (and therefore it doesn't have to be declared in your own one). Here the static function "factory" is defined inside the class "router" that is located at the namespace "hubert\service" that is the initiator for the router itself. This function also returns the router as an object. The defined service is then globally available using _hubert()->router_ and is first initialised on its first use. Furthermore you can integrate your own services.

### Settings

Settings can be strings or booleans that are used by services for their configuration. The setting in this example would be available globally using _hubert()->config->logger['path']_ verfügbar.
```php
"config" => array(
    "logger" => array(
        "path" => "logs/"
    )
),
```

### Routes

In this section you define your routes. You can finde more about this topic in the [Routing](/en/documentation/mvc-tutorial/routing) section of this documentation.

```php
"routes" => array(
    "home" => array(
        "route" => "/",
        "method" => "GET|POST",
        "target" => function(){
            echo "Hello World";
        }
    ),
),
```

## Loading your Settings

The configuration must be defined at the first call of the _hubert()_ function. You have some options to do this:
- Array
- File
- Directory

### Configure with an array

In the "Hello World" example the configuration is defined using an array. This is especially useful for smaller applications.
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

hubert($config);
```


### Configure from a file
You can also outsource this array to a dedicated file, let's say you put it into a _config.php_ file.
```php
return array(
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

Now you can pass this file instead of an array at initialisation:
```php
hubert("config.php");
```


### Configure from a directory

This is the best way to configure your Hubert instance. In this case you create a directory named _/config_ and place your config files in there in some sorted way. Now you can load these configuration files giving Hubert only the path of your config directory:
```php
$app->loadConfig('config/');
```    

Using this method you can use three possible file extensions for the configuration files in your config directory. If some files have the same configuration the extension decides which configuriation is going to be used:
- _.default.php_ this is for standard settings
- _.global.php_ in this file you define setting that are used for your specific application, think about routes
- _.local.php_ this file is used for settings that are used locally on your machine, let's say database connection settings because they are different for each developer

Here is a short example on how to use this: Let's say we have a file  _config/general.global.php_ in which we define a route and a error report setting:

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

In your local environment you also create a _config/general.local.php_ file in which yoo now can define that you wan to see error reportings:
```php
<?php
return array(
    "config" => array(
        "display_errors" => true
    )
);
```

The _display\_errors_ setting is now contained in both files. On Hubert initialisation those arrays are merged. Because the _display\_errors_ setting in the file ending on _.local.php_ is set to _true_ thats the value that is used because the local configuration has priority over all other setups.

## Cache

If you configure Hubert using directories it is possible that there will be a bunch of configuration files. routes.global.php, database.global.php, database.local.php, template.global.php and more for instance. Hubert can merge them all into a single cache file and reload only this cached configuration on every next request instead of loading all  files individually. Therefore it is important that the configuration can be serialised. That means that for example routes have to be defined as references instead of anonymous functions.

```php
$app->loadConfig('config/', 'cache/config.php');
```   