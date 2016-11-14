<?php

namespace app\lib;

use Gettext\Translations;
use Gettext\Translator;
use Gettext\Merge;

class locale {
    
    public function register($dir, $language, $default){
        if(file_exists("{$dir}/{$language}.po")){
            $translations = Translations::fromPoFile("{$dir}/{$language}.po");
            if($default !== $language && file_exists("{$dir}/{$default}.po")){
                $translations->mergeWith(Translations::fromPoFile("{$dir}/{$default}.po"), Merge::DEFAULTS);
            }
        } elseif(file_exists("{$dir}/{$default}.po")){ 
            $translations = Translations::fromPoFile("{$dir}/{$default}.po");
        } else {
            return false;
        }

        //Create the translator instance
        $t = new Translator();
        $t->loadTranslations($translations);

        //set global functions
        $t->register();
        return true;
    }
    
    public function getFromRequest(){
        $locales = explode(",",str_replace("-","_",$_SERVER["HTTP_ACCEPT_LANGUAGE"]));
        $return = array();
        
        foreach ($locales as $locale){
            $locale = strtolower(current(explode("_", current(explode(";", $locale)))));
            if(!in_array($locale, $return)){
                $return[] = $locale;
            }
        }
        
        return $return;
    }
}
