<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

return [
//如果需要全局替换的话
    'view_replace_str'  =>  [
        '__PUBLIC__'=>'/public/',
        '__ROOT__' => '/',
        '__STATIC__'=>'http://localhost/php/thinkphp/public/static',
    ],
	 'AUTH_CONFIG' => array(
	  'AUTH_ON' => true, //认证开关
	  'AUTH_TYPE' => 1, // 认证方式，1为时时认证；2为登录认证。
	  'AUTH_GROUP' => 'auth_group', //用户组数据表名
	  'AUTH_GROUP_ACCESS' => 'auth_group_access', //用户组明细表
	  'AUTH_RULE' => 'auth_rule', //权限规则表
	  'AUTH_USER' => 'admin'//用户信息表
	 )
];
