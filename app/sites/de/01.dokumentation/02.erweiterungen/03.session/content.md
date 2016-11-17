# Session

Als Session-Container wird [zend-session](https://docs.zendframework.com/zend-session/) verwendet.

## Installation

Zuerst muss die Configuration des Composers erweitert werden
```json
{
    "require": {
        "falkm/hubert-session": "1.*"
    }
}
```

## Konfiguration

Anschließend erweitert man die konfiguration oder legt eine neue Datei _config/session.global.php_ an:
```php
<?php
return array(
    "factories" => array(
         "session" => array(hubert\extension\session\factory::class, 'get')
        ),
    "config" => array(
        "session" => array(
                'remember_me_seconds'   => 1800,
                'validate_user_agend'   => false,
                'validate_remote_addr'  => false
            ),
        ),
);
```

In der Konfiguration oben wird definiert, wie lang die Session gültig ist (in Sekunden) und ob die Session validiert werden soll, für mehr Sicherheit.


## Verwendung

```php
 hubert()->session()->name = "Name ohne Namespace";
 hubert()->session('user')->name = "hubert (Name im Namespace 'user')";
 echo hubert()->session('user')->name;
```

Im Beispiel sieht man, dass man beim Aufruf der Session jeweils einen Namespace für die Variablen definieren kann.
Anschließend können wWrte zugewießen und abgerufen werden.

