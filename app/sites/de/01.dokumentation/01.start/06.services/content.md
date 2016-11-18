# Services

Wie wir im Bereich der Konfiguration gesehen haben, werden Services als Factories definiert:
```php
"factories" => array(
    "test" => array(\src\service\test::class, 'factory'),
    "add" => array(\src\service\add::class, 'factory'),
),
```

Services stehen anschließend über den definierten Namen zur Verfügung. Im Bespiel über _hubert()->test_. Die Factory ist dabei eine statische Funktion.
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
Bei der erstmaligen Verwendung des Services wird die Factory ausgeführt. Ein weiteres Beispiel wäre ein Service, welcher eine direkt aufrufbare Funktion bereitstellt:

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

In diesem Fall kann man über _$c = hubert()->add(2,3)_ zwei Zahlen addieren. Die Services sind in der Konfiguration überschreibbar. Wird in einer Konfigurationsdatei, welche auf _.global.php_ endet ein Service definiert, welcher auch in einer Datei, welche auf _.local.php_ endet definiert ist, so wird nur der Service, welcher in der local-Datei definiert ist initialisiert.