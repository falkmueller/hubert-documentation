# Services

As we have learned in the configuration section services are defined as factories:
```php
"factories" => array(
    "test" => array(\src\service\test::class, 'factory'),
    "add" => array(\src\service\add::class, 'factory'),
),
```

Afterwards the services are available using the defined name. In the example we can run _hubert()->test_. In this case the factory is a static function.
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

If you call _$wert = hubert()->test->retrunTest()_, you will get _$wert = "blub"_. When you use the service for the first time the factory is executed. Another example would be a service that provides a function that is directly callable:

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

In this case you can add two numbers using _$c = hubert()->add(2,3)_. The services can be overwritten in the configuration. If a service is simultaneously defined in a file ending on _.global.php_ and in a file ending on _.local.php_ only the service that is defined in the local file will be initialised.

