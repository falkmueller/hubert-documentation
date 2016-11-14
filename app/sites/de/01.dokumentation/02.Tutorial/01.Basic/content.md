# Structure

We build a little MVC application.    
Fist, install hubert via composer.

## File structure

```rouge
.
├── src/
│   ├── controller/
│   └── templates/
├── config/
│   ├── general.global.php
│   └── routes.global.php
├── data/
├── public/
│   ├── images/
│   └── ...
├── vendor/
├── index.php
├── .htaccess
```

The "src"-folder is later used and containes templates, contoller, models, etc. of your application.    
The "config"-folder containes all configutaion files.   
The "data"-folder is uses later to log errors and use caching.    
The "public"-folder contains all files, how have directly public access, like images, styles and javascript-files.

### index.php
```php
<?php

//load autoloader
require_once 'vendor/autoload.php';

//init app
$app = new hubert\app();

//register namespace of your application code
$app->registerNamespace("src", __dir__."/src/");

//load configuration
$app->loadConfig(__dir__.'/config/');

//run and emit app
$app->emit($app->run());
```

###.htaccess
The htaccess defines the url-rewrite.
All files should be route to your index.php, only files from folder "public" have directly external access.

```rouge
#disable directory listing
Options -Indexes 

#switch on rewrite engine
RewriteEngine On

#allow robots.txt
RewriteRule robots.txt$ public/robots.txt [NC,L]

#if folder not "public", then rewrite to index.php
RewriteRule !^(public)/(.*)$ index.php [NC,L]

# All folder to index.php
RewriteCond %{REQUEST_FILENAME} -d
RewriteRule ^(.*)$ index.php [NC,L,QSA]

#all existing files stream to browser
RewriteCond %{REQUEST_FILENAME} -s [OR]
RewriteCond %{REQUEST_FILENAME} -l
RewriteRule ^.*$ - [NC,L]

#other to index.php
RewriteRule ^(.*)$ index.php [NC,L,QSA]
```

### config/general.global.php

This file containes the standard configuration, for start, its only the configuration, if errors details be displayed in browser.

```php
<?php
return array( 
   "config" => array(
       "display_errors" => true, 
    ),
);
```
### config/routes.global.php

This file containes the routes. For start, we add a simple route for the start-Page with executly target-function:

```php
<?php
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