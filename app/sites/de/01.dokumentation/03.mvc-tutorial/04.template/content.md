# Templates

Befor man mit den Tampletes beginnt muss man die TemplateExtension per composer laden:
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

Im controller haben wir gesehen, dass die home-Rpute die indexAction des IndexControllers aufruft.
Diese hat als Rückgabe _$this->responseTemplate("index/index", ["name" => "Hubert"])_.
Es wird also das Template _src/templates/index/index.phtml_ geladen und diesem die Variable $name übergeben.

```html
<?php $this->layout('layout') ?>

Name: <?= $name ?>

```

Im Beispiel geben wir die Variable aus und laden das layout namens "layout".

Dies liegt ebenfalls im Template-Pfad unter _src/temnplates/layout.phtml_:
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

Im Layout wird der Inhalt des index-Templates als Section ausgegeben.
Weitere Infos zum Umgang mit Plates-Templates findes du unter [platesphp.com](http://platesphp.com).

# Template Erweiterungen

In der Konfigutation wird eine ulrExtension geladen. Diese stellt innerhalt der Templates drei Funtionen zur verfügung:
- _$this->url($name, $params = array(), $query = array())_: Diese funktion kann zum bilden von Urls verwendet werden, equivalent zu hubert()->router->url($name, $params = array(), $query = array())
- _$this->baseUrl($relPath)_: bildet eine Url. kann verwendet werden für Styles zum Beispiel: $this->baseUrl("/public/styles.css")
- _$this->current\_route()_: gibt die aktuelle Router mit Namen und Parametern zurück. Dies kann Nutzlich sein, wenn man zum Beispiel links im Template als "active" markieren möchte.