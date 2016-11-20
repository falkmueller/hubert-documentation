# Logger

Hubert uses [Monolog](https://github.com/Seldaek/monolog) as logger.

## Installation

At first you have to extend the configuration of composer:
```json
{
    "require": {
        "falkm/hubert-logger": "1.*"
    }
}
```

## Configuation

Afterwards you have to extend the configuration of Hubert or create a new _config/logger.global.php_ file. In the following example we define for instance that log files will be stored in _logs/_ and that error reports should not show up in the frontend.
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


## Usage

```php
 hubert()->logger->error("test-error");
```

This command creates a file with a datestamp for example _logs/2016-01-31.log_ and writes the error report _"test-error"_ into it. How to use log files in detail and what other logging possibilities there are you can read at [github.com/Seldaek/monolog](https://github.com/Seldaek/monolog).
