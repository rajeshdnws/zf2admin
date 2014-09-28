<?php 
namespace RajeshAuth\Model;
    
use Zend\Db\Adapter\Adapter;
use Zend\Db\TableGateway\AbstractTableGateway;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Where;

  class Collection extends AbstractTableGateway {

    protected $table = 'profile';
    public function __construct(Adapter $adapter) {
        $this->adapter = $adapter;
    }
     public function fetchAll($userid) {
        $resultSet = $this->select(function (Select $select) {
                      $select->where('userid=1');
                      $select->order('adde_date ASC');
                });
        $entities = array();
        foreach ($resultSet as $row) {
                $entities[] = $row;
        }
        return $entities;
    }
 
}