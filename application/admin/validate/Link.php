<?php
namespace app\admin\validate;
use think\Validate;


class Link extends Validate
{
    protected $rule = [
        'title'  =>  'require|unique:link|max:25',
        'url' =>  'url',
        'desc' =>  'require',
    ];
    
    protected $message = [
        'title.require'  =>  '链接标题不能为空！',
        'title.unique'  =>  '链接标题不能重复！',
        'title.max'  =>  '链接标题长度不得超过25个字符！',
        'url' =>  '链接格式错误',
        'desc.require'  =>  '描叙不能为空！',
    ];

    protected $scene = [
        'edit'  =>  ['title','url','desc'],
    ];
    
}