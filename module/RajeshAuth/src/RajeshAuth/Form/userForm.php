<?php
namespace RajeshAuth\Form;

use Zend\Form\Form;
use Zend\InputFilter\Factory as InputFilterFactory;
use Zend\Form\Element;
use Admin\Form\AbstractForm ;
class userForm extends AbstractForm
{
  

    public function init()
    {
        $inputFilterFactory = new InputFilterFactory();
        $inputFilter        = $inputFilterFactory->createInputFilter(
            array(
                'email' => array(
                    'required' => true,
                    'validators' => array(
                        array('name' => 'not_empty'),
                        array('name' => 'email_address'),
                           array(
                            'name' => 'db\\no_record_exists',
                            'options' => array(
                                'table' => 'users',
                                'field' => 'email',
                                'adapter' => $this->getAdapter(),
                            ),
                        ),
                    ),
                ),
                'login' => array(
                    'required' => true,
                    'validators' => array(
                        array('name' => 'not_empty'),
                        array(
                            'name' => 'db\\no_record_exists',
                            'options' => array(
                                'table' => 'users',
                                'field' => 'username',
                                'adapter' => $this->getAdapter(),
                            ),
                        ),
                    ),
                ),
                'lastname' => array(
                    'required' => true,
                    'validators' => array(
                        array('name' => 'not_empty'),
                    ),
                ),
                'country' => array(
                    'required' => true,
                    'validators' => array(
                        array('name' => 'not_empty'),
                    ),
                ),
                 'firstname' => array(
                    'required' => true,
                    'validators' => array(
                        array('name' => 'not_empty'),
                    ),
                ),
               
                'state' => array(
                    'required' => true,
                    'validators' => array(
                        array('name' => 'not_empty'),
                    ),
                ),
               
                'city' => array(
                    'required' => true,
                    'validators' => array(
                        array('name' => 'not_empty'),
                    ),
                ),
               
               
                'active' => array(
                    'allow_empty' => true,
                ),
            )
        );

        $this->setInputFilter($inputFilter);

        $email = new Element\Text('email');
        $email->setLabel('Email')
            ->setLabelAttributes(
                array(
                    'class' => 'required control-label col-lg-2',
                )
            )
            ->setAttribute('class', 'form-control')
            ->setAttribute('id', 'email');
        $this->add($email);

        $login = new Element\Text('login');
        $login->setLabel('Login')
            ->setLabelAttributes(
                array(
                    'class' => 'required control-label col-lg-2',
                )
            )
            ->setAttribute('class', 'form-control')
            ->setAttribute('id', 'login');
        $this->add($login);

        $password = new Element\Password('password');
        $password->setLabel('Password')
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

        $lastname = new Element\Text('lastname');
        $lastname->setLabel('Lastname')
            ->setLabelAttributes(
                array(
                    'class' => 'required control-label col-lg-2',
                )
            )
            ->setAttribute('class', 'form-control')
            ->setAttribute('id', 'lastname');
        $this->add($lastname);

        $firstname = new Element\Text('firstname');
        $firstname->setLabel('Firstname')
            ->setLabelAttributes(
                array(
                    'class' => 'required control-label col-lg-2',
                )
            )
            ->setAttribute('class', 'form-control')
            ->setAttribute('id', 'firstname');
        $this->add($firstname);
        $country = new Element\Select('country');
        $country->setLabel('Select Country')
            ->setLabelAttributes(
                array(
                    'class' => 'required control-label col-lg-2',
                )
            )
            ->setAttribute('class', 'form-control')
            ->setValueOptions(array(''=>'Select Country'))
            ->setAttribute('id', 'country')
            ->setAttribute('onchange', "load_options(this.value,'state')");
        $this->add($country);
        $state = new Element\Select('state');
        $state->setLabel('Select state')
            ->setLabelAttributes(
                array(
                    'class' => 'required control-label col-lg-2',
                )
            )
            ->setValueOptions(array(''=>'Select state'))
            ->setAttribute('class', 'form-control')
            ->setAttribute('id', 'state')
             ->setAttribute('onchange', "load_options(this.value,'city')");
        $this->add($state);
        $city = new Element\Select('city');
        $city->setLabel('Select city')
            ->setLabelAttributes(
                array(
                    'class' => 'required control-label col-lg-2',
                )
            )
            ->setValueOptions(array(''=>'Select city'))
            ->setAttribute('class', 'form-control')
            ->setAttribute('id', 'city');
        $this->add($city);

        $active = new Element\Checkbox('active');
        $active->setLabel('Is active')
            ->setLabelAttributes(
                array(
                    'class' => 'required control-label col-lg-2'
                )
            )
            ->setAttribute('class', 'input-checkbox')
            ->setAttribute('id', 'active')
            ->setCheckedValue('1');
        $this->add($active);
      
        
    }

    /**
     * Set if yes or no password is required when user click on Save
     *
     * @return User
     */
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
}
