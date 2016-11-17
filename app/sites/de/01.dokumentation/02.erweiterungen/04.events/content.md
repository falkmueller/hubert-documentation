# Events

Als Event-manager wird [zend-eventmanager](https://docs.zendframework.com/zend-eventmanager/) verwendet.

## Installation

Zuerst muss die Configuration des Composers erweitert werden
```json
{
    "require": {
        "falkm/hubert-event": "1.*"
    }
}
```

## Konfiguration

Anschließend erweitert man die konfiguration oder legt eine neue Datei _config/event.global.php_ an:
```php
<?php
return array(
    "factories" => array(
      "eventManager" => array(hubert\extension\event\factory::class, 'get')
     ),
);
```

es muss lediglich die factory angegeben werden.
## Verwendung

```php
 $a =  hubert()->eventManager->trigger('do', null, ["test" => 2]);
 print_r($a->last());
```
Im Beispiel wird ein Event namens "do" ausgeführt. 
Es wird kein Scope an das Event übergeben, aber eine Variable namens "test".


Damit auch etwas passiert, muss zuvor über die Funktion _attach($event\_name, $event\_target)_ dem Event eine Aktion zugewiesen worden sein:
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
Im Beispiel gibt das Event die übergebenen Parameter aus und gibt einen String zurück.

Wie Events verwendet werden, kann unter [docs.zendframework.com/zend-eventmanager/](https://docs.zendframework.com/zend-eventmanager/) nachgelesen werden.

