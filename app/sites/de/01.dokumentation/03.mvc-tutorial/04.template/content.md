# Templates

Bevor man mit den Templates beginnt, muss man die TemplateExtension per Composer laden:
```json
{
    "require": {
        "falkm/hubert-template": "1.*"
    }
}
```

Anschließend legen wir eine _config/template.global.php_ Datei an:
```php
<?php
return array(
    "factories" => array(
        "template" => array(hubert\extension\template\factory::class, 'get')
    ),
    "config" => array(
        "template" => array(
            "path" => dirname(__dir__).'/src/templates',
            "fileExtension" => "phtml",
            "extensions" => array(
                hubert\extension\template\urlExtension::class
            )
        )
    )
);
```

Im Controller haben wir gesehen, dass die Home-Route die indexAction des IndexControllers aufruft. Diese hat als Rückgabe _$this->responseTemplate("index/index", ["name" => "Hubert"])_. Es wird also das Template _src/templates/index/index.phtml_ geladen und diesem die Variable _$name_ übergeben.

```html
<?php $this->layout('layout') ?>
Name: <?= $name ?>
```

Nun geben wir die Variable aus und laden das Layout namens "layout". Dieses liegt ebenfalls im Template-Pfad unter _src/templates/layout.phtml_:

```html
<html>
    <head>
    </head>
    <body>
        <ul>
            <li><a href="<?= $this->url('home') ?>">Home</a></li>
            <li><a href="<?= $this->url('mvc',['controller' => 'index', 'action' => 'redirect']) ?>">Redirect Home</a></li>
        </ul>

        <?=$this->section('content')?>
    </body>
</html>
```

Im Layout wird der Inhalt des index-Templates als Section ausgegeben. Weitere Infos zum Umgang mit Plates-Templates findes du unter [platesphp.com](http://platesphp.com).

## Template Erweiterungen

In der Konfiguration wird eine Url Extension geladen. Diese stellt innerhalb der Templates drei Funktionen zur Verfügung:
- _$this->url($name, $params = array(), $query = array())_ Diese Funktion kann zum Bilden von Urls verwendet werden, analog zu hubert()->router->url($name, $params = array(), $query = array())
- _$this->baseUrl($relPath)_ Bildet eine Url, was beispielsweise für Styles verwendet werden kann $this->baseUrl("/public/styles.css")
- _$this->current\_route()_ Gibt die aktuelle Route mit Namen und Parametern zurück – dies kann nützlich sein, wenn man zum Beispiel Navigationslinks im Template als "active" markieren möchte