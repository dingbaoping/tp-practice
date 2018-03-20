<?php
namespace app\admin\controller;
use app\admin\controller\Common;
use app\admin\model\AuthRule as AuthRuleModel;

class AuthRule extends Common
{
    //列表
    public function index()
    {
      $auth=new AuthRuleModel();
       if(request()->isPost()){
        $sorts=input('post.');
        foreach ($sorts as $key => $value) {
          $auth->update(['id' => $key, 'sort' => $value]);
        }
        $this->success('更新成功！',url('auth_rule/index'));
        return;
       }
       $authres=$auth->authtree();
       $this->assign('data',$authres);
       return $this->fetch();
    }
    //添加
    public function add()
    {
      $auth=new AuthRuleModel();
       if(request()->isPost()){
          $pData=input('post.'); 
                 
          $res=$auth->save($pData);
          if($res){
            $this->success('添加用户信息成功！',url('auth_rule/index'));
          }else{
            $this->error('添加用户信息失败！');
          }
          return;
       }
       $authres=$auth->authtree();
       $this->assign('data',$authres);
       return $this->fetch();
    }
     //编辑
    public function edit()
    {
      $auth=new AuthRuleModel();
      if(request()->isPost()){
          $pData=input('post.');         
          $res=db('auth_rule')->update($pData);
          if($res){
            $this->success('添加链接成功！',url('auth_rule/index'));
          }else{
            $this->error('添加链接失败！');
          }
          return;
      }
      $authres=$auth->authtree();
       $authf=$auth->find(input('id'));
       $this->assign(array(
          'authres' => $authres, 
          'data' => $authf,
        ));
       return $this->fetch();
    }
    //删除
    public function del()
    {
      $auth=new AuthRuleModel();
      $auth->getParentid(input('id'));
      
      $authid=$auth->getChildrenid(input('id')); 
      $authid[]=input('id');

       $res=AuthRuleModel::destroy(input('id'));
       if($res){
          $this->success('删除成功！');
       }else{
          $this->error('删除失败！');
       }
       return $this->fetch();
    }
   
}
