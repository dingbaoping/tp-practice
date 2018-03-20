<?php
namespace app\admin\model;
use think\Model;

class User extends Model
{
    public function getUser()
    {
       	return $this->paginate(5);
    }
    public function addUser($data)
    {
       if(empty($data) || !is_array($data)){
       		return false;
       }
       if($this->save($data)){
       	 	return true;
       }else{
       		return false;
       }
    }
}
