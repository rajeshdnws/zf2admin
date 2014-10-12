<?php
return array(
    // This should be an array of module namespaces used in the application.
    'modules' => array(
        'Application','Album','RajeshAuth','ZfcUser','ZfcBase','Cmspage',
    ),

    // These are various options for the listeners attached to the ModuleManager
    'module_listener_options' => array(
            'module_paths' => array(
            './module',
            './vendor',
        ),

        'config_glob_paths' => array(
            'config/autoload/{,*.}{global,local}.php',
        ),

    ),

'service_manager' => array(
        'use_defaults' => true,
        'factories' => array(),
    ),
    'autoloader' => array(
        'namespaces' => array(
             'Admin' => __DIR__ . '/../vendor/Admin',
            // 'admin' => str_replace('config/','',__DIR__ . '/vendor/admin'),

        ),
        'autoregister_zf' => true,
    ),
);
