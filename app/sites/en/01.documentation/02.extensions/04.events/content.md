# Events

Hubert uses [zend-eventmanager](https://docs.zendframework.com/zend-eventmanager/) as Event Manager.

## Installation

At first you have to extend the configuration of composer:
```json
{
    "require": {
        "falkm/hubert-event": "1.*"
    }
}
```

## Configuration

Afterwards you have to extend the configuration of Hubert or create a new _config/event.global.php_ file. Just define the factory here:
```php
<?php
return array(
    "factories" => array(
        "eventManager" => array(hubert\extension\event\factory::class, 'get')
    ),
);
```

## Usage

```php
$a =  hubert()->eventManager->trigger('do', null, ["test" => 2]);
print_r($a->last());
```

In this example the event "do" is executed. The is no scope given to the event but there is a variable "test". To make something happen you first have to pass an action to the event using _attach($event\_name, $event\_target)_:

```php
hubert()->eventManager->attach('do', function ($e) {
    $event = $e->getName();
    $params = $e->getParams();
    printf(
        'Handled event "%s", with parameters %s',
        $event,
        json_encode($params)
    );
    return "eventresult";
});
```

In this example the event outputs the parameters passed to it and returns a string. More detailed information on how to use Events you will finde at [docs.zendframework.com/zend-eventmanager/](https://docs.zendframework.com/zend-eventmanager/).

