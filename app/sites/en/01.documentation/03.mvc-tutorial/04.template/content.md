# Templates

Before starting with templates you have to load the template extension using composer:
```json
{
    "require": {
        "falkm/hubert-template": "1.*"
    }
}
```

Afterwards you create a _config/template.global.php_ file:
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

In the controller section we learned that the home route calls the indexAction of the indexController. It returns _$this->responseTemplate("index/index", ["name" => "Hubert"])_. That means that the template _src/templates/index/index.phtml_ is loaded and the variable _$name_ is passed to it.

```html
<?php $this->layout('layout') ?>
Name: <?= $name ?>
```

Now we can output the variable and load the layout named "layout". It is also placed inside the template directory at _src/templates/layout.phtml_

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

In the layout the content of the index template is emitted as section. More information about using Plates temlpates can be found at [platesphp.com](http://platesphp.com).

## Template extensions

In the configuration a url extension is loaded. It provides three functions inside of the templates:
- _$this->url($name, $params = array(), $query = array())_ This function can be used for creating urls, same as hubert()->router->url($name, $params = array(), $query = array())
- _$this->baseUrl($relPath)_ creates a url that can be used for stylesheets for instance $this->baseUrl("/public/styles.css")
- _$this->current\_route()_ returns the current route with its parameters and names, that can be useful to mark navigation links as active for instance