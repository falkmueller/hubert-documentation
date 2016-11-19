# Template

Hubert uses [Plates](http://platesphp.com) as template engine.

## Installation

At first you have to extend the configuration of composer:
```json
{
    "require": {
        "falkm/hubert-template": "1.*"
    }
}
```

## Configuration

Afterwards you have to extend the configuration of Hubert or create a new _config/template.global.php_ file. In the following example we define for instance that templates will be place in a _/templates_ directory and have a _.phtml_ file extension.
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


## Usage

```php
$html = hubert()->template->render("index/index", array("name" => "hubert"));
```

This command for instance renders the template "templates/index/index.phtml". In the template is a _$name_ variable available. Using the following command you can insert a template variable globally.

```php
hubert()->template->addData(array("language" => 'de'));
```

Read more about templates and their best practice on [platesphp.com](http://platesphp.com).
