# Controller

Controllers are placed inside the  _src/controller_ directory. As a convention all controller names have to end on _Controller.php_. Actions contained in there must end on _Action_. For instance we create a _src/controller/indexController.php_ file with the following content:

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

Controllers inherit from _\hubert\generic\controller_ or you implement your own interface at _hubert\interfaces\controller_. The response object is avaliable using _$this->getResponse()_ and the request object is available using _$this->getRequest()_. Controllers always have to return a response object. To populate it with some data there are three ways to do so:

- _$this->responseJson($data, $status = null, $encodingOptions = 0)_ using this function an object for instance an array is set to the response and the response itself is encoded as json
- _$this->responseRedirect($url, $status = null)_ a url is set to the response and delivered as redirect to he receiver
- _$this->responseTemplate($template, $data = array())_ renders a template
