# Bootstrap

Bootstrap-Klassen können genutz werden um Code nach oder vor Ausführung der Anwengung auszuführen. 
Dies ist nützlich, wenn man zum Beispiel den Usernamen aus der Session global als Variable indie Templates geben möchte.

Um eine bootstrap-Plassu zu nutzen muss dise in der Konfiguration angegeben werden.
Im Beispiel fügen wir dies in die Datei config/general.global.php ein:
```php
<?php
return array( 
   "config" => array(
       "bootstrap" => src\bootstrap::class,
    ),
);
```
Bei mehreren Bootstrap-Klassen können diese auch als Array angegeben werden.

Die eigendliche Bootstrap Klasse wäre in dem Falle in der Datei "src\bootstrap.php":
```php
<?php

namespace src;

class bootstrap extends \hubert\generic\bootstrap {
    
    public function init(){
        //For example, if you use the template engine, you can here set shared data vor all Templates
        //hubert()->template->addData(array("name" => "ronny"));
    }

    public function postDispatch($response){
        //here you can manipulate the response after route ist dirpatched
    }
```

Bootstrap-Klassen erben Eigenschaften von "\hubert\generic\bootstrap".
(oder Sie müssen selbstständig das inerface "hubert\interfaces\bootstrap" implementieren)

Die init-Funktion einer Bootstrap wird vor dem Routing ausgeführt und die postDispatch-Funktion nach dem Ausführen der Route.
