<?php
//filename : RajeshAuth/Module.php
namespace RajeshAuth;

use Zend\Mvc\MvcEvent;
use Zend\ModuleManager\ModuleManager;
use RajeshAuth\Model\Collection;
use Zend\Db\Adapter\Adapter as DbAdapter;
use Zend\Db\TableGateway\Feature\GlobalAdapterFeature;

class Module
{
    
     protected $directory = __DIR__;

    /**
     * Module namespace
     */
    protected $namespace = __NAMESPACE__;
    public function onBootstrap(MvcEvent $e)
    {
        $em = $e->getApplication()->getEventManager();
     $application    = $e->getApplication();

        $em->attach('route', array($this, 'checkAuthenticated'));
        $config         = $application->getConfig();
        if (isset($config['db'])) {
            $dbAdapter = $this->initDatabase($config);
            //$this->initSession($serviceManager, $dbAdapter);
        }
        
    }

    public function isOpenRequest(MvcEvent $e)
    {
             $routeMatch = $e->getRouteMatch();
            // echo '<pre>'; var_dump($routeMatch); die;
       //echo $e->getRouteMatch()->getParam('controller');
       $module_array = explode('\\', $e->getRouteMatch()->getParam('controller'));
      
        /*if ($e->getRouteMatch()->getParam('controller') == 'RajeshAuth\Controller\AuthController') {
            return true;
        }*/
        if($module_array[0]=='RajeshAuth')
        {
         return false;   
            
        }
        return true;
    }

    public function checkAuthenticated(MvcEvent $e)
    {
        if (!$this->isOpenRequest($e)) {
            $sm = $e->getApplication()->getServiceManager();
                      $hh=$sm->get('AuthService')->getStorage()->getSessionManager();
                      //var_dump($hh);die;

            if (! $sm->get('AuthService')->getStorage()->getSessionManager()
                        ->getSaveHandler()->read($sm->get('AuthService')->getStorage()->getSessionId())) {
                $e->getRouteMatch()
                ->setParam('controller', 'RajeshAuth\Controller\Auth')
                 ->setParam('action', 'index');
            }
        }
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . str_replace('\\', '/' , __NAMESPACE__),
                ),
            ),
        );
    }
    public function init(ModuleManager $manager)
{
    $events = $manager->getEventManager();
    $sharedEvents = $events->getSharedManager();
    $sharedEvents->attach(__NAMESPACE__, 'dispatch', function($e) {
        $controller = $e->getTarget();      
            $controller->layout('layout/layoutadmin');
   
    }, 100);
}
  public function getServiceConfig() {
        return array(
            'factories' => array(
                'RajeshAuth\Model\Collection'=> function($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $table = new Collection($dbAdapter);
                    return $table;
                },
            ),
        );
    }
     public function initDatabase(array $config)
    {
        $dbAdapter = new DbAdapter($config['db']);
        GlobalAdapterFeature::setStaticAdapter($dbAdapter);

        return $dbAdapter;
    }
}

