<?php

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Application\Model\Application;
use Application\Form\ApplicationForm;

class IndexController extends AbstractActionController
{
protected $aboutusTable;

public function indexAction()
{
return new ViewModel();
}
public function getApplicationTable()
{
if (!$this->aboutusTable) {
$sm = $this->getServiceLocator();

$this->aboutusTable = $sm->get('Application\Model\ApplicationTable');
}
return $this->aboutusTable;
}    
}
