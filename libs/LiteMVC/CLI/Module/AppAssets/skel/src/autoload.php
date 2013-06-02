<?php
require_once '../../../libs/LiteMVC/Autoloader/Classmap.php';
new LiteMVC\Autoloader\Classmap();
new LiteMVC\Autoloader\Universal(array(
    LiteMVC\Autoloader\Universal::CONFIG_NAMESPACE_MAP => array(
        '{{ucfirst_name}}\Controller' => __DIR__ . '/Controller',
        '{{ucfirst_name}}\Model' => __DIR__ . '/Model',
    ),
));