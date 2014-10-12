<?php
namespace RajeshAuth\Form;

use Zend\Form\Form;
use Zend\InputFilter;
use Zend\Form\Element;


class chnagePasswordForm extends Form
{
    public function __construct($name = null)
    {
      parent::__construct();
        $this->setAttribute('method', 'post');
        
        $this->add(array(
            'name' => 'oldpassword',
            'type' => 'Password',
            'options' => array(
                'label' => 'Old Password'
            ),
        ));
        $oldpassword = new Element\Password('oldpassword');
        $oldpassword ->setLabel('New Password')
            ->setLabelAttributes(
                array(
                    'class' => 'required control-label col-lg-2',
                )
            )
            ->setAttribute('class', 'form-control')
            ->setAttribute('autocomplete', 'off')
            ->setAttribute('id', 'oldpassword');
        $this->add($oldpassword);
         $password = new Element\Password('password');
        $password->setLabel('New Password')
            ->setLabelAttributes(
                array(
                    'class' => 'required control-label col-lg-2',
                )
            )
            ->setAttribute('class', 'form-control')
            ->setAttribute('autocomplete', 'off')
            ->setAttribute('id', 'password');
        $this->add($password);

        $passwordConfirm = new Element\Password('password_confirm');
        $passwordConfirm->setLabel('Password Confirm')
            ->setLabelAttributes(
                array(
                    'class' => 'required control-label col-lg-2',
                )
            )
            ->setAttribute('class', 'form-control')
            ->setAttribute('autocomplete', 'off')
            ->setAttribute('id', 'password_confirm');
        $this->add($passwordConfirm);
          $this->add(array(
            'name' => 'Loginsubmit',
            'type' => 'Submit',
            'attributes' => array(
                'value' => 'Update',
                'class'=>'btn',
                'id' => 'Loginsubmit',
            ),
        ));
        $this->setInputFilter($this->createInputFilter());

    }
      public function passwordRequired()
    {
        $filter = $this->getInputFilter();
        $filter->add(
            array(
                'required' => true,
                'validators' => array(
                    array('name' => 'not_empty'),
                ),
            ),
            'password'
        );

        $filter->add(
            array(
                'required' => true,
                'validators' => array(
                    array('name' => 'not_empty'),
                ),
            ),
            'password_confirm'
        );

        return $this;
    }
     public function createInputFilter()
    {
        $inputFilter = new InputFilter\InputFilter();

        //username
        $username = new InputFilter\Input('oldpassword');
        $username->setRequired(true);
        $inputFilter->add($username);

        //password
        $password = new InputFilter\Input('password');
        $password->setRequired(true);
        $inputFilter->add($password);

        return $inputFilter;
    }
}
