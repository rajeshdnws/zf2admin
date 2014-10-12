<?php
//filename : module/RajeshAuth/src/RajeshAuth/Storage/AuthStorage.php
namespace RajeshAuth\Storage;

use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Authentication\Storage;
use Zend\Session\Config\SessionConfig;
use Zend\Db\TableGateway\TableGateway;
use Zend\Session\SaveHandler\DbTableGateway;
use Zend\Session\SaveHandler\DbTableGatewayOptions;
use Zend\Session\Container;
class AuthStorage extends Storage\Session
    implements ServiceLocatorAwareInterface
{
    protected $serviceLocator;
    protected $namespace;

    public function __construct($namespace = null)
    {
        parent::__construct($namespace);

        $this->namespace = $namespace;
    }

    public function setDbHandler()
    {
        $tableGateway = new TableGateway('session', $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter'));
        $saveHandler = new DbTableGateway($tableGateway, new DbTableGatewayOptions());

        //open session
        $sessionConfig = new SessionConfig();
        $saveHandler->open($sessionConfig->getOption('save_path'), $this->namespace);
       $this->session->getManager()->setSaveHandler($saveHandler);
        
    }

    public function write($contents)
    {
        parent::write($contents);
        //check if $contents is array
        if (is_array($contents) && !empty($contents)) {
            $this->getSessionManager()
             ->getSaveHandler()->write($this->getSessionId(), \Zend\Json\Json::encode($contents));
        }
    }

    public function clear()
    {
        $this->getSessionManager()->getSaveHandler()->destroy($this->getSessionId());
         $this-> getSessionName('');
        parent::clear();
    }

    public function getSessionManager()
    {
        return $this->session->getManager();
    }

    public function getSessionId()
    {
        return $this->session->getManager()->getId();
    }
     public function getSessionName($ses)
    {
      $user_session = new Container('admin');
      $user_session->admin = $ses;
    }
    public function setServiceLocator(ServiceLocatorInterface $serviceLocator)
    {
        $this->serviceLocator = $serviceLocator;
    }

    public function getServiceLocator()
    {
        return $this->serviceLocator;
    }
}
