<?php

namespace app\admin\controller;
use think\Controller;
use think\Request;

class Common extends Controller
{   
    public function _initialize()
    {
        if(!session('id') || !session('username')){
            $this->error('您尚未登录系统，请重新登录！',url('login/index'));
        }

        $authRoles=new Auth();
        $request=Request::instance();
        $con=$request->controller();//控制器名称
        $action=$request->action();//当前方法名称
        $name=$con.'/'.$action;
        // echo $name;
        $notCheck=array('Login/index','Admin/index','Admin/loginout');
        if(session('id')!=1){
        	if(!in_array($name, $notCheck)){
		        if(!$authRoles->check($name,session('id'))){
		            $this->error('你没有权限',url('admin/index'));
		        }
	        }
        }
    }
}
