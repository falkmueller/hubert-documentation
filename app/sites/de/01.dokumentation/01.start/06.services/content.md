# Services

Wir wird im Bereich der Konfiguration gesehen haben, werden Services als Factories definiert:
```php
...
 "factories" => array(
         "test" => array(\src\service\test::class, 'factory'),
         "add" => array(\src\service\add::class, 'factory'),
    ),
...
```

Services stehen anschließend über den definierten namen zur verfügung.
Im Bespiel über _hubert()->test_

die factory ist dabei eine Statische funktion.
```php
<?php

namespace src\service;

class test {

    public static function factory($hubert){
        return new static();
    }

    public function returnTest(){
        return "blub";
    }

}
```

Ruft man _$wert = hubert()->test->retrunTest()_ auf, erhält man _$wert = "blub"_.
Beim erstmaligen verwenden des Services wird die Facory ausgeführt. Ein weiteres Beispiel wäre ein Service, welcher eine direkt aufrufbare Funktion bereitstellt:

```php
<?php

namespace src\service;

class add {

    public static function factory($hubert){
        return new static();
    }

    public function __invoke($a, $b){
        return $a + $b;
    }

}
```

In dem Falle kann man über _$c = hubert()->add(2,3)_ zwei Zahlen addieren. Die Services sind in der Konfiguration überschreibbar. Wird in einer Konfigurationsdatei, welche auf _.global.php_ endet ein Service definiert, welcher auch in einer Datei, welche auf ".local.php" endet definiert ist, so wird nur der Service, welcher in der local-Datei definiert ist inizialisiert.