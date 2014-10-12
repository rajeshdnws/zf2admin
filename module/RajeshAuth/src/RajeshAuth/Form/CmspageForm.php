<?php
namespace RajeshAuth\Form;

use Zend\Form\Form;
use Zend\InputFilter\Factory as InputFilterFactory;
use Zend\Form\Element;
use Admin\Form\AbstractForm ;

class CmspageForm extends AbstractForm
{
    public function init()
    {
        $inputFilterFactory = new InputFilterFactory();
        $inputFilter    = $inputFilterFactory->createInputFilter(
            array(
                'title' => array(
                    'required' => true,
                    'validators' => array(
                        array('name' => 'not_empty'),
                                        ),
                ),
                  'aliase' => array(
                    'required' => true,
                    'validators' => array(
                        array('name' => 'not_empty'),
                                        ),
                ),
                'content' => array(
                    'required' => true,
                    'validators' => array(
                        array('name' => 'not_empty'),
                     
                    ),
                ),
                'metatitle' => array(
                    'required' => false,
                    'validators' => array(
                        array('name' => 'not_empty'),
                    ),
                ),
                'metakey' => array(
                    'required' => false,
                    'validators' => array(
                        array('name' => 'not_empty'),
                    ),
                ),
                    'metadesc' => array(
                    'required' => false,
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

        $title = new Element\Text('title');
        $title->setLabel('Page Title')
            ->setLabelAttributes(
                array(
                    'class' => 'required control-label col-lg-2',
                )
            )
            ->setAttribute('class', 'form-control')
            ->setAttribute('id', 'title');
        $this->add($title);
  $aliase = new Element\Text('aliase');
        $aliase->setLabel('Page URL')
            ->setLabelAttributes(
                array(
                    'class' => 'required control-label col-lg-2',
                )
            )
            ->setAttribute('class', 'form-control')
            ->setAttribute('id', 'aliase');
        $this->add($aliase);
        $conetnt = new Element\Textarea('content');
        $conetnt->setLabel('Page Conetnt')
            ->setLabelAttributes(
                array(
                    'class' => 'required control-label col-lg-2',
                )
            )
            ->setAttribute('class', 'form-control')
            ->setAttribute('id', 'editor1');
        $this->add($conetnt);

         $metatitle = new Element\Text('metatitle');
        $metatitle->setLabel('Meta Title')
            ->setLabelAttributes(
                array(
                    'class' => 'required control-label col-lg-2',
                )
            )
            ->setAttribute('class', 'form-control')
            ->setAttribute('id', 'metatitle');
        $this->add($metatitle);

        $metakey = new Element\Text('metakey');
        $metakey->setLabel('Meta keyword')
            ->setLabelAttributes(
                array(
                    'class' => 'required control-label col-lg-2',
                )
            )
            ->setAttribute('class', 'form-control')
            ->setAttribute('id', 'metakey');
        $this->add($metakey);
        $metadesc= new Element\Text('metadesc');
        $metadesc->setLabel('Meta description')
            ->setLabelAttributes(
                array(
                    'class' => 'required control-label col-lg-2',
                )
            )
            ->setAttribute('class', 'form-control')
            ->setAttribute('id', 'metadesc');
        $this->add($metadesc);

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
   
}
