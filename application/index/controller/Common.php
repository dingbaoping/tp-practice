<?php

namespace app\index\controller;
use think\Controller;
use think\Request;

class Common extends Controller
{   
    public function _initialize()
    {
        if(!session('id') || !session('username')){
            $this->error('您尚未登录系统，请重新登录！',url('login/index'));
        }
    }
}
