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
    //echo $profil[0]->name;
  $user_session->name = $profil[0]->name;
     $user_session->email = $profil[0]->email;
     $user_session->id = $profil[0]->id;

    }
}
