# Einfaches Beispiel

Hier ein einfaches Beispiel in einer php-Datei.


Zuerst muss der autoloader des Composers eingefügt werden:
```php
require 'vendor/autoload.php'
```

Nun definiert man die Konfiguration.
Im einfachen Beispiel beinhaltet diese nur eine Route für die Startseite, welche "Hello World" ausgibt:
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

Nun initialisert man Hubert mit dieser Konfiguration:
```php
hubert($config);
```

Zum Schluss füht man den "run"-Befehlr der Core-Komponente aus:
```php
hubert()->core()->run();
```


Hier die komplette "index.php"-Datei:
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

### Serverkonfiguration

Der Server muss so konfiguriert werden dass es alle Anfragen auf unsere index.php leitet.
Für Apache-Server definiert man eine .htaccess-Datei mit folgenden Inhalt:
```rouge
RewriteEngine on
RewriteCond %{REQUEST_FILENAME} !-d
RewriteCond %{REQUEST_FILENAME} !-f
RewriteRule . index.php [L]
```