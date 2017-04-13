<?php
namespace Home\Controller;
use Think\Controller;
class CommentController extends Controller {
   /**
    * ajax提交和展示评论操作
    */
   public function ajaxAdd(){
       if(IS_POST){
           $model = D('comment');
           if($model->create(I('post.'),1) ){
               if($member_id = $model->add()){
                   //如果登录成功则返回状态 status = 1 ,并且将一条评论中所需要的数据返回,如评论内容,id,等级等
                   $this->success(array(
                       'comment_id' => $member_id,
                       'comment_content' => I('post.comment_content'),
                       'level' => I('post.level'),
                       'add_time' => date('Y-m-d H:i:s',time()),
                       'member_name' => session('member_name'),
                       'member_face' => session('member_face'),
                   ),'',true);
               }
           }
           $this->error($model->getError(),'',true);
       }
   }

   /**
    * ajax获得分页数据
    * @param $p int 当前页
    */
   public function ajaxPage(){
       $listRows = 5 ;
        $model = D('comment');
       //取分页数据
       $data = $model->getPage($listRows);
       //取一下印象数据
        echo json_encode($data);
   }
}