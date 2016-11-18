# Template

Als Template Engine wird [Plates](http://platesphp.com) verwendet.

## Installation

Zuerst muss die Konfiguration von Composer erweitert werden:
```json
{
    "require": {
        "falkm/hubert-template": "1.*"
    }
}
```

## Konfiguration

Anschließend erweitert man die Konfiguration von Hubert oder legt eine neue Datei _config/template.global.php_ an. In der nachfolgenden Beispielkonfiguration ist unter Anderem festgelegt, dass Templates im Order _/templates_ liegen und auf _.phtml_ enden.
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


## Verwendung

```php
$html = hubert()->template->render("index/index", array("name" => "hubert"));
```

Dieser Befehl rendert beispielsweise das Template "templates/index/index.phtml". Im Template ist dann die Variable _$name_ verfügbar. Über folgenden Befehl kann global eine Template-Variable eingefügt werden:

```php
hubert()->template->addData(array("language" => 'de'));
```

Wie Templates aufgebaut sind, wie man Layouts verwendet, etc kann auch noch genauer unter [platesphp.com](http://platesphp.com) nachgelesen werden.
