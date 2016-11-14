<?php return array(
    
    "config" => array(
        "controller_namespace" => "app\\controller",
    ),
    
    "factories" => array(
        "preDispatch" => array(app\service\preDispatcher::class, 'get')
    ),
    
    "routes" => array(
           "home" => array(
               "route" => "/", 
               "method" => "GET|POST", 
               "target" => array("controller" => "index", "action" => "index")
           ),
           "home_language" => array(
               "route" => "/[:language][/]?", 
               "method" => "GET|POST", 
               "target" => array("controller" => "index", "action" => "index")
           ),
           "doc" => array(
               "route" => "/[:language]/[*:path][/]?", 
               "method" => "GET|POST", 
               "target" => array("controller" => "doc", "action" => "index")
           )
    )
);
