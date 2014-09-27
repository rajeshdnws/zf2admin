<?php
//filename : module/RajeshAuth/src/RajeshAuth/Factory/Storage/AuthenticationServiceFactory.php
namespace RajeshAuth\Factory\Storage;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Authentication\AuthenticationService;
use Zend\Authentication\Adapter\DbTable as DbTableAuthAdapter;

class AuthenticationServiceFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $dbAdapter      	 = $serviceLocator->get('Zend\Db\Adapter\Adapter');
        $dbTableAuthAdapter  = new DbTableAuthAdapter($dbAdapter, 'users','username','password', 'MD5(?)');

        $authService = new AuthenticationService($serviceLocator->get('AuthStorage'), $dbTableAuthAdapter);

        return $authService;
    }
}
