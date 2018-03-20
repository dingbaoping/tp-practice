<?php
namespace app\admin\controller;
use app\admin\controller\Common;
use app\admin\model\Cate as CateModel;
use app\admin\model\Article as ArticleModel;

class Article extends Common
{

    //列表
    public function index()
    {
      $res=db('article')->field('a.*,b.catename')->order('id')->alias('a')->join('cate b','a.cateid=b.id')->paginate(5);
      $this->assign('data',$res);
       return $this->fetch();
    }
    //添加
    public function add()
    {
    	
       if(request()->isPost()){
	       	$pData=input('post.');	
          $article=new ArticleModel();                

          // if($_FILES['thumb']['tmp_name']){
          //    $file = request()->file('thumb');
          //    $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads');
          //    if($info){
          //       $thumb='http://127.0.0.1/thinkphp/' . 'public' . DS . 'uploads'.'/'.$info->getSaveName();
          //       $pData['thumb']=$thumb;
          //   }else{
          //       echo $file->getError();
          //   }
          // }

           $res=$article->save($pData);
	       	if($res){
	       		$this->success('添加文章成功！',url('article/index'));
	       	}else{
	       		$this->error('添加文章失败！');
	       	}
	       	return;
       }
       $cate=new CateModel();
       $cateres=$cate->catetree();
       $this->assign('data',$cateres);
       return $this->fetch();
    }
    //删除
    public function del($id)
    {
       // $article=new ArticleModel();
       // $res=$article->delete($id);
        $res=ArticleModel::destroy($id);
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
     $article=new ArticleModel();
      if(request()->isPost()){
          $pData=input('post.');         
          $res=$article->save($pData,['id' => input('id')]);
          if($res){
            $this->success('修改文章成功！',url('article/index'));
          }else{
            $this->error('修改文章失败！');
          }
          return;
      }
       $cate=new CateModel();
       $cateres=$cate->catetree();
       $article=$article->find(input('id'));
       $this->assign(array(
          'cateres' => $cateres, 
          'article' => $article,
        ));
       return $this->fetch();
    }
}
