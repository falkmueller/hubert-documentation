# Einfaches Beispiel

Hier ein einfaches Beispiel in einer php-Datei. Zuerst muss der Autoloader des Composers eingefügt werden:
```php
require 'vendor/autoload.php'
```

Nun definiert man die Konfiguration. Im einfachen Beispiel beinhaltet diese nur eine Route für die Startseite, welche "Hello World" ausgibt:
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

Zum Schluss führt man den _run()_ Befehl der Core-Komponente aus:
```php
hubert()->core()->run();
```


Hier die komplette _index.php_:
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

Der Server muss so konfiguriert werden, dass er alle Anfragen auf unsere _index.php_ leitet. Für Apache-Server definiert man eine _.htaccess_ mit folgenden Inhalt:
```rouge
RewriteEngine on
RewriteCond %{REQUEST_FILENAME} !-d
RewriteCond %{REQUEST_FILENAME} !-f
RewriteRule . index.php [L]
```