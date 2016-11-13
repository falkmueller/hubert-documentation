<?php return array(
    
    "factories" => array(
        "md" => array(app\container\md\factory::class, 'get'),
    ),
    
    "config" => array(
        "md" => array(
            "path" => dirname(__dir__).'/app/sites',
            "template" => "md/page"
        )
    ),
    
     "routes" => array(
            "home" => array(
                "route" => "/", 
                "method" => "GET|POST", 
                "target" => array("namespace" => "app\\container\\md","controller" => "index", "action" => "parse")
            ),
            "md" => array(
                "route" => "/[*:path]", 
                "method" => "GET|POST", 
                "target" => array("namespace" => "app\\container\\md","controller" => "index", "action" => "parse")
            )
        )
);
