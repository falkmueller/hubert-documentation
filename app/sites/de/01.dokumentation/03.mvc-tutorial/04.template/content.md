# Templates

Befor man mit den Tampletes beginnt muss man die TemplateExtension per composer laden:
```json
{
    "require": {
        "falkm/hubert-template": "1.*"
    }
}
```


Anschließend legen wir eine "config/template.global.php" Datei an:
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
Diese hat als Rückgabe "$this->responseTemplate("index/index", ["name" => "Hubert"])".
Es wird also das Template "src/templates/index/index.phtml" geladen und diesem die Variable $name übergeben.

```html
<?php $this->layout('layout') ?>

Name: <?= $name ?>

```

Im Beispiel geben wir die Variable aus und laden das layout namens "layout".

Dies liegt ebenfalls im Template-Pfad unter "src/temnplates/layout.phtml":
```html
<html>
    <head>
    </head>
    <body>
        <ul>
            <li><a href="<?= $this->url('home') ?>">Home</a></li>
            <li><a href="<?= $this->url(['name' => 'mvc',['controller' => 'index', 'action' => 'redirect']]) ?>">Redirect Home</a></li>
        </ul>

        <?=$this->section('content')?>
    </body>
</html>
```

Im Layout wird der Inhalt des index-Templates als Section ausgegeben.
Weitere Infos zum Umgang mit Plates-Templates findes du unter [platesphp.com](http://platesphp.com).
