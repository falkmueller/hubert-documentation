<?php

namespace app\controller;

class docController extends \hubert\generic\controller {
 
    public function indexAction($params){
        $container = hubert()->container();
        
        
        $language = $container->session("locale")->language;
        
        $url_path = "";
        if(isset($params["path"])){
            $url_path = $params["path"];
        }

        $root = new \app\lib\md\node(dirname(__dir__).'/sites/'.$language);
        
        $current_node = $root->searchChild($url_path);
        
        if(!$current_node){
            return $container["notFoundHandler"]($this->_response);
        } 

        $template = "doc/page";
        if(isset($current_node->getConfig()["template"])){
            $template = $current_node->getConfig()["template"];
        }
        
        return $this->responseTemplate($template, array(
            "root" => $root,
            "current" => $current_node
        ));
    }
    
}
