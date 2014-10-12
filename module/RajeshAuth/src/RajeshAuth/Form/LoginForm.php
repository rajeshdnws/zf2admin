<?php
//filename : module/RajeshAuth/src/RajeshAuth/Form/LoginForm.php
namespace RajeshAuth\Form;

use Admin\Form\AbstractForm;
use Zend\Form\Element;
use Zend\InputFilter\Factory as InputFilterFactory;

class LoginForm extends AbstractForm
{
    /**
     * Initialize UserLogin form
     *
     * @return void
     */
    public function init()
    {
        $inputFilterFactory = new InputFilterFactory();
        $inputFilter        = $inputFilterFactory->createInputFilter(
            array(
                'username' => array(
                    'required' => true,
                    'validators' => array(
                        array('name' => 'not_empty'),
                    )
                ),
                'password' => array(
                    'required' => true,
                    'validators' => array(
                        array('name' => 'not_empty'),
                    ),
                ),
            )
        );

        $this->setInputFilter($inputFilter);

        $this->add(new Element('username'));
        $this->add(new Element('password'));
        $this->add(new Element('redirect'));
    }
}
