<?php

namespace app\container\md;

class md {
    
    protected $container;
    
    protected $root;

    public function __construct($container){
        $this->container = $container;
        $this->root = new node(hubert()->config()->md["path"]);
    }
    
    public function getRoot(){
        return $this->root;
    }
    
    public function parseMD($md){
        $Parsedown = new mdParser();
        return $Parsedown->text($md);
    }
    
}