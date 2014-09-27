<?php
//filename : module/RajeshAuth/src/RajeshAuth/Factory/Controller/AuthControllerServiceFactory.php
namespace RajeshAuth\Factory\Controller;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use RajeshAuth\Controller\AuthController;

class AuthControllerServiceFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $identityManager = $serviceLocator->getServiceLocator()->get('IdentityManager');
        $controller = new AuthController($identityManager);

        return $controller;
    }
}
