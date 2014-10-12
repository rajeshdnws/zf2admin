<?php
       //filename : module/RajeshAuth/src/RajeshAuth/Controller/AuthController.php
       namespace RajeshAuth\Controller;
       
       use Zend\Mvc\Controller\AbstractActionController;
       use Zend\View\Model\ViewModel;
       use RajeshAuth\Storage\IdentityManagerInterface;
       use RajeshAuth\Model\Collection;
       use RajeshAuth\Model\Model;
       use Zend\View\Model\JsonModel;
       use RajeshAuth\Form\chnagePasswordForm;
       use RajeshAuth\Form\userForm;
       use RajeshAuth\Form\usereditForm;
       use Zend\Validator\Identical;
       use Zend\Session\Container;
       
       class AuthController extends AbstractActionController
       {
       protected $identityManager;
       
       //we will inject authService via factory
       public function __construct(IdentityManagerInterface $identityManager)
       {
       $this->identityManager = $identityManager;
       }
       
       public function indexAction()
       {
       $this->layout('layout/layout -login');
       if ($this->identityManager->hasIdentity()) {
       //redirect to success controller...
       return $this->redirect()->toRoute('success');
       }
       
       $form = $this->getServiceLocator()->get('FormElementManager')
       ->get('RajeshAuth\Form\LoginForm');
       $viewModel = new ViewModel();
       
       //initialize error...
       $viewModel->setVariable('error', '');
       //authentication block...
       $this->authenticate($form, $viewModel);
       
       $viewModel->setVariable('form', $form);
       
       return $viewModel;
       }
       
       /** this function called by indexAction to reduce complexity of function */
       protected function authenticate($form, $viewModel)
       {
       $request = $this->getRequest();
       if ($request->isPost()) {
       $form->setData($request->getPost());
       if ($form->isValid()) {
       $dataform = $form->getData();
       $result = $this->identityManager->login($dataform['username'], $dataform['password']);
       
       if ($result->isValid()) {
       //authentication success
       $identityRow = $this->identityManager->getAuthService()->getAdapter()->getResultRowObject();
//$this->setProfile($identityRow->id);
        // echo '<pre>'; var_dump($identityRow);die;
       
       $this->identityManager->storeIdentity(
       array('id'          => $identityRow->id,
       'username'   => $dataform['username'],
       'ip_address' => $this->getRequest()->getServer('REMOTE_ADDR'),
       'user_agent'    => $request->getServer('HTTP_USER_AGENT'))
       );
        $user_session = new Container('admin');
          //echo $profil[0]->name;
           $user_session->name = $identityRow->fname.' '.$identityRow->lname ;
           $user_session->email = $identityRow->email;
           $user_session->id = $identityRow->id;
       return $this->redirect()->toRoute('success', array('action' => 'index'));;
       } else {
       $viewModel->setVariable('error', 'Login Error');
       }
       }
       }
       }
       public function  changePasswordAction()
       {
       $user_session = new Container('admin');  
       $ChangePasswordForm = new chnagePasswordForm();
       $ChangePasswordForm->passwordRequired();
       $post = $this->getRequest()->getPost()->toArray();
       if ($this->getRequest()->isPost()) {
       $ChangePasswordForm->setData($post);
       $ChangePasswordForm->getInputFilter()
       ->get('password_confirm')
       ->getValidatorChain()
       ->addValidator(new Identical(empty($post['password']) ? null : $post['password']));
       // var_dump($ChangePasswordForm->isValid());
       //var_dump($post);
       $ChangePasswordForm->isValid();
       $userModel = new Model();
       if($userModel->checkpassword($user_session->id,$post['oldpassword']))
       {
       $userModel->setData($post);
       //$userModel->setPassword($post['password']);
       $userModel->setId($user_session->id);
       $userModel->updatepassword($user_session->id);
       $this->flashMessenger()->addSuccessMessage('Password has been change!');
       return $this->redirect()->toRoute('success', array('action' => 'index'));;
       
       }
       
       $this->useFlashMessenger();
       $this->flashMessenger()->addErrorMessage('Old Password is wrong');
       }
       return array('form' => $ChangePasswordForm);
       
       
       }
       public function logoutAction()
       {
       $this->identityManager->logout();
       
       return $this->redirect()->toRoute('auth');
       }
       public function userAction()
       {
       $userCollection = new Collection();
       
       return array('users' => $userCollection->getUsers());
       }
       
       public function addAction()
       {
       $form = new userForm();
       $form->setAttribute('action', $this->url()->fromRoute('auth', array('action' => 'add')));
       $form->passwordRequired();
       $post = $this->getRequest()->getPost()->toArray();
       if ($this->getRequest()->isPost()) {
       $form->setData($post);
       $form->getInputFilter()
       ->get('password_confirm')
       ->getValidatorChain()
       ->addValidator(new Identical(empty($post['password']) ? null : $post['password']));
       
       if ($form->isValid()) {
       $userModel = new Model();
       $userModel->setData($post);
       $userModel->setPassword($post['password']);
       $userModel->save();
       $this->flashMessenger()->addSuccessMessage('User saved!');
       
       return $this->redirect()->toRoute('auth', array('action' => 'user','id' => $userModel->getId()));
       }
       // var_dump($form->getMessages());
       $this->useFlashMessenger();
       $this->flashMessenger()->addErrorMessage('User can not be saved');
       }
       
       return array('form' => $form);
       }
       public function useFlashMessenger($forceDisplay = true)
       {
       $flashMessenger = $this->flashMessenger();
       $flashMessages  = array();
       foreach (array('error', 'success', 'info', 'warning') as $namespace) {
       $flashNamespace = $flashMessenger->setNameSpace($namespace);
       if ($forceDisplay) {
       if ($flashNamespace->hasCurrentMessages()) {
       $flashMessages[$namespace] = $flashNamespace->getCurrentMessages();
       $flashNamespace->clearCurrentMessages();
       }
       } else {
       if ($flashNamespace->hasMessages()) {
       $flashMessages[$namespace] = $flashNamespace->getMessages();
       }
       }
       }
       
       $this->layout()->setVariable('flashMessages', $flashMessages);
       }
       
       public function editAction()
       {
       $userId    = $this->getRouteMatch()->getParam('id');
       $userModel = Model::fromId($userId);
       $viewModel = new ViewModel();
       if (empty($userModel)) {
       // $this->flashMessenger()->addErrorMessage("Can't edit this user");
       $viewModel->setVariable('error', "Can't edit this user");
       return $this->redirect()->toRoute('auth', array('action' => 'user'));
       }
       
       $form = new usereditForm();
       $form->setAttribute('action', $this->url()->fromRoute('auth', array('action' => 'edit', 'id' => $userId)));
       $form->loadValues($userModel);
       if ($this->getRequest()->isPost()) {
       $post = $this->getRequest()->getPost()->toArray();
       if (!empty($post['password'])) {
       $form->passwordRequired();
       $form->getInputFilter()
       ->get('password_confirm')
       ->getValidatorChain()
       ->addValidator(new Identical($post['password']));
       }
       
       $form->setData($post);
       if ($form->isValid()) {
       $userModel->addData($post);
       $userModel->setId($userId);
       $userModel->setActive(
       empty($post['active']) ?
       false :
       $post['active']
       );
       
       if (!empty($post['password'])) {
       $userModel->setPassword($post['password']);
       }
       $check=$userModel->checknewemail($userId,$post['login'],$post['email']);
       
       if($check=='true'){                
       $userModel->save();
       $this->flashMessenger()->addSuccessMessage('This user has been saved');
       return $this->redirect()->toRoute('auth', array('action' => 'user', 'id' => $userId));
       exit;
       
       }else
       {
       
       //$this->flashMessenger()->addErrorMessage($check);
       $viewModel->setVariable('error',$check);
       $viewModel->setVariable('form', $form);
       return $viewModel;
       //return $this->redirect()->toRoute('auth', array('action' => 'edit', 'id' => $userId,'msg'=>$check));
       exit;
       }
       
       }
       
       $this->flashMessenger()->addErrorMessage('User can not be saved');
       }
       $viewModel->setVariable('form', $form);
       return $viewModel;
       }
       
       public function deleteAction()
       {
       $user = Model::fromId($this->getRouteMatch()->getParam('id'));
        if (!empty($user) and $user->delete()) {
            //return $this->returnJson(array('success' => true, 'message' => 'The user has been deleted'));
           return $this->redirect()->toRoute('auth', array('action' => 'user',  'message' => 'The user has been deleted'));
        }

        return $this->returnJson(array('success' => false, 'message' => 'User does not exists'));
       }
       public function getRouteMatch()
       {
       if (empty($this->routeMatch)) {
       $this->routeMatch = $this->getEvent()->getRouteMatch();
       }
       
       return $this->routeMatch;
       }
       public function returnJson(array $data)
    {
        $jsonModel = new JsonModel();
        $jsonModel->setVariables($data);
        $jsonModel->setTerminal(true);

        return $jsonModel;
    }
    
       }
