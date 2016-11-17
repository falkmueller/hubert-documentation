# Template

Als Template Engine wird [plates](http://platesphp.com) verwendet.

## Installation

Zuerst muss die Konfiguration des Composers erweitert werden
```json
{
    "require": {
        "falkm/hubert-template": "1.*"
    }
}
```

## Konfiguration

Anschließend erweitert man die Konfiguration oder legt eine neue Datei "config/template.global.php" an:
```php
<?php
return array(
    "factories" => array(
         "template" => array(hubert\extension\template\factory::class, 'get')
        ), 
    "config" => array(
        "template" => array(
           "path" => dirname(__dir__).'/templates',
           "fileExtension" => "phtml",
           "extensions" => array(
               hubert\extension\template\urlExtension::class
           )
       )
    )
);
```

In der Konfiguration oben ist unter anderen festgelegt, dass Tempaltes im Order _/templates_ liegen und auf _.phtml_ enden.


## Verwendung

```php
$html = hubert()->template->render("index/index", array("name" => "hubert"));
```

der Befehl rendert das template "templates/index/index.phtml".
Im Template ist dann die Variable $name verfügbar.
Über folgenden Befehl kann global eine Template-Variabe eingefügt werden:
```php
hubert()->template->addData(array("language" => 'de'));
```

Wie Templates aufgebaut sind, wie man Layouts verwendet, etc kann unter [platesphp.com](http://platesphp.com) nachgelesen werden.
