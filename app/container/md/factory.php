<?php

namespace app\container\md;

class factory {
    public static function get($container){
        return new md($container);
    }
   
}