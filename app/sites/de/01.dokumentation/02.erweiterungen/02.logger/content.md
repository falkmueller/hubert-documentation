# Logger

Als Logger wird [monolog](https://github.com/Seldaek/monolog) verwendet.

## Installation

Zuerst muss die Configuration des Composers erweitert werden
```json
{
    "require": {
        "falkm/hubert-logger": "1.*"
    }
}
```

## Konfiguration

Anschließend erweitert man die konfiguration oder legt eine neue Datei _config/logger.global.php_ an:
```php
<?php
return array(
    "factories" => array(
         "logger" => array(hubert\extension\logger\factory::class, 'get')
        ),
    "config" => array(
        "display_errors" => false,
        "logger" => array(
                "path" => dirname(__dir__).'/logs/',
            )
        ),
);
```

In der Konfiguration oben wird definiert, dass log-Datein unter _logs/_ abgelegt werden und das Fehlermeldungen nicht im Frontend ausgegeben werden sollen.


## Verwendung

```php
 hubert()->logger->error("test-error");
```

Der Befehl erzeut eine Datei mit TagesDatum, zum Beispiel _logs/2016-01-31.log_ und schreibt die Fehlermeldung _"test-error"_ hinein.

Wie Log-Datein aufgebaut sind, welche Möglichkeiten des Logging es gibt, etc kann unter [github.com/Seldaek/monolog](https://github.com/Seldaek/monolog) nachgelesen werden.
