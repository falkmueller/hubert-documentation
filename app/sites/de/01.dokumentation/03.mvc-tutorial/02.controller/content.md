# Controller

Controller legen wir in den Order "src/controller" ab.
Als Konvention müssem Controller-Namen auf "Controller.php" enden und darin enthaltene Action-Function auf "Action" enden.

Für unser Beispiel legen wir die Datei "src/controller/indexController" an:
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

Controller erben Eigenschaften von "\hubert\generic\controller".    
(oder Sie implementieren selbstständig das Interface "hubert\interfaces\controller")
Über $this->getResonse() steht as Response-Objekt und über $this->getRequest steht das Request-Objekt zur verfügung.    

Controller müssen ein das Respone Objekt zurückgeben.
Um dieses mit Daten zu befüllen stehen drei Funtionen zur verfügung.

- $this->responseJson($data, $status = null, $encodingOptions = 0): Über diese Funktion wird ein Objejekt, wie ein Array in den Response gesetzt und der Response als Json encodet.
- $this->responseRedirect($url, $status = null): In den Response wird eine Url gesetzt und es diese wird als Redirekt an den Empfänger übergeben
- $this->responseTemplate($template, $data = array()): Es wird ein Template gerendert.
