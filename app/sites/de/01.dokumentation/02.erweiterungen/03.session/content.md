# Session

Als Session-Container wird [zend-session](https://docs.zendframework.com/zend-session/) verwendet.

## Installation

Zuerst muss die Configuration von Composer erweitert werden:
```json
{
    "require": {
        "falkm/hubert-session": "1.*"
    }
}
```

## Konfiguration

Anschließend erweitert man die Konfiguration von Hubert oder legt eine neue Datei _config/session.global.php_ an. In der Konfiguration hier wird definiert, wie lang die Session in Sekunden gültig ist und ob die Session aus Sicherheitsgründen validiert werden soll.
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


## Verwendung

```php
 hubert()->session()->name = "Name ohne Namespace";
 hubert()->session('user')->name = "hubert (Name im Namespace 'user')";
 echo hubert()->session('user')->name;
```

Im Beispiel sieht man, dass man beim Aufruf der Session jeweils einen Namespace für die Variablen definieren kann. Anschließend können Werte zugewiesen und abgerufen werden.

