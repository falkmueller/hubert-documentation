<?php
/**
 * http://platesphp.com
 */
return array(
    "factories" => array(
        "template" => array(hubert\extension\template\factory::class, 'get')
        ),
    
    
   "config" => array(
       "template" => array(
           "path" => dirname(__dir__).'/app/templates/',
           "fileExtension" => "phtml",
           "extensions" => array(
               hubert\extension\template\urlExtension::class
           )
       )
   ),
);
