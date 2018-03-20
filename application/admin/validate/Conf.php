<?php
namespace app\admin\validate;
use think\Validate;


class Conf extends Validate
{
    protected $rule = [
        'cnname' =>  'require|unique:conf',
        'enname'  =>  'require|unique:conf',
        'type' =>  'require',
    ];
    
    protected $message = [
        'cnname.require'  =>  '中文名称不能为空！',
        'cnname.unique'  =>  '中文名称不能重复！',
        'enname.require'  =>  '英文名称不能为空！',
        'enname.unique'  =>  '英文名称不能重复！',
        'type' =>  '配置类型不能为空！',
    ];
    
}