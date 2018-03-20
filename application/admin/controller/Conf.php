<?php
namespace app\admin\controller;
use app\admin\controller\Common;
use app\admin\model\Conf as ConfModel;

class Conf extends Common
{
    //列表
    public function index()
    {
      $conf=new ConfModel();
      $res=$conf->paginate(5);
      $this->assign('data',$res);
       return $this->fetch();
    }
    //添加
    public function add()
    {
      $conf=new ConfModel();
       if(request()->isPost()){
	       	$pData=input('post.');
           $validate = \think\Loader::validate('Conf');
            if(!$validate->check($pData)){
                $this->error($validate->getError());
            }
          if($pData['values']){
            $pData['values']=str_replace('，', ',', $pData['values']);
          }       
	       	$res=$conf->save($pData);
	       	if($res){
	       		$this->success('添加配置项成功！',url('conf/index'));
	       	}else{
	       		$this->error('添加配置项失败！');
	       	}
	       	return;
       }

       return $this->fetch();
    }
    //删除
    public function del($id)
    {
       $conf=new ConfModel();
       $res=$conf::destroy($id);
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
      $conf=new ConfModel();
      if(request()->isPost()){
          $pData=input('post.'); 
          if($pData['values']){
            $pData['values']=str_replace('，', ',', $pData['values']);
          }          
          $res=$conf->save($pData,['id' => input('id')]);
          if($res){
            $this->success('修改配置项成功！',url('conf/index'));
          }else{
            $this->error('修改配置项失败！');
          }
          return;
      }
      $resf=$conf->find(input('id'));
      $this->assign('data',$resf);
       return $this->fetch();
    }

    //配置项
    public function conf(){
        $conf=new ConfModel();
        if(request()->isPost()){
            $pData=input('post.');
            $formarr= array();
            foreach ($pData as $k => $v) {
              $formarr[]=$k;
            }
            $_confarr=$conf->field('enname')->select();
            $confarr=array();
            foreach ($_confarr as $k => $v) {
              $confarr[]=$v['enname'];
            }
            foreach ($confarr as $k => $v) {
              if(!in_array($v,$formarr)){
                $checkarr[]=$v;
              }

            }
             // dump($checkarr);die; 
            if($pData){
              foreach ($pData as $k => $v) {
                 $res=$conf->where('enname', $k)->update(['value' =>$v]);
              }

              $this->success('修改配置项成功！',url('conf/conf'));
                
            }
           
           
            return;
        }
        $resf=$conf->order('sort desc')->select();
        $this->assign('data',$resf);
         return $this->fetch();
    }
}
