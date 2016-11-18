# Logger

Als Logger wird [Monolog](https://github.com/Seldaek/monolog) verwendet.

## Installation

Zuerst muss die Konfiguration von Composer erweitert werden:
```json
{
    "require": {
        "falkm/hubert-logger": "1.*"
    }
}
```

## Konfiguration

Anschließend erweitert man die Konfiguration von Hubert oder legt eine neue Datei _config/logger.global.php_ an. In der folgenden Konfiguration wird definiert, dass log-Datein unter _logs/_ abgelegt werden und dass Fehlermeldungen nicht im Frontend ausgegeben werden sollen.
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


## Verwendung

```php
 hubert()->logger->error("test-error");
```

Der Befehl erzeut eine Datei mit Tagesdatum, zum Beispiel _logs/2016-01-31.log_ und schreibt die Fehlermeldung _"test-error"_ hinein. Wie Log-Datein aufgebaut sind und welche Möglichkeiten des Logging es gibt, kann unter [github.com/Seldaek/monolog](https://github.com/Seldaek/monolog) nachgelesen werden.
