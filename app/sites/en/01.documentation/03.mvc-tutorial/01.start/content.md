# MVC

## File structure

```rouge
.
├── src/
│   ├── controller/
│   ├── model/
│   └── templates/
├── config/
│   ├── general.global.php
│   └── routes.global.php
├── data/
│   ├── cache/
│   └── logs/
├── public/
│   ├── images/
│   └── ...
├── vendor/
├── index.php
├── .htaccess
```

The _src_ directory contains the applications code, that means controller, templates, models, libraries and so on

The _config_ directory contains all configuration files

The _data_ directory contains files like logs or caches

The _public_ directory contains files that are accessible by the browser like stylesheets, images or scripts

## Getting started

### index.php
```php
<?php

//load autoloader
require_once 'vendor/autoload.php';

//init app
hubert(__dir__.'/config/');

//run and emit app
hubert()->core()->run();
```

###.htaccess
The _.htaccess_ file is used to redirect all requests to _index.php_ except for files in the _public_ directory.

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

In the standard configration we allow for instance some error reports and we add an autoloader to the namespace:

```php
<?php
return array( 
    "namespace" => array(
        "src" => dirname(__dir__)."/src/"
    ),
    "config" => array(
        "display_errors" => true,
    ),
);
```
