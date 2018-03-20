<?php
namespace app\admin\controller;
use app\admin\controller\Common;
use app\admin\model\Cate as CateModel;
use app\admin\model\Article as ArticleModel;

class Cate extends Common
{
   protected $beforeActionList = [
         'delsoncate'  =>  ['only'=>'del'],
    ];
    //列表
    public function index()
    {
       $cate=new CateModel();
       if(request()->isPost()){
        $sorts=input('post.');
        foreach ($sorts as $key => $value) {
          $cate->update(['id' => $key, 'sort' => $value]);
        }
        $this->success('更新成功！',url('cate/index'));
        return;
       }
       $cateres=$cate->catetree();
       $this->assign('data',$cateres);
       return $this->fetch();
    }
    //添加
    public function add()
    {
    	$cate=new CateModel();
       if(request()->isPost()){
	       	$pData=input('post.');	       
	       	$res=$cate->save($pData);
	       	if($res){
	       		$this->success('添加用户信息成功！',url('cate/index'));
	       	}else{
	       		$this->error('添加用户信息失败！');
	       	}
	       	return;
       }
       // $cateres=$cate->select();
       // $this->assign('data',$cateres);
       $cateres=$cate->catetree();
       $this->assign('data',$cateres);
       return $this->fetch();
    }
    //删除
    public function del($id)
    {
       $res=db('cate')->delete($id);
       if($res){
          $this->success('删除成功！');
       }else{
          $this->error('删除失败！');
       }
       return $this->fetch();
    }
    public function delsoncate()
    {
       $cataid=input('id');//要删除当前栏目id
       $cate=new CateModel();
       $sonid=$cate->getChildrenid($cataid);  //删除当前子栏目的id

       $allcataid=$sonid;
       $allcataid[]=$cataid;  //子栏目与主栏目在类的所有栏目
       foreach ($allcataid as $k => $v) {
          $article=new ArticleModel();
          $article->where(array('cateid' => $v))->delete();  //删除关联文章
       }

       if($sonid){
           $res=db('cate')->delete($sonid);
       }
    }
    //编辑
    public function edit()
    {
      $cate=new CateModel();
      if(request()->isPost()){
          $pData=input('post.');         
          $res=$cate->save($pData,['id' => input('id')]);
          if($res){
            $this->success('添加用户信息成功！',url('cate/index'));
          }else{
            $this->error('添加用户信息失败！');
          }
          return;
      }
       $cateres=$cate->catetree();
       $cates=$cate->find(input('id'));
       $this->assign(array(
          'cateres' => $cateres, 
          'cates' => $cates,
        ));
       return $this->fetch();
    }
}
