<?php
//filename : module/RajeshAuth/src/RajeshAuth/Controller/SuccessController.php
namespace RajeshAuth\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use RajeshAuth\Model\Collection;
use Zend\Session\Container;
 use RajeshAuth\Model\Model;
use RajeshAuth\Form\CmspageForm;
 use Zend\View\Model\JsonModel;
class SuccessController extends AbstractActionController
{
protected $_profileTable;

    public function indexAction()
    {
         $viewModel = new ViewModel();
     $profile=new Collection();

        $profile->getKeystatus();
        return $viewModel;
    }
    
   
    public function cmspageAction()
    {
         $viewModel = new ViewModel();
          $profile=new Collection();

        
        $viewModel->setVariable('rows', $profile->getCnspage());
        return $viewModel;
    }
    public function addAction()
      {
          $viewModel = new ViewModel();
         $form= new CmspageForm();
      
      $post = $this->getRequest()->getPost()->toArray();
       if($this->getRequest()->isPost())
       {
       $form->setData($post);
       $form->getInputFilter();
        if($form->isValid())
        {
       $userModel = new Model();
       $userModel->setData($post);
       $id='';
       $check=$userModel->checkURL($post['aliase'],$id);
       if($check=='true'){
       $userModel->savepage();
       $this->flashMessenger()->addSuccessMessage('Page saved!');
       
       return $this->redirect()->toRoute('success', array('action' => 'cmspage','id' => $userModel->getId()));
       }else
       {
       $viewModel->setVariable('error', 'URL already exist');
       $viewModel->setVariable('form', $form);
       return $viewModel;
        exit;   
       }
       }
       $viewModel->setVariable('error', 'Page not create');
       $viewModel->setVariable('form', $form);
       return $viewModel;
        exit;
       }
       $viewModel->setVariable('error', '');
       $viewModel->setVariable('form', $form);
       return $viewModel;
    }
     public function editAction()
    {
         $viewModel = new ViewModel();
     $profile=new Collection();

        $profile->getKeystatus();
        return $viewModel;
    }
      public function deleteAction()
    {
         $viewModel = new ViewModel();
     $profile=new Collection();

        $profile->getKeystatus();
        return $viewModel;
    }
    public function ajaxrequestAction()
    {
     $viewModel = new ViewModel();
      $drop=new Collection();
   $this->_index = ($_REQUEST['index'])?$_REQUEST['index']:NULL;
     $id = ($_REQUEST['id'])?$_REQUEST['id']:NULL;
     switch($this->_index){
     case 'country':
            $this->_query=$drop->getCountry();
             break;
     case 'state':
             $this->_query=$drop->getState($id);       
             break;
     case 'city':          
              $this->_query=$drop->getCity($id);             
             break;
     default:
             break;
     }
     $this->show_result();
     $viewModel->setTerminal(true);
     //$viewModel ->setvariable('tempData','ssss');
    return $viewModel;
}
public function show_result(){
     echo '<option value="">Select '.$this->_index.'</option>';
     $rows = $this->_query;
    // echo '<pre>'; print_r($rows);die;
     $i=0;
     for($i=0;$i<sizeof($rows); $i++){
          
             $entity_id = $rows[0][$i];
             $enity_name = $rows[1][$i];
             echo "<option value='$entity_id'>$enity_name</option>";
            
     }
}
public function getHtmlrespAction()
    {
     $viewModel = new ViewModel();
    $request=$this->getRequest();
    if($request->isXmlHttpRequest()){
    $data=$request->getPost();
    if(isset($data['tempData'])&&!empty($data['tempData'])){
   
     $viewModel->setvariable('tempData',$data['tempData']);
    }
    }
    $viewModel->setTerminal(true);
    return $viewModel;
}
}
