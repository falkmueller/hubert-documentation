<?php

namespace app\service;

class preDispatcher {
    
    public static function get($container){
        return array(new static(), 'preDispatch');
    }
    
    public function preDispatch(){
        $this->setLocale();
    }
    
    private function setLocale(){
        $config = hubert()->config()->locale;
        $locale_lib = new \app\lib\locale();
        //Sprache aus url ziehen und in session schreiben
        $current_route = hubert()->current_route;
        $language = hubert()->session("locale")->language;
        if (is_array($current_route) && isset($current_route["params"]["language"])){
            $language = $current_route["params"]["language"];
        }
        elseif (!$language){
            $request_locales = $locale_lib->getFromRequest();
            foreach ($request_locales as $request_locale){
                if(in_array($request_locale, $config["available"])){
                    $language = $request_locale;
                    break;
                }
            }
        }
        
        if(!$language || !in_array($language, $config["available"])){
            $language = $config["default"];
        }
        
        //set locale in session
        hubert()->session("locale")->language = $language;
        
        //load locale for template
        $locale_lib->register($config["dir"], $language,$config["default"]);
        hubert()->template->addData(array("language" => $language));
        
        return $language;
        
    }
    
}
