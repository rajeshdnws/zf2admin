<?php
/**
 * This source file is part of chaudharyweb.com
 *

 */

namespace RajeshAuth\Model;    
use Admin\Db\AbstractTable;
use Zend\Authentication\Adapter;
use Zend\Authentication\Storage;
use Zend\Authentication\AuthenticationService;
use Zend\Db\Sql\Predicate\Expression;
use Zend\Db\Sql\Select;
use Zend\Validator\EmailAddress;
class Model extends AbstractTable
{
   
    protected $name = 'users';
    public function updatepassword($useid)
    {
    $this->events()->trigger(__CLASS__, 'before.save', $this);
     $arraySave = array(
            'password' =>md5(trim($this->getPassword())),
              );
     //echo 'kk='.$this->getPassword();die;
         try {
            $id = $useid;
            if (empty($id)) {
                $arraySave['created_at'] = new Expression('NOW()');
                $this->insert($arraySave);
                $this->setId($this->getLastInsertId());
            } else {
                $this->update($arraySave, array('id' =>$id));
            }

            $this->events()->trigger(__CLASS__, 'after.save', $this);

            return $this->getId();
        } catch (\Exception $e) {
            $this->events()->trigger(__CLASS__, 'after.save.failed', $this);
            throw new \Admin\Exception($e->getMessage(), $e->getCode(), $e);
        }
    }
    public function checkpassword($id,$oldpassword)
    {
       $this->name ='users';
        // echo md5($oldpassword);
        $select = $this->Select(array('password'=>md5($oldpassword),'id' =>$id));
        $result = $this->fetchRow($select);
	
    // var_dump($result); exit;
	return $result;   
        
    }
    
      public function checknewemail($id,$username,$email)
    {
       $this->name ='users';
        // echo md5($oldpassword);
//echo $id.'   '.$username.'   '.$email; die;
        $select = $this->Select(array('username'=>$username));
        $result = $this->fetchAll($select);
	$selects = $this->Select(array('email'=>$email));
        $results = $this->fetchAll($selects);
	if(count($result)>1)
	{
	 return "Username already exist";   

	}	
	elseif(count($results)>1)
	{
	 return "Email already exist";   
	    
	}else
	{
 	return 'true';
        }
        
    }
      public function checkURL($aliase,$id)
    {
       $this->name ='page';
    
        $select = $this->Select(array('aliase'=>$aliase));
        $result = $this->fetchAll($select);
	$this->name ='users';
	$editval=false;
	if($id!='')
	{
	if(count($result)>1)	
	$editval=true;
	}
	else
	{
	if(count($result)>0)
	$editval=true;
	}
	if($editval)
	{
	 return "URL already exist";   

	}	
	else
	{
 	return 'true';
        }
        
    }
 public function setPassword($userPassword, $encrypt = true)
    {
        $this->setData('password', ($encrypt ? md5(trim($userPassword)) : md5($userPassword)));
    }
    public function save()
    {
       //  $this->name ='page';
        $this->events()->trigger(__CLASS__, 'before.save', $this);
        $arraySave = array(
            'fname' => $this->getFirstname(),
            'lname' => $this->getLastname(),
            'email' => $this->getEmail(),
	    'country' =>$this->getCountry(),
	    'state' => $this->getState(),
	    'city' => $this->getCity(),
            'username' => $this->getLogin(),
            'updated_at' => new Expression('NOW()'),
            'retrieve_password_key' => $this->getRetrievePasswordKey(),
            'retrieve_updated_at' => $this->getRetrieveUpdatedAt(),
        );

        $password = $this->getPassword();
        if (!empty($password)) {
            $arraySave['password'] = $password;
        }

        if ($this->getDriverName() == 'pdo_pgsql') {
            $arraySave['active'] = $this->getActive() ? 'true' : 'false';
        } else {
            $arraySave['active'] = $this->getActive() ? 1 : 0;
        }

        try {
            $id = $this->getId();
            if (empty($id)) {
                $arraySave['created_at'] = new Expression('NOW()');
                $this->insert($arraySave);
                $this->setId($this->getLastInsertId());
            } else {
                $this->update($arraySave, array('id' => $this->getId()));
            }

            $this->events()->trigger(__CLASS__, 'after.save', $this);

            return $this->getId();
        } catch (\Exception $e) {
            $this->events()->trigger(__CLASS__, 'after.save.failed', $this);
            throw new \Admin\Exception($e->getMessage(), $e->getCode(), $e);
        }
    }

    
    
     public function savepage()
    {
       $this->name ='page';
        $this->events()->trigger(__CLASS__, 'before.save', $this);
        $arraySave = array(
            'title' => $this->getTitle(),
            'content' => $this->getContent(),
            'metatitle' => $this->getMetatitle(),	    
            'metakey' => $this->getMetakey(),
	    'aliase' => $this->getAliase(),
            'create_at' => new Expression('NOW()'),
            'metakey' => $this->getMetakey(),
            'metadesc' => $this->getMetadesc(),
        );

        
        if ($this->getDriverName() == 'pdo_pgsql') {
            $arraySave['status'] = $this->getActive() ? 'true' : 'false';
        } else {
            $arraySave['status'] = $this->getActive() ? 1 : 0;
        }

        try {
            $id = $this->getId();
            if (empty($id)) {
                $arraySave['update_at'] = new Expression('NOW()');
                $this->insert($arraySave);
                $this->setId($this->getLastInsertId());
            } else {
                $this->update($arraySave, array('id' => $this->getId()));
            }

            $this->events()->trigger(__CLASS__, 'after.save', $this);

            return $this->getId();
        } catch (\Exception $e) {
            $this->events()->trigger(__CLASS__, 'after.save.failed', $this);
            throw new \Admin\Exception($e->getMessage(), $e->getCode(), $e);
        }
	$this->name ='users';
    }

    public function delete()
    {
        $this->events()->trigger(__CLASS__, 'before.delete', $this);
        $id = $this->getId();
        if (!empty($id)) {
            try {
                parent::delete(array('id' => $id));
            } catch (\Exception $e) {
                throw new \Gc\Exception($e->getMessage(), $e->getCode(), $e);
            }

            $this->events()->trigger(__CLASS__, 'after.delete', $this);
            unset($this);

            return true;
        }

        $this->events()->trigger(__CLASS__, 'after.delete.failed', $this);

        return false;
    }
 public static function fromArray(array $array)
    {
        $userTable = new Model();
        $userTable->setData($array);
        $userTable->unsetData('password');
        $userTable->setOrigData();

        return $userTable;
    }

    /**
     * Initiliaze from id
     *
     * @param integer $userId User id
     *
     * @return RajeshAuth\Model
     */
    public static function fromId($userId)
    {
        $userTable = new Model();
        $row       = $userTable->fetchRow($userTable->select(array('id' => (int) $userId)));
        $userTable->events()->trigger(__CLASS__, 'before.load', $userTable);
	//echo '<pre>'; var_dump($row);die;
        if (!empty($row)) {
            $userTable->setData((array) $row);
	    $userTable->setLogin($row['username']);
	   // $userTable->setCountry('India');
	    $userTable->setFirstname($row['fname']);
	    $userTable->setLastname($row['lname']);
            $userTable->unsetData('password');
            $userTable->setOrigData();
            $userTable->events()->trigger(__CLASS__, 'after.load', $userTable);
            return $userTable;
        } else {
            $userTable->events()->trigger(__CLASS__, 'after.load.failed', $userTable);
            return false;
        }
    }

    
}
