<?php

namespace app\controller;

class indexController extends \hubert\generic\controller {
 
    public function indexAction($params){
        $language = hubert()->container()->session("locale")->language;
        
        return $this->responseTemplate("index/index_".$language);
    }
    
}
