# MVC

## Datei Struktur

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

Der "src"-Ordner beinhaltet den Code der Anwendung, also Controller,, templates, Models, Librarys, ...    
Der "config"-Ordner beinhaltet die Konfigurations-Datein.
Der "data"-Ordner beinhaltet daten, wie Log-Dateien und Cache-Dateien.
Der "public"-Ordner beinhaltet Dateien, welche direkt im Browser aufrufbar sind, wie Styles, Bilder und Javascripte. 

## der Einstieg

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
In der htaccess Datei wird konfiguriert, dass alle Anfragen auf die index.php geleitet werden,
mit außnahme der Dateien im Ordner "public".

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

in der Standard-Configuration erlauben wir vorerst das Anzeigen von Fehlermeldungen und
fügen den Namespace für unseren Code aus dem Order "src" den Autoloader hinzu.

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
