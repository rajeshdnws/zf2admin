<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'Cmspage\Controller\Cmspage' => 'Cmspage\Controller\CmspageController',
        ),
    ),
    
    'router' => array(
        'routes' => array(
            'cmspageqq' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/cmspage[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Cmspage\Controller\Cmspage',
                        'action'     => 'index',
                    ),
                ),
            ),
        ),
    ),

    'view_manager' => array(
        'template_path_stack' => array(
            'cmspage' => __DIR__ . '/../view',
        ),
    ),
);