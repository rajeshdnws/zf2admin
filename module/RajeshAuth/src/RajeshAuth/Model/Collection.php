<?php 
namespace RajeshAuth\Model;    
use Admin\Db\AbstractTable;
use Zend\Db\Sql\Select;
use Zend\Db\TableGateway\Feature\GlobalAdapterFeature;
use Zend\Db\Adapter\Adapter;

  class Collection extends AbstractTable{

    protected $table = 'profile';
    
  
        public function getKeystatus()
        {
        
        $this->name = 'keys_status';
        $select = new Select();
        $select->from('keys_status');
       $select->where('keys_status!=7');
        
        $result = $this->fetchAll($select);
                //  var_dump($this->getAdapter()); die;

        //$statement = $this->getAdapter()->query("select * from keys_status",Adapter::QUERY_MODE_EXECUTE);
	//$result = $statement->toArray();
      // echo '<pre>'; var_dump($result); die;
        return  $result;
        }
	 public function getCountry()
        {
        
        $select = new Select();
        $select->from('countries');
     
        $rows= $this->fetchAll($select);
	$row=array();
	$i=0;
	 foreach($rows as $result){
	 $row[0][$i]=$result['id'];
	 $row[1][$i]=$result['country_name'];
	 $i++;
	 }
         return  $row;
        }
	public function getState($id)
        {
        
        $select = new Select();
        $select->from('states');
         $select->where("country_id=$id");
        $rows= $this->fetchAll($select);
	$row=array();
	$i=0;
	 foreach($rows as $result){
	 $row[0][$i]=$result['id'];
	 $row[1][$i]=$result['state_name'];
	 $i++;
	 }
         return  $row;
        }
        
	public function getCity($id)
        {
        
        $select = new Select();
        $select->from('cities');
	 $select->where("state_id=$id");
      $rows= $this->fetchAll($select);
	$row=array();
	$i=0;
	 foreach($rows as $result){
	 $row[0][$i]=$result['id'];
	 $row[1][$i]=$result['city_name'];
	 $i++;
	 }
         return  $row;
        
        }
        protected function getAdapter()
        {
        return GlobalAdapterFeature::getStaticAdapter();
        }
     public function getUsers()
    {
         $this->name = 'users';
        $select = $this->select(
            function (Select $select) {
                $select->order('email');
            }
        );

        $rows  = $this->fetchAll($select);
        $users = array();
        foreach ($rows as $row) {
            $users[] =$row;
        }

       return $users;
    }
     public function getCnspage()
    {
         $this->name = 'page';
       $select = $this->select(
            function (Select $select) {
                $select->order('create_at');
            }
        );

        $rows  = $this->fetchAll($select);
        $users = array();
        foreach ($rows as $row) {
            $users[] =$row;
        }

       return $users;
    }
     
}