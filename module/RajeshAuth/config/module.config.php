<?php

//filename : RajeshAuth/config/module.config.php
namespace RajeshAuth;

return array(

    //controllers services...
    'controllers' => array(
        'factories' => array(
            'RajeshAuth\Controller\Auth' => 'RajeshAuth\Factory\Controller\AuthControllerServiceFactory'
        ),
        'invokables' => array(
            'RajeshAuth\Controller\Success' => 'RajeshAuth\Controller\SuccessController'
        ),
    ),

    //register auth services...
    'service_manager' => array(
        'factories' => array(
            'AuthStorage' => 'RajeshAuth\Factory\Storage\AuthStorageFactory',
            'AuthService' => 'RajeshAuth\Factory\Storage\AuthenticationServiceFactory',
            'IdentityManager' => 'RajeshAuth\Factory\Storage\IdentityManagerFactory',
        ),
    ),

    //routing configuration...
    'router' => array(
        'routes' => array(

            'auth' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/admin[/:action]',
                    'defaults' => array(
                        'controller' => 'RajeshAuth\Controller\Auth',
                        'action'     => 'index',
                    ),
                ),
            ),

            'success' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/success[/:action]',
                    'defaults' => array(
                        'controller' => 'RajeshAuth\Controller\Success',
                        'action'     => 'index',
                    ),
                ),
            ),
        ),
    ),

    //setting up view_manager
    'view_manager' => array(
        'template_path_stack' => array(
            'RajeshAuth' => __DIR__ . '/../view',
        ),
    ),
);
