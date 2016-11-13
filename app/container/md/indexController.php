<?php

namespace app\container\md;

class indexController extends \hubert\generic\controller {
    
    public function parseAction($params){
        $container = hubert()->container();
        
        $url_path = "";
        if(isset($params["path"])){
            $url_path = $params["path"];
        }

        $current_node = $container["md"]->getRoot()->searchChild($url_path);
        
        if(!$current_node){
            return $container["notFoundHandler"]($this->_response);
        } 

        $template = hubert()->config()->md["template"];
        if(isset($current_node->getConfig()["template"])){
            $template = $current_node->getConfig()["template"];
        }
        
        return $this->responseTemplate($template, array(
            "root" => $container["md"]->getRoot(),
            "current" => $current_node,
            "md" => $container["md"]
        ));
    }
    
}
