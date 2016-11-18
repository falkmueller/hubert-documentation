# Events

Als Event-Manager wird [zend-eventmanager](https://docs.zendframework.com/zend-eventmanager/) verwendet.

## Installation

Zuerst muss die Configuration von Composer erweitert werden:
```json
{
    "require": {
        "falkm/hubert-event": "1.*"
    }
}
```

## Konfiguration

Anschließend erweitert man die Konfiguration von Hubert oder legt eine neue Datei _config/event.global.php_ an. Hier muss lediglich die Factory angegeben werden.
```php
<?php
return array(
    "factories" => array(
        "eventManager" => array(hubert\extension\event\factory::class, 'get')
    ),
);
```

## Verwendung

```php
$a =  hubert()->eventManager->trigger('do', null, ["test" => 2]);
print_r($a->last());
```

Im Beispiel wird ein Event namens "do" ausgeführt. Es wird kein Scope an das Event übergeben, aber eine Variable namens "test". Damit auch etwas passiert, muss zuvor dem Event über die Funktion _attach($event\_name, $event\_target)_ eine Aktion zugewiesen werden:

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

Im Beispiel gibt das Event die übergebenen Parameter aus und gibt einen String zurück. Wie Events verwendet werden, kann im Detail unter [docs.zendframework.com/zend-eventmanager/](https://docs.zendframework.com/zend-eventmanager/) nachgelesen werden.

