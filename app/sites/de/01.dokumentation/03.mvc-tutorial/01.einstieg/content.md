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

Der _src_ Ordner beinhaltet den Code der Anwendung, also Controller, Templates, Models, Libraries, ...

Der _config_ Ordner beinhaltet die Konfigurations-Datein.

Der _data_ Ordner beinhaltet daten, wie Log-Dateien und Cache-Dateien.

Der _public_ Ordner beinhaltet Dateien, welche direkt im Browser aufrufbar sind, wie Styles, Bilder und Javascripte.

## Einstieg

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
In der _.htaccess_ Datei wird konfiguriert, dass alle Anfragen auf die _index.php_ geleitet werden, mit Ausnahme der Dateien im Ordner _public_.

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

In der Standardkonfiguration erlauben wir vorerst das Anzeigen von Fehlermeldungen und fügen dem Namespace einen Autoloader hinzu:

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
