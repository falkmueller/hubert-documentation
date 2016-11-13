<?php

namespace app\container\md;

class node {
    
    private $_path;
    private $_children;
    private $_name; 
    private $_parent;
    private $_url;
    private $_config;
            
    function __construct($_file_path, self &$parent = null){
        $this->_path = $_file_path;
        $this->_path .= preg_match('/\/$/', $this->_path) ? "" : "/";
        $this->_parent = $parent;
    }
    
    public function getPath(){
        return  $this->_path;
    }

    public function getParent(){
        return $this->_parent;
    }

    public function getChildren(){
        if(is_array($this->_children)){
            return $this->_children;
        }
        
        $this->_children = array();
        foreach (glob($this->_path.'*', GLOB_ONLYDIR) as $folder){
            $this->_children[] = new self($folder, $this);
        }
        
        return $this->_children;
        
    }
    
    public function getName(){
        if($this->_name){
            return $this->_name;
        }
        
        $this->_name = basename($this->_path);
        $this->_name = trim(substr($this->_name, strpos($this->_name, ".")),".");
        
        return $this->_name;
    }
    
    public function getUrl(){
        if(isset($this->_url)){
            return $this->_url;
        }
        
        if($this->_parent){
            $this->_url = $this->_parent->getUrl().'/'.$this->getName();
        } else {
            $this->_url = "";
        }
        
        return $this->_url;
    }

    public function isActive($activeNode){
        
        if(preg_match('/^' . preg_quote($this->getUrl(), '/') . '/', $activeNode->getUrl())){
            return true;
        }
        
        return false;
    }


    public function getContent(){
        if(!file_exists($this->_path.'content.md')){
            $children = $this->getChildren();
            if(!empty($children)){
                return current($children)->getContent();
            }
            return "NOT FOUND";
        }
        
        return file_get_contents($this->_path.'content.md');
    }
    
    public function getConfig(){
        if(!is_array($this->_config)){
            $this->_config = array();
            
            if(file_exists($this->_path.'config.php')){
                $this->_config = require $this->_path.'config.php';
            }
        }
        
        return $this->_config;
    }
    
    public function searchChild($child_path){
        $search_path = $this->_path;
        
        $child_path = trim(urldecode($child_path),"/");
        
        if($child_path){
            $child_path = str_replace(array("..", "*"), "", $child_path);
            $child_path = str_replace("/", "/*", $child_path);
            $search_path .= "*".$child_path;
        } else {
            $search_path .= "*";
        }
        
        $match = glob($search_path, GLOB_ONLYDIR);
        
        if(empty($match)){
            return null;
        }
        
        $match_path = substr(current($match), strlen($this->_path));
        $node = $this;
        foreach (explode("/", $match_path) as $folder){
            $node = new self( $node->getPath().$folder,$node);
        }
        
        return $node;
    }
    
}
