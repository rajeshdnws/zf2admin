<?php
//filename : module/RajeshAuth/src/RajeshAuth/Controller/SuccessController.php
namespace RajeshAuth\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use RajeshAuth\Model\Collection;
use Zend\Session\Container;

class SuccessController extends AbstractActionController
{
protected $_profileTable;

    public function indexAction()
    {
         $viewModel = new ViewModel();
     // $user_session = new Container('rajeshauth');
    // $user =$this->getProfileTable()->fetchAll();
      //$this->hasIdentity();
     // $this->identityManager->hasIdentity();
       // echo '<pre>'; var_dump($user);//die;
        return $viewModel;
    }
    public function getProfileTable() {
        if (!$this->_profileTable) {
            $sm = $this->getServiceLocator();
            $this->_profileTable = $sm->get('RajeshAuth\Model\Collection');
        }
        return $this->_profileTable;
    }
    public function setProfile($id)
    {
    $profil=$this->getProfileTable()->fetchAll($id);
    $user_session = new Container('admin');
      $user_session->admin = $profil;
      //   echo '<pre>'; var_dump($profil);die;

    }
}
