<?php
namespace app\admin\model;
use think\Model;

class Article extends Model
{
    protected static function init()
    {
        Article::event('before_insert', function ($data) {
           if($_FILES['thumb']['tmp_name']){
             $file = request()->file('thumb');
             $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads');
             if($info){
                $thumb='/php/thinkphp/' . 'public' . DS . 'uploads'.'/'.$info->getSaveName();
                $data['thumb']=$thumb;
            }else{
                echo $file->getError();
            }
          }
        });

        Article::event('before_update', function ($data) {
           if($_FILES['thumb']['tmp_name']){

             $art=Article::find($data->id);
             $thumbpath=$_SERVER['DOCUMENT_ROOT'].$art['thumb'];
             if(file_exists($thumbpath)){
                @unlink($thumbpath);
            }
            // if(file_exists($art->thumb)){
            //     @unlink($art->thumb);
            // }

             $file = request()->file('thumb');
             $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads');
             if($info){
                // $thumb='http://127.0.0.1/php/thinkphp/' . 'public' . DS . 'uploads'.'/'.$info->getSaveName();
                $thumb='/php/thinkphp/' . 'public' . DS . 'uploads'.'/'.$info->getSaveName();
                $data['thumb']=$thumb;
            }else{
                echo $file->getError();
            }
          }
        });

        Article::event('before_delete', function ($data) {
             $art=Article::find($data->id);
             $thumbpath=$_SERVER['DOCUMENT_ROOT'].$art['thumb'];
             if(file_exists($thumbpath)){
                @unlink($thumbpath);
            }
        });
    }
}
