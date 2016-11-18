# Controller

Controller legen wir im Ordner _src/controller_ ab. Als Konvention müssem Controller-Namen auf _Controller.php_ enden und darin enthaltene Action-Funktionen müssen auf _Action_ enden. Für unser Beispiel legen wir die Datei _src/controller/indexController.php_ an:

```php
<?php

namespace src\controller;

class indexController extends \hubert\generic\controller {
    
    public function indexAction($params){
        return $this->responseTemplate("index/index", ["name" => "Hubert"]);
    }
    
    public function apiAction(){
        $data = ["users" => ["Falk", "Ronny"]];
        return $this->responseJson($data);
    }

    public function redirectAction(){
        $home_route = hubert()->router->get("home");
        return $this->responseRedirect($home_route);
    }

}
```

Controller erben Eigenschaften von _\hubert\generic\controller_ oder Sie implementieren selbstständig das Interface _hubert\interfaces\controller_. Über _$this->getResonse()_ steht as Response-Objekt und über _$this->getRequest_ steht das Request-Objekt zur Verfügung. Controller müssen ein Respone Objekt zurückgeben. Um dieses mit Daten zu befüllen stehen drei Funktionen zur Verfügung:

- _$this->responseJson($data, $status = null, $encodingOptions = 0)_ Über diese Funktion wird ein Objekt wie zB. ein Array in den Response gesetzt und der Response als Json encodet
- _$this->responseRedirect($url, $status = null)_ In den Response wird eine Url gesetzt und diese wird als Redirect an den Empfänger übergeben
- _$this->responseTemplate($template, $data = array())_ Es wird ein Template gerendert
