<?php

namespace app\admin\controller;
// use app\admin\controller\Common;
use app\admin\model\Admin as AdminModel;

class Admin extends Common
{   
    public function index()
    {
        header("Content-type: text/html; charset=utf-8");
    	// $res=db('login_user')->select();

         // $res=AdminModel::find();
         $admin=new AdminModel();
         $res=$admin->getAdmin();
        // var_dump($res);die;
          $roles=db('admin')                
                ->join('auth_group_access','admin.id= auth_group_access.uid')               
                ->join('auth_group','auth_group_access.group_id= auth_group.id')
                ->field('admin.id,admin.username,auth_group.title')
                ->select();

         // $auth=new Auth();
         // $roles=$auth->getGroups(session('id'));
         // dump($roles);
         $this->assign(array(
            'data'=>$res,
            'roles'=>$roles
        ));
    	return $this->fetch();
    }
    public function add()
    {
    	if(request()->isPost()){
    		$data=input('post.');
    		
    		$admin=new AdminModel();
    		$res=$admin->addAdmin($data);

    		if($res){
    			$this->success('添加管理员成功！',url('index'));
    		}else{
    			$this->error('添加管理员失败！');
    		}
    		return ;
    	}
        $authGroup=db('auth_group')->select();
    	$this->assign('authGroup',$authGroup);
    	return $this->fetch();
    }
    public function edit($id)
    {
        $data=db('admin')->find($id);
        if(request()->isPost()){
            $pData=input('post.');
            if(!$pData['username']){
                $this->error('管理员用户名不能为空！');
            }
            if(!$pData['paw']){
                $pData['paw']=$data['paw'];
            }else{
                 $pData['paw']=md5($pData['paw']);
            }
            $adminData = array();
            $adminData['username']=$pData['username'];
            $adminData['paw']=$pData['paw'];

            $res=db('admin')->where('id', input('id'))->update($adminData);
            if($res!==false){
                db('auth_group_access')->where(array('uid' => $id))->update(['group_id'=>$pData['group_id']]);

                $this->success('修改管理员成功！',url('index'));
            }else{
                $this->error('修改管理员失败！');
            }
            return;
        }
       
        if(!$data){
            $this->error('该管理员不存在！');
        }
        $authGroup=db('auth_group')->select();
        $groupAccess=db('auth_group_access')->where(array('uid' => $id))->find();

        $this->assign(array(
            'data' => $data,
            'authGroup' => $authGroup, 
            'groupAccess'=>$groupAccess
        ));
    	return $this->fetch();
    }
    public function del($id)
    {
        //方法一、数据库操作
        // $res=db('admin')->delete($id);
        // if($res){
        //     $this->success('删除成功',url('index'));
        // }else{
        //     $this->error('删除失败');
        // }
        //方法二、model操作
        $admin=new AdminModel();
        $res=$admin->delAdmin($id);
        if($res==1){
            db('auth_group_access')->where(array('uid' => $id))->delete();
            $this->success('删除成功',url('index'));
        }else{
            $this->error('删除失败');
        }
    }
    public function loginout()
    {
        session(null);
        $this->success('退出成功',url('login/index'));

    }
}
