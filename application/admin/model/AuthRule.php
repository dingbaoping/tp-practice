<?php
namespace app\admin\model;
use think\Model;

class AuthRule extends Model
{
    public function authtree()
    {
       	$authres=$this->order('sort desc')->select();
        return $this->sort($authres);
    }

    public function sort($data,$pid=0,$level=0)
    {
      static $arr=array();
      foreach ($data as $key => $value) {
        if($value['pid']==$pid){
            $value['dataid']=$this->getParentid($value['id']);
            $value['level']=$level;
            $arr[]=$value;
            $this->sort($data,$value['id'],$level+1);
        }
      }
      return $arr;
    }

    public function getChildrenid($authid)
    {
        $authres=$this->select();
        return $this->_getChildrenid($authres,$authid);
    }
    public function _getChildrenid($authres,$authid){
      static $arr=array();
      foreach ($authres as $key => $value) {
        if($value['pid']==$authid){
             $arr[]=$value['id'];
            $this->_getChildrenid($authres,$value['id']);
        }
      }
      return $arr;
    }

    public function getParentid($authid)
    {
        $authres=$this->select();
        return $this->_getParentid($authres,$authid,true);
    }

    public function _getParentid($authres,$authid,$clear=false){
      static $arr=array();
      if($clear){
        $arr=array();
      }
      foreach ($authres as $key => $value) {
        if($value['id']==$authid){
            $arr[]=$value['id'];
            $this->_getParentid($authres,$value['pid'],false);
        }
      }
      asort($arr);
      $arrStr=implode('-',$arr);
      // dump($arr);die;
      return $arrStr;
    }
}
