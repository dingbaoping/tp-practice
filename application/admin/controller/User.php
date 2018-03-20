<?php
namespace app\admin\controller;
use app\admin\controller\Common;
use app\admin\model\User as UserModel;

class User extends Common
{
    public function index()
    {
       $user=new UserModel();
       $res=$user->getUser();
       $this->assign('data',$res);
       return $this->fetch();
    }
    public function add()
    {
    	$user=new UserModel();
       if(request()->isPost()){
	       	$pData=input('post.');	       
	       	// $res=$user->addUser($pData);
	       	$res=$user->save($pData);
	       	if($res){
	       		$this->success('添加用户信息成功！',url('user/index'));
	       	}else{
	       		$this->error('添加用户信息失败！');
	       	}
	       	return;
       }
       $res=db('user')->distinct(true)->field('course_id,course_name')->select();
       $this->assign('data',$res);
       return $this->fetch();
    }
}
