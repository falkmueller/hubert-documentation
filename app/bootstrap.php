<?php

namespace app;

use Leafo\ScssPhp\Compiler as ScssCompiler;

class bootstrap extends \hubert\generic\bootstrap{
    
    public function init(){
        //set Shared Data vor all Templates
        //$this->_container["template"]->addData(array("name" => "ronny"));
        
        $query_params = hubert()->request->getQueryParams();
        if(isset($query_params["compile"]) ){ //&& $this->_container["request"]->getUri()->getHost() == "localhost"
            $this->compile_css();
        }
    }
    
    private function compile_css() {
        set_time_limit(120);
        
        

        //$css_url = $this->_container["router"]->getBasePath().'/public/'; //"http://".$this->app["request"]->getUri()->getHost().'
        
        $css_output_file = hubert()->config()->basedir.'/public/styles.min.css';

        //$options = array( 'compress'=>true );
        $compiler = new ScssCompiler();
        $compiler->setImportPaths(hubert()->config()->basedir.'/public/scss/');
        $compiler->setFormatter('Leafo\ScssPhp\Formatter\Compressed');
        
        //$parser->parseFile( $this->_container["config"]["basedir"].'/public/less/styles.less', $css_url );
        $css = $compiler->compile('@import "styles.scss";');
        file_put_contents($css_output_file, $css);
        $css = null;
    } 
    
    private function compile_js(){
        set_time_limit(120);
        require_once './libs/JShrink/Minifier.php';
        $js_output_file = __dir__.'/scripts/script.min.js';
        //creat js file
        file_put_contents($js_output_file, "");

        $js_array = json_decode(file_get_contents(__dir__."/min/js.json"), true);
        foreach($js_array as $js_file){
            $js = file_get_contents(__dir__."/".$js_file["file"]);
            if($js_file["minify"]){
               $js = \JShrink\Minifier::minify($js);
            }
            file_put_contents($js_output_file, $js.PHP_EOL , FILE_APPEND);
        }
    }
    
}
