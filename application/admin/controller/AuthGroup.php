<?php
namespace app\admin\controller;
use app\admin\controller\Common;
use app\admin\model\AuthGroup as AuthGroupModel;
use app\admin\model\AuthRule as AuthRuleModel;


class AuthGroup extends Common
{
    //列表
    public function index()
    {
    	$auth=new AuthGroupModel();
     	$res=$auth->paginate(5);
     	$this->assign('data',$res);
       return $this->fetch();
    }
    //添加
    public function add()
    {
     	if(request()->isPost()){
     		$pData=input('post.');
            if($pData['rules']){
                $pData['rules']=implode(',', $pData['rules']);
            }
            // dump($pData);die; 
     		$res=AuthGroupModel::create($pData);
     		if($res){
     			$this->success('添加成功！',url('auth_group/index'));
     		}else{
     			$this->error('添加失败！');
     		}
     		return ;
     	}
        $auth=new AuthRuleModel();
        $authres=$auth->authtree();
        $this->assign('auth',$authres);
       return $this->fetch();
    }
    //编辑
    public function edit()
    {
    	if(request()->isPost()){
     		$pData=input('post.');
            
            if($pData['rules']){
                $pData['rules']=implode(',', $pData['rules']);
            }
     		$_pData = array();
     		foreach ($pData as $k => $v) {
     			$_pData[]=$k;
     		}
     		if(!in_array('status', $_pData)){
     			$pData['status']=0;
     		}

     		$res=db('auth_group')->update($pData);
     		// dump($res);die;
     		if($res){
     			$this->success('添加成功！',url('auth_group/index'));
     		}else{
     			$this->error('添加失败！');
     		}
     		return ;
     	}
        $auth=new AuthRuleModel();
        $authres=$auth->authtree();

     	$resf=db('auth_group')->where(['id'=>input('id')])->find();
     	$this->assign(array(
            'auth'=>$authres,
            'data'=>$resf
        ));    
       return $this->fetch();
    }
    //删除
    public function del($id)
    {
    	$res=db('auth_group')->where('id',$id)->delete();
	    if($res){
	     	$this->success('删除成功！');
	     }else{
			$this->error('删除失败！');
		}
       return $this->fetch();
    }
   
}
