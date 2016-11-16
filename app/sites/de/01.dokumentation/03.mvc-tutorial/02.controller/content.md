# Controller

Controller legen wir in den Order "src/controller" ab.
Als Konvention sollten Controller-Namen auf "Controller.php" enden.

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


