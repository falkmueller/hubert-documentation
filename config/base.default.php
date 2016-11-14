<?php

return array(
    
    "factories" => array(
        "session" => array(hubert\extension\session\factory::class, 'get'),
    ),
    
    "config" => array(
        "bootstrap" => \app\bootstrap::class,
        "basedir" => dirname(__dir__),
        "locale" => array(
             "dir" => dirname(__dir__).'/data/locale/',
             "default" => "en",
             "available" => array("de", "en")
        ),
        "session" => array(
            'remember_me_seconds' => 1800,
            'validate_user_agend' => true,
            'validate_remote_addr' => true
        )
    ),
    
    "namespace" => array(
        "app" => dirname(__dir__)."/app/"
    )
);

