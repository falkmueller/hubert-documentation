<?php

namespace app\controller;

class indexController extends \hubert\generic\controller {
 
    public function indexAction($params){
        $language = hubert()->session("locale")->language;
        
        return $this->responseTemplate("index/index_".$language);
    }
    
}
