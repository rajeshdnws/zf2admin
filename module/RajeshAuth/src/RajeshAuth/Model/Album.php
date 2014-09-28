<?php
namespace RajeshAuth\Model;

use Zend\InputFilter\InputFilter;
use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class Album implements InputFilterAwareInterface
{
  public $id;
    public $useid;
    public $name;
      public $email;
        public $city;
          public $address;
            public $phone;

    protected $inputFilter;

    /**
     * Used by ResultSet to pass each database row to the entity
     */
    public function exchangeArray($data)
    {
        $this->id     = (isset($data['id'])) ? $data['id'] : null;
        $this->useid = (isset($data['useid'])) ? $data['useid'] : null;
        $this->name  = (isset($data['name'])) ? $data['name'] : null;
        $this->email     = (isset($data['email'])) ? $data['email'] : null;
        $this->city = (isset($data['city'])) ? $data['city'] : null;
        $this->address  = (isset($data['address'])) ? $data['address'] : null;
        $this->phone  = (isset($data['phone'])) ? $data['phone'] : null;
    }

    public function getArrayCopy()
    {
        return get_object_vars($this);
    }

   
    
}
