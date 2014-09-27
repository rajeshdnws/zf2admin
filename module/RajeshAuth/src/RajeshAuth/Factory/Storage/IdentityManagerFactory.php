<?php
namespace RajeshAuth\Factory\Storage;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use RajeshAuth\Storage\IdentityManager;

class IdentityManagerFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $authService = $serviceLocator->get('AuthService');
        $identityManager = new IdentityManager($authService);

        return $identityManager;
    }
}
