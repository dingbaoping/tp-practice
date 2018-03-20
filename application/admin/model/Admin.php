<?php

namespace app\admin\model;
use think\Model;

class Admin extends Model
{
    public function addAdmin($data)
    {
        if(empty($data) || !is_array($data)){
            return false;
        }
        if($data['paw']){
        	$data['paw']=md5($data['paw']);
        }
        $adminData = array();
        $adminData['username']=$data['username'];
        $adminData['paw']=$data['paw'];
        if($this->save($adminData)){
            $groupAccess['uid']=$this->id;
            $groupAccess['group_id']=$data['group_id'];
            db('auth_group_access')->insert($groupAccess);
        	return true;
        }else{
        	return false;
        }
    }
    public function getAdmin()
    {
        return $this->paginate(5);
    }
    public function delAdmin($id)
    {
        if($this::destroy($id)){
            return 1;
        }else{
            return 2;
        }
    }
    public function login($data)
    {
        $admin=Admin::getByUsername($data['username']);
        if($admin){
            if($admin['paw']==md5($data['paw']) || $admin['paw']==$data['paw']){
                session('id', $admin['id']);
                session('username', $admin['username']);
                return 2; //登录信息正确
            }else{
                return 3; //密码错误
            }
        }else{
            return 1; //用户名不存在
        }
       
    }
}
