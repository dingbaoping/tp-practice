<?php
namespace app\admin\controller;
use think\Controller;
use app\admin\model\Admin as AdminModel;
use think\captcha\Captcha;

class Login extends Controller
{
    public function index()
    { 
      if(request()->isPost()){
        
        $this-> check_verify(input('code'));
        $admin=new AdminModel();
        $res=$admin->login(input('post.'));
        if($res==1){
          $this->error('用户名不存在！');
        }
        if($res==2){
          $this->success('登录信息正确！',url('admin/index'));
        }
        if($res==3){
          $this->error('密码错误！');
        }
        return ;      
      }
       return $this->fetch();
    }

    // 检测输入的验证码是否正确，$code为用户输入的验证码字符串，$id多个验证码标识
    public function check_verify($code){
    // 方法一、对象方法
        $captcha = new Captcha();
        if(!$captcha->check($code)){
          $this->error('验证码错误！');
        }else{
          return true;
        }

    // 方法二、助手函数
        // if(!captcha_check($code)){
        //   $this->error('验证码错误！');
        // }else{
        //   return true;
        // }
    }
}
