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
                    'route'    => '/admin/login[/:action]',
                    'defaults' => array(
                        'controller' => 'RajeshAuth\Controller\Auth',
                        'action'     => 'index',
                    ),
                ),
                ),
                        'auth' => array(
                             'type'    => 'segment', 
                        'options' => array(
                       'route'    => '/admin/user[/:action][/:id]',
                         'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'RajeshAuth\Controller\Auth',
                        'action'     => 'user',
                    ),
                ),            
                      
                 ),
             
                  
            'success' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/admin/success[/:action]',
                    'defaults' => array(
                        'controller' => 'RajeshAuth\Controller\Success',
                        'action'     => 'index',
                    ),
                ),         
                        'may_terminate' => true,
                        'child_routes'  => array(
                        'cmpage' => array(
                             'type'    => 'Literal', 
                        'options' => array(
                       'route'    => '/admin/cmpage[/:action][/:id]',
                         'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'RajeshAuth\Controller\Success',
                        'action'     => 'cmspage',
                    ),
                    ),
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
