<?php
namespace app\admin\controller;
use app\admin\controller\Common;
use app\admin\model\Link as LinkModel;
// use app\admin\validate\Link as LinkValidate;


class Link extends Common
{
    //列表
    public function index()
    {
      $link=new LinkModel();
      if(request()->isPost()){
        $sorts=input('post.');
        foreach ($sorts as $key => $value) {
          $link->update(['id' => $key, 'sort' => $value]);
        }
        $this->success('更新成功！',url('link/index'));
        return;
       }
      $res=$link->order('sort desc')->paginate(5);
      $this->assign('data',$res);
       return $this->fetch();
    }
    //添加
    public function add()
    {
       if(request()->isPost()){
	       	$pData=input('post.');

            $validate = \think\Loader::validate('Link');
            if(!$validate->scene('add')->check($pData)){
                $this->error($validate->getError());
            }
            $res=LinkModel::create($pData);
	       	if($res){
	       		$this->success('添加链接成功！',url('link/index'));
	       	}else{
	       		$this->error('添加链接失败！');
	       	}
	       	return;
       }
       return $this->fetch();
    }
    //删除
    public function del($id)
    {
      $link=new LinkModel();
       $res=$link::destroy($id);
       if($res){
          $this->success('删除成功！');
       }else{
          $this->error('删除失败！');
       }
       return $this->fetch();
    }
    //编辑
    public function edit()
    {
      $link=new LinkModel();
      if(request()->isPost()){
          $pData=input('post.');         
          $res=$link->save($pData,['id' => input('id')]);
          if($res){
            $this->success('添加链接成功！',url('link/index'));
          }else{
            $this->error('添加链接失败！');
          }
          return;
      }
       $linkf=$link->find(input('id'));
       $this->assign('data',$linkf);
       return $this->fetch();
    }
}
