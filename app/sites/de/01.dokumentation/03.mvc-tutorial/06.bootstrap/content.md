# Bootstrap

Bootstrap-Klassen können genutzt werden, um Code nach oder vor Ausführung der Anwendund zu initialisieren. Dies ist nützlich, wenn man zum Beispiel den Usernamen aus der Session global als Variable in die Templates geben möchte. Um eine Bootstrap-Klasse zu nutzen muss diese in der Konfiguration angegeben werden. Im Beispiel fügen wir dies in die Datei _config/general.global.php_ ein:
```php
<?php
return array( 
    "config" => array(
        "bootstrap" => src\bootstrap::class,
    ),
);
```

Bei mehreren Bootstrap-Klassen können diese auch als Array angegeben werden. Die eigentliche Bootstrap-Klasse wäre in dem Falle in der Datei _src\bootstrap.php_:
```php
<?php

namespace src;

class bootstrap extends \hubert\generic\bootstrap {
    
    public function init(){
        //if you use the template engine, you can set shared data for all templates here
        hubert()->template->addData(array("name" => "ronny"));
    }

    public function preDispatch(){
        //access to current route using hubert()->current_route
        //routing ends here if function returns an object of type response
    }

    public function postDispatch($response){
        //response after route ist dispatched can be manipulated here
    }

```

Bootstrap-Klassen erben Eigenschaften von _\hubert\generic\bootstrap_ oder müssen selbstständig das Interface _hubert\interfaces\bootstrap_ implementieren. Die init-Funktion einer Bootstrap Klasse wird vor dem Routing ausgeführt. Die preDispatch-Funktion wird nach der Ermittlung der aktuellen Route ausgeführt, aber noch vor dem eigendtlichen dispatch-Event. Wenn der preDispatch ein Objekt vom Type Response liefert, wird das Routing sofort beendet. Die postDispatch-Funktion wird nach dem Ausführen der Route aufgerufen und dient dazu, den Response zu manipulieren.
